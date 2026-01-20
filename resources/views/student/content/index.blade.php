@extends('layouts.student')

@section('title', 'My Learning Library - WellPath')
@section('page-title', 'My Learning Library')

@section('content')
<!-- Welcome Section -->
<div class="mb-8">
    <div class="bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Your Learning Journey</h2>
                <p class="text-gray-600 dark:text-gray-400">Track your progress and continue where you left off</p>
            </div>
            <div class="hidden md:block">
                <span class="material-symbols-outlined text-6xl text-gray-300 dark:text-gray-600">auto_stories</span>
            </div>
        </div>
    </div>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between mb-2">
            <span class="material-symbols-outlined text-blue-500 text-2xl">visibility</span>
            <span class="text-xs text-gray-500 dark:text-gray-400">Total</span>
        </div>
        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_viewed'] }}</p>
        <p class="text-sm text-gray-600 dark:text-gray-400">Articles Read</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between mb-2">
            <span class="material-symbols-outlined text-green-500 text-2xl">bookmark</span>
            <span class="text-xs text-gray-500 dark:text-gray-400">Saved</span>
        </div>
        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['bookmarked'] }}</p>
        <p class="text-sm text-gray-600 dark:text-gray-400">Bookmarks</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between mb-2">
            <span class="material-symbols-outlined text-purple-500 text-2xl">schedule</span>
            <span class="text-xs text-gray-500 dark:text-gray-400">Time</span>
        </div>
        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_time'] }}</p>
        <p class="text-sm text-gray-600 dark:text-gray-400">Minutes Read</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between mb-2">
            <span class="material-symbols-outlined text-orange-500 text-2xl">local_fire_department</span>
            <span class="text-xs text-gray-500 dark:text-gray-400">Streak</span>
        </div>
        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['streak_days'] }}</p>
        <p class="text-sm text-gray-600 dark:text-gray-400">Day Streak</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="flex flex-wrap gap-4 mb-8">
    <a href="{{ route('content.index') }}" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary/90 transition-colors">
        <span class="material-symbols-outlined">explore</span>
        Browse All Content
    </a>
    <button onclick="filterContent('all')" id="filter-all" class="filter-btn inline-flex items-center gap-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
        <span class="material-symbols-outlined">grid_view</span>
        All Content
    </button>
    <button onclick="filterContent('bookmarked')" id="filter-bookmarked" class="filter-btn inline-flex items-center gap-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
        <span class="material-symbols-outlined">bookmark</span>
        My Bookmarks
    </button>
    <button onclick="filterContent('recent')" id="filter-recent" class="filter-btn inline-flex items-center gap-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
        <span class="material-symbols-outlined">history</span>
        Recently Viewed
    </button>
</div>

<!-- Continue Reading Section -->
<div class="mb-8 content-section" id="section-continue">
    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Continue Reading</h3>
    @if($continueReading->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($continueReading as $content)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-all">
            <div class="aspect-video bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 relative overflow-hidden">
                @if($content->featured_image)
                    <img src="{{ asset('storage/' . $content->featured_image) }}" alt="{{ $content->title }}" class="w-full h-full object-cover">
                @else
                    <div class="absolute inset-0 flex items-center justify-center text-gray-600 dark:text-gray-400">
                        <span class="material-symbols-outlined text-4xl">article</span>
                    </div>
                @endif
                <div class="absolute bottom-2 right-2 bg-gray-900/70 text-white text-xs px-2 py-1 rounded">
                    {{ $content->reading_time }} min
                </div>
            </div>
            <div class="p-4">
                <span class="text-xs font-semibold text-primary uppercase">{{ $content->category->name }}</span>
                <h4 class="text-lg font-bold text-gray-900 dark:text-white mt-1 mb-2 line-clamp-2">{{ $content->title }}</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">{{ $content->description }}</p>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $content->views }} views</span>
                    <a href="{{ route('content.show', $content) }}" class="text-primary hover:underline text-sm font-semibold">Continue →</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-8 text-center text-gray-500 dark:text-gray-400">
        <span class="material-symbols-outlined text-4xl mb-2 block">auto_stories</span>
        <p class="mb-2">No content available</p>
        <p class="text-sm">Check back later for new content!</p>
    </div>
    @endif
</div>

<!-- Bookmarked Content -->
<div class="mb-8 content-section" id="section-bookmarked">
    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">My Bookmarks</h3>
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($bookmarkedContent as $content)
            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <div class="flex items-start gap-4">
                    <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-lg flex-shrink-0 overflow-hidden">
                        @if($content->featured_image)
                            <img src="{{ asset('storage/' . $content->featured_image) }}" alt="{{ $content->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-600 dark:text-gray-400">
                                <span class="material-symbols-outlined text-2xl">
                                    @if($content->type === 'video') play_circle
                                    @elseif($content->type === 'infographic') image
                                    @else article
                                    @endif
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <span class="text-xs font-semibold text-primary uppercase">{{ $content->category->name }}</span>
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mt-1 mb-1">{{ $content->title }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2 line-clamp-2">{{ $content->description }}</p>
                                <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">schedule</span>
                                        {{ $content->reading_time }} min
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">visibility</span>
                                        {{ $content->views }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('content.show', $content) }}" class="text-primary hover:underline text-sm font-semibold whitespace-nowrap">Read →</a>
                                <button onclick="removeBookmark({{ $content->id }})" class="text-red-600 hover:underline text-sm font-semibold whitespace-nowrap">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                <span class="material-symbols-outlined text-4xl mb-2 block">bookmark_border</span>
                <p class="mb-2">No bookmarks yet</p>
                <p class="text-sm">Start bookmarking content to save it for later!</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Reading History -->
<div class="mb-8 content-section" id="section-recent">
    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Reading History</h3>
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($recentlyViewed as $view)
            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-lg flex-shrink-0 overflow-hidden">
                            @if($view->content->featured_image)
                                <img src="{{ asset('storage/' . $view->content->featured_image) }}" alt="{{ $view->content->title }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-600 dark:text-gray-400">
                                    <span class="material-symbols-outlined">article</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-gray-900 dark:text-white truncate">{{ $view->content->title }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $view->content->category->name }} • {{ $view->created_at ? $view->created_at->diffForHumans() : 'Recently' }}</p>
                        </div>
                    </div>
                    <a href="{{ route('content.show', $view->content) }}" class="text-primary hover:underline text-sm font-semibold whitespace-nowrap ml-4">View →</a>
                </div>
            </div>
            @empty
            <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                <span class="material-symbols-outlined text-4xl mb-2">history</span>
                <p>No reading history yet. Start exploring content!</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Recommended Content -->
<div class="content-section" id="section-recommended">
    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Recommended for You</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($recommendedContent as $content)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-all">
            <div class="aspect-video bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 relative overflow-hidden">
                @if($content->featured_image)
                    <img src="{{ asset('storage/' . $content->featured_image) }}" alt="{{ $content->title }}" class="w-full h-full object-cover">
                @else
                    <div class="absolute inset-0 flex items-center justify-center text-gray-600 dark:text-gray-400">
                        <span class="material-symbols-outlined text-4xl">
                            @if($content->type === 'video') play_circle
                            @elseif($content->type === 'infographic') image
                            @else article
                            @endif
                        </span>
                    </div>
                @endif
                <div class="absolute top-2 left-2 bg-gray-900/70 text-white text-xs px-2 py-1 rounded">
                    {{ ucfirst($content->type) }}
                </div>
            </div>
            <div class="p-4">
                <span class="text-xs font-semibold text-primary uppercase">{{ $content->category->name }}</span>
                <h4 class="text-lg font-bold text-gray-900 dark:text-white mt-1 mb-2 line-clamp-2">{{ $content->title }}</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">{{ $content->description }}</p>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $content->reading_time }} min read</span>
                    <a href="{{ route('content.show', $content) }}" class="text-primary hover:underline text-sm font-semibold">Read →</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

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
let currentFilter = 'all';

function filterContent(type) {
    currentFilter = type;
    
    // Update button states
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('bg-primary', 'text-white');
        btn.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
    });
    
    const activeBtn = document.getElementById('filter-' + type);
    if (activeBtn) {
        activeBtn.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
        activeBtn.classList.add('bg-primary', 'text-white');
    }
    
    // Show/hide sections based on filter
    const sections = {
        'all': ['section-continue', 'section-bookmarked', 'section-recent', 'section-recommended'],
        'bookmarked': ['section-bookmarked'],
        'recent': ['section-recent'],
    };
    
    // Hide all sections first
    document.querySelectorAll('.content-section').forEach(section => {
        section.style.display = 'none';
    });
    
    // Show relevant sections
    const sectionsToShow = sections[type] || sections['all'];
    sectionsToShow.forEach(sectionId => {
        const section = document.getElementById(sectionId);
        if (section) {
            section.style.display = 'block';
        }
    });
}

function removeBookmark(contentId) {
    if (confirm('Remove this bookmark?')) {
        fetch(`/api/bookmarks/${contentId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                showToast('Failed to remove bookmark', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('An error occurred', 'error');
        });
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    filterContent('all');
});
</script>
@endpush
