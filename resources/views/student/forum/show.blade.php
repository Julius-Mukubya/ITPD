@extends('layouts.student')

@section('title', $forum->title)
@section('page-title', 'Forum Post')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('student.forum.index') }}" class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-primary transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
            Back to Forum
        </a>
    </div>

    <!-- Post Content -->
    <article class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-8">
        <div class="p-8">
            <!-- Category Badge -->
            <div class="mb-4">
                <span class="bg-primary/10 text-primary text-sm px-4 py-2 rounded-full font-semibold">
                    {{ $forum->category->name ?? 'General' }}
                </span>
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                {{ $forum->title }}
            </h1>

            <!-- Author & Meta -->
            <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400 mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-white font-bold">
                        {{ $forum->is_anonymous ? '?' : strtoupper(substr($forum->user->name ?? 'A', 0, 2)) }}
                    </div>
                    <span class="font-medium">{{ $forum->is_anonymous ? 'Anonymous' : ($forum->user->name ?? 'Unknown') }}</span>
                </div>
                <span>•</span>
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">schedule</span>
                    {{ $forum->created_at->diffForHumans() }}
                </span>
                <span>•</span>
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">visibility</span>
                    {{ $forum->views ?? 0 }} views
                </span>
            </div>

            <!-- Content -->
            <div class="prose prose-lg max-w-none dark:prose-invert mb-6">
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $forum->content }}</p>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                <form action="{{ route('student.forum.upvote', $forum) }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <span class="material-symbols-outlined">thumb_up</span>
                        <span>Upvote ({{ $forum->upvoteRecords->count() ?? 0 }})</span>
                    </button>
                </form>
            </div>
        </div>
    </article>

    <!-- Comments Section -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-8">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">
            Replies ({{ $forum->comments->count() ?? 0 }})
        </h3>

        <!-- Comment Form -->
        <form action="{{ route('student.forum.comment', $forum) }}" method="POST" class="mb-8">
            @csrf
            <textarea name="comment" rows="4" required
                      placeholder="Share your thoughts..."
                      class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary focus:border-primary resize-none mb-3"></textarea>
            
            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <input type="checkbox" name="is_anonymous" value="1" class="rounded border-gray-300 text-primary focus:ring-primary">
                    <span>Post anonymously</span>
                </label>
                <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg font-semibold hover:bg-primary/90 transition-colors">
                    Post Reply
                </button>
            </div>
        </form>

        <!-- Comments List -->
        <div class="space-y-6">
            @forelse($forum->comments as $comment)
            <div class="flex gap-4">
                <div class="w-10 h-10 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                    {{ $comment->is_anonymous ? '?' : strtoupper(substr($comment->user->name ?? 'A', 0, 2)) }}
                </div>
                <div class="flex-1">
                    <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="font-semibold text-gray-900 dark:text-white">
                                {{ $comment->is_anonymous ? 'Anonymous' : ($comment->user->name ?? 'Unknown') }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $comment->created_at->diffForHumans() }}
                            </span>
                        </div>
                        <p class="text-gray-700 dark:text-gray-300">{{ $comment->comment }}</p>
                    </div>
                    
                    <!-- Replies -->
                    @if($comment->replies && $comment->replies->count() > 0)
                    <div class="ml-8 mt-4 space-y-4">
                        @foreach($comment->replies as $reply)
                        <div class="flex gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                                {{ $reply->is_anonymous ? '?' : strtoupper(substr($reply->user->name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-3">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="font-semibold text-sm text-gray-900 dark:text-white">
                                            {{ $reply->is_anonymous ? 'Anonymous' : ($reply->user->name ?? 'Unknown') }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $reply->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-700 dark:text-gray-300">{{ $reply->comment }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                <span class="material-symbols-outlined text-4xl mb-2">chat_bubble_outline</span>
                <p>No replies yet. Be the first to comment!</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
