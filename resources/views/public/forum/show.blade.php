@extends('layouts.public')

@section('title', ($post->title ?? 'Forum Post') . ' - WellPath')

@section('content')
<!-- Hero Section with Post Title -->
<section class="relative overflow-hidden min-h-[300px] sm:min-h-[400px] lg:h-96 pt-16 sm:pt-20">
    <!-- Background Image -->
    <div class="absolute inset-0">
        @php
            $categoryImages = [
                'general' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80',
                'mental-health' => 'https://images.unsplash.com/photo-1559757175-0eb30cd8c063?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80',
                'stress-anxiety' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80',
                'academic-support' => 'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80',
                'substance-use' => 'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80',
                'relationships' => 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80',
                'self-care' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80',
                'success-stories' => 'https://images.unsplash.com/photo-1521737711867-e3b97375f902?ixlib=rb-4.0.3&auto=format&fit=crop&w=2071&q=80',
            ];
            $categorySlug = $post->category->slug ?? 'general';
            $categoryImage = $categoryImages[$categorySlug] ?? $categoryImages['general'];
        @endphp
        <img src="{{ $categoryImage }}" 
             alt="{{ $post->category->name ?? 'Forum' }} discussion" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>
    
    <!-- Content -->
    <div class="relative w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center py-8 sm:py-12">
        <div class="w-full">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-xs sm:text-sm text-white/80 mb-4 sm:mb-6">
                <a href="{{ route('public.forum.index') }}" class="hover:text-white transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined !text-sm">arrow_back</span>
                    Forum
                </a>
                <span class="material-symbols-outlined !text-xs">chevron_right</span>
                @if($post->category ?? null)
                    <a href="{{ route('public.forum.category', $post->category->slug ?? 'general') }}" class="hover:text-white transition-colors truncate">
                        {{ $post->category->name }}
                    </a>
                    <span class="material-symbols-outlined !text-xs">chevron_right</span>
                @endif
                <span class="text-white font-medium truncate">{{ Str::limit($post->title ?? 'Discussion', 30) }}</span>
            </nav>

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 lg:gap-8">
                <div class="flex-1 min-w-0">
                    <!-- Category Badge -->
                    @if($post->category ?? null)
                    <div class="mb-3 sm:mb-4">
                        <span class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white text-xs sm:text-sm px-3 sm:px-4 py-1.5 sm:py-2 rounded-full font-semibold border border-white/30">
                            <span class="material-symbols-outlined !text-sm">{{ $post->category->icon ?? 'forum' }}</span>
                            {{ $post->category->name }}
                        </span>
                    </div>
                    @endif

                    <!-- Post Title -->
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white mb-3 sm:mb-4 leading-tight break-words">
                        {{ $post->title ?? 'Untitled Discussion' }}
                    </h1>

                    <!-- Author & Meta Info -->
                    <div class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-6 text-xs sm:text-sm text-white/80">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center text-white font-bold shadow-lg border border-white/30">
                                {{ $post->is_anonymous ? '?' : strtoupper(substr($post->user->name ?? 'A', 0, 2)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-white text-sm sm:text-base">
                                    {{ $post->is_anonymous ? 'Anonymous User' : ($post->user->name ?? 'Unknown User') }}
                                </p>
                                <p class="text-xs text-white/70">
                                    {{ $post->created_at->format('M j, Y \a\t g:i A') ?? 'Recently posted' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap items-center gap-3 sm:gap-4 text-xs">
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined !text-sm">schedule</span>
                                <span class="hidden sm:inline">{{ $post->created_at->diffForHumans() ?? 'Recently' }}</span>
                                <span class="sm:hidden">{{ $post->created_at->diffForHumans() ? Str::replace([' ago', ' minutes', ' hours', ' days', ' weeks', ' months'], ['', 'm', 'h', 'd', 'w', 'mo'], $post->created_at->diffForHumans()) : 'Now' }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined !text-sm">visibility</span>
                                <span>{{ $post->views ?? 0 }} views</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined !text-sm">comment</span>
                                <span>{{ $post->comments_count ?? 0 }} {{ Str::plural('reply', $post->comments_count ?? 0) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="hidden lg:flex flex-col gap-3">
                    <a href="{{ route('public.forum.index') }}" class="inline-flex items-center justify-center gap-2 bg-white/20 backdrop-blur-sm border-2 border-white/30 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-xl font-bold hover:bg-white/30 transition-all duration-200 transform hover:scale-105 text-sm">
                        <span class="material-symbols-outlined">forum</span>
                        All Discussions
                    </a>
                    @if($post->category ?? null)
                        <a href="{{ route('public.forum.category', $post->category->slug) }}" class="inline-flex items-center justify-center gap-2 bg-white text-primary px-4 sm:px-6 py-2 sm:py-3 rounded-xl font-bold hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-lg text-sm">
                            <span class="material-symbols-outlined">{{ $post->category->icon ?? 'forum' }}</span>
                            More {{ $post->category->name }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
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

    <div class="flex flex-col lg:flex-row gap-6 sm:gap-8">
    <!-- Main Content Area -->
    <div class="lg:w-2/3">
        <!-- Post Content Card -->
        <article class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm mb-6 sm:mb-8">
            <div class="p-4 sm:p-6 lg:p-8">
                <!-- Post Content -->
                <div class="prose prose-sm sm:prose-base lg:prose-lg max-w-none dark:prose-invert mb-6 sm:mb-8">
                    <div class="text-gray-700 dark:text-gray-300 leading-relaxed text-sm sm:text-base lg:text-lg whitespace-pre-wrap break-words">{{ $post->content ?? 'No content available' }}</div>
                </div>

                <!-- Post Actions -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 sm:pt-6 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex flex-wrap items-center gap-2 sm:gap-4">
                        @auth
                            <!-- Upvote Button -->
                            <form action="{{ route('public.forum.upvote', $post->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="flex items-center gap-2 px-3 sm:px-4 py-2 rounded-xl border-2 {{ $post->isUpvotedBy(auth()->id()) ? 'bg-primary/10 text-primary border-primary' : 'border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:border-primary hover:text-primary' }} transition-all duration-200 font-semibold text-xs sm:text-sm">
                                    <span class="material-symbols-outlined !text-sm sm:!text-base">thumb_up</span>
                                    <span>{{ $post->upvotes ?? 0 }}</span>
                                </button>
                            </form>
                            
                            <!-- Share Button -->
                            <button onclick="sharePost()" class="flex items-center gap-2 px-3 sm:px-4 py-2 rounded-xl border-2 border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:border-primary hover:text-primary transition-all duration-200 font-semibold text-xs sm:text-sm">
                                <span class="material-symbols-outlined !text-sm sm:!text-base">share</span>
                                <span class="hidden sm:inline">Share</span>
                            </button>

                            <!-- Flag Button -->
                            <button onclick="openFlagModal('App\\Models\\ForumPost', {{ $post->id }})" 
                                    data-flag-type="App\Models\ForumPost" 
                                    data-flag-id="{{ $post->id }}"
                                    class="flex items-center gap-2 px-3 sm:px-4 py-2 rounded-xl border-2 border-gray-200 dark:border-gray-600 {{ $post->isFlaggedBy(auth()->id()) ? 'text-red-600 dark:text-red-400 border-red-200 dark:border-red-800' : 'text-gray-600 dark:text-gray-400 hover:border-red-200 hover:text-red-600 dark:hover:border-red-800 dark:hover:text-red-400' }} transition-all duration-200 font-semibold text-xs sm:text-sm"
                                    title="{{ $post->isFlaggedBy(auth()->id()) ? 'Content flagged' : 'Flag content' }}">
                                <span class="material-symbols-outlined !text-sm sm:!text-base">flag</span>
                                <span class="hidden sm:inline">Flag</span>
                            </button>
                        @else
                            <button onclick="openLoginModal()" class="flex items-center gap-2 px-3 sm:px-4 py-2 rounded-xl border-2 border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:border-primary hover:text-primary transition-all duration-200 font-semibold text-xs sm:text-sm">
                                <span class="material-symbols-outlined !text-sm sm:!text-base">thumb_up</span>
                                <span>{{ $post->upvotes ?? 0 }}</span>
                            </button>
                        @endauth
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="flex items-center gap-3 sm:gap-4 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined !text-sm">thumb_up</span>
                            {{ $post->upvotes ?? 0 }}
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined !text-sm">comment</span>
                            {{ $post->comments_count ?? 0 }}
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined !text-sm">visibility</span>
                            {{ $post->views ?? 0 }}
                        </span>
                    </div>
                </div>
            </div>
        </article>

        <!-- Comments Section -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm">
            <!-- Comments Header -->
            <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">comment</span>
                        Discussion (<span data-comment-count>{{ $post->comments_count ?? 0 }}</span>)
                    </h3>
                    @guest
                    <button onclick="openLoginModal()" class="text-xs sm:text-sm text-primary hover:text-primary/80 font-semibold">
                        Sign in to join
                    </button>
                    @endguest
                </div>
            </div>

            <div class="p-4 sm:p-6">
                @auth
                <!-- Comment Form -->
                <div class="mb-6 sm:mb-8 p-3 sm:p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                    <form id="commentForm" action="{{ route('public.forum.comment', $post->id ?? 1) }}" method="POST">
                        @csrf
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0 text-sm sm:text-base">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <textarea name="comment" id="commentTextarea" rows="3" required
                                          placeholder="Share your thoughts on this discussion..."
                                          class="w-full px-3 sm:px-4 py-2 sm:py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary focus:border-primary resize-none shadow-sm text-sm sm:text-base"></textarea>
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4 mt-3 sm:mt-4">
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1" 
                                               class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary dark:focus:ring-primary dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="is_anonymous" class="text-xs sm:text-sm text-gray-700 dark:text-gray-300">Post anonymously</label>
                                    </div>
                                    <button type="submit" id="submitCommentBtn" class="bg-primary text-white px-4 sm:px-6 py-2 rounded-xl font-semibold hover:bg-primary/90 transition-colors shadow-sm disabled:opacity-50 disabled:cursor-not-allowed text-sm sm:text-base">
                                        <span class="flex items-center gap-2">
                                            <span id="submitBtnText">Post Reply</span>
                                            <span id="submitBtnSpinner" class="hidden">
                                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @else
                <!-- Guest CTA -->
                <div class="mb-6 sm:mb-8 p-4 sm:p-6 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 rounded-xl">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
                        <div>
                            <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-1 text-sm sm:text-base">Join the conversation</h4>
                            <p class="text-xs sm:text-sm text-blue-800 dark:text-blue-200">Sign in to share your thoughts and engage with the community.</p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2">
                            <button onclick="openLoginModal()" class="bg-blue-600 text-white px-3 sm:px-4 py-2 rounded-xl font-semibold hover:bg-blue-700 transition-colors text-xs sm:text-sm">
                                Sign In
                            </button>
                            <button onclick="openSignupModal()" class="bg-white dark:bg-gray-700 border border-blue-300 dark:border-blue-700 text-blue-600 dark:text-blue-400 px-3 sm:px-4 py-2 rounded-xl font-semibold hover:bg-blue-50 dark:hover:bg-gray-600 transition-colors text-xs sm:text-sm">
                                Sign Up
                            </button>
                        </div>
                    </div>
                </div>
                @endauth

                <!-- Comments List -->
                <div id="commentsList" class="space-y-6">
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
                                                        <span class="hidden sm:inline">{{ $comment->created_at->diffForHumans() ?? 'Recently' }}</span>
                                                        <span class="sm:hidden">{{ $comment->created_at->diffForHumans() ? Str::replace([' ago', ' minutes', ' hours', ' days', ' weeks', ' months'], ['', 'm', 'h', 'd', 'w', 'mo'], $comment->created_at->diffForHumans()) : 'Now' }}</span>
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

                                    <!-- Comment Actions -->
                                    @auth
                                    <div class="flex items-center gap-3 mt-3 pl-13">
                                        <button onclick="openFlagModal('App\\Models\\ForumComment', {{ $comment->id }})" 
                                                data-flag-type="App\Models\ForumComment" 
                                                data-flag-id="{{ $comment->id }}"
                                                class="flex items-center gap-1 px-2 py-1 rounded-lg text-xs {{ $comment->isFlaggedBy(auth()->id()) ? 'text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600' }} transition-all duration-200"
                                                title="{{ $comment->isFlaggedBy(auth()->id()) ? 'Comment flagged' : 'Flag comment' }}">
                                            <span class="material-symbols-outlined !text-sm">flag</span>
                                            <span>Flag</span>
                                        </button>
                                    </div>
                                    @endauth
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
                                                                <span class="hidden sm:inline">{{ $reply->created_at->diffForHumans() ?? 'Recently' }}</span>
                                                                <span class="sm:hidden">{{ $reply->created_at->diffForHumans() ? Str::replace([' ago', ' minutes', ' hours', ' days', ' weeks', ' months'], ['', 'm', 'h', 'd', 'w', 'mo'], $reply->created_at->diffForHumans()) : 'Now' }}</span>
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
                                                
                                                <!-- Reply Actions -->
                                                @auth
                                                <div class="flex items-center gap-3 mt-2 pl-11">
                                                    <button onclick="openFlagModal('App\\Models\\ForumComment', {{ $reply->id }})" 
                                                            data-flag-type="App\Models\ForumComment" 
                                                            data-flag-id="{{ $reply->id }}"
                                                            class="flex items-center gap-1 px-2 py-1 rounded-lg text-xs {{ $reply->isFlaggedBy(auth()->id()) ? 'text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-600' }} transition-all duration-200"
                                                            title="{{ $reply->isFlaggedBy(auth()->id()) ? 'Reply flagged' : 'Flag reply' }}">
                                                        <span class="material-symbols-outlined !text-xs">flag</span>
                                                        <span>Flag</span>
                                                    </button>
                                                </div>
                                                @endauth
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
        <div class="sticky top-8 space-y-4 sm:space-y-6">
            <!-- Author Info Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-4 sm:p-6">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-3 sm:mb-4 text-sm sm:text-base">Discussion Author</h4>
                <div class="flex items-center gap-3 sm:gap-4">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-white font-bold text-lg sm:text-xl shadow-lg">
                        {{ $post->is_anonymous ? '?' : strtoupper(substr($post->user->name ?? 'A', 0, 2)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="font-semibold text-gray-900 dark:text-white text-sm sm:text-base truncate">
                            {{ $post->is_anonymous ? 'Anonymous User' : ($post->user->name ?? 'Unknown User') }}
                        </p>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                            <span class="hidden sm:inline">Posted {{ $post->created_at->diffForHumans() ?? 'recently' }}</span>
                            <span class="sm:hidden">{{ $post->created_at->diffForHumans() ? Str::replace([' ago', ' minutes', ' hours', ' days', ' weeks', ' months'], ['', 'm', 'h', 'd', 'w', 'mo'], $post->created_at->diffForHumans()) : 'Now' }}</span>
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
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-4 sm:p-6">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-3 sm:mb-4 text-sm sm:text-base">Discussion Stats</h4>
                <div class="space-y-3 sm:space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                            <span class="material-symbols-outlined !text-sm">thumb_up</span>
                            <span class="text-xs sm:text-sm">Upvotes</span>
                        </div>
                        <span class="font-semibold text-gray-900 dark:text-white text-sm sm:text-base">{{ $post->upvotes ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                            <span class="material-symbols-outlined !text-sm">comment</span>
                            <span class="text-xs sm:text-sm">Replies</span>
                        </div>
                        <span class="font-semibold text-gray-900 dark:text-white text-sm sm:text-base">{{ $post->comments_count ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                            <span class="material-symbols-outlined !text-sm">visibility</span>
                            <span class="text-xs sm:text-sm">Views</span>
                        </div>
                        <span class="font-semibold text-gray-900 dark:text-white text-sm sm:text-base">{{ $post->views ?? 0 }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                            <span class="material-symbols-outlined !text-sm">schedule</span>
                            <span class="text-xs sm:text-sm">Posted</span>
                        </div>
                        <span class="font-semibold text-gray-900 dark:text-white text-xs sm:text-sm">{{ $post->created_at->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Related Discussions -->
            @if($post->category ?? null)
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-4 sm:p-6">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-3 sm:mb-4 text-sm sm:text-base">More in {{ $post->category->name }}</h4>
                <div class="space-y-3">
                    <a href="{{ route('public.forum.category', $post->category->slug) }}" class="block p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary">{{ $post->category->icon ?? 'forum' }}</span>
                            <div class="min-w-0 flex-1">
                                <p class="font-medium text-gray-900 dark:text-white text-xs sm:text-sm">Browse {{ $post->category->name }}</p>
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
<section class="py-8 sm:py-12 lg:py-16 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 sm:mb-12">
            <div class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-primary/20 rounded-full mb-3 sm:mb-4">
                <span class="material-symbols-outlined text-2xl sm:text-3xl text-primary">forum</span>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-3 sm:mb-4">Continue the Conversation</h2>
            <p class="text-base sm:text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto px-4">
                Explore more discussions, share your experiences, and connect with our supportive community.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            <!-- Browse Category -->
            @if($post->category ?? null)
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center gap-3 sm:gap-4 mb-3 sm:mb-4">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-primary to-green-600 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-lg sm:text-xl">{{ $post->category->icon ?? 'forum' }}</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="font-bold text-gray-900 dark:text-white group-hover:text-primary transition-colors text-sm sm:text-base">
                            More {{ $post->category->name }}
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Explore similar discussions</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-xs sm:text-sm mb-3 sm:mb-4 leading-relaxed">
                    {{ $post->category->description ?? 'Discover more conversations and insights in this category.' }}
                </p>
                <a href="{{ route('public.forum.category', $post->category->slug) }}" 
                   class="inline-flex items-center gap-2 text-primary font-semibold text-xs sm:text-sm hover:gap-3 transition-all">
                    <span>Browse Category</span>
                    <span class="material-symbols-outlined !text-sm">arrow_forward</span>
                </a>
            </div>
            @endif

            <!-- Start New Discussion -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300 group">
                <div class="flex items-center gap-3 sm:gap-4 mb-3 sm:mb-4">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-lg sm:text-xl">add_circle</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="font-bold text-gray-900 dark:text-white group-hover:text-primary transition-colors text-sm sm:text-base">
                            Start Discussion
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Share your thoughts</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-xs sm:text-sm mb-3 sm:mb-4 leading-relaxed">
                    Have something on your mind? Start a new discussion and connect with our community.
                </p>
                @auth
                    <button onclick="openCreateDiscussionModal({{ $post->category->id ?? 'null' }})" 
                            class="inline-flex items-center gap-2 text-primary font-semibold text-xs sm:text-sm hover:gap-3 transition-all">
                        <span>Create Post</span>
                        <span class="material-symbols-outlined !text-sm">arrow_forward</span>
                    </button>
                @else
                    <button onclick="openLoginModal()" 
                            class="inline-flex items-center gap-2 text-primary font-semibold text-xs sm:text-sm hover:gap-3 transition-all">
                        <span>Sign In to Post</span>
                        <span class="material-symbols-outlined !text-sm">arrow_forward</span>
                    </button>
                @endauth
            </div>

            <!-- Community Guidelines -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-lg transition-all duration-300 group sm:col-span-2 lg:col-span-1">
                <div class="flex items-center gap-3 sm:gap-4 mb-3 sm:mb-4">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-lg sm:text-xl">verified_user</span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="font-bold text-gray-900 dark:text-white group-hover:text-primary transition-colors text-sm sm:text-base">
                            Community Guidelines
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Safe & supportive space</p>
                    </div>
                </div>
                <p class="text-gray-600 dark:text-gray-400 text-xs sm:text-sm mb-3 sm:mb-4 leading-relaxed">
                    Our community thrives on respect, support, and constructive conversations. Learn more about our guidelines.
                </p>
                <button class="inline-flex items-center gap-2 text-primary font-semibold text-xs sm:text-sm hover:gap-3 transition-all">
                    <span>Learn More</span>
                    <span class="material-symbols-outlined !text-sm">arrow_forward</span>
                </button>
            </div>
        </div>

        <!-- Call to Action -->
        @guest
        <div class="mt-8 sm:mt-12 text-center">
            <div class="bg-gradient-to-r from-primary/10 to-green-50 dark:from-primary/20 dark:to-gray-800 rounded-2xl p-6 sm:p-8 border border-primary/20 dark:border-primary/30">
                <div class="max-w-2xl mx-auto">
                    <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-3 sm:mb-4">
                        Join Our Community Today
                    </h3>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-4 sm:mb-6 leading-relaxed px-4">
                        Connect with peers, share your experiences, and find support in a safe, moderated environment. 
                        Your voice matters in our community.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center px-4">
                        <button onclick="openSignupModal()" 
                                class="inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2 sm:py-3 bg-primary text-white rounded-xl font-semibold hover:bg-primary/90 transition-all duration-200 transform hover:scale-105 shadow-lg text-sm sm:text-base">
                            <span class="material-symbols-outlined">person_add</span>
                            <span>Create Free Account</span>
                        </button>
                        <button onclick="openLoginModal()" 
                                class="inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2 sm:py-3 bg-white dark:bg-gray-700 text-primary border-2 border-primary rounded-xl font-semibold hover:bg-primary hover:text-white transition-all duration-200 text-sm sm:text-base">
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

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    toast.className = `fixed top-4 right-4 ${bgColor} text-white px-4 py-2 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300`;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    // Slide in
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 10);
    
    // Slide out and remove
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}

function formatTimeAgo(dateString) {
    const now = new Date();
    const date = new Date(dateString);
    const diffInSeconds = Math.floor((now - date) / 1000);
    
    if (diffInSeconds < 60) return 'just now';
    if (diffInSeconds < 3600) return Math.floor(diffInSeconds / 60) + ' minutes ago';
    if (diffInSeconds < 86400) return Math.floor(diffInSeconds / 3600) + ' hours ago';
    return Math.floor(diffInSeconds / 86400) + ' days ago';
}

function addCommentToList(comment) {
    const commentsList = document.getElementById('commentsList');
    const commentHtml = `
        <div class="group" data-comment-id="${comment.id}">
            <div class="flex gap-4">
                <!-- Comment Upvote Section -->
                <div class="flex flex-col items-center gap-2 min-w-[44px]">
                    <form action="/forum/comment/${comment.id}/upvote" method="POST" class="inline">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="w-9 h-9 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-primary/10 hover:text-primary transition-all duration-200 flex items-center justify-center">
                            <span class="material-symbols-outlined text-sm">thumb_up</span>
                        </button>
                    </form>
                </div>
                
                <!-- Comment Content -->
                <div class="flex-1">
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-2xl p-5 group-hover:bg-gray-100 dark:group-hover:bg-gray-700/70 transition-colors">
                        <!-- Comment Header -->
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-white font-bold shadow-sm">
                                ${comment.is_anonymous ? '?' : comment.author_initial}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold text-gray-900 dark:text-white">
                                            ${comment.author_name}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 bg-gray-200 dark:bg-gray-600 px-2 py-1 rounded-full">
                                            just now
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Comment Text -->
                        <div class="text-gray-700 dark:text-gray-300 leading-relaxed pl-13">
                            ${comment.comment}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Add the new comment at the top of the list
    commentsList.insertAdjacentHTML('afterbegin', commentHtml);
    
    // Update comment count in header
    const commentCountElements = document.querySelectorAll('[data-comment-count]');
    commentCountElements.forEach(element => {
        const currentCount = parseInt(element.textContent) || 0;
        element.textContent = currentCount + 1;
    });
    
    // Update discussion header comment count
    const discussionHeader = document.querySelector('h3');
    if (discussionHeader && discussionHeader.textContent.includes('Discussion')) {
        const currentCount = parseInt(discussionHeader.textContent.match(/\d+/)?.[0] || 0);
        discussionHeader.innerHTML = discussionHeader.innerHTML.replace(/\(\d+\)/, `(${currentCount + 1})`);
    }
}

// Auto-resize textarea and handle form submission
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('commentTextarea');
    const commentForm = document.getElementById('commentForm');
    const submitBtn = document.getElementById('submitCommentBtn');
    const submitBtnText = document.getElementById('submitBtnText');
    const submitBtnSpinner = document.getElementById('submitBtnSpinner');
    
    // Auto-resize textarea
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 150) + 'px';
        });
    }
    
    // Handle form submission
    if (commentForm) {
        commentForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const comment = formData.get('comment').trim();
            
            if (!comment) {
                showToast('Please enter a comment', 'error');
                return;
            }
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtnText.classList.add('hidden');
            submitBtnSpinner.classList.remove('hidden');
            
            // Submit via AJAX
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Add comment to the list
                    addCommentToList(data.comment);
                    
                    // Reset form
                    textarea.value = '';
                    textarea.style.height = 'auto';
                    document.getElementById('is_anonymous').checked = false;
                    
                    // Show success message
                    showToast('Comment posted successfully!', 'success');
                } else {
                    showToast(data.message || 'Failed to post comment', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Failed to post comment. Please try again.', 'error');
            })
            .finally(() => {
                // Reset button state
                submitBtn.disabled = false;
                submitBtnText.classList.remove('hidden');
                submitBtnSpinner.classList.add('hidden');
            });
        });
    }
});
</script>
@endpush
@endsection
