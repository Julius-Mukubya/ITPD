@extends('layouts.public')

@section('title', 'Awareness Campaigns - WellPath')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden h-screen">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2073&q=80" 
             alt="Students participating in awareness campaign" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>
    
    <!-- Content -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center justify-center">
        <div class="text-center">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-semibold mb-6">
                <span class="material-symbols-outlined !text-lg">campaign</span>
                Wellness Campaigns
            </div>
            <h1 class="text-4xl lg:text-6xl font-black text-white tracking-tight mb-6">Join Our Awareness Campaigns</h1>
            <p class="text-xl lg:text-2xl text-white/90 max-w-4xl mx-auto leading-relaxed mb-8">Be part of transformative initiatives that promote mental health awareness, substance education, and campus wellbeing. Together, we're building a supportive community for all students.</p>
            <div class="flex justify-center">
                @auth
                    <a href="#active-campaigns" class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md border border-white/30 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/30 hover:border-white/50 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="material-symbols-outlined !text-xl">volunteer_activism</span>
                        Join a Campaign
                    </a>
                @else
                    <button onclick="openLoginModal()" class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md border border-white/30 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/30 hover:border-white/50 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="material-symbols-outlined !text-xl">login</span>
                        Login to Join
                    </button>
                @endauth
            </div>
        </div>
    </div>
</section>

<!-- Filter Section -->
<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-6 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
        <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
            <!-- Search Bar -->
            <div class="relative flex-1 max-w-md">
                <span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-[#61897c] dark:text-gray-400 !text-xl">search</span>
                <input type="text" placeholder="Search campaigns..." 
                       class="w-full pl-12 pr-4 py-3 rounded-xl border border-[#f0f4f3] dark:border-gray-700 bg-white dark:bg-gray-900 text-[#111816] dark:text-white placeholder-[#61897c] dark:placeholder-gray-400 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200">
            </div>
            
            <!-- Filter Buttons -->
            <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-800 p-1 rounded-xl">
                <button class="px-4 py-2 rounded-lg bg-primary text-white font-semibold text-sm transition-all duration-200 transform hover:scale-105 shadow-sm">
                    All Campaigns
                </button>
                <button class="px-4 py-2 rounded-lg text-[#61897c] dark:text-gray-400 hover:text-[#111816] dark:hover:text-white font-medium text-sm transition-colors">
                    Active
                </button>
                <button class="px-4 py-2 rounded-lg text-[#61897c] dark:text-gray-400 hover:text-[#111816] dark:hover:text-white font-medium text-sm transition-colors">
                    Upcoming
                </button>
                <button class="px-4 py-2 rounded-lg text-[#61897c] dark:text-gray-400 hover:text-[#111816] dark:hover:text-white font-medium text-sm transition-colors">
                    Completed
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Active Campaigns -->
@if(isset($activeCampaigns) && $activeCampaigns->count() > 0)
<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col flex-1 gap-10">
        <!-- Active Campaigns Section -->
        <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-8 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-2 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <span class="material-symbols-outlined !text-lg">play_circle</span>
                    Active Now
                </div>
                <h2 class="text-3xl font-bold text-[#111816] dark:text-white mb-4">
                    Join Active Campaigns
                </h2>
                <p class="text-[#61897c] dark:text-gray-400 max-w-2xl mx-auto">
                    These campaigns are currently running and accepting new participants. Join now to make a difference!
                </p>
            </div>
            
            <!-- Active Campaigns Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach($activeCampaigns as $campaign)
                <article class="group bg-gray-50 dark:bg-gray-800/50 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-primary/30 transform hover:-translate-y-1">
                <!-- Image Container -->
                <div class="relative overflow-hidden">
                    @if($campaign->banner_image)
                        <img src="{{ $campaign->banner_url }}" alt="{{ $campaign->title }}" 
                             class="w-full h-64 object-cover transition-transform duration-700 group-hover:scale-110">
                    @else
                        <div class="w-full h-64 bg-gradient-to-br from-primary/20 to-green-500/20 flex items-center justify-center">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-primary/30 rounded-full flex items-center justify-center mb-3 mx-auto">
                                    <span class="material-symbols-outlined text-primary !text-2xl">campaign</span>
                                </div>
                                <p class="text-[#111816] dark:text-white font-semibold">{{ $campaign->title }}</p>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Overlay Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <!-- Status Badge -->
                    <div class="absolute top-4 left-4">
                        <div class="flex items-center gap-2 bg-green-500 text-white px-3 py-1.5 rounded-full text-sm font-bold shadow-lg">
                            <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                            Active
                        </div>
                    </div>
                    
                    <!-- Registration Status & Participants Badge -->
                    <div class="absolute top-4 right-4 flex flex-col gap-2">
                        @auth
                            @if(isset($campaign->is_user_registered) && $campaign->is_user_registered)
                                <div class="bg-green-500 text-white px-3 py-1.5 rounded-full text-sm font-bold shadow-lg">
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined !text-sm">check</span>
                                        Joined
                                    </span>
                                </div>
                            @endif
                        @endauth
                        <div class="flex items-center gap-1 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-sm font-semibold text-[#111816] dark:text-white shadow-lg">
                            <span class="material-symbols-outlined !text-sm">group</span>
                            {{ $campaign->participants_count ?? 0 }}
                        </div>
                    </div>
                    
                    <!-- Hover Action -->
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="bg-primary/90 backdrop-blur-sm rounded-full p-4 transform scale-75 group-hover:scale-100 transition-transform duration-300 shadow-2xl">
                            <span class="material-symbols-outlined text-white !text-2xl">arrow_forward</span>
                        </div>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="p-8">
                    <!-- Title -->
                    <h3 class="text-2xl font-bold text-[#111816] dark:text-white mb-3 group-hover:text-primary dark:group-hover:text-primary transition-colors duration-200">
                        {{ $campaign->title }}
                    </h3>
                    
                    <!-- Description -->
                    <p class="text-[#61897c] dark:text-gray-400 leading-relaxed mb-6">
                        {{ Str::limit($campaign->description, 150) }}
                    </p>
                    
                    <!-- Campaign Details -->
                    <div class="flex items-center justify-between mb-6 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
                        <div class="flex items-center gap-2 text-[#61897c] dark:text-gray-400">
                            <span class="material-symbols-outlined !text-lg">calendar_today</span>
                            <span class="text-sm font-medium">
                                {{ $campaign->start_date->format('M d') }} - {{ $campaign->end_date->format('M d, Y') }}
                                @if($campaign->start_time)
                                    <br><span class="flex items-center gap-1 mt-1">
                                        <span class="material-symbols-outlined !text-sm">schedule</span>
                                        {{ \Carbon\Carbon::parse($campaign->start_time)->format('g:i A') }}
                                        @if($campaign->end_time)
                                            - {{ \Carbon\Carbon::parse($campaign->end_time)->format('g:i A') }}
                                        @endif
                                    </span>
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center gap-2 text-[#61897c] dark:text-gray-400">
                            <span class="material-symbols-outlined !text-lg">schedule</span>
                            <span class="text-sm font-medium">
                                @if($campaign->end_date && $campaign->end_date->isFuture())
                                    {{ $campaign->end_date->diffInDays(now()) }} days left
                                @else
                                    Ongoing
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        @auth
                            @if(isset($campaign->is_user_registered) && $campaign->is_user_registered)
                                <a href="{{ route('campaigns.show', $campaign) }}" 
                                   class="flex-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-center py-4 rounded-xl font-bold hover:bg-green-200 dark:hover:bg-green-900/50 transition-all duration-200">
                                    <span class="flex items-center justify-center gap-2">
                                        <span class="material-symbols-outlined !text-lg">check_circle</span>
                                        Registered
                                    </span>
                                </a>
                            @else
                                <a href="{{ route('campaigns.show', $campaign) }}" 
                                   class="flex-1 bg-gradient-to-r from-primary to-green-500 text-white text-center py-4 rounded-xl font-bold hover:from-primary/90 hover:to-green-500/90 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                    <span class="flex items-center justify-center gap-2">
                                        <span class="material-symbols-outlined !text-lg">volunteer_activism</span>
                                        Register Now
                                    </span>
                                </a>
                            @endif
                        @else
                            <a href="{{ route('campaigns.show', $campaign) }}" 
                               class="flex-1 bg-gradient-to-r from-primary to-green-500 text-white text-center py-4 rounded-xl font-bold hover:from-primary/90 hover:to-green-500/90 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined !text-lg">volunteer_activism</span>
                                    Register Now
                                </span>
                            </a>
                        @endauth
                        <a href="{{ route('campaigns.show', $campaign) }}" 
                           class="px-4 py-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-[#61897c] dark:text-gray-400 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary transition-all duration-200">
                            <span class="material-symbols-outlined !text-lg">info</span>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Enhanced Upcoming Campaigns -->
@if(isset($upcomingCampaigns) && $upcomingCampaigns->count() > 0)
<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 {{ isset($activeCampaigns) && $activeCampaigns->count() > 0 ? '' : 'py-12' }}">
    <div class="flex flex-col flex-1 gap-10">
        <!-- Upcoming Campaigns Section -->
        <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-8 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-2 bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-300 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <span class="material-symbols-outlined !text-lg">schedule</span>
                    Coming Soon
                </div>
                <h2 class="text-3xl font-bold text-[#111816] dark:text-white mb-4">
                    Upcoming Campaigns
                </h2>
                <p class="text-[#61897c] dark:text-gray-400 max-w-2xl mx-auto">
                    Get ready for these exciting campaigns launching soon. Mark your calendar and be the first to participate!
                </p>
            </div>
            
            <!-- Upcoming Campaigns Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                @foreach($upcomingCampaigns as $campaign)
                <article class="group bg-gray-50 dark:bg-gray-800/50 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-primary/30 transform hover:-translate-y-1">
                <!-- Image Container -->
                <div class="relative overflow-hidden">
                    @if($campaign->banner_image)
                        <img src="{{ $campaign->banner_url }}" alt="{{ $campaign->title }}" 
                             class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-blue-500/20 to-purple-500/20 flex items-center justify-center">
                            <div class="text-center">
                                <div class="w-12 h-12 bg-blue-500/30 rounded-full flex items-center justify-center mb-2 mx-auto">
                                    <span class="material-symbols-outlined text-blue-600 !text-xl">event</span>
                                </div>
                                <p class="text-[#111816] dark:text-white font-medium text-sm">Coming Soon</p>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <!-- Status Badge -->
                    <div class="absolute top-4 left-4">
                        <div class="flex items-center gap-2 bg-blue-500 text-white px-3 py-1.5 rounded-full text-sm font-bold shadow-lg">
                            <span class="material-symbols-outlined !text-sm">schedule</span>
                            Upcoming
                        </div>
                    </div>
                    
                    <!-- Countdown Badge -->
                    <div class="absolute top-4 right-4">
                        <div class="bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-sm font-semibold text-[#111816] dark:text-white shadow-lg">
                            @if($campaign->start_date && $campaign->start_date->isFuture())
                                {{ $campaign->start_date->diffInDays(now()) }} days
                            @else
                                Soon
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="p-6">
                    <!-- Title -->
                    <h3 class="text-xl font-bold text-[#111816] dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors duration-200 line-clamp-2">
                        {{ $campaign->title }}
                    </h3>
                    
                    <!-- Description -->
                    <p class="text-[#61897c] dark:text-gray-400 text-sm leading-relaxed mb-4 line-clamp-3">
                        {{ Str::limit($campaign->description, 120) }}
                    </p>
                    
                    <!-- Launch Date -->
                    <div class="flex items-center gap-2 mb-6 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 !text-lg">event</span>
                        <div>
                            <div class="text-sm font-semibold text-[#111816] dark:text-white">Launches</div>
                            <div class="text-sm text-blue-600 dark:text-blue-400 font-medium">
                                {{ $campaign->start_date->format('M d, Y') }}
                                @if($campaign->start_time)
                                    <br>{{ \Carbon\Carbon::parse($campaign->start_time)->format('g:i A') }}
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <a href="{{ route('campaigns.show', $campaign) }}" 
                           class="flex-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-center py-3 rounded-xl font-semibold hover:bg-blue-200 dark:hover:bg-blue-900/50 transition-all duration-200 transform hover:scale-105">
                            Learn More
                        </a>
                        <button class="px-4 py-3 bg-gray-100 dark:bg-gray-700 text-[#61897c] dark:text-gray-400 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                            <span class="material-symbols-outlined !text-lg">notifications</span>
                        </button>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Enhanced Default State -->
@if((!isset($activeCampaigns) || $activeCampaigns->count() === 0) && (!isset($upcomingCampaigns) || $upcomingCampaigns->count() === 0))
<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col flex-1 gap-10">
        <!-- Empty State -->
        <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-12 shadow-sm border border-[#f0f4f3] dark:border-gray-800 text-center">
            <div class="w-32 h-32 bg-gradient-to-br from-primary/20 to-primary/10 rounded-full flex items-center justify-center mx-auto mb-8">
                <span class="material-symbols-outlined text-primary !text-6xl">campaign</span>
            </div>
            <h2 class="text-3xl font-bold text-[#111816] dark:text-white mb-4">
                No Campaigns Available
            </h2>
            <p class="text-[#61897c] dark:text-gray-400 max-w-2xl mx-auto mb-8">
                We're currently preparing exciting new wellness campaigns for the community. Check back soon for upcoming initiatives and events!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('content.index') }}" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-xl font-semibold hover:bg-primary/90 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <span class="material-symbols-outlined !text-lg">library_books</span>
                    Explore Resources
                </a>
                <a href="{{ route('public.counseling.index') }}" class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-[#f0f4f3] dark:border-gray-700 text-[#111816] dark:text-white px-6 py-3 rounded-xl font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 transform hover:scale-105">
                    <span class="material-symbols-outlined !text-lg">support_agent</span>
                    Get Support
                </a>
            </div>
        </div>
    </div>
</div>
@endif

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
                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-2xl mx-auto">Connect with our counselors or join the community for personalized guidance and peer support.</p>
                <div class="flex justify-center">
                    <a href="{{ route('public.counseling.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition-colors text-sm">
                        <span class="material-symbols-outlined text-base">psychology</span>
                        <span>Get Counseling</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

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
    
    /* Smooth animations */
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    /* Custom scrollbar */
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
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.querySelector('input[placeholder="Search campaigns..."]');
    const filterButtons = document.querySelectorAll('.flex.items-center.gap-2.bg-gray-100 button');
    
    // Search input handler
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            // Add search functionality here
            console.log('Searching for:', e.target.value);
        });
    }
    
    // Filter button handlers
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active state from all buttons
            filterButtons.forEach(btn => {
                btn.className = btn.className.replace(/bg-primary text-white/, 'text-[#61897c] dark:text-gray-400 hover:text-[#111816] dark:hover:text-white');
            });
            
            // Add active state to clicked button
            this.className = this.className.replace(/text-\[#61897c\] dark:text-gray-400 hover:text-\[#111816\] dark:hover:text-white/, 'bg-primary text-white');
            
            console.log('Filter changed to:', this.textContent.trim());
        });
    });
    
    // Intersection Observer for animations
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
    
    // Observe campaign cards for fade-in animation
    document.querySelectorAll('article.group').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});
</script>
@endpush