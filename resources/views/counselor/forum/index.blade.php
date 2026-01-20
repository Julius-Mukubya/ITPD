@extends('layouts.counselor')

@section('title', 'Forum Moderation')
@section('page-title', 'Community Forum')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold mb-2">Forum Moderation</h2>
                    <p class="text-white/90">Monitor and moderate community discussions</p>
                </div>
                <div class="hidden md:block">
                    <span class="material-symbols-outlined text-6xl opacity-20">forum</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-2">
                <span class="material-symbols-outlined text-blue-500 text-2xl">forum</span>
                <span class="text-xs text-gray-500 dark:text-gray-400">Total</span>
            </div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalPosts ?? 0 }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">Total Posts</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-2">
                <span class="material-symbols-outlined text-green-500 text-2xl">today</span>
                <span class="text-xs text-gray-500 dark:text-gray-400">Today</span>
            </div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $todayPosts ?? 0 }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">New Today</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-2">
                <span class="material-symbols-outlined text-orange-500 text-2xl">flag</span>
                <span class="text-xs text-gray-500 dark:text-gray-400">Flagged</span>
            </div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $flaggedPosts ?? 0 }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">Need Review</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-2">
                <span class="material-symbols-outlined text-purple-500 text-2xl">comment</span>
                <span class="text-xs text-gray-500 dark:text-gray-400">Comments</span>
            </div>
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalComments ?? 0 }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">Total Comments</p>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="mb-6">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="flex gap-8">
                <button onclick="showTab('all')" id="tab-all" class="tab-button py-4 px-1 border-b-2 border-primary text-primary font-semibold">
                    All Posts
                </button>
                <button onclick="showTab('flagged')" id="tab-flagged" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 font-medium">
                    Flagged
                </button>
                <button onclick="showTab('recent')" id="tab-recent" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 font-medium">
                    Recent
                </button>
            </nav>
        </div>
    </div>

    <!-- Posts List -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($posts ?? [] as $post)
            <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <div class="flex items-start gap-4">
                    <!-- Author Avatar -->
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-white font-bold flex-shrink-0">
                        {{ strtoupper(substr($post->user->name ?? 'A', 0, 2)) }}
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <!-- Header -->
                        <div class="flex items-start justify-between gap-4 mb-2">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $post->title ?? 'Untitled Post' }}</h3>
                                    @if($post->is_flagged ?? false)
                                        <span class="bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-xs px-2 py-1 rounded-full font-semibold">Flagged</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                                    <span>{{ $post->is_anonymous ? 'Anonymous' : ($post->user->name ?? 'Unknown') }}</span>
                                    <span>•</span>
                                    <span>{{ $post->created_at->diffForHumans() ?? 'Recently' }}</span>
                                    <span>•</span>
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">comment</span>
                                        {{ $post->comments_count ?? 0 }} comments
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex items-center gap-2">
                                <a href="{{ route('student.forum.show', $post->id ?? 1) }}" class="text-primary hover:underline text-sm font-semibold">
                                    View
                                </a>
                                @if($post->is_flagged ?? false)
                                    <button class="text-green-600 hover:underline text-sm font-semibold">
                                        Approve
                                    </button>
                                    <button class="text-red-600 hover:underline text-sm font-semibold">
                                        Remove
                                    </button>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Content Preview -->
                        <p class="text-gray-700 dark:text-gray-300 mb-3 line-clamp-2">
                            {{ $post->content ?? 'No content available' }}
                        </p>
                        
                        <!-- Tags -->
                        <div class="flex items-center gap-2">
                            <span class="bg-primary/10 text-primary text-xs px-3 py-1 rounded-full font-semibold">
                                {{ $post->category->name ?? 'General' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-12 text-center">
                <span class="material-symbols-outlined text-6xl text-gray-400 mb-4">forum</span>
                <p class="text-gray-500 dark:text-gray-400">No forum posts yet</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6">
        <div class="flex items-start gap-4">
            <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-2xl">info</span>
            <div>
                <h3 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Moderation Guidelines</h3>
                <ul class="text-sm text-blue-800 dark:text-blue-200 space-y-1">
                    <li>• Review flagged posts promptly</li>
                    <li>• Ensure discussions remain respectful and supportive</li>
                    <li>• Remove content that violates community guidelines</li>
                    <li>• Provide guidance to users when needed</li>
                </ul>
            </div>
        </div>
    </div>
</div>

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
function showTab(tabName) {
    // Remove active state from all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-primary', 'text-primary');
        button.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
    });
    
    // Add active state to selected tab
    const activeTab = document.getElementById('tab-' + tabName);
    activeTab.classList.add('border-primary', 'text-primary');
    activeTab.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
    
    // In production, filter posts based on tab
    console.log('Showing:', tabName);
}
</script>
@endpush
@endsection
