<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\ForumCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicForumController extends Controller
{
    public function index(Request $request)
    {
        $categories = ForumCategory::withCount('posts')->get();
        
        $query = ForumPost::with(['user', 'category'])
            ->withCount(['comments', 'upvoteRecords']);
        
        // Hide hidden posts from non-admin users
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            $query->where(function($q) {
                $q->where('is_hidden', false)
                  ->orWhereNull('is_hidden');
            });
        }
        
        // Filter by category if specified
        if ($request->has('category') && $request->category !== 'all') {
            $category = ForumCategory::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }
        
        // Sort by upvotes (descending) then by latest
        $posts = $query->orderBy('upvotes', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $selectedCategory = $request->category ?? 'all';

        return view('public.forum.index', compact('categories', 'posts', 'selectedCategory'));
    }

    public function show($id)
    {
        $post = ForumPost::with(['user', 'category'])
            ->withCount('comments')
            ->findOrFail($id);
        
        // Load comments with their replies and users
        $commentsQuery = $post->comments()
            ->with(['user', 'replies.user'])
            ->whereNull('parent_id'); // Only get top-level comments
        
        // Hide hidden comments from non-admin users
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            $commentsQuery->where(function($q) {
                $q->where('is_hidden', false)
                  ->orWhereNull('is_hidden');
            });
        }
        
        $comments = $commentsQuery->latest()->get();

        return view('public.forum.show', compact('post', 'comments'));
    }

    public function category($slug)
    {
        $category = ForumCategory::where('slug', $slug)->firstOrFail();
        
        $query = ForumPost::with(['user', 'category'])
            ->withCount(['comments', 'upvoteRecords'])
            ->where('category_id', $category->id);
        
        // Hide hidden posts from non-admin users
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            $query->where(function($q) {
                $q->where('is_hidden', false)
                  ->orWhereNull('is_hidden');
            });
        }
        
        $posts = $query->latest()->paginate(15);

        $categories = ForumCategory::withCount('posts')->get();

        return view('public.forum.category', compact('category', 'posts', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:forum_categories,id',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'is_anonymous' => 'boolean',
        ]);

        $post = ForumPost::create([
            'category_id' => $validated['category_id'],
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_anonymous' => $validated['is_anonymous'] ?? false,
        ]);

        // Check if user came from a category page
        $referer = $request->header('referer');
        if ($referer && str_contains($referer, '/forum/category/')) {
            $category = ForumCategory::find($validated['category_id']);
            if ($category) {
                return redirect()->route('public.forum.category', $category->slug)
                    ->with('success', 'Post created successfully!');
            }
        }

        return redirect()->route('public.forum.index')
            ->with('success', 'Post created successfully!');
    }

    public function storeComment(Request $request, $id)
    {
        $post = ForumPost::findOrFail($id);
        
        $request->validate([
            'comment' => 'required|string',
            'is_anonymous' => 'boolean',
            'parent_id' => 'nullable|exists:forum_comments,id',
        ]);

        $comment = \App\Models\ForumComment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'comment' => $request->comment,
            'is_anonymous' => $request->is_anonymous ?? false,
        ]);

        // If it's an AJAX request, return JSON
        if ($request->wantsJson() || $request->ajax()) {
            $user = auth()->user();
            return response()->json([
                'success' => true,
                'message' => 'Comment posted successfully!',
                'comment' => [
                    'id' => $comment->id,
                    'comment' => $comment->comment,
                    'is_anonymous' => $comment->is_anonymous,
                    'author_name' => $comment->is_anonymous ? 'Anonymous User' : $user->name,
                    'author_initial' => $comment->is_anonymous ? '?' : strtoupper(substr($user->name, 0, 2)),
                    'created_at' => $comment->created_at->toISOString(),
                    'upvotes' => 0,
                ]
            ]);
        }

        return back()->with('success', 'Comment posted!');
    }

    public function upvote($id)
    {
        $post = ForumPost::findOrFail($id);
        $post->toggleUpvote(auth()->id());
        return back();
    }

    public function upvoteComment($commentId)
    {
        $comment = \App\Models\ForumComment::findOrFail($commentId);
        $comment->toggleUpvote(auth()->id());
        return back();
    }

    public function getComments($id)
    {
        try {
            // First, let's verify the post exists
            $post = ForumPost::findOrFail($id);
            
            // Get all comments for this post (including replies)
            $allComments = $post->allComments()->with('user')->get();
            
            // Filter to get only top-level comments (no parent)
            $topLevelComments = $allComments->where('parent_id', null)->sortByDesc('created_at')->take(3);
            
            $mappedComments = $topLevelComments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'comment' => Str::limit($comment->comment, 100),
                    'author' => $comment->is_anonymous ? 'Anonymous' : ($comment->user ? $comment->user->name : 'Unknown'),
                    'created_at' => $comment->created_at->diffForHumans(),
                    'is_anonymous' => $comment->is_anonymous,
                    'upvotes' => $comment->upvotes ?? 0,
                ];
            })->values(); // Reset array keys

            $totalComments = $allComments->where('parent_id', null)->count();

            return response()->json([
                'success' => true,
                'comments' => $mappedComments,
                'total' => $totalComments,
                'has_more' => $totalComments > 3,
                'post_title' => $post->title
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Post not found',
                'message' => "Post with ID {$id} does not exist"
            ], 404);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to load comments',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => basename($e->getFile())
            ], 500);
        }
    }
}
