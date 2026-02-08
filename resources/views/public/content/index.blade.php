@extends('layouts.public')

@section('title', 'Educational Resources - WellPath')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden h-screen">
    <!-- Background Image -->
    <div class="absolute inset-0 overflow-hidden">
        <img src="{{ asset('images/contentpage-hero.avif') }}" 
             alt="Students studying and learning" 
             class="w-full h-full object-cover animate-hero-zoom">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>
    
    <!-- Content -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center justify-center">
        <div class="text-center">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-semibold mb-6">
                <span class="material-symbols-outlined !text-lg">library_books</span>
                Educational Resources
            </div>
            <h1 class="text-4xl lg:text-6xl font-black text-white tracking-tight mb-4">Your Knowledge Hub for Well-being</h1>
            <p class="text-xl lg:text-2xl text-white/90 max-w-4xl mx-auto leading-relaxed mb-6">Explore over 150 resources to support you and help our community stay safe and informed.</p>
            <div class="mt-6 max-w-2xl mx-auto relative">
                <label class="flex flex-col min-w-40 h-14 w-full">
                    <div class="flex w-full flex-1 items-stretch rounded-xl h-full shadow-lg">
                        <div class="text-gray-500 flex bg-white dark:bg-gray-800 items-center justify-center pl-4 rounded-l-xl border-y border-l border-gray-300 dark:border-gray-600">
                            <span class="material-symbols-outlined">search</span>
                        </div>
                        <input id="search-input" class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-r-xl text-charcoal dark:text-white focus:outline-0 focus:ring-2 focus:ring-primary focus:ring-inset border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 h-full placeholder:text-gray-500 dark:placeholder:text-gray-400 px-4 text-base" placeholder="Search for articles, videos, and more..." value="{{ request('search') }}" autocomplete="off"/>
                    </div>
                </label>
                
                <!-- Search Suggestions Dropdown -->
                <div id="search-suggestions" class="absolute top-full left-0 right-0 mt-2 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 z-50 max-h-80 overflow-y-auto hidden">
                    <div class="p-2">
                        <div id="suggestions-list" class="space-y-1">
                            <!-- Suggestions will be populated here -->
                        </div>
                        <div id="no-suggestions" class="hidden p-4 text-center text-gray-500 dark:text-gray-400 text-sm">
                            <span class="material-symbols-outlined mb-2 text-2xl">search_off</span>
                            <p>No matching content found</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-center mt-6">
                <button onclick="scrollToResources()" class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md border border-white/30 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/30 hover:border-white/50 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <span class="material-symbols-outlined !text-xl">explore</span>
                    Browse All Resources
                </button>
            </div>
        </div>
    </div>
</section>

<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col flex-1 gap-10">

        <!-- Enhanced Filters Section - Sticky -->
        <div id="filters-section" class="sticky top-16 z-40 bg-white/95 dark:bg-gray-800/95 backdrop-blur-md rounded-2xl p-4 sm:p-6 shadow-lg border border-[#f0f4f3] dark:border-gray-800 transition-all duration-300 scroll-mt-20">
            <!-- Mobile Filter Header with Toggle -->
            <div class="flex items-center justify-between mb-4 lg:hidden">
                <h3 class="text-lg font-semibold text-[#111816] dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">tune</span>
                    Filters
                </h3>
                <button id="mobile-filter-toggle" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                    <span>Show Filters</span>
                    <span id="mobile-filter-icon" class="material-symbols-outlined text-sm transition-transform">expand_more</span>
                </button>
            </div>

            <!-- Mobile Layout -->
            <div id="mobile-filters" class="hidden lg:hidden space-y-4">
                <!-- Category Filter - Full Width on Mobile -->
                <div class="w-full">
                    <label class="text-sm font-semibold text-[#111816] dark:text-gray-300 flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-primary">filter_list</span>
                        <span>Category</span>
                    </label>
                    <div class="relative w-full">
                        <select class="appearance-none rounded-xl h-10 pl-4 pr-10 border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-[#111816] dark:text-white text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 w-full cursor-pointer hover:border-primary/50" id="category-filter">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" data-slug="{{ $category->slug }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 pointer-events-none">expand_more</span>
                    </div>
                </div>
                
                <!-- Content Type Filters - Grid on Mobile -->
                <div>
                    <label class="text-sm font-semibold text-[#111816] dark:text-gray-300 block mb-2">Content Type</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        <button data-type="" class="type-filter flex h-10 items-center justify-center gap-1.5 rounded-xl {{ !request('type') ? 'bg-primary text-white' : 'bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-[#111816] dark:text-gray-300' }} px-3 text-sm font-semibold shadow-sm hover:shadow-md transition-all duration-200">
                            <span class="material-symbols-outlined !text-base">select_all</span>
                            <span>All</span>
                        </button>
                        <button data-type="article" class="type-filter flex h-10 items-center justify-center gap-1.5 rounded-xl {{ request('type') == 'article' ? 'bg-primary text-white' : 'bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-[#111816] dark:text-gray-300' }} px-3 text-sm font-medium hover:border-primary transition-all duration-200">
                            <span class="material-symbols-outlined !text-base">article</span>
                            <span>Articles</span>
                        </button>
                        <button data-type="video" class="type-filter flex h-10 items-center justify-center gap-1.5 rounded-xl {{ request('type') == 'video' ? 'bg-primary text-white' : 'bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-[#111816] dark:text-gray-300' }} px-3 text-sm font-medium hover:border-primary transition-all duration-200">
                            <span class="material-symbols-outlined !text-base">play_circle</span>
                            <span>Videos</span>
                        </button>
                        <button data-type="infographic" class="type-filter flex h-10 items-center justify-center gap-1.5 rounded-xl {{ request('type') == 'infographic' ? 'bg-primary text-white' : 'bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-[#111816] dark:text-gray-300' }} px-3 text-sm font-medium hover:border-primary transition-all duration-200">
                            <span class="material-symbols-outlined !text-base">image</span>
                            <span>Infographics</span>
                        </button>
                        <button data-type="guide" class="type-filter flex h-10 items-center justify-center gap-1.5 rounded-xl {{ request('type') == 'guide' ? 'bg-primary text-white' : 'bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-[#111816] dark:text-gray-300' }} px-3 text-sm font-medium hover:border-primary transition-all duration-200">
                            <span class="material-symbols-outlined !text-base">menu_book</span>
                            <span>Guides</span>
                        </button>
                        
                        @auth
                        <!-- Bookmarks Filter -->
                        <button id="bookmarks-filter" class="flex h-10 items-center justify-center gap-1.5 rounded-xl {{ request('bookmarked') ? 'bg-primary text-white' : 'bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-[#111816] dark:text-gray-300' }} px-3 text-sm font-medium hover:border-primary transition-all duration-200" data-bookmarked="{{ request('bookmarked') ? 'true' : 'false' }}">
                            <span class="material-symbols-outlined !text-base">{{ request('bookmarked') ? 'bookmark' : 'bookmark_border' }}</span>
                            <span>My Library</span>
                        </button>
                        @endauth
                    </div>
                </div>
            </div>
            
            <!-- Desktop Layout -->
            <div class="hidden lg:flex flex-wrap items-center gap-4">
                <!-- Category Filter -->
                <div class="flex items-center gap-3">
                    <label class="text-sm font-semibold text-[#111816] dark:text-gray-300 whitespace-nowrap flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">filter_list</span>
                        <span>Category:</span>
                    </label>
                    <div class="relative">
                        <select class="appearance-none rounded-xl h-10 pl-4 pr-10 border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-[#111816] dark:text-white text-sm font-medium focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 min-w-[180px] cursor-pointer hover:border-primary/50" id="category-filter-desktop">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" data-slug="{{ $category->slug }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400 pointer-events-none">expand_more</span>
                    </div>
                </div>
                
                <div class="w-px h-8 bg-gray-200 dark:bg-gray-700"></div>
                
                <!-- Content Type Filters -->
                <span class="text-sm font-semibold text-[#111816] dark:text-gray-300">Type:</span>
                <button data-type="" class="type-filter flex h-10 items-center justify-center gap-1.5 rounded-xl {{ !request('type') ? 'bg-primary text-white' : 'bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-[#111816] dark:text-gray-300' }} px-4 text-sm font-semibold shadow-sm hover:shadow-md transition-all duration-200">
                    <span class="material-symbols-outlined !text-base">select_all</span>
                    <span>All</span>
                </button>
                <button data-type="article" class="type-filter flex h-10 items-center justify-center gap-1.5 rounded-xl {{ request('type') == 'article' ? 'bg-primary text-white' : 'bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-[#111816] dark:text-gray-300' }} px-4 text-sm font-medium hover:border-primary transition-all duration-200">
                    <span class="material-symbols-outlined !text-base">article</span>
                    <span>Articles</span>
                </button>
                <button data-type="video" class="type-filter flex h-10 items-center justify-center gap-1.5 rounded-xl {{ request('type') == 'video' ? 'bg-primary text-white' : 'bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-[#111816] dark:text-gray-300' }} px-4 text-sm font-medium hover:border-primary transition-all duration-200">
                    <span class="material-symbols-outlined !text-base">play_circle</span>
                    <span>Videos</span>
                </button>
                <button data-type="infographic" class="type-filter flex h-10 items-center justify-center gap-1.5 rounded-xl {{ request('type') == 'infographic' ? 'bg-primary text-white' : 'bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-[#111816] dark:text-gray-300' }} px-4 text-sm font-medium hover:border-primary transition-all duration-200">
                    <span class="material-symbols-outlined !text-base">image</span>
                    <span>Infographics</span>
                </button>
                <button data-type="guide" class="type-filter flex h-10 items-center justify-center gap-1.5 rounded-xl {{ request('type') == 'guide' ? 'bg-primary text-white' : 'bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-[#111816] dark:text-gray-300' }} px-4 text-sm font-medium hover:border-primary transition-all duration-200">
                    <span class="material-symbols-outlined !text-base">menu_book</span>
                    <span>Guides</span>
                </button>
                
                @auth
                <div class="w-px h-8 bg-gray-200 dark:bg-gray-700"></div>
                
                <!-- Bookmarks Filter -->
                <button id="bookmarks-filter-desktop" class="flex h-10 items-center justify-center gap-1.5 rounded-xl {{ request('bookmarked') ? 'bg-primary text-white' : 'bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-[#111816] dark:text-gray-300' }} px-4 text-sm font-medium hover:border-primary transition-all duration-200" data-bookmarked="{{ request('bookmarked') ? 'true' : 'false' }}">
                    <span class="material-symbols-outlined !text-base">{{ request('bookmarked') ? 'bookmark' : 'bookmark_border' }}</span>
                    <span>My Library</span>
                </button>
                @endauth
            </div>
        </div>

        <!-- Enhanced Content Grid -->
        <div id="resources" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 scroll-mt-24">
            @forelse($contents as $content)
            <article class="group bg-white dark:bg-gray-800/50 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-[#f0f4f3] dark:border-gray-800 transform hover:-translate-y-1 flex flex-col h-full" 
                     data-title="{{ strtolower($content->title) }}" 
                     data-description="{{ strtolower($content->description) }}" 
                     data-category="{{ $content->category_id }}" 
                     data-category-name="{{ strtolower($content->category->name) }}"
                     data-type="{{ strtolower($content->type) }}"
                     data-bookmarked="{{ auth()->check() && $content->isBookmarkedBy(auth()->id()) ? 'true' : 'false' }}">
                <!-- Image Container with Overlay -->
                <div class="relative w-full aspect-video bg-center bg-no-repeat bg-cover overflow-hidden" 
                     style="background-image: url('{{ $content->featured_image ? $content->featured_image_url : 'https://lh3.googleusercontent.com/aida-public/AB6AXuDuXoSapEBaja_kQ1hrYBGTGOGzYhm8hAs4J1cnbzKK5K4J3XnDAZgVzVLDrTSqsLKear5TspYM6ur2y5JoX9vXUlm6wR287hGWzn1-HvqOtuRpyVefLK8NtI5ORkjQFiB6MBqwd8fwMNkEHk84VAS-lbFQyOMpL7VoHohpIb_HpqXUYCS7bIDxZU8Xf5CN7riZcvzO2voJDsPEsy3bKcGBVfn1UoAm23rLIjMHroTlkiDHVGlaEGfPWH-OE908XwE3hynanLtD3w' }}')">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <!-- Content Type Badge -->
                    <div class="absolute top-4 left-4">
                        <div class="flex items-center gap-1 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-semibold text-[#111816] dark:text-white">
                            <span class="material-symbols-outlined !text-sm">
                                @if($content->type === 'video') play_circle
                                @elseif($content->type === 'infographic') image
                                @elseif($content->type === 'guide') menu_book
                                @else article
                                @endif
                            </span>
                            {{ ucfirst($content->type) }}
                        </div>
                    </div>
                    
                    <!-- Reading Time Badge -->
                    <div class="absolute top-4 right-4">
                        <div class="flex items-center gap-1 bg-primary/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-semibold text-white">
                            <span class="material-symbols-outlined !text-sm">schedule</span>
                            {{ $content->reading_time }} min
                        </div>
                    </div>
                    
                    <!-- Bookmark Indicator -->
                    @auth
                        @if($content->isBookmarkedBy(auth()->id()))
                            <div class="absolute top-16 right-4">
                                <div class="flex items-center justify-center w-8 h-8 bg-primary rounded-full shadow-lg">
                                    <span class="material-symbols-outlined !text-sm text-white">bookmark</span>
                                </div>
                            </div>
                        @endif
                    @endauth
                    
                    <!-- Hover Play Button for Videos -->
                    @if($content->type === 'video')
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="bg-primary/90 backdrop-blur-sm rounded-full p-4 transform scale-75 group-hover:scale-100 transition-transform duration-300">
                            <span class="material-symbols-outlined text-white !text-2xl">play_arrow</span>
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Content -->
                <div class="p-6 flex flex-col flex-1">
                    <!-- Category Badge -->
                    <div class="flex items-center justify-between mb-4">
                        <span class="inline-flex items-center gap-1 text-xs font-bold uppercase tracking-wider px-3 py-1.5 rounded-full
                            @if($content->category->name === 'Mental Health') text-yellow-700 dark:text-yellow-300 bg-yellow-100 dark:bg-yellow-900/50
                            @elseif($content->category->name === 'Alcohol') text-blue-700 dark:text-blue-300 bg-blue-100 dark:bg-blue-900/50
                            @elseif($content->category->name === 'Drug Information') text-orange-700 dark:text-orange-300 bg-orange-100 dark:bg-orange-900/50
                            @elseif($content->category->name === 'Support') text-purple-700 dark:text-purple-300 bg-purple-100 dark:bg-purple-900/50
                            @else text-green-700 dark:text-green-300 bg-green-100 dark:bg-green-900/50
                            @endif">
                            <span class="material-symbols-outlined !text-sm">category</span>
                            {{ $content->category->name }}
                        </span>
                        
                        <!-- Bookmark Button -->
                        @auth
                            <button onclick="toggleBookmark({{ $content->id }}, this)" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group/bookmark" data-bookmarked="{{ $content->isBookmarkedBy(auth()->id()) ? 'true' : 'false' }}">
                                <span class="material-symbols-outlined !text-lg {{ $content->isBookmarkedBy(auth()->id()) ? 'text-primary' : 'text-[#61897c] dark:text-gray-400' }} group-hover/bookmark:text-primary">
                                    {{ $content->isBookmarkedBy(auth()->id()) ? 'bookmark' : 'bookmark_border' }}
                                </span>
                            </button>
                        @else
                            <button onclick="openLoginModal()" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors group/bookmark">
                                <span class="material-symbols-outlined !text-lg text-[#61897c] dark:text-gray-400 group-hover/bookmark:text-primary">bookmark_border</span>
                            </button>
                        @endauth
                    </div>
                    
                    <!-- Title - Fixed height container -->
                    <div class="mb-4 min-h-[3.5rem] flex items-start">
                        <h3 class="text-[#111816] dark:text-white text-xl font-bold leading-tight group-hover:text-primary dark:group-hover:text-primary transition-colors duration-200 line-clamp-2">
                            <a href="{{ route('content.show', $content) }}" class="block">{{ $content->title }}</a>
                        </h3>
                    </div>
                    
                    <!-- Description - Flexible height -->
                    <div class="flex-1 mb-6">
                        <p class="text-[#61897c] dark:text-gray-400 text-sm leading-relaxed line-clamp-3">
                            {{ Str::limit($content->description, 140) }}
                        </p>
                    </div>
                    
                    <!-- Footer Stats - Fixed at bottom -->
                    <div class="flex items-center justify-between pt-4 border-t border-[#f0f4f3] dark:border-gray-700 mt-auto">
                        <div class="flex items-center gap-4 text-xs text-[#61897c] dark:text-gray-500">
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined !text-base">visibility</span>
                                <span class="font-medium">{{ number_format($content->views) }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined !text-base">calendar_today</span>
                                <span class="font-medium">{{ $content->created_at->format('M j') }}</span>
                            </div>
                        </div>
                        
                        <!-- Read More Button -->
                        <a href="{{ route('content.show', $content) }}" 
                           class="inline-flex items-center gap-1 text-primary hover:text-primary/80 text-sm font-semibold transition-colors group/read">
                            @if($content->type === 'video')
                                Watch Video
                            @elseif($content->type === 'infographic')
                                View Infographic
                            @elseif($content->type === 'guide')
                                Read Guide
                            @elseif($content->type === 'document')
                                View Document
                            @else
                                Read Article
                            @endif
                            <span class="material-symbols-outlined !text-sm transform group-hover/read:translate-x-0.5 transition-transform">arrow_forward</span>
                        </a>
                    </div>
                </div>
            </article>
            @empty
            <!-- Enhanced Empty State -->
            <div class="col-span-full flex flex-col items-center justify-center gap-8 py-20 text-center">
                <div class="relative">
                    <div class="w-32 h-32 bg-gradient-to-br from-primary/20 to-primary/10 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary !text-6xl">search_off</span>
                    </div>
                    <div class="absolute -top-2 -right-2 w-8 h-8 bg-yellow-400 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-yellow-800 !text-lg">sentiment_dissatisfied</span>
                    </div>
                </div>
                <div class="flex max-w-lg flex-col items-center gap-4">
                    <h3 class="text-[#111816] dark:text-white text-2xl font-bold leading-tight">No Resources Found</h3>
                    <p class="text-[#61897c] dark:text-gray-400 text-base leading-relaxed">
                        We couldn't find any content matching your current filters. Try adjusting your search criteria or explore different categories to discover valuable resources.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <button class="flex items-center justify-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-semibold hover:bg-primary/90 transition-colors transform hover:scale-105">
                        <span class="material-symbols-outlined !text-lg">refresh</span>
                        Clear All Filters
                    </button>
                    <button class="flex items-center justify-center gap-2 px-6 py-3 bg-white dark:bg-gray-800 border border-[#f0f4f3] dark:border-gray-700 text-[#111816] dark:text-gray-200 rounded-xl font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <span class="material-symbols-outlined !text-lg">explore</span>
                        Browse All Content
                    </button>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Enhanced Pagination -->
        @if($contents->hasPages())
        <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-6 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-6">
                <!-- Results Info -->
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2 text-sm text-[#61897c] dark:text-gray-400">
                        <span class="material-symbols-outlined !text-lg">info</span>
                        <span>
                            Showing <span class="font-bold text-[#111816] dark:text-gray-200">{{ $contents->firstItem() }}-{{ $contents->lastItem() }}</span> 
                            of <span class="font-bold text-[#111816] dark:text-gray-200">{{ $contents->total() }}</span> resources
                        </span>
                    </div>
                </div>
                
                <!-- Pagination Controls -->
                <nav class="flex items-center gap-2">
                    @if ($contents->onFirstPage())
                        <button disabled class="flex items-center justify-center w-10 h-10 rounded-xl border border-[#f0f4f3] dark:border-gray-700 bg-white dark:bg-gray-800 text-[#61897c] dark:text-gray-400 opacity-50 cursor-not-allowed">
                            <span class="material-symbols-outlined !text-xl">chevron_left</span>
                        </button>
                    @else
                        <a href="{{ $contents->previousPageUrl() }}" class="flex items-center justify-center w-10 h-10 rounded-xl border border-[#f0f4f3] dark:border-gray-700 bg-white dark:bg-gray-800 text-[#61897c] dark:text-gray-400 hover:bg-primary hover:text-white hover:border-primary transition-all duration-200 transform hover:scale-105">
                            <span class="material-symbols-outlined !text-xl">chevron_left</span>
                        </a>
                    @endif

                    @php
                        $currentPage = $contents->currentPage();
                        $lastPage = $contents->lastPage();
                        $showPages = [];
                        
                        // Always show first page
                        $showPages[] = 1;
                        
                        // Show pages around current page
                        for ($i = max(2, $currentPage - 1); $i <= min($lastPage - 1, $currentPage + 1); $i++) {
                            $showPages[] = $i;
                        }
                        
                        // Always show last page
                        if ($lastPage > 1) {
                            $showPages[] = $lastPage;
                        }
                        
                        $showPages = array_unique($showPages);
                        sort($showPages);
                    @endphp
                    
                    @foreach ($showPages as $index => $page)
                        @if ($index > 0 && $showPages[$index - 1] < $page - 1)
                            <span class="flex items-center justify-center w-10 h-10 text-[#61897c] dark:text-gray-400">...</span>
                        @endif
                        
                        @if ($page == $currentPage)
                            <button class="flex items-center justify-center w-10 h-10 rounded-xl bg-primary text-white font-bold text-sm shadow-sm transform scale-105">{{ $page }}</button>
                        @else
                            <a href="{{ $contents->url($page) }}" class="flex items-center justify-center w-10 h-10 rounded-xl border border-[#f0f4f3] dark:border-gray-700 bg-white dark:bg-gray-800 text-[#111816] dark:text-gray-300 hover:bg-primary hover:text-white hover:border-primary transition-all duration-200 transform hover:scale-105 text-sm font-medium">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($contents->hasMorePages())
                        <a href="{{ $contents->nextPageUrl() }}" class="flex items-center justify-center w-10 h-10 rounded-xl border border-[#f0f4f3] dark:border-gray-700 bg-white dark:bg-gray-800 text-[#111816] dark:text-gray-300 hover:bg-primary hover:text-white hover:border-primary transition-all duration-200 transform hover:scale-105">
                            <span class="material-symbols-outlined !text-xl">chevron_right</span>
                        </a>
                    @else
                        <button disabled class="flex items-center justify-center w-10 h-10 rounded-xl border border-[#f0f4f3] dark:border-gray-700 bg-white dark:bg-gray-800 text-[#61897c] dark:text-gray-400 opacity-50 cursor-not-allowed">
                            <span class="material-symbols-outlined !text-xl">chevron_right</span>
                        </button>
                    @endif
                </nav>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- CTA Section -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-gradient-to-r from-primary/10 to-green-50 dark:from-gray-800 dark:to-gray-800/50 rounded-2xl p-8 border border-primary/20 dark:border-gray-700 overflow-hidden">
            <!-- Decorative Icons -->
            <div class="absolute top-4 left-4 opacity-10">
                <span class="material-symbols-outlined text-6xl text-primary">support_agent</span>
            </div>
            <div class="absolute bottom-4 right-4 opacity-10">
                <span class="material-symbols-outlined text-6xl text-primary">groups</span>
            </div>
            
            <div class="relative text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/20 rounded-full mb-4">
                    <span class="material-symbols-outlined text-3xl text-primary">favorite</span>
                </div>
                <h3 class="text-xl font-bold text-[#111816] dark:text-white mb-2">Need More Support?</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-2xl mx-auto">Connect with our counselors or join the community for personalized guidance.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('public.counseling.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition-colors text-sm">
                        <span class="material-symbols-outlined text-base">psychology</span>
                        <span>Get Counseling</span>
                    </a>
                    <a href="{{ route('public.forum.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white dark:bg-gray-700 text-[#111816] dark:text-white border border-gray-300 dark:border-gray-600 rounded-lg font-semibold hover:border-primary hover:text-primary transition-colors text-sm">
                        <span class="material-symbols-outlined text-base">forum</span>
                        <span>Join Community</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Hero zoom animation */
    @keyframes hero-zoom {
        0% {
            transform: scale(1);
        }
        100% {
            transform: scale(1.1);
        }
    }
    
    .animate-hero-zoom {
        animation: hero-zoom 8s ease-out infinite alternate;
    }
    
    /* Smooth scrolling for the entire page */
    html {
        scroll-behavior: smooth;
    }
    
    /* Scroll margin to account for fixed header */
    #filters-section {
        scroll-margin-top: 20px;
    }
    
    /* Enhanced sticky filter styling */
    #filters-section.sticky-active {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(240, 244, 243, 0.8);
        transition: all 0.3s ease;
    }
    
    .dark #filters-section.sticky-active {
        background: rgba(31, 41, 55, 0.98);
        border: 1px solid rgba(75, 85, 99, 0.8);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.25), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
    }
    
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
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
    
    /* Search suggestions dropdown */
    #search-suggestions {
        backdrop-filter: blur(10px);
        animation: slideDown 0.2s ease-out;
    }
    
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .suggestion-item {
        transition: all 0.15s ease;
    }
    
    .suggestion-item:hover {
        transform: translateX(4px);
    }
    
    /* Smooth hover animations */
    .group:hover .group-hover\:scale-100 {
        transform: scale(1);
    }
    
    .group:hover .group-hover\:opacity-100 {
        opacity: 1;
    }
    
    /* Custom scrollbar for better UX */
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #14eba3;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #12d494;
    }
    
    /* Loading animation */
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    /* Bookmark indicator animations */
    @keyframes bounce {
        0%, 100% {
            transform: translateY(-25%);
            animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
        }
        50% {
            transform: none;
            animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
        }
    }
    
    .animate-bounce {
        animation: bounce 1s infinite;
    }
    
    /* Bookmark indicator transition */
    .bookmark-indicator {
        transition: opacity 0.2s ease, transform 0.2s ease;
    }
</style>
@endpush

@push('scripts')
<script>
// Smooth scroll to resources section
function scrollToResources() {
    const filtersSection = document.getElementById('filters-section');
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

document.addEventListener('DOMContentLoaded', function() {
    // Mobile filter toggle functionality
    const mobileFilterToggle = document.getElementById('mobile-filter-toggle');
    const mobileFilters = document.getElementById('mobile-filters');
    const mobileFilterIcon = document.getElementById('mobile-filter-icon');
    
    if (mobileFilterToggle && mobileFilters) {
        mobileFilterToggle.addEventListener('click', function() {
            const isHidden = mobileFilters.classList.contains('hidden');
            
            if (isHidden) {
                mobileFilters.classList.remove('hidden');
                mobileFilterIcon.style.transform = 'rotate(180deg)';
                mobileFilterIcon.textContent = 'expand_less';
                mobileFilterToggle.querySelector('span:first-child').textContent = 'Hide Filters';
            } else {
                mobileFilters.classList.add('hidden');
                mobileFilterIcon.style.transform = 'rotate(0deg)';
                mobileFilterIcon.textContent = 'expand_more';
                mobileFilterToggle.querySelector('span:first-child').textContent = 'Show Filters';
            }
        });
    }
    
    // Simplified sticky filter behavior for mobile
    const filtersSection = document.getElementById('filters-section');
    
    if (filtersSection) {
        let lastScrollY = window.scrollY;
        let isSticky = false;
        
        function handleScroll() {
            const currentScrollY = window.scrollY;
            const isMobile = window.innerWidth < 1024;
            
            if (isMobile) {
                const rect = filtersSection.getBoundingClientRect();
                const headerHeight = 64;
                
                // Check if filter should be sticky (when it reaches the header)
                if (rect.top <= headerHeight && !isSticky) {
                    filtersSection.classList.add('sticky-active');
                    isSticky = true;
                } else if (rect.top > headerHeight && isSticky) {
                    filtersSection.classList.remove('sticky-active');
                    isSticky = false;
                }
            } else {
                // Desktop behavior
                const rect = filtersSection.getBoundingClientRect();
                if (rect.top <= 64 && !isSticky) {
                    filtersSection.classList.add('sticky-active');
                    isSticky = true;
                } else if (rect.top > 64 && isSticky) {
                    filtersSection.classList.remove('sticky-active');
                    isSticky = false;
                }
            }
            
            lastScrollY = currentScrollY;
        }
        
        // Use throttled scroll listener
        let ticking = false;
        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(() => {
                    handleScroll();
                    ticking = false;
                });
                ticking = true;
            }
        }, { passive: true });
    }
    
    // Filter functionality
    let currentFilters = {
        search: '',
        category: '',
        type: '',
        bookmarked: false
    };
    
    // Initialize filters from URL parameters
    function initializeFiltersFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        const categoryParam = urlParams.get('category');
        
        if (categoryParam) {
            const categorySelect = document.getElementById('category-filter');
            const categorySelectDesktop = document.getElementById('category-filter-desktop');
            
            if (categorySelect) {
                // Find option by slug using data-slug attribute
                const matchedOption = categorySelect.querySelector(`option[data-slug="${categoryParam}"]`);
                
                if (matchedOption && matchedOption.value) {
                    currentFilters.category = matchedOption.value;
                    categorySelect.value = matchedOption.value;
                    if (categorySelectDesktop) categorySelectDesktop.value = matchedOption.value;
                    applyFilters();
                    
                    // Scroll to filters section after a short delay
                    setTimeout(() => {
                        const filtersSection = document.getElementById('filters-section');
                        if (filtersSection) {
                            const headerHeight = 100;
                            const elementPosition = filtersSection.getBoundingClientRect().top + window.pageYOffset;
                            const offsetPosition = elementPosition - headerHeight;
                            
                            window.scrollTo({
                                top: offsetPosition,
                                behavior: 'smooth'
                            });
                        }
                    }, 300);
                }
            }
        }
    }
    
    // Get all content cards
    const contentCards = document.querySelectorAll('article.group');
    
    // Function to apply filters without reload
    function applyFilters() {
        const searchValue = currentFilters.search.toLowerCase();
        const categoryValue = currentFilters.category;
        const typeValue = currentFilters.type.toLowerCase();
        const bookmarkedFilter = currentFilters.bookmarked;
        
        let visibleCount = 0;
        
        contentCards.forEach(card => {
            let shouldShow = true;
            
            // Get card data from data attributes
            const cardTitle = card.getAttribute('data-title') || '';
            const cardDescription = card.getAttribute('data-description') || '';
            const cardCategory = card.getAttribute('data-category') || '';
            const cardType = card.getAttribute('data-type') || '';
            const cardBookmarked = card.getAttribute('data-bookmarked') === 'true';
            
            // Search filter
            if (searchValue && !cardTitle.includes(searchValue) && !cardDescription.includes(searchValue)) {
                shouldShow = false;
            }
            
            // Category filter
            if (categoryValue && cardCategory !== categoryValue) {
                shouldShow = false;
            }
            
            // Type filter
            if (typeValue && cardType !== typeValue) {
                shouldShow = false;
            }
            
            // Bookmarks filter
            if (bookmarkedFilter && !cardBookmarked) {
                shouldShow = false;
            }
            
            // Show/hide card with animation
            if (shouldShow) {
                card.style.display = 'block';
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 10);
                visibleCount++;
            } else {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.display = 'none';
                }, 300);
            }
        });
        
        // Show/hide empty state
        showEmptyState(visibleCount === 0);
        
        // Update URL without reload
        updateURL();
    }
    
    // Function to show/hide empty state
    function showEmptyState(show) {
        let emptyState = document.querySelector('.empty-state-message');
        
        if (show && !emptyState) {
            const grid = document.querySelector('.grid');
            emptyState = document.createElement('div');
            emptyState.className = 'empty-state-message col-span-full flex flex-col items-center justify-center gap-8 py-20 text-center';
            emptyState.innerHTML = `
                <div class="relative">
                    <div class="w-32 h-32 bg-gradient-to-br from-primary/20 to-primary/10 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary !text-6xl">search_off</span>
                    </div>
                </div>
                <div class="flex max-w-lg flex-col items-center gap-4">
                    <h3 class="text-[#111816] dark:text-white text-2xl font-bold leading-tight">No Resources Found</h3>
                    <p class="text-[#61897c] dark:text-gray-400 text-base leading-relaxed">
                        No content matches your current filters. Try adjusting your search criteria.
                    </p>
                </div>
                <button onclick="clearAllFilters()" class="flex items-center justify-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-semibold hover:bg-primary/90 transition-colors">
                    <span class="material-symbols-outlined !text-lg">refresh</span>
                    Clear All Filters
                </button>
            `;
            grid.appendChild(emptyState);
        } else if (!show && emptyState) {
            emptyState.remove();
        }
    }
    
    // Function to update URL without reload
    function updateURL() {
        const params = new URLSearchParams();
        
        if (currentFilters.search) params.set('search', currentFilters.search);
        if (currentFilters.category) params.set('category', currentFilters.category);
        if (currentFilters.type) params.set('type', currentFilters.type);
        
        const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
        window.history.pushState({}, '', newUrl);
    }
    
    // Search functionality with suggestions
    const searchInput = document.getElementById('search-input');
    const suggestionsDropdown = document.getElementById('search-suggestions');
    const suggestionsList = document.getElementById('suggestions-list');
    const noSuggestions = document.getElementById('no-suggestions');
    
    let currentSuggestionIndex = -1;
    let suggestions = [];
    
    // Debounce function
    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }
    
    // Function to fetch search suggestions
    async function fetchSuggestions(query) {
        if (query.length < 2) {
            hideSuggestions();
            return;
        }
        
        try {
            const response = await fetch(`/api/content/search-suggestions?q=${encodeURIComponent(query)}`);
            const data = await response.json();
            suggestions = data;
            displaySuggestions(data);
        } catch (error) {
            console.error('Error fetching suggestions:', error);
            hideSuggestions();
        }
    }
    
    // Function to display suggestions
    function displaySuggestions(suggestions) {
        suggestionsList.innerHTML = '';
        
        if (suggestions.length === 0) {
            noSuggestions.classList.remove('hidden');
            suggestionsList.classList.add('hidden');
        } else {
            noSuggestions.classList.add('hidden');
            suggestionsList.classList.remove('hidden');
            
            suggestions.forEach((suggestion, index) => {
                const suggestionItem = document.createElement('div');
                suggestionItem.className = 'suggestion-item p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors border-l-4 border-transparent hover:border-primary';
                suggestionItem.innerHTML = `
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 mt-1">
                            <span class="material-symbols-outlined text-primary !text-lg">
                                ${suggestion.type === 'video' ? 'play_circle' : 
                                  suggestion.type === 'infographic' ? 'image' : 
                                  suggestion.type === 'guide' ? 'menu_book' : 'article'}
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white line-clamp-1">${suggestion.title}</h4>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">${suggestion.description}</p>
                            <div class="flex items-center gap-3 mt-2 text-xs text-gray-500 dark:text-gray-500">
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined !text-xs">category</span>
                                    ${suggestion.category}
                                </span>
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined !text-xs">schedule</span>
                                    ${suggestion.reading_time} min
                                </span>
                            </div>
                        </div>
                    </div>
                `;
                
                suggestionItem.addEventListener('click', () => {
                    window.location.href = suggestion.url;
                });
                
                suggestionItem.addEventListener('mouseenter', () => {
                    currentSuggestionIndex = index;
                    updateSuggestionHighlight();
                });
                
                suggestionsList.appendChild(suggestionItem);
            });
        }
        
        showSuggestions();
    }
    
    // Function to show suggestions dropdown
    function showSuggestions() {
        if (suggestionsDropdown) {
            suggestionsDropdown.classList.remove('hidden');
        }
    }
    
    // Function to hide suggestions dropdown
    function hideSuggestions() {
        if (suggestionsDropdown) {
            suggestionsDropdown.classList.add('hidden');
            currentSuggestionIndex = -1;
        }
    }
    
    // Function to update suggestion highlight
    function updateSuggestionHighlight() {
        if (!suggestionsList) return;
        
        const items = suggestionsList.querySelectorAll('.suggestion-item');
        items.forEach((item, index) => {
            if (index === currentSuggestionIndex) {
                item.classList.add('bg-gray-50', 'dark:bg-gray-700', 'border-primary');
            } else {
                item.classList.remove('bg-gray-50', 'dark:bg-gray-700', 'border-primary');
            }
        });
    }
    
    // Debounced suggestion fetching
    const debouncedFetchSuggestions = debounce(fetchSuggestions, 300);
    
    if (searchInput) {
        // Handle input for suggestions
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            debouncedFetchSuggestions(query);
            
            // Also update filters
            currentFilters.search = query;
            if (query.length === 0) {
                applyFilters();
            }
        });
        
        // Handle keyboard navigation
        searchInput.addEventListener('keydown', function(e) {
            const items = suggestionsList.querySelectorAll('.suggestion-item');
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                currentSuggestionIndex = Math.min(currentSuggestionIndex + 1, items.length - 1);
                updateSuggestionHighlight();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                currentSuggestionIndex = Math.max(currentSuggestionIndex - 1, -1);
                updateSuggestionHighlight();
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (currentSuggestionIndex >= 0 && items[currentSuggestionIndex]) {
                    items[currentSuggestionIndex].click();
                } else {
                    // Perform search
                    currentFilters.search = searchInput.value.trim();
                    applyFilters();
                    hideSuggestions();
                }
            } else if (e.key === 'Escape') {
                hideSuggestions();
                searchInput.blur();
            }
        });
        
        // Handle focus
        searchInput.addEventListener('focus', function() {
            if (this.value.trim().length >= 2) {
                fetchSuggestions(this.value.trim());
            }
        });
        
        // Handle blur (with delay to allow clicking suggestions)
        searchInput.addEventListener('blur', function() {
            setTimeout(() => {
                hideSuggestions();
            }, 200);
        });
    }
    
    // Hide suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (searchInput && suggestionsDropdown && 
            !searchInput.contains(e.target) && !suggestionsDropdown.contains(e.target)) {
            hideSuggestions();
        }
    });
    
    // Category filter handlers (both mobile and desktop)
    const categorySelect = document.getElementById('category-filter');
    const categorySelectDesktop = document.getElementById('category-filter-desktop');
    
    function handleCategoryChange(value) {
        currentFilters.category = value;
        // Sync both selects
        if (categorySelect) categorySelect.value = value;
        if (categorySelectDesktop) categorySelectDesktop.value = value;
        applyFilters();
    }
    
    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            handleCategoryChange(this.value);
        });
    }
    
    if (categorySelectDesktop) {
        categorySelectDesktop.addEventListener('change', function() {
            handleCategoryChange(this.value);
        });
    }
    
    // Content type filter buttons
    const typeButtons = document.querySelectorAll('.type-filter');
    typeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active state from all buttons
            typeButtons.forEach(btn => {
                btn.classList.remove('bg-primary', 'text-white');
                btn.classList.add('bg-white', 'dark:bg-gray-800', 'border-2', 'border-gray-200', 'dark:border-gray-700', 'text-[#111816]', 'dark:text-gray-300');
            });
            
            // Add active state to clicked button
            this.classList.add('bg-primary', 'text-white');
            this.classList.remove('bg-white', 'dark:bg-gray-800', 'border-2', 'border-gray-200', 'dark:border-gray-700', 'text-[#111816]', 'dark:text-gray-300');
            
            // Update filter and apply
            currentFilters.type = this.getAttribute('data-type');
            applyFilters();
        });
    });
    
    // Bookmarks filter handlers (both mobile and desktop)
    const bookmarksButton = document.getElementById('bookmarks-filter');
    const bookmarksButtonDesktop = document.getElementById('bookmarks-filter-desktop');
    
    function handleBookmarkToggle(button) {
        if (!button) return; // Safety check
        
        const isActive = button.getAttribute('data-bookmarked') === 'true';
        
        // Update both buttons
        const buttons = [bookmarksButton, bookmarksButtonDesktop].filter(btn => btn);
        
        buttons.forEach(btn => {
            if (isActive) {
                // Deactivate bookmarks filter
                btn.classList.remove('bg-primary', 'text-white');
                btn.classList.add('bg-white', 'dark:bg-gray-800', 'border-2', 'border-gray-200', 'dark:border-gray-700', 'text-[#111816]', 'dark:text-gray-300');
                btn.setAttribute('data-bookmarked', 'false');
                btn.querySelector('.material-symbols-outlined').textContent = 'bookmark_border';
            } else {
                // Activate bookmarks filter
                btn.classList.add('bg-primary', 'text-white');
                btn.classList.remove('bg-white', 'dark:bg-gray-800', 'border-2', 'border-gray-200', 'dark:border-gray-700', 'text-[#111816]', 'dark:text-gray-300');
                btn.setAttribute('data-bookmarked', 'true');
                btn.querySelector('.material-symbols-outlined').textContent = 'bookmark';
            }
        });
        
        currentFilters.bookmarked = !isActive;
        applyFilters();
    }
    
    if (bookmarksButton) {
        bookmarksButton.addEventListener('click', function(e) {
            e.preventDefault();
            handleBookmarkToggle(this);
        });
    }
    
    if (bookmarksButtonDesktop) {
        bookmarksButtonDesktop.addEventListener('click', function(e) {
            e.preventDefault();
            handleBookmarkToggle(this);
        });
    }
    
    // Global function to clear all filters
    window.clearAllFilters = function() {
        currentFilters = { search: '', category: '', type: '', bookmarked: false };
        if (searchInput) searchInput.value = '';
        
        // Reset category selects (both mobile and desktop)
        if (categorySelect) categorySelect.value = '';
        if (categorySelectDesktop) categorySelectDesktop.value = '';
        
        // Reset type buttons
        typeButtons.forEach(btn => {
            btn.classList.remove('bg-primary', 'text-white');
            btn.classList.add('bg-white', 'dark:bg-gray-800', 'border-2', 'border-gray-200', 'dark:border-gray-700', 'text-[#111816]', 'dark:text-gray-300');
        });
        
        // Activate "All" button
        const allButtons = document.querySelectorAll('[data-type=""]');
        allButtons.forEach(button => {
            button.classList.add('bg-primary', 'text-white');
            button.classList.remove('bg-white', 'dark:bg-gray-800', 'border-2', 'border-gray-200', 'dark:border-gray-700', 'text-[#111816]', 'dark:text-gray-300');
        });
        
        // Reset bookmarks filters (both mobile and desktop)
        const bookmarkButtons = [bookmarksButton, bookmarksButtonDesktop].filter(btn => btn);
        bookmarkButtons.forEach(btn => {
            if (btn) {
                btn.classList.remove('bg-primary', 'text-white');
                btn.classList.add('bg-white', 'dark:bg-gray-800', 'border-2', 'border-gray-200', 'dark:border-gray-700', 'text-[#111816]', 'dark:text-gray-300');
                btn.setAttribute('data-bookmarked', 'false');
                const icon = btn.querySelector('.material-symbols-outlined');
                if (icon) icon.textContent = 'bookmark_border';
            }
        });
        
        applyFilters();
    };
    
    // Enhanced bookmark functionality
    window.toggleBookmark = function(contentId, button) {
        const icon = button.querySelector('.material-symbols-outlined');
        const isBookmarked = button.getAttribute('data-bookmarked') === 'true';
        
        // Make AJAX call to toggle bookmark
        fetch(`/content/${contentId}/bookmark`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update button state
                if (data.bookmarked) {
                    icon.textContent = 'bookmark';
                    icon.classList.remove('text-[#61897c]', 'dark:text-gray-400');
                    icon.classList.add('text-primary');
                    button.setAttribute('data-bookmarked', 'true');
                    
                    // Update card data attribute for filtering
                    button.closest('article').setAttribute('data-bookmarked', 'true');
                    
                    // Add bookmark indicator to card
                    addBookmarkIndicator(button);
                    showToast('Added to your library! 📚', 'success');
                } else {
                    icon.textContent = 'bookmark_border';
                    icon.classList.remove('text-primary');
                    icon.classList.add('text-[#61897c]', 'dark:text-gray-400');
                    button.setAttribute('data-bookmarked', 'false');
                    
                    // Update card data attribute for filtering
                    button.closest('article').setAttribute('data-bookmarked', 'false');
                    
                    // Remove bookmark indicator from card
                    removeBookmarkIndicator(button);
                    showToast('Removed from library', 'info');
                }
                
                // If bookmarks filter is active, reapply filters to show/hide cards accordingly
                if (currentFilters.bookmarked) {
                    applyFilters();
                }
            } else {
                showToast('Something went wrong. Please try again.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Network error. Please check your connection.', 'error');
        });
    };
    
    // Function to add bookmark indicator to card
    function addBookmarkIndicator(button) {
        const card = button.closest('article');
        const imageContainer = card.querySelector('.aspect-video');
        
        // Check if indicator already exists
        if (imageContainer.querySelector('.bookmark-indicator')) return;
        
        const indicator = document.createElement('div');
        indicator.className = 'bookmark-indicator absolute top-16 right-4 animate-bounce';
        indicator.innerHTML = `
            <div class="flex items-center justify-center w-8 h-8 bg-primary rounded-full shadow-lg">
                <span class="material-symbols-outlined !text-sm text-white">bookmark</span>
            </div>
        `;
        
        imageContainer.appendChild(indicator);
        
        // Remove bounce animation after 1 second
        setTimeout(() => {
            indicator.classList.remove('animate-bounce');
        }, 1000);
    }
    
    // Function to remove bookmark indicator from card
    function removeBookmarkIndicator(button) {
        const card = button.closest('article');
        const indicator = card.querySelector('.bookmark-indicator');
        
        if (indicator) {
            indicator.style.opacity = '0';
            indicator.style.transform = 'scale(0.8)';
            setTimeout(() => {
                indicator.remove();
            }, 200);
        }
    }
    
    // Login modal function is defined in login-modal.blade.php component
    // No need to redefine it here
    
    // Toast notification function
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `fixed top-20 right-4 z-50 px-6 py-3 rounded-xl shadow-lg transform translate-x-full transition-transform duration-300 ${
            type === 'success' ? 'bg-green-500 text-white' : 
            type === 'error' ? 'bg-red-500 text-white' : 
            'bg-primary text-white'
        }`;
        toast.textContent = message;
        
        document.body.appendChild(toast);
        
        // Slide in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        // Slide out and remove
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Intersection Observer for fade-in animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe all content cards
    document.querySelectorAll('article.group').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });

    // Auto-scroll to filters section if bookmarked parameter or category parameter is present
    function scrollToFiltersIfBookmarked() {
        const urlParams = new URLSearchParams(window.location.search);
        const hash = window.location.hash;
        
        // Check for bookmarked parameter or category parameter with #resources hash
        const hasBookmark = urlParams.get('bookmarked') === '1' && hash === '#resources';
        const hasCategory = urlParams.get('category') && hash === '#resources';
        
        if (hasBookmark || hasCategory) {
            setTimeout(() => {
                // Find the filters section by ID
                const filtersSection = document.getElementById('filters-section');
                
                if (filtersSection) {
                    // Calculate offset for fixed header (approximately 80px) plus some padding
                    const headerHeight = 100; // Increased to account for header + padding
                    const elementPosition = filtersSection.getBoundingClientRect().top + window.pageYOffset;
                    const offsetPosition = elementPosition - headerHeight;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                } else {
                    // Fallback to resources section with offset
                    const resourcesSection = document.getElementById('resources');
                    if (resourcesSection) {
                        const headerHeight = 120; // Extra space to show filters above
                        const elementPosition = resourcesSection.getBoundingClientRect().top + window.pageYOffset;
                        const offsetPosition = elementPosition - headerHeight;
                        
                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });
                    }
                }
            }, 300); // Increased delay to ensure page is fully loaded and filters are applied
        }
    }

    // Initialize filters from URL and call scroll function
    initializeFiltersFromURL();
    scrollToFiltersIfBookmarked();
});
</script>
@endpush