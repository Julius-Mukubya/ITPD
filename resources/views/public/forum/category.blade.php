@extends('layouts.public')

@section('title', $category->name . ' - Community Forum - WellPath')

@section('content')


<!-- Error Messages -->
@if($errors->any())
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-4">
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
</div>
@endif

<!-- Hero Section -->
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
            $categoryImage = $categoryImages[$category->slug] ?? $categoryImages['general'];
        @endphp
        <img src="{{ $categoryImage }}" 
             alt="{{ $category->name }} discussions" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>
    
    <!-- Content -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center py-8 sm:py-12">
        <div class="w-full">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-xs sm:text-sm text-white/80 mb-4 sm:mb-6">
                <a href="{{ route('public.forum.index') }}" class="hover:text-white transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined !text-sm">arrow_back</span>
                    Forum
                </a>
                <span class="material-symbols-outlined !text-xs">chevron_right</span>
                <span class="text-white font-medium truncate">{{ $category->name }}</span>
            </nav>
            
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 lg:gap-8">
                <div class="flex items-start sm:items-center gap-3 sm:gap-6">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 lg:w-20 lg:h-20 bg-white/20 backdrop-blur-sm rounded-xl sm:rounded-2xl flex items-center justify-center shadow-lg border border-white/30 flex-shrink-0">
                        <span class="material-symbols-outlined text-white text-2xl sm:text-2xl lg:text-3xl">{{ $category->icon ?? 'forum' }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h1 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-black text-white tracking-tight mb-2 sm:mb-4 break-words">{{ $category->name }}</h1>
                        <p class="text-sm sm:text-base lg:text-lg text-white/90 mb-2 sm:mb-4 line-clamp-2">{{ $category->description ?? 'Discussions in this category' }}</p>
                        <div class="flex flex-wrap items-center gap-2 sm:gap-4 text-xs sm:text-sm text-white/80">
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined !text-sm">article</span>
                                {{ $posts->total() }} {{ Str::plural('discussion', $posts->total()) }}
                            </span>
                            <span class="hidden sm:inline">•</span>
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined !text-sm">groups</span>
                                Active community
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="hidden md:flex flex-col gap-3">
                    <a href="{{ route('public.forum.index') }}" class="inline-flex items-center justify-center gap-2 bg-white/20 backdrop-blur-sm border-2 border-white/30 text-white px-4 lg:px-6 py-2.5 lg:py-3 rounded-xl font-bold hover:bg-white/30 transition-all duration-200 transform hover:scale-105 text-sm">
                        <span class="material-symbols-outlined !text-base">forum</span>
                        All Categories
                    </a>
                    @auth
                        <button onclick="openCreateDiscussionModal({{ $category->id }})" class="inline-flex items-center justify-center gap-2 bg-white text-primary px-4 lg:px-6 py-2.5 lg:py-3 rounded-xl font-bold hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-lg text-sm">
                            <span class="material-symbols-outlined !text-base">add_circle</span>
                            New Discussion
                        </button>
                    @else
                        <button onclick="openLoginModal()" class="inline-flex items-center justify-center gap-2 bg-white text-primary px-4 lg:px-6 py-2.5 lg:py-3 rounded-xl font-bold hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-lg text-sm">
                            <span class="material-symbols-outlined !text-base">login</span>
                            Login to Post
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>

<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    <div class="flex flex-col lg:flex-row gap-6 sm:gap-8">
        <!-- Main Content -->
        <div class="flex-1 min-w-0">
            <!-- Create Post Button (for authenticated users) -->
            @auth
            <div class="mb-6 sm:mb-8">
                <div class="bg-gradient-to-r from-primary/5 to-green-50 dark:from-primary/10 dark:to-gray-800 rounded-xl sm:rounded-2xl border border-primary/20 dark:border-primary/30 p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4">
                        <div class="flex items-center gap-3 sm:gap-4">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 dark:text-white text-sm sm:text-base">Share in {{ $category->name }}</h3>
                                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Start a discussion in this category</p>
                            </div>
                        </div>
                        <button onclick="openCreateDiscussionModal({{ $category->id }})" 
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 sm:px-6 py-2.5 sm:py-3 bg-primary text-white rounded-xl font-bold hover:bg-primary/90 transition-all duration-200 transform hover:scale-105 shadow-lg text-sm">
                            <span class="material-symbols-outlined !text-base">add</span>
                            New Discussion
                        </button>
                    </div>
                </div>
            </div>
            @endauth

            <!-- Discussions List -->
            <div class="space-y-3 sm:space-y-4">
                @forelse($posts as $post)
                <article class="group bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 hover:border-primary/30 hover:shadow-lg transition-all duration-300">
                    <div class="p-4 sm:p-6">
                        <div class="flex gap-3 sm:gap-4">
                            <!-- Left: Engagement Stats -->
                            <div class="hidden sm:flex flex-col items-center gap-3 min-w-[60px]">
                                <!-- Comments -->
                                <div class="flex flex-col items-center relative">
                                    <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center cursor-pointer comment-hover-trigger" 
                                         data-post-id="{{ $post->id }}"
                                         onmouseenter="showCommentPreview(this)" 
                                         onmouseleave="hideCommentPreview(this)">
                                        <span class="material-symbols-outlined text-primary !text-base">comment</span>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-600 dark:text-gray-400 mt-1">{{ $post->comments_count ?? 0 }}</span>
                                    
                                    <!-- Comment Preview Tooltip -->
                                    <div class="comment-preview absolute left-full ml-4 top-0 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg p-4 w-80 z-50 hidden">
                                        <div class="flex items-center gap-2 mb-3">
                                            <span class="material-symbols-outlined text-primary text-sm">comment</span>
                                            <span class="font-semibold text-gray-900 dark:text-white text-sm">Recent Comments</span>
                                        </div>
                                        <div class="comment-content">
                                            <div class="flex items-center justify-center py-4">
                                                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-primary"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right: Content -->
                            <div class="flex-1 min-w-0">
                                <!-- Header -->
                                <div class="flex items-start justify-between gap-3 sm:gap-4 mb-2 sm:mb-3">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-2">
                                            <!-- Hot/Trending Badge -->
                                            @if(($post->comments_count ?? 0) > 5)
                                            <span class="inline-flex items-center gap-1 bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 text-xs px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-full font-semibold">
                                                <span class="material-symbols-outlined !text-xs sm:!text-sm">local_fire_department</span>
                                                <span class="hidden xs:inline">Hot</span>
                                            </span>
                                            @endif
                                        </div>
                                        
                                        <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:text-primary transition-colors line-clamp-2">
                                            <a href="{{ route('public.forum.show', $post->id) }}">{{ $post->title ?? 'Untitled Post' }}</a>
                                        </h3>
                                        
                                        <!-- Content Preview -->
                                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-2 sm:mb-3 line-clamp-2 leading-relaxed">
                                            {{ Str::limit($post->content ?? 'No content available', 150) }}
                                        </p>
                                        
                                        <!-- Meta Info -->
                                        <div class="flex flex-wrap items-center gap-2 sm:gap-4 text-xs text-gray-500 dark:text-gray-400">
                                            <div class="flex items-center gap-1.5 sm:gap-2">
                                                <div class="w-5 h-5 sm:w-6 sm:h-6 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-white text-[10px] sm:text-xs font-bold">
                                                    {{ $post->is_anonymous ? '?' : strtoupper(substr($post->user->name ?? 'A', 0, 1)) }}
                                                </div>
                                                <span class="font-medium truncate max-w-[100px] sm:max-w-none">{{ $post->is_anonymous ? 'Anonymous' : ($post->user->name ?? 'Unknown') }}</span>
                                            </div>
                                            <span class="hidden xs:inline">•</span>
                                            <span class="flex items-center gap-1">
                                                <span class="material-symbols-outlined !text-xs sm:!text-sm">schedule</span>
                                                <span class="hidden sm:inline">{{ $post->created_at->diffForHumans() ?? 'Recently' }}</span>
                                                <span class="sm:hidden">{{ $post->created_at->diffForHumans() ? Str::replace([' ago', ' minutes', ' hours', ' days'], ['', 'm', 'h', 'd'], $post->created_at->diffForHumans()) : 'Now' }}</span>
                                            </span>
                                            <span class="hidden xs:inline">•</span>
                                            <span class="flex items-center gap-1">
                                                <span class="material-symbols-outlined !text-xs sm:!text-sm">visibility</span>
                                                {{ $post->views ?? 0 }}
                                            </span>
                                            <span class="sm:hidden flex items-center gap-1">
                                                <span class="material-symbols-outlined !text-xs">comment</span>
                                                {{ $post->comments_count ?? 0 }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex flex-wrap items-center gap-2 sm:gap-3 pt-2 sm:pt-3 border-t border-gray-100 dark:border-gray-700">
                                    <a href="{{ route('public.forum.show', $post->id) }}" class="flex items-center gap-1 text-primary hover:text-primary/80 text-xs sm:text-sm font-semibold transition-colors">
                                        <span>Read</span>
                                        <span class="material-symbols-outlined !text-sm group-hover:translate-x-0.5 transition-transform">arrow_forward</span>
                                    </a>
                                    
                                    <button class="flex items-center gap-1 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-xs sm:text-sm font-medium transition-colors">
                                        <span class="material-symbols-outlined !text-sm">bookmark_border</span>
                                        <span class="hidden xs:inline">Save</span>
                                    </button>
                                    
                                    <button class="flex items-center gap-1 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-xs sm:text-sm font-medium transition-colors">
                                        <span class="material-symbols-outlined !text-sm">share</span>
                                        <span class="hidden xs:inline">Share</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                @empty
                <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 p-8 sm:p-16 text-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-3xl sm:text-4xl text-gray-400">{{ $category->icon ?? 'forum' }}</span>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-2">No Discussions Yet</h3>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-4 sm:mb-6 max-w-md mx-auto">Be the first to start a conversation in {{ $category->name }}!</p>
                    @guest
                    <button onclick="openSignupModal()" class="inline-flex items-center gap-2 bg-primary text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl font-bold hover:bg-primary/90 transition-colors text-sm">
                        <span class="material-symbols-outlined !text-base">person_add</span>
                        Sign Up to Post
                    </button>
                    @endguest
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $posts->links() }}
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="lg:w-80 space-y-4 sm:space-y-6">
            <!-- Category Info -->
            <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 p-4 sm:p-6">
                <h3 class="font-bold text-gray-900 dark:text-white mb-3 sm:mb-4 text-sm sm:text-base">About This Category</h3>
                <div class="space-y-2 sm:space-y-3 text-xs sm:text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Total Discussions</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $posts->total() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Active Today</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $posts->where('created_at', '>=', today())->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Other Categories -->
            <div class="bg-white dark:bg-gray-800 rounded-xl sm:rounded-2xl border border-gray-200 dark:border-gray-700 p-4 sm:p-6">
                <h3 class="font-bold text-gray-900 dark:text-white mb-3 sm:mb-4 text-sm sm:text-base">Other Categories</h3>
                <div class="space-y-2 sm:space-y-3">
                    @foreach($categories->where('id', '!=', $category->id)->take(5) as $otherCategory)
                    <a href="{{ route('public.forum.category', $otherCategory->slug) }}" class="flex items-center gap-2 sm:gap-3 p-2 sm:p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors group">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-primary to-green-600 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="material-symbols-outlined text-white text-base sm:text-lg">{{ $otherCategory->icon ?? 'forum' }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-gray-900 dark:text-white group-hover:text-primary transition-colors text-xs sm:text-sm truncate">{{ $otherCategory->name }}</h4>
                            <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400">{{ $otherCategory->posts_count ?? 0 }} discussions</p>
                        </div>
                    </a>
                    @endforeach
                    
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-2 sm:pt-3 mt-2 sm:mt-3">
                        <a href="{{ route('public.forum.index') }}" class="flex items-center justify-center gap-2 p-2 sm:p-3 text-primary hover:bg-primary/5 rounded-lg transition-colors text-xs sm:text-sm font-semibold">
                            <span>View All Categories</span>
                            <span class="material-symbols-outlined !text-sm">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@guest
<!-- CTA Section -->
<section class="py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-gradient-to-r from-primary/10 to-green-50 dark:from-gray-800 dark:to-gray-800/50 rounded-xl sm:rounded-2xl p-6 sm:p-8 border border-primary/20 dark:border-gray-700 overflow-hidden">
            <!-- Decorative Icons -->
            <div class="absolute top-2 left-2 sm:top-4 sm:left-4 opacity-10">
                <span class="material-symbols-outlined text-4xl sm:text-6xl text-primary">{{ $category->icon ?? 'forum' }}</span>
            </div>
            <div class="absolute bottom-2 right-2 sm:bottom-4 sm:right-4 opacity-10">
                <span class="material-symbols-outlined text-4xl sm:text-6xl text-primary">groups</span>
            </div>
            
            <div class="relative text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-primary/20 rounded-full mb-3 sm:mb-4">
                    <span class="material-symbols-outlined text-2xl sm:text-3xl text-primary">favorite</span>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-[#111816] dark:text-white mb-2">Join the {{ $category->name }} Discussion</h3>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-4 sm:mb-6 max-w-2xl mx-auto">Connect with peers, share your experiences, and find support in a safe, moderated environment. Your voice matters.</p>
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 justify-center">
                    <button onclick="openSignupModal()" class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition-colors text-sm">
                        <span class="material-symbols-outlined !text-base">person_add</span>
                        <span>Create Free Account</span>
                    </button>
                    <button onclick="openLoginModal()" class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-white dark:bg-gray-700 text-[#111816] dark:text-white border border-gray-300 dark:border-gray-600 rounded-lg font-semibold hover:border-primary hover:text-primary transition-colors text-sm">
                        <span class="material-symbols-outlined !text-base">login</span>
                        <span>Sign In</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@endguest

@include('components.login-modal')
@include('components.signup-modal')
@include('components.forgot-password-modal')
@auth
@include('components.create-discussion-modal')

<!-- Floating Action Button (Mobile) -->
<button onclick="openCreateDiscussionModal({{ $category->id }})" 
        class="fixed bottom-6 right-6 w-14 h-14 bg-primary text-white rounded-full shadow-lg hover:bg-primary/90 transition-all duration-200 transform hover:scale-110 z-40 md:hidden flex items-center justify-center">
    <span class="material-symbols-outlined text-2xl">add</span>
</button>
@endauth

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .comment-preview {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .comment-preview::before {
        content: '';
        position: absolute;
        top: 15px;
        left: -5px;
        width: 10px;
        height: 10px;
        background: inherit;
        border-left: 1px solid;
        border-bottom: 1px solid;
        border-color: inherit;
        transform: rotate(45deg);
        z-index: -1;
    }
    
    @media (max-width: 1024px) {
        .comment-preview {
            left: -320px !important;
            right: auto !important;
        }
        
        .comment-preview::before {
            left: auto;
            right: 15px;
            transform: rotate(-135deg);
        }
    }
</style>
@endpush

@push('scripts')
<script>
// Comment preview functionality
let commentPreviewTimeout;
let currentPreviewElement = null;

function showCommentPreview(element) {
    // Clear any existing timeout
    if (commentPreviewTimeout) {
        clearTimeout(commentPreviewTimeout);
    }
    
    const postId = element.dataset.postId;
    const preview = element.parentElement.querySelector('.comment-preview');
    
    if (!preview) return;
    
    // Show the preview immediately
    preview.classList.remove('hidden');
    currentPreviewElement = preview;
    
    // Load comments if not already loaded
    if (!preview.dataset.loaded) {
        loadCommentPreview(postId, preview);
        preview.dataset.loaded = 'true';
    }
}

function hideCommentPreview(element) {
    const preview = element.parentElement.querySelector('.comment-preview');
    if (!preview) return;
    
    // Delay hiding to allow mouse movement to tooltip
    commentPreviewTimeout = setTimeout(() => {
        if (currentPreviewElement && !currentPreviewElement.matches(':hover')) {
            currentPreviewElement.classList.add('hidden');
            currentPreviewElement = null;
        }
    }, 150);
}

function loadCommentPreview(postId, previewElement) {
    const contentDiv = previewElement.querySelector('.comment-content');
    
    fetch(`/forum/${postId}/comments`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.message || data.error);
            }
            
            if (data.success && data.comments && data.comments.length > 0) {
                let html = '';
                data.comments.forEach(comment => {
                    const initial = comment.is_anonymous ? '?' : comment.author.charAt(0).toUpperCase();
                    const upvoteDisplay = comment.upvotes > 0 ? `
                        <div class="flex items-center gap-1 text-xs text-primary">
                            <span class="material-symbols-outlined text-xs">thumb_up</span>
                            <span>${comment.upvotes}</span>
                        </div>
                    ` : '';
                    
                    html += `
                        <div class="flex gap-3 mb-3 last:mb-0">
                            <div class="w-8 h-8 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                ${initial}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold text-gray-900 dark:text-white text-sm">${comment.author}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">${comment.created_at}</span>
                                    </div>
                                    ${upvoteDisplay}
                                </div>
                                <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">${comment.comment}</p>
                            </div>
                        </div>
                    `;
                });
                
                if (data.has_more) {
                    html += `
                        <div class="text-center pt-3 border-t border-gray-200 dark:border-gray-700 mt-3">
                            <a href="/forum/${postId}" class="text-primary hover:text-primary/80 text-sm font-semibold">
                                View all ${data.total} comments →
                            </a>
                        </div>
                    `;
                }
                
                contentDiv.innerHTML = html;
            } else {
                contentDiv.innerHTML = `
                    <div class="text-center py-4">
                        <span class="material-symbols-outlined text-gray-400 text-2xl mb-2">chat_bubble_outline</span>
                        <p class="text-sm text-gray-500 dark:text-gray-400">No comments yet</p>
                        <a href="/forum/${postId}" class="text-primary hover:text-primary/80 text-sm font-semibold">
                            Be the first to comment →
                        </a>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading comments:', error);
            contentDiv.innerHTML = `
                <div class="text-center py-4">
                    <p class="text-sm text-red-500">Failed to load comments</p>
                    <p class="text-xs text-gray-500 mt-1">Check console for details</p>
                </div>
            `;
        });
}

// Keep tooltip visible when hovering over it
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to comment previews to keep them visible
    document.addEventListener('mouseenter', function(e) {
        if (e.target.closest('.comment-preview')) {
            if (commentPreviewTimeout) {
                clearTimeout(commentPreviewTimeout);
                commentPreviewTimeout = null;
            }
        }
    }, true);
    
    document.addEventListener('mouseleave', function(e) {
        if (e.target.closest('.comment-preview')) {
            commentPreviewTimeout = setTimeout(() => {
                if (currentPreviewElement) {
                    currentPreviewElement.classList.add('hidden');
                    currentPreviewElement = null;
                }
            }, 150);
        }
    }, true);
});

// Auto-resize textarea
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('content');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 200) + 'px';
        });
    }
    
    // Character counter for title
    const titleInput = document.getElementById('title');
    if (titleInput) {
        const maxLength = 255;
        const counter = document.createElement('div');
        counter.className = 'text-xs text-gray-500 dark:text-gray-400 mt-1';
        counter.textContent = `0/${maxLength} characters`;
        titleInput.parentNode.appendChild(counter);
        
        titleInput.addEventListener('input', function() {
            const length = this.value.length;
            counter.textContent = `${length}/${maxLength} characters`;
            counter.className = length > maxLength * 0.9 
                ? 'text-xs text-orange-500 dark:text-orange-400 mt-1'
                : 'text-xs text-gray-500 dark:text-gray-400 mt-1';
        });
    }
});
</script>
@endpush
@endsection
