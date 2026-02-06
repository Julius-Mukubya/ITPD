@extends('layouts.public')

@section('title', 'Community Forum - WellPath')

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
<section class="relative overflow-hidden min-h-screen flex items-center">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2071&q=80" 
             alt="Students discussing and connecting in community" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>
    
    <!-- Content -->
    <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
        <div class="text-center">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-3 sm:px-4 py-2 rounded-full text-sm font-semibold mb-4 sm:mb-6">
                <span class="material-symbols-outlined !text-base sm:!text-lg">forum</span>
                Community Forum
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-6xl font-black text-white tracking-tight mb-4 sm:mb-6 leading-tight">Community Forum</h1>
            <p class="text-lg sm:text-xl lg:text-2xl text-white/90 max-w-4xl mx-auto leading-relaxed mb-6 sm:mb-8 px-4">Connect with peers, share experiences, and find support in a safe, moderated environment. Join the conversation today.</p>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center px-4">
                @auth
                    <button onclick="openCreateDiscussionModal()" class="inline-flex items-center justify-center gap-2 bg-white text-primary px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-bold text-base sm:text-lg hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="material-symbols-outlined !text-lg sm:!text-xl">add_circle</span>
                        Start Discussion
                    </button>
                @else
                    <button onclick="openLoginModal()" class="inline-flex items-center justify-center gap-2 bg-white text-primary px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-bold text-base sm:text-lg hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="material-symbols-outlined !text-lg sm:!text-xl">login</span>
                        Login to Participate
                    </button>
                @endauth
                <button onclick="scrollToDiscussions()" class="inline-flex items-center justify-center gap-2 bg-white/20 backdrop-blur-sm border-2 border-white/30 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-bold text-base sm:text-lg hover:bg-white/30 transition-all duration-200 transform hover:scale-105">
                    <span class="material-symbols-outlined !text-lg sm:!text-xl">visibility</span>
                    Browse Discussions
                </button>
            </div>
        </div>
    </div>
</section>

<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    <!-- Filter Section -->
    <div id="forum-filters" class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
        <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-4 sm:p-6 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
            <!-- Mobile Filter Header with Toggle -->
            <div class="flex items-center justify-between mb-3 sm:mb-4 lg:hidden">
                <h3 class="text-base sm:text-lg font-semibold text-[#111816] dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">tune</span>
                    Filters & Search
                </h3>
                <button id="forum-mobile-filter-toggle" class="flex items-center gap-2 px-3 py-2 text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                    <span>Show Filters</span>
                    <span id="forum-mobile-filter-icon" class="material-symbols-outlined !text-sm transition-transform">expand_more</span>
                </button>
            </div>

            <!-- Mobile Filters -->
            <div id="forum-mobile-filters" class="hidden lg:block">
                <div class="flex flex-col lg:flex-row gap-3 sm:gap-4 items-start lg:items-center justify-between">
                    <!-- Search Bar -->
                    <div class="relative flex-1 max-w-md w-full lg:w-auto">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-[#61897c] dark:text-gray-400 !text-lg sm:!text-xl">search</span>
                        <input type="text" id="search-input" placeholder="Search discussions..." 
                               class="w-full pl-10 sm:pl-12 pr-4 py-2.5 sm:py-3 rounded-xl border border-[#f0f4f3] dark:border-gray-700 bg-white dark:bg-gray-900 text-[#111816] dark:text-white placeholder-[#61897c] dark:placeholder-gray-400 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 text-sm sm:text-base">
                    </div>
                    
                    <!-- Filters Container -->
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 items-start sm:items-center w-full lg:w-auto">
                        <!-- Post Type Filter -->
                        @auth
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 w-full sm:w-auto">
                            <span class="text-xs sm:text-sm font-semibold text-[#111816] dark:text-gray-300 flex items-center gap-2 whitespace-nowrap">
                                <span class="material-symbols-outlined text-primary !text-sm sm:!text-base">person</span>
                                <span>Posts:</span>
                            </span>
                            <div class="flex items-center gap-1 sm:gap-2 bg-gray-100 dark:bg-gray-800 p-1 rounded-xl w-full sm:w-auto overflow-x-auto">
                                <button id="all-posts-btn" onclick="filterByPostType('all')" class="post-filter-btn px-2 sm:px-3 py-1.5 sm:py-2 rounded-lg bg-primary text-white font-semibold text-xs transition-all duration-200 transform hover:scale-105 shadow-sm whitespace-nowrap">
                                    All Posts
                                </button>
                                <button id="my-posts-btn" onclick="filterByPostType('my')" class="post-filter-btn px-2 sm:px-3 py-1.5 sm:py-2 rounded-lg text-[#61897c] dark:text-gray-400 hover:text-[#111816] dark:hover:text-white font-medium text-xs transition-colors whitespace-nowrap">
                                    My Posts
                                </button>
                                <button id="others-posts-btn" onclick="filterByPostType('others')" class="post-filter-btn px-2 sm:px-3 py-1.5 sm:py-2 rounded-lg text-[#61897c] dark:text-gray-400 hover:text-[#111816] dark:hover:text-white font-medium text-xs transition-colors whitespace-nowrap">
                                    Others' Posts
                                </button>
                            </div>
                        </div>
                        @endauth
                        
                        <!-- Category Filter -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 w-full sm:w-auto">
                            <span class="text-xs sm:text-sm font-semibold text-[#111816] dark:text-gray-300 flex items-center gap-2 whitespace-nowrap">
                                <span class="material-symbols-outlined text-primary !text-sm sm:!text-base">filter_list</span>
                                <span>Category:</span>
                            </span>
                            <div class="relative flex-1 sm:flex-initial">
                                <select id="category-filter" class="appearance-none rounded-xl h-9 sm:h-10 pl-3 sm:pl-4 pr-8 sm:pr-10 border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-[#111816] dark:text-white text-xs sm:text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 w-full sm:min-w-[200px] cursor-pointer hover:border-primary/50">
                                    <option value="all" {{ $selectedCategory === 'all' ? 'selected' : '' }}>All Categories</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->slug }}" {{ $selectedCategory === $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                <span class="material-symbols-outlined absolute right-2 sm:right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 pointer-events-none !text-sm sm:!text-base">expand_more</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Discussions List with Fixed Sidebar -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-4 sm:gap-6">
            <!-- Fixed Sidebar -->
            <div class="hidden lg:block w-64 flex-shrink-0">
                <div class="sticky top-24 space-y-4">
                    <!-- New Post Button -->
                    @auth
                    <button onclick="openCreateDiscussionModal()" class="w-full flex items-center justify-center gap-2 bg-primary text-white px-6 py-4 rounded-xl font-semibold text-sm hover:bg-primary/90 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="material-symbols-outlined !text-lg">add_circle</span>
                        <span>New Post</span>
                    </button>
                    @else
                    <button onclick="openLoginModal()" class="w-full flex items-center justify-center gap-2 bg-primary text-white px-6 py-4 rounded-xl font-semibold text-sm hover:bg-primary/90 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="material-symbols-outlined !text-lg">login</span>
                        <span>Login to Post</span>
                    </button>
                    @endauth
                    
                    <!-- Quick Stats Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-3 text-sm">Community Stats</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Total Posts</span>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $posts->total() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Categories</span>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $categories->count() }}</span>
                            </div>
                            @auth
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">My Posts</span>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $posts->where('user_id', auth()->id())->count() }}</span>
                            </div>
                            @endauth
                        </div>
                    </div>
                    
                    <!-- Popular Categories -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-3 text-sm">Popular Categories</h3>
                        <div class="space-y-2">
                            @foreach($categories->take(5) as $category)
                            <button onclick="filterByCategory('{{ $category->slug }}')" class="w-full text-left flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">
                                <span class="text-gray-700 dark:text-gray-300">{{ $category->name }}</span>
                                <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 px-2 py-1 rounded-full">{{ $category->posts_count ?? 0 }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Discussions Content -->
            <div class="flex-1 min-w-0">
                <div class="space-y-4 sm:space-y-6" id="discussions-container">
        @forelse($posts as $post)
        <article class="discussion-post bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-4 sm:p-6 hover:shadow-lg transition-all duration-200 hover:border-primary/30" 
                 data-category="{{ $post->category->slug ?? 'general' }}" 
                 data-title="{{ strtolower($post->title) }}" 
                 data-content="{{ strtolower(strip_tags($post->content)) }}"
                 data-author="{{ $post->is_anonymous ? 'anonymous' : strtolower($post->user->name ?? 'user') }}"
                 data-author-id="{{ $post->user_id ?? 0 }}">
            <div class="flex items-start gap-3 sm:gap-4">
                <!-- Author Avatar -->
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-white font-bold text-sm sm:text-lg">
                        {{ $post->is_anonymous ? '?' : strtoupper(substr($post->user->name ?? 'U', 0, 1)) }}
                    </div>
                </div>

                <!-- Post Content -->
                <div class="flex-1 min-w-0">
                    <!-- Post Header -->
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 sm:gap-4 mb-3">
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="bg-primary/10 text-primary px-2 py-1 rounded-full text-xs font-semibold">
                                    {{ $post->category->name ?? 'General' }}
                                </span>
                                @if($post->is_pinned)
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold flex items-center gap-1">
                                        <span class="material-symbols-outlined !text-xs">push_pin</span>
                                        Pinned
                                    </span>
                                @endif
                            </div>
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2 break-words">
                                <a href="{{ route('public.forum.show', $post->id) }}" class="hover:text-primary transition-colors">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 text-xs sm:text-sm line-clamp-3 leading-relaxed mb-3 break-words">
                                {{ Str::limit(strip_tags($post->content), 200) }}
                            </p>
                        </div>
                    </div>

                    <!-- Post Meta -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex flex-wrap items-center gap-2 sm:gap-4 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined !text-sm">person</span>
                                <span class="truncate max-w-[120px] sm:max-w-none">{{ $post->is_anonymous ? 'Anonymous' : ($post->user->name ?? 'Unknown') }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined !text-sm">schedule</span>
                                <span class="whitespace-nowrap">{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                            @if($post->views > 0)
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined !text-sm">visibility</span>
                                <span class="whitespace-nowrap">{{ $post->views }} views</span>
                            </div>
                            @endif
                        </div>

                        <!-- Post Actions -->
                        <div class="flex items-center gap-2 sm:gap-3 flex-wrap">
                            <!-- Upvotes -->
                            <div class="flex items-center gap-1">
                                @auth
                                    <form action="{{ route('public.forum.upvote', $post->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-1 px-2 py-1 rounded-lg transition-colors {{ $post->isUpvotedBy(auth()->id()) ? 'bg-primary/10 text-primary' : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                            <span class="material-symbols-outlined !text-sm">thumb_up</span>
                                            <span class="text-xs sm:text-sm font-medium">{{ $post->upvotes ?? 0 }}</span>
                                        </button>
                                    </form>
                                @else
                                    <div class="flex items-center gap-1 text-gray-500">
                                        <span class="material-symbols-outlined !text-sm">thumb_up</span>
                                        <span class="text-xs sm:text-sm font-medium">{{ $post->upvotes ?? 0 }}</span>
                                    </div>
                                @endauth
                            </div>

                            <!-- Comments -->
                            <div class="relative comments-preview-container">
                                <a href="{{ route('public.forum.show', $post->id) }}" class="flex items-center gap-1 text-gray-500 hover:text-primary transition-colors px-2 py-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700" 
                                   data-post-id="{{ $post->id }}"
                                   onmouseenter="showCommentsPreview(this, {{ $post->id }})"
                                   onmouseleave="hideCommentsPreview()">
                                    <span class="material-symbols-outlined !text-sm">chat_bubble</span>
                                    <span class="text-xs sm:text-sm font-medium">{{ $post->comments_count ?? 0 }}</span>
                                </a>
                                
                                <!-- Comments Preview Tooltip -->
                                <div id="comments-preview-{{ $post->id }}" class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 w-72 sm:w-80 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg p-4 z-50 hidden">
                                    <div class="comments-preview-content">
                                        <div class="loading-state text-center text-gray-500 dark:text-gray-400 text-sm py-4">
                                            <div class="animate-spin w-5 h-5 border-2 border-primary border-t-transparent rounded-full mx-auto mb-2"></div>
                                            Loading comments...
                                        </div>
                                        <div class="comments-content hidden"></div>
                                        <div class="no-comments-state hidden text-center text-gray-500 dark:text-gray-400 text-sm py-2">
                                            <span class="material-symbols-outlined text-2xl mb-1">chat_bubble_outline</span>
                                            <div>No comments yet</div>
                                            <div class="text-xs">Be the first to comment!</div>
                                        </div>
                                    </div>
                                    <!-- Tooltip Arrow (pointing up) -->
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-b-4 border-transparent border-b-gray-200 dark:border-b-gray-700"></div>
                                </div>
                            </div>

                            <!-- Flag Button -->
                            @auth
                                <button onclick="openFlagModal('App\\Models\\ForumPost', {{ $post->id }})" 
                                    class="flex items-center gap-1 px-2 py-1 rounded-lg transition-colors {{ $post->isFlaggedBy(auth()->id()) ? 'text-red-600 dark:text-red-400' : 'text-gray-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700' }}"
                                    data-flag-type="App\Models\ForumPost" 
                                    data-flag-id="{{ $post->id }}"
                                    title="{{ $post->isFlaggedBy(auth()->id()) ? 'Content flagged' : 'Flag content' }}">
                                    <span class="material-symbols-outlined !text-sm">flag</span>
                                </button>
                            @endauth

                            <!-- Read More -->
                            <a href="{{ route('public.forum.show', $post->id) }}" class="text-primary hover:text-primary/80 text-xs sm:text-sm font-semibold px-2 sm:px-3 py-1 rounded-lg hover:bg-primary/10 transition-colors whitespace-nowrap">
                                Read More →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        @empty
        <div class="text-center py-8 sm:py-12">
            <div class="w-16 h-16 sm:w-24 sm:h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-2xl sm:text-4xl text-gray-400">forum</span>
            </div>
            <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-2">No discussions yet</h3>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-4 sm:mb-6 px-4">Be the first to start a conversation in this category!</p>
            @auth
                <button onclick="openCreateDiscussionModal()" class="inline-flex items-center gap-2 bg-primary text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-semibold hover:bg-primary/90 transition-colors text-sm sm:text-base">
                    <span class="material-symbols-outlined">add</span>
                    Start Discussion
                </button>
            @else
                <button onclick="openLoginModal()" class="inline-flex items-center gap-2 bg-primary text-white px-4 sm:px-6 py-2 sm:py-3 rounded-lg font-semibold hover:bg-primary/90 transition-colors text-sm sm:text-base">
                    <span class="material-symbols-outlined">login</span>
                    Login to Start Discussion
                </button>
            @endauth
        </div>
        @endforelse
        
        <!-- No Results Message (hidden by default) -->
        <div id="no-results-message" class="hidden text-center py-8 sm:py-12">
            <div class="w-16 h-16 sm:w-24 sm:h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-2xl sm:text-4xl text-gray-400">search_off</span>
            </div>
            <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-2">No discussions found</h3>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-4 sm:mb-6 px-4">Try adjusting your search terms or category filter.</p>
        </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
        <div class="mt-8">
            {{ $posts->appends(request()->query())->links() }}
        </div>
        @endif

        <!-- Safe & Supportive Space Info -->
        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 border border-emerald-200 dark:border-emerald-800 rounded-2xl p-4 sm:p-6 mt-8 sm:mt-12">
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <span class="material-symbols-outlined text-primary text-2xl sm:text-3xl flex-shrink-0">info</span>
                <div class="flex-1">
                    <h3 class="font-bold text-emerald-900 dark:text-emerald-100 mb-2 text-sm sm:text-base">Safe & Supportive Space</h3>
                    <p class="text-xs sm:text-sm text-emerald-800 dark:text-emerald-200">
                        Our community forum is moderated by professional counselors to ensure a respectful and supportive environment for all members.
                    </p>
                </div>
            </div>
        </div>

        <!-- Community Guidelines -->
        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-2xl p-4 sm:p-6 lg:p-8 border border-emerald-200 dark:border-emerald-800 mt-8 sm:mt-12">
            <div class="flex flex-col sm:flex-row items-start gap-3 sm:gap-4">
                <span class="material-symbols-outlined text-primary text-2xl sm:text-3xl flex-shrink-0">verified_user</span>
                <div class="flex-1">
                    <h3 class="text-lg sm:text-xl font-bold text-emerald-900 dark:text-emerald-100 mb-3 sm:mb-4">Community Guidelines</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 text-xs sm:text-sm text-emerald-800 dark:text-emerald-200">
                        <div class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-base sm:text-lg flex-shrink-0">check_circle</span>
                            <span>Be respectful and supportive of others</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-base sm:text-lg flex-shrink-0">check_circle</span>
                            <span>Keep discussions relevant and constructive</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-base sm:text-lg flex-shrink-0">check_circle</span>
                            <span>Protect your privacy and that of others</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-base sm:text-lg flex-shrink-0">check_circle</span>
                            <span>Report inappropriate content to moderators</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- CTA Section -->
@guest
<section class="py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-gradient-to-r from-primary/10 to-green-50 dark:from-gray-800 dark:to-gray-800/50 rounded-2xl p-6 sm:p-8 border border-primary/20 dark:border-gray-700 overflow-hidden">
            <!-- Decorative Icons -->
            <div class="absolute top-3 sm:top-4 left-3 sm:left-4 opacity-10">
                <span class="material-symbols-outlined text-4xl sm:text-6xl text-primary">forum</span>
            </div>
            <div class="absolute bottom-3 sm:bottom-4 right-3 sm:right-4 opacity-10">
                <span class="material-symbols-outlined text-4xl sm:text-6xl text-primary">groups</span>
            </div>
            
            <div class="relative text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-primary/20 rounded-full mb-3 sm:mb-4">
                    <span class="material-symbols-outlined text-2xl sm:text-3xl text-primary">favorite</span>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-[#111816] dark:text-white mb-2">Join Our Community Today</h3>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-4 sm:mb-6 max-w-2xl mx-auto px-4">Connect with peers, share your experiences, and find support in a safe, moderated environment. Your voice matters.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center px-4">
                    <button onclick="openSignupModal()" class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition-colors text-sm">
                        <span class="material-symbols-outlined text-sm sm:text-base">person_add</span>
                        <span>Create Free Account</span>
                    </button>
                    <button onclick="openLoginModal()" class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-white dark:bg-gray-700 text-[#111816] dark:text-white border border-gray-300 dark:border-gray-600 rounded-lg font-semibold hover:border-primary hover:text-primary transition-colors text-sm">
                        <span class="material-symbols-outlined text-sm sm:text-base">login</span>
                        <span>Sign In</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@endguest

@auth
@include('components.create-discussion-modal')
@include('components.flag-content-modal')

<!-- Floating Action Button (Mobile) -->
<button onclick="openCreateDiscussionModal()" 
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
    
    /* Comments preview tooltip styling */
    .comments-preview-container:hover [id^="comments-preview-"] {
        display: block;
    }
    
    /* Loading spinner animation */
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    /* Custom scrollbar for comments preview */
    .comments-preview-content .max-h-48::-webkit-scrollbar {
        width: 4px;
    }
    
    .comments-preview-content .max-h-48::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 2px;
    }
    
    .comments-preview-content .max-h-48::-webkit-scrollbar-thumb {
        background: #14eba3;
        border-radius: 2px;
    }
    
    .comments-preview-content .max-h-48::-webkit-scrollbar-thumb:hover {
        background: #12d494;
    }
</style>
@endpush

@push('scripts')
<script>
// Smooth scroll to discussions section
function scrollToDiscussions() {
    const filtersSection = document.getElementById('forum-filters');
    if (filtersSection) {
        // Get the header height to offset the scroll position
        const header = document.querySelector('header');
        const headerHeight = header ? header.offsetHeight : 80;
        
        // Calculate the position to scroll to
        const elementPosition = filtersSection.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - headerHeight - 10;
        
        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
        });
    }
}

// Global variables for filtering
let currentCategory = 'all';
let currentPostType = 'all';
let currentSearchTerm = '';
let previewTimeout;
let currentUserId = {{ auth()->id() ?? 'null' }};

function showCommentsPreview(element, postId) {
    // Clear any existing timeout
    clearTimeout(previewTimeout);
    
    // Hide any other open previews
    document.querySelectorAll('[id^="comments-preview-"]').forEach(preview => {
        preview.classList.add('hidden');
    });
    
    // Show the preview after a short delay
    previewTimeout = setTimeout(() => {
        const preview = document.getElementById(`comments-preview-${postId}`);
        if (preview) {
            preview.classList.remove('hidden');
            
            // Check if comments are already loaded
            const commentsContent = preview.querySelector('.comments-content');
            if (!commentsContent.hasAttribute('data-loaded')) {
                loadComments(postId);
            }
        }
    }, 300); // 300ms delay
}

function loadComments(postId) {
    const preview = document.getElementById(`comments-preview-${postId}`);
    if (!preview) return;
    
    const loadingState = preview.querySelector('.loading-state');
    const commentsContent = preview.querySelector('.comments-content');
    const noCommentsState = preview.querySelector('.no-comments-state');
    
    // Show loading state
    loadingState.classList.remove('hidden');
    commentsContent.classList.add('hidden');
    noCommentsState.classList.add('hidden');
    
    // Fetch comments via AJAX
    fetch(`/forum/${postId}/comments`)
        .then(response => response.json())
        .then(data => {
            if (data.success && data.comments.length > 0) {
                // Build comments HTML
                let commentsHtml = '<div class="space-y-3 max-h-48 overflow-y-auto">';
                
                data.comments.forEach(comment => {
                    const initial = comment.is_anonymous ? '?' : comment.author.charAt(0).toUpperCase();
                    commentsHtml += `
                        <div class="flex gap-2 text-sm">
                            <div class="w-6 h-6 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                                ${initial}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-gray-900 dark:text-white text-xs">
                                    ${comment.author}
                                </div>
                                <div class="text-gray-600 dark:text-gray-400 text-xs line-clamp-2">
                                    ${comment.comment}
                                </div>
                                <div class="text-gray-400 text-xs mt-1">
                                    ${comment.created_at}
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                if (data.has_more) {
                    commentsHtml += `
                        <div class="text-center text-xs text-gray-500 dark:text-gray-400 pt-2 border-t border-gray-200 dark:border-gray-700">
                            +${data.total - 3} more comments
                        </div>
                    `;
                }
                
                commentsHtml += '</div>';
                commentsContent.innerHTML = commentsHtml;
                
                // Show comments content
                loadingState.classList.add('hidden');
                commentsContent.classList.remove('hidden');
                commentsContent.setAttribute('data-loaded', 'true');
            } else {
                // Show no comments state
                loadingState.classList.add('hidden');
                noCommentsState.classList.remove('hidden');
                commentsContent.setAttribute('data-loaded', 'true');
            }
        })
        .catch(error => {
            console.error('Error loading comments:', error);
            // Show error state
            loadingState.classList.add('hidden');
            commentsContent.innerHTML = '<div class="text-center text-red-500 text-sm py-2">Failed to load comments</div>';
            commentsContent.classList.remove('hidden');
            commentsContent.setAttribute('data-loaded', 'true');
        });
}

function hideCommentsPreview() {
    // Clear the timeout
    clearTimeout(previewTimeout);
    
    // Hide preview after a short delay to allow moving to the tooltip
    previewTimeout = setTimeout(() => {
        document.querySelectorAll('[id^="comments-preview-"]').forEach(preview => {
            preview.classList.add('hidden');
        });
    }, 200); // 200ms delay
}

function filterByCategory(categorySlug) {
    currentCategory = categorySlug;
    applyFilters();
    updateCategoryButtons(categorySlug);
}

function updateCategoryButtons(activeCategory) {
    // Update dropdown selection
    const categoryDropdown = document.getElementById('category-filter');
    if (categoryDropdown) {
        categoryDropdown.value = activeCategory;
    }
}

function applyFilters() {
    const posts = document.querySelectorAll('.discussion-post');
    const noResultsMessage = document.getElementById('no-results-message');
    let visibleCount = 0;

    posts.forEach(post => {
        const postCategory = post.getAttribute('data-category');
        const postTitle = post.getAttribute('data-title');
        const postContent = post.getAttribute('data-content');
        const postAuthor = post.getAttribute('data-author');
        const postAuthorId = parseInt(post.getAttribute('data-author-id'));
        
        // Check category filter
        const categoryMatch = currentCategory === 'all' || postCategory === currentCategory;
        
        // Check post type filter
        let postTypeMatch = true;
        if (currentPostType === 'my' && currentUserId) {
            postTypeMatch = postAuthorId === currentUserId;
        } else if (currentPostType === 'others' && currentUserId) {
            postTypeMatch = postAuthorId !== currentUserId;
        } else if (currentPostType === 'all') {
            postTypeMatch = true;
        }
        
        // Check search filter
        const searchMatch = currentSearchTerm === '' || 
            postTitle.includes(currentSearchTerm.toLowerCase()) ||
            postContent.includes(currentSearchTerm.toLowerCase()) ||
            postAuthor.includes(currentSearchTerm.toLowerCase());
        
        if (categoryMatch && postTypeMatch && searchMatch) {
            post.style.display = 'block';
            visibleCount++;
        } else {
            post.style.display = 'none';
        }
    });

    // Show/hide no results message
    if (visibleCount === 0) {
        noResultsMessage.classList.remove('hidden');
    } else {
        noResultsMessage.classList.add('hidden');
    }
}

function filterByPostType(postType) {
    currentPostType = postType;
    applyFilters();
    updatePostTypeButtons(postType);
}

function updatePostTypeButtons(activeType) {
    // Update button styles
    document.querySelectorAll('.post-filter-btn').forEach(btn => {
        btn.classList.remove('bg-primary', 'text-white', 'font-semibold', 'shadow-sm');
        btn.classList.add('text-[#61897c]', 'dark:text-gray-400', 'hover:text-[#111816]', 'dark:hover:text-white', 'font-medium');
    });
    
    // Activate the selected button
    const activeButton = document.getElementById(`${activeType}-posts-btn`);
    if (activeButton) {
        activeButton.classList.remove('text-[#61897c]', 'dark:text-gray-400', 'hover:text-[#111816]', 'dark:hover:text-white', 'font-medium');
        activeButton.classList.add('bg-primary', 'text-white', 'font-semibold', 'shadow-sm');
    }
}

function handleSearch(searchTerm) {
    currentSearchTerm = searchTerm;
    applyFilters();
}

function openCreateDiscussionModal(categoryId = null) {
    const modal = document.getElementById('createDiscussionModal');
    const modalContent = document.getElementById('modalContent');
    const categorySelect = document.getElementById('modal_category_id');
    
    if (!modal || !modalContent) {
        console.error('Modal elements not found');
        return;
    }
    
    // Pre-select category if provided
    if (categoryId && categorySelect) {
        categorySelect.value = categoryId;
    }
    
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Animate modal in
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
    
    // Focus on title input
    setTimeout(() => {
        document.getElementById('modal_title')?.focus();
    }, 150);
}

// Initialize filtering functionality
document.addEventListener('DOMContentLoaded', function() {
    // Mobile filter toggle functionality
    const forumMobileFilterToggle = document.getElementById('forum-mobile-filter-toggle');
    const forumMobileFilters = document.getElementById('forum-mobile-filters');
    const forumMobileFilterIcon = document.getElementById('forum-mobile-filter-icon');
    
    if (forumMobileFilterToggle && forumMobileFilters) {
        forumMobileFilterToggle.addEventListener('click', function() {
            const isHidden = forumMobileFilters.classList.contains('hidden');
            
            if (isHidden) {
                forumMobileFilters.classList.remove('hidden');
                forumMobileFilterIcon.style.transform = 'rotate(180deg)';
                forumMobileFilterIcon.textContent = 'expand_less';
                forumMobileFilterToggle.querySelector('span:first-child').textContent = 'Hide Filters';
            } else {
                forumMobileFilters.classList.add('hidden');
                forumMobileFilterIcon.style.transform = 'rotate(0deg)';
                forumMobileFilterIcon.textContent = 'expand_more';
                forumMobileFilterToggle.querySelector('span:first-child').textContent = 'Show Filters';
            }
        });
    }
    
    // Handle category filter dropdown
    const categoryDropdown = document.getElementById('category-filter');
    
    if (categoryDropdown) {
        categoryDropdown.addEventListener('change', function(e) {
            const category = e.target.value;
            filterByCategory(category);
        });
    }
    
    // Handle search input
    const searchInput = document.getElementById('search-input');
    
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            handleSearch(e.target.value);
        });
    }
    
    // Set initial category state
    const initialCategory = '{{ $selectedCategory }}' || 'all';
    currentCategory = initialCategory;
    updateCategoryButtons(initialCategory);
    
    // Smooth scroll to discussions when coming from hero section
    const hash = window.location.hash;
    if (hash === '#forum-filters') {
        setTimeout(() => {
            const filtersSection = document.getElementById('forum-filters');
            if (filtersSection) {
                // Use a very large fixed offset to ensure filter is fully visible
                const elementPosition = filtersSection.offsetTop;
                const offsetPosition = elementPosition - 250; // Much larger 250px offset
                
                window.scrollTo({
                    top: Math.max(0, offsetPosition), // Ensure we don't scroll above page top
                    behavior: 'smooth'
                });
            }
        }, 100);
    } else if (hash === '#discussions') {
        setTimeout(() => {
            const discussionsSection = document.getElementById('discussions');
            if (discussionsSection) {
                discussionsSection.scrollIntoView({ 
                    behavior: 'smooth', 
                    block: 'start' 
                });
            }
        }, 100);
    }
});
</script>
@endpush
@endsection