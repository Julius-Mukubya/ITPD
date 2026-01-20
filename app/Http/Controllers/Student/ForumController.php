<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\{ForumCategory, ForumPost, ForumComment};
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index(Request $request)
    {
        $query = ForumPost::with(['user', 'category'])
            ->withCount('allComments');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $posts = $query->latest('is_pinned')->latest()->paginate(15);
        $categories = ForumCategory::active()->get();

        return view('student.forum.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = ForumCategory::active()->get();
        return view('student.forum.create', compact('categories'));
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

        return redirect()->route('student.forum.show', $post)
            ->with('success', 'Post created successfully!');
    }

    public function show(ForumPost $forum)
    {
        $forum->incrementViews();
        $forum->load(['category', 'user', 'comments.user', 'comments.replies.user']);

        return view('student.forum.show', compact('forum'));
    }

    public function storeComment(Request $request, ForumPost $forum)
    {
        $request->validate([
            'comment' => 'required|string',
            'is_anonymous' => 'boolean',
            'parent_id' => 'nullable|exists:forum_comments,id',
        ]);

        ForumComment::create([
            'post_id' => $forum->id,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'comment' => $request->comment,
            'is_anonymous' => $request->is_anonymous ?? false,
        ]);

        return back()->with('success', 'Comment posted!');
    }

    public function upvote(ForumPost $forum)
    {
        $forum->toggleUpvote(auth()->id());
        return back();
    }

    public function upvoteComment($commentId)
    {
        $comment = \App\Models\ForumComment::findOrFail($commentId);
        $comment->toggleUpvote(auth()->id());
        return back();
    }
}