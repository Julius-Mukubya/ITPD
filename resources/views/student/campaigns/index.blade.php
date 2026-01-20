@extends('layouts.student')

@section('title', 'Campaigns & Events')
@section('page-title', 'Campaigns & Events')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Heading -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Campaigns & Events</h1>
                <p class="text-gray-600 dark:text-gray-400">Participate in awareness campaigns and make a difference</p>
            </div>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <!-- Active Campaigns -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-lg backdrop-blur-sm">
                    <span class="material-symbols-outlined text-2xl">event</span>
                </div>
            </div>
            <p class="text-3xl font-bold mb-1">{{ $activeCampaigns }}</p>
            <p class="text-blue-100 text-sm">Active Campaigns</p>
        </div>

        <!-- My Registrations -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-lg backdrop-blur-sm">
                    <span class="material-symbols-outlined text-2xl">check_circle</span>
                </div>
            </div>
            <p class="text-3xl font-bold mb-1">{{ $myRegistrations }}</p>
            <p class="text-green-100 text-sm">My Registrations</p>
        </div>

        <!-- Total Participants -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-white/20 rounded-lg backdrop-blur-sm">
                    <span class="material-symbols-outlined text-2xl">groups</span>
                </div>
            </div>
            <p class="text-3xl font-bold mb-1">{{ $totalParticipants }}</p>
            <p class="text-purple-100 text-sm">Total Participants</p>
        </div>
    </div>

    <!-- Tabs -->
    <div class="mb-6">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="flex gap-8">
                <button onclick="showTab('all')" id="tab-all" class="tab-button py-4 px-1 border-b-2 border-primary text-primary font-semibold">
                    All Campaigns
                </button>
                <button onclick="showTab('registered')" id="tab-registered" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 font-medium">
                    My Campaigns
                </button>
                <button onclick="showTab('upcoming')" id="tab-upcoming" class="tab-button py-4 px-1 border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 font-medium">
                    Upcoming
                </button>
            </nav>
        </div>
    </div>

    <!-- All Campaigns Tab -->
    <div id="content-all" class="tab-content">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($campaigns as $campaign)
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-all">
                <div class="aspect-video bg-gradient-to-br from-primary to-green-600 relative">
                    @if($campaign->banner_image)
                        <img src="{{ $campaign->banner_url }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center text-white">
                            <span class="material-symbols-outlined text-6xl">campaign</span>
                        </div>
                    @endif
                    
                    @if($campaign->status === 'active')
                        <div class="absolute top-2 right-2 bg-green-500 text-white text-xs px-3 py-1 rounded-full font-semibold">
                            Active
                        </div>
                    @endif
                </div>
                
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">{{ $campaign->title }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">{{ $campaign->description }}</p>
                    
                    <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400 mb-4">
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">calendar_today</span>
                            <span>{{ $campaign->start_date->format('M d') }} - {{ $campaign->end_date->format('M d') }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">groups</span>
                            <span>{{ $campaign->participants_count }} joined</span>
                        </div>
                    </div>
                    
                    <div class="flex gap-2">
                        <a href="{{ route('campaigns.show', $campaign) }}" class="flex-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-center py-2 rounded-lg font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-sm">
                            View Details
                        </a>
                        
                        @if($campaign->isUserRegistered(auth()->id()))
                            <button class="flex-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-center py-2 rounded-lg font-semibold cursor-default text-sm">
                                ✓ Registered
                            </button>
                        @else
                            <form action="{{ route('campaigns.register', $campaign) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full bg-primary text-white text-center py-2 rounded-lg font-semibold hover:bg-primary/90 transition-colors text-sm">
                                    Join Now
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <span class="material-symbols-outlined text-6xl text-gray-400 mb-4">campaign</span>
                <p class="text-gray-500 dark:text-gray-400">No campaigns available at the moment</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- My Campaigns Tab -->
    <div id="content-registered" class="tab-content hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($registeredCampaigns as $campaign)
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-all">
                <div class="aspect-video bg-gradient-to-br from-primary to-green-600 relative">
                    @if($campaign->banner_image)
                        <img src="{{ $campaign->banner_url }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center text-white">
                            <span class="material-symbols-outlined text-6xl">campaign</span>
                        </div>
                    @endif
                    
                    <div class="absolute top-2 right-2 bg-green-500 text-white text-xs px-3 py-1 rounded-full font-semibold">
                        ✓ Registered
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">{{ $campaign->title }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">{{ $campaign->description }}</p>
                    
                    <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400 mb-4">
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">calendar_today</span>
                            <span>{{ $campaign->start_date->format('M d') }} - {{ $campaign->end_date->format('M d') }}</span>
                        </div>
                    </div>
                    
                    <div class="flex gap-2">
                        <a href="{{ route('campaigns.show', $campaign) }}" class="flex-1 bg-primary text-white text-center py-2 rounded-lg font-semibold hover:bg-primary/90 transition-colors text-sm">
                            View Campaign
                        </a>
                        
                        <form action="{{ route('campaigns.unregister', $campaign) }}" method="POST" class="flex-1" onsubmit="return confirm('Are you sure you want to unregister?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-center py-2 rounded-lg font-semibold hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors text-sm">
                                Unregister
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <span class="material-symbols-outlined text-6xl text-gray-400 mb-4">event_busy</span>
                <p class="text-gray-500 dark:text-gray-400 mb-4">You haven't registered for any campaigns yet</p>
                <button onclick="showTab('all')" class="bg-primary text-white px-6 py-2 rounded-lg font-semibold hover:bg-primary/90 transition-colors">
                    Browse Campaigns
                </button>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Upcoming Tab -->
    <div id="content-upcoming" class="tab-content hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($upcomingCampaigns as $campaign)
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-all">
                <div class="aspect-video bg-gradient-to-br from-primary to-green-600 relative">
                    @if($campaign->banner_image)
                        <img src="{{ $campaign->banner_url }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center text-white">
                            <span class="material-symbols-outlined text-6xl">campaign</span>
                        </div>
                    @endif
                    
                    <div class="absolute top-2 right-2 bg-blue-500 text-white text-xs px-3 py-1 rounded-full font-semibold">
                        Upcoming
                    </div>
                </div>
                
                <div class="p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">{{ $campaign->title }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">{{ $campaign->description }}</p>
                    
                    <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400 mb-4">
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">calendar_today</span>
                            <span>Starts {{ $campaign->start_date->format('M d, Y') }}</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('campaigns.show', $campaign) }}" class="block w-full bg-primary text-white text-center py-2 rounded-lg font-semibold hover:bg-primary/90 transition-colors text-sm">
                        Learn More
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <span class="material-symbols-outlined text-6xl text-gray-400 mb-4">event</span>
                <p class="text-gray-500 dark:text-gray-400">No upcoming campaigns scheduled</p>
            </div>
            @endforelse
        </div>
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
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active state from all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-primary', 'text-primary');
        button.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
    });
    
    // Show selected tab content
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Add active state to selected tab
    const activeTab = document.getElementById('tab-' + tabName);
    activeTab.classList.add('border-primary', 'text-primary');
    activeTab.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
}
</script>
@endpush
