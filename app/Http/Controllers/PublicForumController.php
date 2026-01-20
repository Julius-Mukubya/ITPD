<?php

namespace App\Http\Controllers;

use App\Models\ForumPost;
use App\Models\ForumCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicForumController extends Controller
{
    public function index()
    {
        $categories = ForumCategory::withCount('posts')->get();
        
        $posts = ForumPost::with(['user', 'category'])
            ->withCount(['comments', 'upvoteRecords'])
            ->latest()
            ->paginate(15);

        return view('public.forum.index', compact('categories', 'posts'));
    }

    public function show($id)
    {
        $post = ForumPost::with(['user', 'category'])
            ->withCount('comments')
            ->findOrFail($id);
        
        // Load comments with their replies and users
        $comments = $post->comments()
            ->with(['user', 'replies.user'])
            ->whereNull('parent_id') // Only get top-level comments
            ->latest()
            ->get();

        return view('public.forum.show', compact('post', 'comments'));
    }

    public function category($slug)
    {
        $category = ForumCategory::where('slug', $slug)->firstOrFail();
        
        $posts = ForumPost::with(['user', 'category'])
            ->withCount(['comments', 'upvoteRecords'])
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(15);

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

        \App\Models\ForumComment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'comment' => $request->comment,
            'is_anonymous' => $request->is_anonymous ?? false,
        ]);

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
