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
                    <button onclick="scrollToCampaigns()" class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md border border-white/30 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/30 hover:border-white/50 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="material-symbols-outlined !text-xl">explore</span>
                        Browse Campaigns
                    </button>
                @else
                    <button onclick="scrollToCampaigns()" class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md border border-white/30 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/30 hover:border-white/50 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="material-symbols-outlined !text-xl">explore</span>
                        Browse Campaigns
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
                <input type="text" id="campaign-search" placeholder="Search campaigns..." 
                       class="w-full pl-12 pr-12 py-3 rounded-xl border border-[#f0f4f3] dark:border-gray-700 bg-white dark:bg-gray-900 text-[#111816] dark:text-white placeholder-[#61897c] dark:placeholder-gray-400 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200">
                <button type="button" id="clear-search" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-[#61897c] dark:text-gray-400 hover:text-[#111816] dark:hover:text-white transition-colors duration-200 opacity-0 pointer-events-none">
                    <span class="material-symbols-outlined !text-lg">close</span>
                </button>
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

<!-- Dynamic Campaign Section -->
<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col flex-1 gap-10">
        <!-- Campaign Section -->
        <div id="campaigns-section" class="bg-white dark:bg-gray-800/50 rounded-2xl p-8 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
            <div class="text-center mb-8">
                <div id="section-badge" class="inline-flex items-center gap-2 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <span id="badge-icon" class="material-symbols-outlined !text-lg">campaign</span>
                    <span id="badge-text">All Campaigns</span>
                </div>
                <h2 id="section-title" class="text-3xl font-bold text-[#111816] dark:text-white mb-4">
                    Wellness Campaigns
                </h2>
                <p id="section-description" class="text-[#61897c] dark:text-gray-400 max-w-2xl mx-auto">
                    Explore our comprehensive collection of wellness campaigns designed to support your mental health and wellbeing journey.
                </p>
            </div>
            
            <!-- Active Campaigns Grid -->
            <div id="active-campaigns-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                @if(isset($activeCampaigns) && $activeCampaigns->count() > 0)
                    @foreach($activeCampaigns as $campaign)
                <article class="group bg-gray-50 dark:bg-gray-800/50 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-primary/30 transform hover:-translate-y-1">
                <!-- Image Container -->
                <div class="relative overflow-hidden">
                    @if($campaign->banner_image)
                        <img src="{{ $campaign->banner_url }}" alt="{{ $campaign->title }}" 
                             class="w-full h-48 object-cover transition-transform duration-700 group-hover:scale-110">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-primary/20 to-green-500/20 flex items-center justify-center">
                            <div class="text-center">
                                <div class="w-12 h-12 bg-primary/30 rounded-full flex items-center justify-center mb-2 mx-auto">
                                    <span class="material-symbols-outlined text-primary !text-xl">campaign</span>
                                </div>
                                <p class="text-[#111816] dark:text-white font-semibold text-sm">{{ $campaign->title }}</p>
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
                    
                    <!-- Campaign Type Badge -->
                    <div class="absolute top-4 right-4">
                        <div class="bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-sm font-semibold text-[#111816] dark:text-white shadow-lg">
                            {{ ucfirst($campaign->type ?? 'General') }}
                        </div>
                    </div>
                    
                    <!-- Hover Action -->
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <div class="bg-primary/90 backdrop-blur-sm rounded-full p-3 transform scale-75 group-hover:scale-100 transition-transform duration-300 shadow-2xl">
                            <span class="material-symbols-outlined text-white !text-xl">arrow_forward</span>
                        </div>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="p-6">
                    <!-- Title -->
                    <h3 class="text-xl font-bold text-[#111816] dark:text-white mb-3 group-hover:text-primary dark:group-hover:text-primary transition-colors duration-200 line-clamp-2">
                        {{ $campaign->title }}
                    </h3>
                    
                    <!-- Description -->
                    <p class="text-[#61897c] dark:text-gray-400 leading-relaxed mb-4 text-sm line-clamp-3">
                        {{ Str::limit($campaign->description, 120) }}
                    </p>
                    
                    <!-- Campaign Details -->
                    <div class="flex items-center justify-between mb-4 p-3 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
                        <div class="flex items-center gap-2 text-[#61897c] dark:text-gray-400">
                            <span class="material-symbols-outlined !text-lg">calendar_today</span>
                            <span class="text-xs font-medium">
                                {{ $campaign->start_date->format('M d') }} - {{ $campaign->end_date->format('M d') }}
                                @if($campaign->start_time)
                                    <br><span class="flex items-center gap-1 mt-1">
                                        <span class="material-symbols-outlined !text-xs">schedule</span>
                                        {{ \Carbon\Carbon::parse($campaign->start_time)->format('g:i A') }}
                                    </span>
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center gap-1 text-[#61897c] dark:text-gray-400">
                            <span class="material-symbols-outlined !text-lg">schedule</span>
                            <span class="text-xs font-medium">
                                @if($campaign->end_date && $campaign->end_date->isFuture())
                                    {{ $campaign->end_date->diffInDays(now()) }}d left
                                @else
                                    Ongoing
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        <a href="{{ route('campaigns.show', $campaign) }}" 
                           class="flex-1 bg-gradient-to-r from-primary to-green-500 text-white text-center py-3 rounded-xl font-semibold hover:from-primary/90 hover:to-green-500/90 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm">
                            <span class="flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined !text-lg">info</span>
                                Learn More
                            </span>
                        </a>
                        <a href="{{ route('campaigns.show', $campaign) }}" 
                           class="px-3 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-[#61897c] dark:text-gray-400 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary transition-all duration-200">
                            <span class="material-symbols-outlined !text-lg">contact_support</span>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
                @endif
            </div>

            <!-- Upcoming Campaigns Grid -->
            <div id="upcoming-campaigns-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8" style="display: none;">
                @if(isset($upcomingCampaigns) && $upcomingCampaigns->count() > 0)
                    @foreach($upcomingCampaigns as $campaign)
                <article class="group bg-gray-50 dark:bg-gray-800/50 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-primary/30 transform hover:-translate-y-1">
                <!-- Image Container -->
                <div class="relative overflow-hidden">
                    @if($campaign->banner_image)
                        <img src="{{ $campaign->banner_url }}" alt="{{ $campaign->title }}" 
                             class="w-full h-48 object-cover transition-transform duration-500 group-hover:scale-105">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-green-500/20 to-primary/20 flex items-center justify-center">
                            <div class="text-center">
                                <div class="w-12 h-12 bg-green-500/30 rounded-full flex items-center justify-center mb-2 mx-auto">
                                    <span class="material-symbols-outlined text-green-600 !text-xl">event</span>
                                </div>
                                <p class="text-[#111816] dark:text-white font-medium text-sm">Coming Soon</p>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <!-- Status Badge -->
                    <div class="absolute top-4 left-4">
                        <div class="flex items-center gap-2 bg-green-500 text-white px-3 py-1.5 rounded-full text-sm font-bold shadow-lg">
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
                    <h3 class="text-xl font-bold text-[#111816] dark:text-white mb-3 group-hover:text-primary dark:group-hover:text-primary transition-colors duration-200 line-clamp-2">
                        {{ $campaign->title }}
                    </h3>
                    
                    <!-- Description -->
                    <p class="text-[#61897c] dark:text-gray-400 text-sm leading-relaxed mb-4 line-clamp-3">
                        {{ Str::limit($campaign->description, 120) }}
                    </p>
                    
                    <!-- Launch Date -->
                    <div class="flex items-center gap-2 mb-6 p-3 bg-green-50 dark:bg-green-900/20 rounded-xl">
                        <span class="material-symbols-outlined text-green-600 dark:text-green-400 !text-lg">event</span>
                        <div>
                            <div class="text-sm font-semibold text-[#111816] dark:text-white">Launches</div>
                            <div class="text-sm text-green-600 dark:text-green-400 font-medium">
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
                           class="flex-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-center py-3 rounded-xl font-semibold hover:bg-green-200 dark:hover:bg-green-900/50 transition-all duration-200 transform hover:scale-105">
                            Learn More
                        </a>
                        <a href="{{ route('campaigns.show', $campaign) }}" class="px-4 py-3 bg-gray-100 dark:bg-gray-700 text-[#61897c] dark:text-gray-400 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                            <span class="material-symbols-outlined !text-lg">contact_support</span>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
                @endif
            </div>

            <!-- Empty State -->
            <div id="campaigns-empty-state" class="text-center py-12" style="display: none;">
                <div class="w-32 h-32 bg-gradient-to-br from-primary/20 to-primary/10 rounded-full flex items-center justify-center mx-auto mb-8">
                    <span class="material-symbols-outlined text-primary !text-6xl">campaign</span>
                </div>
                <h3 id="campaigns-empty-title" class="text-2xl font-bold text-[#111816] dark:text-white mb-4">No Campaigns Found</h3>
                <p id="campaigns-empty-description" class="text-[#61897c] dark:text-gray-400 max-w-2xl mx-auto mb-8">
                    We couldn't find any campaigns matching your current filter. Try selecting a different filter or check back later.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Default State -->
@if((!isset($activeCampaigns) || $activeCampaigns->count() === 0) && (!isset($upcomingCampaigns) || $upcomingCampaigns->count() === 0))
<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col flex-1 gap-10">
        <!-- Empty State -->
        <div id="empty-state" class="bg-white dark:bg-gray-800/50 rounded-2xl p-12 shadow-sm border border-[#f0f4f3] dark:border-gray-800 text-center">
            <div class="w-32 h-32 bg-gradient-to-br from-primary/20 to-primary/10 rounded-full flex items-center justify-center mx-auto mb-8">
                <span class="material-symbols-outlined text-primary !text-6xl">campaign</span>
            </div>
            <h2 id="empty-title" class="text-3xl font-bold text-[#111816] dark:text-white mb-4">
                No Campaigns Available
            </h2>
            <p id="empty-description" class="text-[#61897c] dark:text-gray-400 max-w-2xl mx-auto mb-8">
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
// Scroll to campaigns function
function scrollToCampaigns() {
    // Try to find active campaigns section first, then upcoming campaigns, then any campaign section
    const activeCampaigns = document.querySelector('#active-campaigns');
    const upcomingCampaigns = document.querySelector('#upcoming-campaigns');
    const campaignSection = document.querySelector('.bg-white.dark\\:bg-gray-800\\/50.rounded-2xl');
    
    let targetElement = activeCampaigns || upcomingCampaigns || campaignSection;
    
    if (targetElement) {
        targetElement.scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
        });
    } else {
        // Fallback: scroll to the first campaign card or section
        const firstCampaignCard = document.querySelector('article.group');
        if (firstCampaignCard) {
            firstCampaignCard.scrollIntoView({ 
                behavior: 'smooth',
                block: 'start'
            });
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.getElementById('campaign-search');
    const clearSearchBtn = document.getElementById('clear-search');
    const filterButtons = document.querySelectorAll('div.bg-gray-100.dark\\:bg-gray-800 button');
    
    console.log('Found filter buttons:', filterButtons.length);
    
    // Search input handler with debounce
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase().trim();
            
            // Show/hide clear button
            if (clearSearchBtn) {
                if (searchTerm.length > 0) {
                    clearSearchBtn.style.opacity = '1';
                    clearSearchBtn.style.pointerEvents = 'auto';
                } else {
                    clearSearchBtn.style.opacity = '0';
                    clearSearchBtn.style.pointerEvents = 'none';
                }
            }
            
            // Clear previous timeout
            clearTimeout(searchTimeout);
            
            // Debounce search for better performance
            searchTimeout = setTimeout(() => {
                performSearch(searchTerm);
            }, 150);
        });
    }
    
    // Search function
    function performSearch(searchTerm) {
        console.log('Searching for:', searchTerm);
        
        // Get all campaign cards
        const allCampaignCards = document.querySelectorAll('article.group');
        
        if (searchTerm === '') {
            // Show all campaigns if search is empty
            allCampaignCards.forEach(card => {
                card.style.display = 'block';
            });
            
            // Update empty states
            updateEmptyStates();
        } else {
            // Filter campaigns based on search term
            let visibleCount = 0;
            
            allCampaignCards.forEach(card => {
                // Get text content from various elements
                const title = card.querySelector('h3')?.textContent.toLowerCase() || '';
                const description = card.querySelector('p')?.textContent.toLowerCase() || '';
                const type = card.querySelector('.bg-white\\/90, .bg-gray-900\\/90')?.textContent.toLowerCase() || '';
                const status = card.querySelector('.bg-green-500')?.textContent.toLowerCase() || '';
                const dates = card.querySelector('.flex.items-center.gap-2')?.textContent.toLowerCase() || '';
                
                // Check if search term matches any field
                const matches = title.includes(searchTerm) || 
                              description.includes(searchTerm) || 
                              type.includes(searchTerm) ||
                              status.includes(searchTerm) ||
                              dates.includes(searchTerm);
                
                if (matches) {
                    card.style.display = 'block';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Update empty states based on search results
            updateEmptyStatesForSearch(searchTerm, visibleCount);
        }
    }
    
    // Clear search button handler
    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', function() {
            if (searchInput) {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input')); // Trigger the input event
                searchInput.focus();
            }
        });
    }
    
    // Function to update empty states after search
    function updateEmptyStatesForSearch(searchTerm, visibleCount) {
        const activeGrid = document.getElementById('active-campaigns-grid');
        const upcomingGrid = document.getElementById('upcoming-campaigns-grid');
        const emptyState = document.getElementById('campaigns-empty-state');
        const emptyTitle = document.getElementById('campaigns-empty-title');
        const emptyDescription = document.getElementById('campaigns-empty-description');
        
        if (visibleCount === 0) {
            // Hide grids and show empty state
            if (activeGrid) activeGrid.style.display = 'none';
            if (upcomingGrid) upcomingGrid.style.display = 'none';
            if (emptyState) emptyState.style.display = 'block';
            if (emptyTitle) emptyTitle.textContent = 'No Campaigns Found';
            if (emptyDescription) emptyDescription.textContent = `No campaigns match your search for "${searchTerm}". Try different keywords or clear the search to see all campaigns.`;
        } else {
            // Show grids and hide empty state
            if (emptyState) emptyState.style.display = 'none';
            
            // Show grids that have visible campaigns
            const activeGridHasVisible = activeGrid && activeGrid.querySelectorAll('article.group[style*="block"], article.group:not([style*="none"])').length > 0;
            const upcomingGridHasVisible = upcomingGrid && upcomingGrid.querySelectorAll('article.group[style*="block"], article.group:not([style*="none"])').length > 0;
            
            if (activeGridHasVisible && activeGrid) activeGrid.style.display = 'grid';
            if (upcomingGridHasVisible && upcomingGrid) upcomingGrid.style.display = 'grid';
        }
    }
    
    // Function to update empty states normally
    function updateEmptyStates() {
        const activeGrid = document.getElementById('active-campaigns-grid');
        const upcomingGrid = document.getElementById('upcoming-campaigns-grid');
        const emptyState = document.getElementById('campaigns-empty-state');
        
        // Get current filter type
        const activeButton = document.querySelector('div.bg-gray-100.dark\\:bg-gray-800 button.bg-primary');
        const filterType = activeButton ? activeButton.textContent.trim().toLowerCase() : 'all campaigns';
        
        // Re-run the filter logic
        updateCampaignSection(filterType);
    }
    
    // Filter button handlers
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Clear search input when filter is applied
            if (searchInput) {
                searchInput.value = '';
            }
            
            // Remove active state from all buttons
            filterButtons.forEach(btn => {
                btn.className = btn.className.replace(/bg-primary text-white/, 'text-[#61897c] dark:text-gray-400 hover:text-[#111816] dark:hover:text-white');
            });
            
            // Add active state to clicked button
            this.className = this.className.replace(/text-\[#61897c\] dark:text-gray-400 hover:text-\[#111816\] dark:hover:text-white/, 'bg-primary text-white');
            
            const filterType = this.textContent.trim().toLowerCase();
            
            // Reset all campaign cards to be visible before applying filter
            const allCampaignCards = document.querySelectorAll('article.group');
            allCampaignCards.forEach(card => {
                card.style.display = 'block';
            });
            
            updateCampaignSection(filterType);
            
            console.log('Filter changed to:', filterType);
        });
    });

    // Initialize page with "All Campaigns" filter on load
    updateCampaignSection('all campaigns');

    // Function to update campaign section based on filter
    function updateCampaignSection(filterType) {
        console.log('updateCampaignSection called with:', filterType);
        
        const badge = document.getElementById('section-badge');
        const badgeIcon = document.getElementById('badge-icon');
        const badgeText = document.getElementById('badge-text');
        const title = document.getElementById('section-title');
        const description = document.getElementById('section-description');
        const activeGrid = document.getElementById('active-campaigns-grid');
        const upcomingGrid = document.getElementById('upcoming-campaigns-grid');
        const emptyState = document.getElementById('campaigns-empty-state');
        const emptyTitle = document.getElementById('campaigns-empty-title');
        const emptyDescription = document.getElementById('campaigns-empty-description');

        console.log('Found elements:', {
            badge: !!badge,
            badgeIcon: !!badgeIcon,
            badgeText: !!badgeText,
            title: !!title,
            description: !!description,
            activeGrid: !!activeGrid,
            upcomingGrid: !!upcomingGrid,
            activeGridChildren: activeGrid ? activeGrid.children.length : 0,
            upcomingGridChildren: upcomingGrid ? upcomingGrid.children.length : 0,
            activeGridArticles: activeGrid ? activeGrid.querySelectorAll('article.group').length : 0,
            upcomingGridArticles: upcomingGrid ? upcomingGrid.querySelectorAll('article.group').length : 0,
            activeGridHTML: activeGrid ? activeGrid.innerHTML.substring(0, 200) : 'null'
        });

        // Hide all grids initially
        if (activeGrid) activeGrid.style.display = 'none';
        if (upcomingGrid) upcomingGrid.style.display = 'none';
        if (emptyState) emptyState.style.display = 'none';

        switch(filterType) {
            case 'all campaigns':
                if (badge) {
                    badge.className = 'inline-flex items-center gap-2 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 px-4 py-2 rounded-full text-sm font-semibold mb-4';
                }
                if (badgeIcon) badgeIcon.textContent = 'campaign';
                if (badgeText) badgeText.textContent = 'All Campaigns';
                if (title) title.textContent = 'Wellness Campaigns';
                if (description) description.textContent = 'Explore our comprehensive collection of wellness campaigns designed to support your mental health and wellbeing journey.';
                
                // Show both active and upcoming campaigns
                let hasActiveCampaigns = false;
                let hasUpcomingCampaigns = false;
                
                // Check for active campaigns (look for actual campaign articles)
                if (activeGrid) {
                    const activeCampaignCards = activeGrid.querySelectorAll('article.group');
                    const hasContent = activeGrid.innerHTML.trim().length > 50; // Check if there's meaningful content
                    console.log('Active grid check:', {
                        articles: activeCampaignCards.length,
                        hasContent: hasContent,
                        innerHTML: activeGrid.innerHTML.substring(0, 100)
                    });
                    
                    if (activeCampaignCards.length > 0 || hasContent) {
                        activeGrid.style.display = 'grid';
                        hasActiveCampaigns = true;
                    }
                }
                
                // Check for upcoming campaigns
                if (upcomingGrid) {
                    const upcomingCampaignCards = upcomingGrid.querySelectorAll('article.group');
                    const hasContent = upcomingGrid.innerHTML.trim().length > 50; // Check if there's meaningful content
                    console.log('Upcoming grid check:', {
                        articles: upcomingCampaignCards.length,
                        hasContent: hasContent,
                        innerHTML: upcomingGrid.innerHTML.substring(0, 100)
                    });
                    
                    if (upcomingCampaignCards.length > 0 || hasContent) {
                        upcomingGrid.style.display = 'grid';
                        hasUpcomingCampaigns = true;
                    }
                }
                
                // Show empty state if no campaigns
                if (!hasActiveCampaigns && !hasUpcomingCampaigns) {
                    if (emptyState) emptyState.style.display = 'block';
                    if (emptyTitle) emptyTitle.textContent = 'No Campaigns Available';
                    if (emptyDescription) emptyDescription.textContent = 'We couldn\'t find any campaigns matching your current filter. Try selecting a different filter or check back later.';
                }
                break;

            case 'active':
                if (badge) {
                    badge.className = 'inline-flex items-center gap-2 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 px-4 py-2 rounded-full text-sm font-semibold mb-4';
                }
                if (badgeIcon) badgeIcon.textContent = 'play_circle';
                if (badgeText) badgeText.textContent = 'Active Now';
                if (title) title.textContent = 'Active Campaigns';
                if (description) description.textContent = 'These campaigns are currently running. Contact us to learn more about how you can get involved and make a difference!';
                
                if (activeGrid) {
                    const activeCampaignCards = activeGrid.querySelectorAll('article.group');
                    const hasContent = activeGrid.innerHTML.trim().length > 50;
                    console.log('Active filter - grid check:', {
                        articles: activeCampaignCards.length,
                        hasContent: hasContent
                    });
                    
                    if (activeCampaignCards.length > 0 || hasContent) {
                        activeGrid.style.display = 'grid';
                    } else {
                        if (emptyState) emptyState.style.display = 'block';
                        if (emptyTitle) emptyTitle.textContent = 'No Active Campaigns';
                        if (emptyDescription) emptyDescription.textContent = 'There are currently no active campaigns running. Check back soon or explore our upcoming campaigns!';
                    }
                } else {
                    if (emptyState) emptyState.style.display = 'block';
                    if (emptyTitle) emptyTitle.textContent = 'No Active Campaigns';
                    if (emptyDescription) emptyDescription.textContent = 'There are currently no active campaigns running. Check back soon or explore our upcoming campaigns!';
                }
                break;

            case 'upcoming':
                if (badge) {
                    badge.className = 'inline-flex items-center gap-2 bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-300 px-4 py-2 rounded-full text-sm font-semibold mb-4';
                }
                if (badgeIcon) badgeIcon.textContent = 'schedule';
                if (badgeText) badgeText.textContent = 'Coming Soon';
                if (title) title.textContent = 'Upcoming Campaigns';
                if (description) description.textContent = 'Get ready for these exciting campaigns launching soon. Contact us for more information and stay updated on launch dates!';
                
                if (upcomingGrid) {
                    const upcomingCampaignCards = upcomingGrid.querySelectorAll('article.group');
                    const hasContent = upcomingGrid.innerHTML.trim().length > 50;
                    console.log('Upcoming filter - grid check:', {
                        articles: upcomingCampaignCards.length,
                        hasContent: hasContent
                    });
                    
                    if (upcomingCampaignCards.length > 0 || hasContent) {
                        upcomingGrid.style.display = 'grid';
                    } else {
                        if (emptyState) emptyState.style.display = 'block';
                        if (emptyTitle) emptyTitle.textContent = 'No Upcoming Campaigns';
                        if (emptyDescription) emptyDescription.textContent = 'There are currently no upcoming campaigns scheduled. Check back later for new announcements!';
                    }
                } else {
                    if (emptyState) emptyState.style.display = 'block';
                    if (emptyTitle) emptyTitle.textContent = 'No Upcoming Campaigns';
                    if (emptyDescription) emptyDescription.textContent = 'There are currently no upcoming campaigns scheduled. Check back later for new announcements!';
                }
                break;

            case 'completed':
                if (badge) {
                    badge.className = 'inline-flex items-center gap-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-full text-sm font-semibold mb-4';
                }
                if (badgeIcon) badgeIcon.textContent = 'check_circle';
                if (badgeText) badgeText.textContent = 'Completed';
                if (title) title.textContent = 'Completed Campaigns';
                if (description) description.textContent = 'View our past campaigns and their impact on the community. These successful initiatives have made a lasting difference.';
                
                // For now, show empty state for completed campaigns
                if (emptyState) emptyState.style.display = 'block';
                if (emptyTitle) emptyTitle.textContent = 'No Completed Campaigns to Display';
                if (emptyDescription) emptyDescription.textContent = 'Completed campaigns are archived and not currently displayed. Contact us for information about past campaign impacts and results.';
                break;
        }
    }
    
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