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
<section class="relative overflow-hidden h-screen">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2071&q=80" 
             alt="Students discussing and connecting in community" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>
    
    <!-- Content -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center justify-center">
        <div class="text-center">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-semibold mb-6">
                <span class="material-symbols-outlined !text-lg">forum</span>
                Community Forum
            </div>
            <h1 class="text-4xl lg:text-6xl font-black text-white tracking-tight mb-6">Community Forum</h1>
            <p class="text-xl lg:text-2xl text-white/90 max-w-4xl mx-auto leading-relaxed mb-8">Connect with peers, share experiences, and find support in a safe, moderated environment. Join the conversation today.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <button onclick="openCreateDiscussionModal()" class="inline-flex items-center gap-2 bg-white text-primary px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="material-symbols-outlined !text-xl">add_circle</span>
                        Start Discussion
                    </button>
                @else
                    <button onclick="openLoginModal()" class="inline-flex items-center gap-2 bg-white text-primary px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="material-symbols-outlined !text-xl">login</span>
                        Login to Participate
                    </button>
                @endauth
                <a href="#discussions" class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm border-2 border-white/30 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/30 transition-all duration-200 transform hover:scale-105">
                    <span class="material-symbols-outlined !text-xl">visibility</span>
                    Browse Discussions
                </a>
            </div>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Info Banner -->
    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 border border-emerald-200 dark:border-emerald-800 rounded-2xl p-6 mb-8">
        <div class="flex gap-4">
            <span class="material-symbols-outlined text-primary text-3xl flex-shrink-0">info</span>
            <div class="flex-1">
                <h3 class="font-bold text-emerald-900 dark:text-emerald-100 mb-2">Safe & Supportive Space</h3>
                <p class="text-sm text-emerald-800 dark:text-emerald-200 mb-3">
                    Our community forum is moderated by professional counselors to ensure a respectful and supportive environment for all members.
                </p>
                @guest
                <button onclick="openSignupModal()" class="bg-primary text-white px-4 py-2 rounded-lg font-semibold hover:bg-primary/90 transition-colors text-sm">
                    Sign Up to Join the Discussion
                </button>
                @endguest
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div id="discussions" class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Community Discussions</h2>
                <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Sorted by most upvoted and recent activity</p>
            </div>
            
            <!-- Category Filter -->
            <div class="flex items-center gap-3">
                <label for="categoryFilter" class="text-sm font-medium text-gray-700 dark:text-gray-300">Filter by category:</label>
                <select id="categoryFilter" onchange="filterByCategory(this.value)" class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="all" {{ $selectedCategory === 'all' ? 'selected' : '' }}>All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ $selectedCategory === $category->slug ? 'selected' : '' }}>
                            {{ $category->name }} ({{ $category->posts_count }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Discussions List -->
    <div class="space-y-6">
        @forelse($posts as $post)
        <article class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg transition-all duration-200 hover:border-primary/30">
            <div class="flex items-start gap-4">
                <!-- Author Avatar -->
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                        {{ $post->is_anonymous ? '?' : strtoupper(substr($post->user->name ?? 'U', 0, 1)) }}
                    </div>
                </div>

                <!-- Post Content -->
                <div class="flex-1 min-w-0">
                    <!-- Post Header -->
                    <div class="flex items-start justify-between gap-4 mb-3">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
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
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">
                                <a href="{{ route('public.forum.show', $post->id) }}" class="hover:text-primary transition-colors">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-3 leading-relaxed mb-3">
                                {{ Str::limit(strip_tags($post->content), 200) }}
                            </p>
                        </div>
                    </div>

                    <!-- Post Meta -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined !text-sm">person</span>
                                <span>{{ $post->is_anonymous ? 'Anonymous' : ($post->user->name ?? 'Unknown') }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined !text-sm">schedule</span>
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                            @if($post->views > 0)
                            <div class="flex items-center gap-1">
                                <span class="material-symbols-outlined !text-sm">visibility</span>
                                <span>{{ $post->views }} views</span>
                            </div>
                            @endif
                        </div>

                        <!-- Post Actions -->
                        <div class="flex items-center gap-3">
                            <!-- Upvotes -->
                            <div class="flex items-center gap-1">
                                @auth
                                    <form action="{{ route('public.forum.upvote', $post->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-1 px-2 py-1 rounded-lg transition-colors {{ $post->isUpvotedBy(auth()->id()) ? 'bg-primary/10 text-primary' : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                                            <span class="material-symbols-outlined !text-sm">thumb_up</span>
                                            <span class="text-sm font-medium">{{ $post->upvotes ?? 0 }}</span>
                                        </button>
                                    </form>
                                @else
                                    <div class="flex items-center gap-1 text-gray-500">
                                        <span class="material-symbols-outlined !text-sm">thumb_up</span>
                                        <span class="text-sm font-medium">{{ $post->upvotes ?? 0 }}</span>
                                    </div>
                                @endauth
                            </div>

                            <!-- Comments -->
                            <a href="{{ route('public.forum.show', $post->id) }}" class="flex items-center gap-1 text-gray-500 hover:text-primary transition-colors px-2 py-1 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span class="material-symbols-outlined !text-sm">chat_bubble</span>
                                <span class="text-sm font-medium">{{ $post->comments_count ?? 0 }}</span>
                            </a>

                            <!-- Read More -->
                            <a href="{{ route('public.forum.show', $post->id) }}" class="text-primary hover:text-primary/80 text-sm font-semibold px-3 py-1 rounded-lg hover:bg-primary/10 transition-colors">
                                Read More →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        @empty
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-4xl text-gray-400">forum</span>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No discussions yet</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Be the first to start a conversation in this category!</p>
            @auth
                <button onclick="openCreateDiscussionModal()" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary/90 transition-colors">
                    <span class="material-symbols-outlined">add</span>
                    Start Discussion
                </button>
            @else
                <button onclick="openLoginModal()" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary/90 transition-colors">
                    <span class="material-symbols-outlined">login</span>
                    Login to Start Discussion
                </button>
            @endauth
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($posts->hasPages())
    <div class="mt-8">
        {{ $posts->appends(request()->query())->links() }}
    </div>
    @endif

    <!-- Community Guidelines -->
    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-2xl p-8 border border-emerald-200 dark:border-emerald-800 mt-12">
        <div class="flex items-start gap-4">
            <span class="material-symbols-outlined text-primary text-3xl flex-shrink-0">verified_user</span>
            <div>
                <h3 class="text-xl font-bold text-emerald-900 dark:text-emerald-100 mb-4">Community Guidelines</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-emerald-800 dark:text-emerald-200">
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                        <span>Be respectful and supportive of others</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                        <span>Keep discussions relevant and constructive</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                        <span>Protect your privacy and that of others</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                        <span>Report inappropriate content to moderators</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
@guest
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-gradient-to-r from-primary/10 to-green-50 dark:from-gray-800 dark:to-gray-800/50 rounded-2xl p-8 border border-primary/20 dark:border-gray-700 overflow-hidden">
            <!-- Decorative Icons -->
            <div class="absolute top-4 left-4 opacity-10">
                <span class="material-symbols-outlined text-6xl text-primary">forum</span>
            </div>
            <div class="absolute bottom-4 right-4 opacity-10">
                <span class="material-symbols-outlined text-6xl text-primary">groups</span>
            </div>
            
            <div class="relative text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/20 rounded-full mb-4">
                    <span class="material-symbols-outlined text-3xl text-primary">favorite</span>
                </div>
                <h3 class="text-xl font-bold text-[#111816] dark:text-white mb-2">Join Our Community Today</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-2xl mx-auto">Connect with peers, share your experiences, and find support in a safe, moderated environment. Your voice matters.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <button onclick="openSignupModal()" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition-colors text-sm">
                        <span class="material-symbols-outlined text-base">person_add</span>
                        <span>Create Free Account</span>
                    </button>
                    <button onclick="openLoginModal()" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white dark:bg-gray-700 text-[#111816] dark:text-white border border-gray-300 dark:border-gray-600 rounded-lg font-semibold hover:border-primary hover:text-primary transition-colors text-sm">
                        <span class="material-symbols-outlined text-base">login</span>
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
</style>
@endpush

@push('scripts')
<script>
function filterByCategory(categorySlug) {
    const currentUrl = new URL(window.location);
    if (categorySlug === 'all') {
        currentUrl.searchParams.delete('category');
    } else {
        currentUrl.searchParams.set('category', categorySlug);
    }
    window.location.href = currentUrl.toString();
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

// Smooth scroll to discussions when coming from hero section
document.addEventListener('DOMContentLoaded', function() {
    const hash = window.location.hash;
    if (hash === '#discussions') {
        setTimeout(() => {
            document.getElementById('discussions').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'start' 
            });
        }, 100);
    }
});
</script>
@endpush
@endsection