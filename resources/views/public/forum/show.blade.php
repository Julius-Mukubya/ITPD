@extends('layouts.public')

@section('title', ($post->title ?? 'Forum Post') . ' - WellPath')

@section('content')
<!-- Hero Section with Post Title -->
<section class="bg-gradient-to-br from-teal-50 via-green-50 to-emerald-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 border-b border-gray-200 dark:border-gray-700">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 mb-6">
            <a href="{{ route('public.forum.index') }}" class="hover:text-primary transition-colors flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Forum
            </a>
            <span class="material-symbols-outlined text-xs">chevron_right</span>
            @if($post->category ?? null)
                <a href="{{ route('public.forum.category', $post->category->slug ?? 'general') }}" class="hover:text-primary transition-colors">
                    {{ $post->category->name }}
                </a>
                <span class="material-symbols-outlined text-xs">chevron_right</span>
            @endif
            <span class="text-gray-900 dark:text-white font-medium truncate">{{ Str::limit($post->title ?? 'Discussion', 50) }}</span>
        </nav>

        <!-- Category Badge -->
        @if($post->category ?? null)
        <div class="mb-4">
            <span class="inline-flex items-center gap-2 bg-primary/10 text-primary text-sm px-4 py-2 rounded-full font-semibold">
                <span class="material-symbols-outlined text-sm">{{ $post->category->icon ?? 'forum' }}</span>
                {{ $post->category->name }}
            </span>
        </div>
        @endif

        <!-- Post Title -->
        <h1 class="text-3xl lg:text-4xl font-black text-gray-900 dark:text-white mb-4 leading-tight">
            {{ $post->title ?? 'Untitled Discussion' }}
        </h1>

        <!-- Author & Meta Info -->
        <div class="flex flex-wrap items-center gap-6 text-sm text-gray-600 dark:text-gray-400">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                    {{ $post->is_anonymous ? '?' : strtoupper(substr($post->user->name ?? 'A', 0, 2)) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white">
                        {{ $post->is_anonymous ? 'Anonymous User' : ($post->user->name ?? 'Unknown User') }}
                    </p>
                    <p class="text-xs">
                        {{ $post->created_at->format('M j, Y \a\t g:i A') ?? 'Recently posted' }}
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-4 text-xs">
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">schedule</span>
                    <span>{{ $post->created_at->diffForHumans() ?? 'Recently' }}</span>
                </div>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">visibility</span>
                    <span>{{ $post->views ?? 0 }} views</span>
                </div>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">comment</span>
                    <span>{{ $post->comments_count ?? 0 }} {{ Str::plural('reply', $post->comments_count ?? 0) }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">


    @if($errors->any())
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 mb-6">
        <div class="flex items-start gap-2">
            <span class="material-symbols-outlined text-red-600 dark:text-red-400">error</span>
            <div>
                <p class="text-red-800 dark:text-red-200 font-medium mb-2">Please fix the following errors:</p>
                <ul class="text-sm text-red-700 dark:text-red-300 list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <!-- Main Content Area -->
    <div class="lg:w-2/3">
        <!-- Post Content Card -->
        <article class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm mb-8">
            <div class="p-8">
                <!-- Post Content -->
                <div class="prose prose-lg max-w-none dark:prose-invert mb-8">
                    <div class="text-gray-700 dark:text-gray-300 leading-relaxed text-lg whitespace-pre-wrap">{{ $post->content ?? 'No content available' }}</div>
                </div>

                <!-- Post Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-4">
                        @auth
                            <!-- Upvote Button -->
                            <form action="{{ route('public.forum.upvote', $post->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-xl border-2 {{ $post->isUpvotedBy(auth()->id()) ? 'bg-primary/10 text-primary border-primary' : 'border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:border-primary hover:text-primary' }} transition-all duration-200 font-semibold">
                                    <span class="material-symbols-outlined">thumb_up</span>
                                    <span>{{ $post->upvotes ?? 0 }}</span>
                                </button>
                            </form>
                            
                            <!-- Share Button -->
                            <button onclick="sharePost()" class="flex items-center gap-2 px-4 py-2 rounded-xl border-2 border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:border-primary hover:text-primary transition-all duration-200 font-semibold">
                                <span class="material-symbols-outlined">share</span>
                                <span>Share</span>
                            </button>
                        @else
                            <button onclick="openLoginModal()" class="flex items-center gap-2 px-4 py-2 rounded-xl border-2 border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:border-primary hover:text-primary transition-all duration-200 font-semibold">
                                <span class="material-symbols-outlined">thumb_up</span>
                                <span>{{ $post->upvotes ?? 0 }}</span>
                            </button>
                        @endauth
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">thumb_up</span>
                            {{ $post->upvotes ?? 0 }}
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">comment</span>
                            {{ $post->comments_count ?? 0 }}
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">visibility</span>
                            {{ $post->views ?? 0 }}
                        </span>
                    </div>
                </div>
            </div>
        </article>

        <!-- Comments Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm">
            <!-- Comments Header -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">comment</span>
                        Discussion ({{ $post->comments_count ?? 0 }})
                    </h3>
                    @guest
                    <button onclick="openLoginModal()" class="text-sm text-primary hover:text-primary/80 font-semibold">
                        Sign in to join
                    </button>
                    @endguest
                </div>
            </div>

            <div class="p-6">
                @auth
                <!-- Comment Form -->
                <div class="mb-8 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                    <form action="{{ route('public.forum.comment', $post->id ?? 1) }}" method="POST">
                        @csrf
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <textarea name="comment" rows="3" required
                                          placeholder="Share your thoughts on this discussion..."
                                          class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary focus:border-primary resize-none shadow-sm"></textarea>
                                <div class="flex items-center justify-between mt-4">
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1" 
                                               class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary dark:focus:ring-primary dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="is_anonymous" class="text-sm text-gray-700 dark:text-gray-300">Post anonymously</label>
                                    </div>
                                    <button type="submit" class="bg-primary text-white px-6 py-2 rounded-xl font-semibold hover:bg-primary/90 transition-colors shadow-sm">
                                        Post Reply
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @else
                <!-- Guest CTA -->
                <div class="mb-8 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 rounded-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-1">Join the conversation</h4>
                            <p class="text-sm text-blue-800 dark:text-blue-200">Sign in to share your thoughts and engage with the community.</p>
                        </div>
                        <div class="flex gap-2">
                            <button onclick="openLoginModal()" class="bg-blue-600 text-white px-4 py-2 rounded-xl font-semibold hover:bg-blue-700 transition-colors">
                                Sign In
                            </button>
                            <button onclick="openSignupModal()" class="bg-white dark:bg-gray-700 border border-blue-300 dark:border-blue-700 text-blue-600 dark:text-blue-400 px-4 py-2 rounded-xl font-semibold hover:bg-blue-50 dark:hover:bg-gray-600 transition-colors">
                                Sign Up
                            </button>
                        </div>
                    </div>
                </div>
                @endauth

                <!-- Comments List -->
                <div class="space-y-6">
                    @forelse($comments ?? [] as $comment)
                    <div class="group">
                        <div class="flex gap-4">
                            <!-- Comment Upvote Section -->
                            <div class="flex flex-col items-center gap-2 min-w-[44px]">
                                @auth
                                    <form action="{{ route('public.forum.comment.upvote', $comment->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="w-9 h-9 rounded-xl {{ $comment->isUpvotedBy(auth()->id()) ? 'bg-primary/20 text-primary shadow-sm' : 'bg-gray-100 dark:bg-gray-700 hover:bg-primary/10 hover:text-primary' }} transition-all duration-200 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-sm">thumb_up</span>
                                        </button>
                                    </form>
                                @else
                                    <button onclick="openLoginModal()" class="w-9 h-9 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-primary/10 hover:text-primary transition-all duration-200 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-sm">thumb_up</span>
                                    </button>
                                @endauth
                                @if(($comment->upvotes ?? 0) > 0)
                                    <span class="text-xs font-bold text-primary">{{ $comment->upvotes }}</span>
                                @endif
                            </div>
                            
                            <!-- Comment Content -->
                            <div class="flex-1">
                                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-5 group-hover:bg-gray-100 dark:group-hover:bg-gray-700/70 transition-colors">
                                    <!-- Comment Header -->
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="w-10 h-10 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-white font-bold shadow-sm">
                                            {{ $comment->is_anonymous ? '?' : strtoupper(substr($comment->user->name ?? 'A', 0, 2)) }}
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-2">
                                                    <span class="font-semibold text-gray-900 dark:text-white">
                                                        {{ $comment->is_anonymous ? 'Anonymous User' : ($comment->user->name ?? 'Unknown User') }}
                                                    </span>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400 bg-gray-200 dark:bg-gray-600 px-2 py-1 rounded-full">
                                                        {{ $comment->created_at->diffForHumans() ?? 'Recently' }}
                                                    </span>
                                                </div>
                                                @if(($comment->upvotes ?? 0) > 0)
                                                    <div class="flex items-center gap-1 text-xs text-primary bg-primary/10 px-2 py-1 rounded-full">
                                                        <span class="material-symbols-outlined text-xs">thumb_up</span>
                                                        <span class="font-semibold">{{ $comment->upvotes }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Comment Text -->
                                    <div class="text-gray-700 dark:text-gray-300 leading-relaxed pl-13">
                                        {{ $comment->comment ?? $comment->content ?? '' }}
                                    </div>
                                </div>
                                
                                <!-- Replies -->
                                @if(isset($comment->replies) && $comment->replies->count() > 0)
                                <div class="ml-16 mt-4 space-y-4">
                                    @foreach($comment->replies as $reply)
                                    <div class="flex gap-3 group/reply">
                                        <!-- Reply Upvote Section -->
                                        <div class="flex flex-col items-center gap-1 min-w-[36px]">
                                            @auth
                                                <form action="{{ route('public.forum.comment.upvote', $reply->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="w-7 h-7 rounded-lg {{ $reply->isUpvotedBy(auth()->id()) ? 'bg-primary/20 text-primary' : 'bg-gray-100 dark:bg-gray-700 hover:bg-primary/10 hover:text-primary' }} transition-all duration-200 flex items-center justify-center">
                                                        <span class="material-symbols-outlined text-xs">thumb_up</span>
                                                    </button>
                                                </form>
                                            @else
                                                <button onclick="openLoginModal()" class="w-7 h-7 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-primary/10 hover:text-primary transition-all duration-200 flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-xs">thumb_up</span>
                                                </button>
                                            @endauth
                                            @if(($reply->upvotes ?? 0) > 0)
                                                <span class="text-xs font-bold text-primary">{{ $reply->upvotes }}</span>
                                            @endif
                                        </div>
                                        
                                        <!-- Reply Content -->
                                        <div class="flex-1">
                                            <div class="bg-white dark:bg-gray-600/50 rounded-xl p-4 group-hover/reply:bg-gray-50 dark:group-hover/reply:bg-gray-600/70 transition-colors border border-gray-200 dark:border-gray-600">
                                                <div class="flex items-center gap-3 mb-2">
                                                    <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                                        {{ $reply->is_anonymous ? '?' : strtoupper(substr($reply->user->name ?? 'A', 0, 1)) }}
                                                    </div>
                                                    <div class="flex items-center justify-between flex-1">
                                                        <div class="flex items-center gap-2">
                                                            <span class="font-semibold text-sm text-gray-900 dark:text-white">
                                                                {{ $reply->is_anonymous ? 'Anonymous User' : ($reply->user->name ?? 'Unknown User') }}
                                                            </span>
                                                            <span class="text-xs text-gray-500 dark:text-gray-400 bg-gray-200 dark:bg-gray-600 px-2 py-1 rounded-full">
                                                                {{ $reply->created_at->diffForHumans() ?? 'Recently' }}
                                                            </span>
                                                        </div>
                                                        @if(($reply->upvotes ?? 0) > 0)
                                                            <div class="flex items-center gap-1 text-xs text-primary bg-primary/10 px-2 py-1 rounded-full">
                                                                <span class="material-symbols-outlined text-xs">thumb_up</span>
                                                                <span class="font-semibold">{{ $reply->upvotes }}</span>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed pl-11">{{ $reply->comment ?? $reply->content ?? '' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-4xl text-gray-400">chat_bubble_outline</span>
                        </div>
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No replies yet</h4>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">
                            @guest
                                <button onclick="openSignupModal()" class="text-primary hover:underline font-semibold">Sign up</button> to be the first to share your thoughts!
                            @else
                                Be the first to share your thoughts on this discussion!
                            @endguest
                        </p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:w-1/3">
        <div class="sticky top-8 space-y-6">
            <!-- Author Info Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Discussion Author</h4>
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg">
                        {{ $post->is_anonymous ? '?' : strtoupper(substr($post->user->name ?? 'A', 0, 2)) }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">
                            {{ $post->is_anonymous ? 'Anonymous User' : ($post->user->name ?? 'Unknown User') }}
                        </p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Posted {{ $post->created_at->diffForHumans() ?? 'recently' }}
                        </p>
                        @if(!$post->is_anonymous && $post->user)
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                            Member since {{ $post->user->created_at->format('M Y') }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Discussion Stats -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Discussion Stats</h4>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                            <span class="material-symbols-outlined text-sm">thumb_up</span>
                            <span class="text-sm">Upvotes</span>
                        </div>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $post->upvotes ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                            <span class="material-symbols-outlined text-sm">comment</span>
                            <span class="text-sm">Replies</span>
                        </div>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $post->comments_count ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                            <span class="material-symbols-outlined text-sm">visibility</span>
                            <span class="text-sm">Views</span>
                        </div>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $post->views ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                            <span class="material-symbols-outlined text-sm">schedule</span>
                            <span class="text-sm">Posted</span>
                        </div>
                        <span class="font-semibold text-gray-900 dark:text-white text-sm">{{ $post->created_at->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Related Discussions -->
            @if($post->category ?? null)
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-4">More in {{ $post->category->name }}</h4>
                <div class="space-y-3">
                    <a href="{{ route('public.forum.category', $post->category->slug) }}" class="block p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">{{ $post->category->icon ?? 'forum' }}</span>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white text-sm">Browse {{ $post->category->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">View all discussions in this category</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>

    </div>
</div>

<!-- Continue the Conversation Section -->
<section class="py-16 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/20 rounded-full mb-4">
                <span class="material-symbols-outlined text-3xl text-primary">forum</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Continue the Conversation</h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Explore more discussions, share your experiences, and connect with our supportive community.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Browse Category -->
            @if($post->category ?? null)
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-green-600 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-xl">{{ $post->category->icon ?? 'forum' }}</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white group-hover:text-primary transition-colors">
                            More {{ $post->category->name }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Explore similar discussions</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 leading-relaxed">
                    {{ $post->category->description ?? 'Discover more conversations and insights in this category.' }}
                </p>
                <a href="{{ route('public.forum.category', $post->category->slug) }}" 
                   class="inline-flex items-center gap-2 text-primary font-semibold text-sm hover:gap-3 transition-all">
                    <span>Browse Category</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
            @endif

            <!-- Start New Discussion -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-xl">add_circle</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white group-hover:text-primary transition-colors">
                            Start Discussion
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Share your thoughts</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 leading-relaxed">
                    Have something on your mind? Start a new discussion and connect with our community.
                </p>
                @auth
                    <button onclick="openCreateDiscussionModal({{ $post->category->id ?? 'null' }})" 
                            class="inline-flex items-center gap-2 text-primary font-semibold text-sm hover:gap-3 transition-all">
                        <span>Create Post</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </button>
                @else
                    <button onclick="openLoginModal()" 
                            class="inline-flex items-center gap-2 text-primary font-semibold text-sm hover:gap-3 transition-all">
                        <span>Sign In to Post</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </button>
                @endauth
            </div>

            <!-- Community Guidelines -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-xl">verified_user</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-900 dark:text-white group-hover:text-primary transition-colors">
                            Community Guidelines
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Safe & supportive space</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 leading-relaxed">
                    Our community thrives on respect, support, and constructive conversations. Learn more about our guidelines.
                </p>
                <button class="inline-flex items-center gap-2 text-primary font-semibold text-sm hover:gap-3 transition-all">
                    <span>Learn More</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>
            </div>
        </div>

        <!-- Call to Action -->
        @guest
        <div class="mt-12 text-center">
            <div class="bg-gradient-to-r from-primary/10 to-green-50 dark:from-primary/20 dark:to-gray-800 rounded-2xl p-8 border border-primary/20 dark:border-primary/30">
                <div class="max-w-2xl mx-auto">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        Join Our Community Today
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                        Connect with peers, share your experiences, and find support in a safe, moderated environment. 
                        Your voice matters in our community.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button onclick="openSignupModal()" 
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-semibold hover:bg-primary/90 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <span class="material-symbols-outlined">person_add</span>
                            <span>Create Free Account</span>
                        </button>
                        <button onclick="openLoginModal()" 
                                class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white dark:bg-gray-700 text-primary border-2 border-primary rounded-xl font-semibold hover:bg-primary hover:text-white transition-all duration-200">
                            <span class="material-symbols-outlined">login</span>
                            <span>Sign In</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endguest
    </div>
</section>

@include('components.login-modal')
@include('components.signup-modal')
@auth
@include('components.create-discussion-modal')
@endauth

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<script>
function sharePost() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $post->title ?? "Forum Post" }}',
            text: '{{ Str::limit($post->content ?? "", 100) }}',
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(function() {
            // Show a temporary notification
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
            notification.textContent = 'Link copied to clipboard!';
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        });
    }
}

// Auto-resize textarea
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.querySelector('textarea[name="comment"]');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 150) + 'px';
        });
    }
});
</script>
@endpush
@endsection
