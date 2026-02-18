@extends('layouts.public')

@section('title', $campaign->title . ' - WellPath')

@section('content')
<!-- Breadcrumb Navigation -->
<div class="bg-white dark:bg-gray-800/50 border-b border-[#f0f4f3] dark:border-gray-800 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-sm">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-[#61897c] dark:text-gray-400 hover:text-primary transition-colors group">
                <span class="material-symbols-outlined !text-lg group-hover:scale-110 transition-transform">home</span>
                Home
            </a>
            <span class="material-symbols-outlined !text-lg text-[#61897c] dark:text-gray-400">chevron_right</span>
            <a href="{{ route('campaigns.index') }}" class="flex items-center gap-2 text-[#61897c] dark:text-gray-400 hover:text-primary transition-colors group">
                <span class="material-symbols-outlined !text-lg group-hover:scale-110 transition-transform">campaign</span>
                Campaigns
            </a>
            <span class="material-symbols-outlined !text-lg text-[#61897c] dark:text-gray-400">chevron_right</span>
            <span class="text-[#111816] dark:text-white font-semibold flex items-center gap-2">
                <span class="material-symbols-outlined !text-lg text-primary">event</span>
                {{ Str::limit($campaign->title, 30) }}
            </span>
        </nav>
    </div>
</div>

<!-- Enhanced Hero Section -->
<div class="relative overflow-hidden">
    @if($campaign->banner_image)
        <img src="{{ $campaign->banner_url }}" alt="{{ $campaign->title }}" 
             class="w-full h-80 sm:h-96 lg:h-[500px] object-cover">
    @else
        <div class="w-full h-80 sm:h-96 lg:h-[500px] bg-gradient-to-br 
            @if($campaign->start_date && $campaign->end_date)
                @if(now()->between($campaign->start_date, $campaign->end_date)) from-green-500 via-primary to-green-600
                @elseif(now()->lt($campaign->start_date)) from-green-500 via-purple-600 to-blue-700
                @else from-gray-500 via-gray-600 to-gray-700
                @endif
            @else
                @if($campaign->status === 'active') from-green-500 via-primary to-green-600
                @elseif($campaign->status === 'upcoming') from-green-500 via-purple-600 to-blue-700
                @else from-gray-500 via-gray-600 to-gray-700
                @endif
            @endif flex items-center justify-center">
            <div class="text-center text-white">
                <div class="w-32 h-32 bg-white/20 rounded-full flex items-center justify-center mb-6 mx-auto">
                    <span class="material-symbols-outlined !text-6xl">campaign</span>
                </div>
                <h2 class="text-2xl font-bold">{{ $campaign->title }}</h2>
            </div>
        </div>
    @endif
    
    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
    
    <!-- Hero Content -->
    <div class="absolute inset-0 flex items-end">
        <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            <div class="max-w-4xl">
                <!-- Status Badge -->
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex items-center gap-2 
                        @if($campaign->start_date && $campaign->end_date)
                            @if(now()->between($campaign->start_date, $campaign->end_date)) bg-green-500 
                            @elseif(now()->lt($campaign->start_date)) bg-green-500 
                            @else bg-gray-500 
                            @endif
                        @else
                            @if($campaign->status === 'active') bg-green-500 
                            @elseif($campaign->status === 'upcoming') bg-green-500 
                            @else bg-gray-500 
                            @endif
                        @endif text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                        @if($campaign->start_date && $campaign->end_date)
                            @if(now()->between($campaign->start_date, $campaign->end_date))
                                <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                Active Campaign
                            @elseif(now()->lt($campaign->start_date))
                                <span class="material-symbols-outlined !text-sm">schedule</span>
                                Upcoming Campaign
                            @else
                                <span class="material-symbols-outlined !text-sm">check_circle</span>
                                Completed Campaign
                            @endif
                        @else
                            @if($campaign->status === 'active')
                                <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                Active Campaign
                            @elseif($campaign->status === 'upcoming')
                                <span class="material-symbols-outlined !text-sm">schedule</span>
                                Upcoming Campaign
                            @else
                                <span class="material-symbols-outlined !text-sm">check_circle</span>
                                Completed Campaign
                            @endif
                        @endif
                    </div>
                    <div class="text-white/80 text-sm">
                        {{ $campaign->type ? ucfirst($campaign->type) : 'General' }} Campaign
                    </div>
                </div>
                
                <!-- Title -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-tight tracking-tight mb-6">
                    {{ $campaign->title }}
                </h1>
                
                <!-- Description -->
                <p class="text-xl text-white/90 leading-relaxed mb-8 max-w-3xl">
                    {{ $campaign->description }}
                </p>
                
                <!-- Meta Information -->
                <div class="flex flex-col sm:flex-row gap-6 text-white/80">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined !text-xl">calendar_today</span>
                        <span class="font-medium">
                            {{ $campaign->start_date ? $campaign->start_date->format('M d') : 'TBD' }} - 
                            {{ $campaign->end_date ? $campaign->end_date->format('M d, Y') : 'TBD' }}
                        </span>
                    </div>
                    @if($campaign->location)
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined !text-xl">location_on</span>
                        <span class="font-medium">{{ $campaign->location }}</span>
                    </div>
                    @endif
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined !text-xl">person</span>
                        <span class="font-medium">By {{ $campaign->creator ? $campaign->creator->name : 'WellPath Team' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        
        <!-- Left Column - Main Content -->
        <div class="lg:col-span-2 space-y-10">
            
            <!-- Campaign Overview -->
            <div class="bg-white dark:bg-gray-800/50 rounded-3xl p-8 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
                <h2 class="text-3xl font-bold text-[#111816] dark:text-white mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary !text-2xl">info</span>
                    About This Campaign
                </h2>
                <div class="prose prose-lg max-w-none dark:prose-invert 
                           prose-headings:font-bold prose-headings:text-[#111816] dark:prose-headings:text-white
                           prose-p:text-[#61897c] dark:prose-p:text-gray-300 prose-p:leading-relaxed
                           prose-a:text-primary prose-a:no-underline hover:prose-a:underline">
                    <p class="text-lg">{{ $campaign->description }}</p>
                    
                    @if($campaign->goals)
                        <h3>Goals & Objectives</h3>
                        <p>{{ $campaign->goals }}</p>
                    @endif
                    
                    @if($campaign->target_audience)
                        <h3>Who Should Join</h3>
                        <p>{{ $campaign->target_audience }}</p>
                    @endif
                </div>
            </div>

            <!-- Campaign Timeline -->
            <div class="bg-white dark:bg-gray-800/50 rounded-3xl p-8 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
                <h3 class="text-2xl font-bold text-[#111816] dark:text-white mb-8 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary !text-2xl">timeline</span>
                    Campaign Timeline
                </h3>
                <div class="relative">
                    <!-- Timeline Line -->
                    <div class="absolute left-6 top-8 bottom-8 w-0.5 bg-gradient-to-b from-primary to-gray-300 dark:to-gray-600"></div>
                    
                    <div class="space-y-8">
                        <!-- Start Date -->
                        <div class="flex items-start gap-6">
                            <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center shadow-lg flex-shrink-0">
                                <span class="material-symbols-outlined text-white !text-xl">play_arrow</span>
                            </div>
                            <div class="pt-2">
                                <h4 class="font-bold text-[#111816] dark:text-white text-lg">Campaign Launch</h4>
                                <p class="text-[#61897c] dark:text-gray-400 mb-2">
                                    {{ $campaign->start_date ? $campaign->start_date->format('F d, Y \a\t g:i A') : 'To be announced' }}
                                </p>
                                <p class="text-sm text-[#61897c] dark:text-gray-400">
                                    The campaign officially begins and participants can start engaging with activities.
                                </p>
                            </div>
                        </div>
                        
                        <!-- End Date -->
                        <div class="flex items-start gap-6">
                            <div class="w-12 h-12 bg-gray-400 dark:bg-gray-600 rounded-full flex items-center justify-center shadow-lg flex-shrink-0">
                                <span class="material-symbols-outlined text-white !text-xl">flag</span>
                            </div>
                            <div class="pt-2">
                                <h4 class="font-bold text-[#111816] dark:text-white text-lg">Campaign Conclusion</h4>
                                <p class="text-[#61897c] dark:text-gray-400 mb-2">
                                    {{ $campaign->end_date ? $campaign->end_date->format('F d, Y \a\t g:i A') : 'To be announced' }}
                                </p>
                                <p class="text-sm text-[#61897c] dark:text-gray-400">
                                    Campaign activities conclude and we celebrate the impact made together.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Campaign Details & Statistics -->
            <div class="bg-gradient-to-br from-primary/10 to-green-500/10 dark:from-primary/20 dark:to-green-500/20 rounded-3xl p-8 border border-primary/20">
                <h3 class="text-2xl font-bold text-[#111816] dark:text-white mb-8 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary !text-2xl">info</span>
                    Campaign Details
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-black text-primary mb-2">
                            {{ $campaign->start_date && $campaign->end_date ? $campaign->start_date->diffInDays($campaign->end_date) : 0 }}
                        </div>
                        <div class="text-sm font-medium text-[#61897c] dark:text-gray-400">Days Duration</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-primary mb-2">24/7</div>
                        <div class="text-sm font-medium text-[#61897c] dark:text-gray-400">Support</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-primary mb-2">{{ ucfirst($campaign->type ?? 'General') }}</div>
                        <div class="text-sm font-medium text-[#61897c] dark:text-gray-400">Campaign Type</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-primary mb-2">
                            @if($campaign->max_participants)
                                {{ $campaign->max_participants }}
                            @else
                                Open
                            @endif
                        </div>
                        <div class="text-sm font-medium text-[#61897c] dark:text-gray-400">
                            @if($campaign->max_participants)
                                Max Participants
                            @else
                                Participation
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-8">

                <!-- Campaign Contact Information -->
                <div id="contact-info" class="bg-white dark:bg-gray-800/50 rounded-2xl p-6 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
                    <h3 class="text-xl font-bold text-[#111816] dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">contact_support</span>
                        Campaign Information
                    </h3>
                    
                    @if($campaign->start_date && $campaign->end_date)
                        @if(now()->between($campaign->start_date, $campaign->end_date))
                            <div class="text-center mb-6">
                                <div class="w-16 h-16 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="material-symbols-outlined text-green-600 dark:text-green-400 !text-2xl">campaign</span>
                                </div>
                                <p class="font-semibold text-green-600 dark:text-green-400 mb-2">Campaign Active</p>
                                <p class="text-sm text-[#61897c] dark:text-gray-400">This campaign is currently running. Contact us for more information.</p>
                            </div>
                        @elseif(now()->lt($campaign->start_date))
                            <div class="text-center mb-6">
                                <div class="w-16 h-16 bg-green-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="material-symbols-outlined text-green-600 dark:text-green-400 !text-2xl">schedule</span>
                                </div>
                                <p class="font-semibold text-[#111816] dark:text-white mb-2">Coming Soon</p>
                                <p class="text-sm text-[#61897c] dark:text-gray-400 mb-4">
                                    Campaign starts {{ $campaign->start_date->format('M d, Y') }}
                                    @if($campaign->start_time)
                                        at {{ \Carbon\Carbon::parse($campaign->start_time)->format('g:i A') }}
                                    @endif
                                </p>
                            </div>
                        @else
                            <div class="text-center mb-6">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="material-symbols-outlined text-gray-400 !text-2xl">check_circle</span>
                                </div>
                                <p class="font-semibold text-[#111816] dark:text-white mb-2">Campaign Ended</p>
                                <p class="text-sm text-[#61897c] dark:text-gray-400 mb-4">
                                    This campaign concluded on {{ $campaign->end_date->format('M d, Y') }}
                                </p>
                            </div>
                        @endif
                    @else
                        @if($campaign->status === 'active')
                            <div class="text-center mb-6">
                                <div class="w-16 h-16 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="material-symbols-outlined text-green-600 dark:text-green-400 !text-2xl">campaign</span>
                                </div>
                                <p class="font-semibold text-green-600 dark:text-green-400 mb-2">Campaign Active</p>
                                <p class="text-sm text-[#61897c] dark:text-gray-400">This campaign is currently running. Contact us for more information.</p>
                            </div>
                        @elseif($campaign->status === 'upcoming')
                            <div class="text-center mb-6">
                                <div class="w-16 h-16 bg-green-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="material-symbols-outlined text-green-600 dark:text-green-400 !text-2xl">schedule</span>
                                </div>
                                <p class="font-semibold text-[#111816] dark:text-white mb-2">Coming Soon</p>
                                <p class="text-sm text-[#61897c] dark:text-gray-400 mb-4">
                                    Campaign starts {{ $campaign->start_date ? $campaign->start_date->format('M d, Y') : 'soon' }}
                                    @if($campaign->start_time)
                                        at {{ \Carbon\Carbon::parse($campaign->start_time)->format('g:i A') }}
                                    @endif
                                </p>
                            </div>
                        @else
                            <div class="text-center mb-6">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="material-symbols-outlined text-gray-400 !text-2xl">check_circle</span>
                                </div>
                                <p class="font-semibold text-[#111816] dark:text-white mb-2">Campaign Ended</p>
                                <p class="text-sm text-[#61897c] dark:text-gray-400 mb-4">
                                    This campaign concluded on {{ $campaign->end_date ? $campaign->end_date->format('M d, Y') : 'recently' }}
                                </p>
                            </div>
                        @endif
                    @endif

                    <!-- Contact Details -->
                    @if($campaign->contacts && $campaign->contacts->count() > 0)
                        @foreach($campaign->contacts as $contact)
                            <div class="bg-primary/5 dark:bg-primary/10 rounded-xl p-4 mb-6 {{ $contact->is_primary ? 'border-2 border-primary/20' : '' }}">
                                <h4 class="font-semibold text-[#111816] dark:text-white mb-3 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary !text-lg">contact_phone</span>
                                    {{ $contact->name }}
                                    @if($contact->is_primary)
                                        <span class="text-xs bg-primary text-white px-2 py-1 rounded-full">Primary</span>
                                    @endif
                                </h4>
                                
                                @if($contact->title)
                                    <p class="text-sm text-[#61897c] dark:text-gray-400 mb-3">{{ $contact->title }}</p>
                                @endif
                                
                                <div class="space-y-3 text-sm">
                                    <div class="flex items-center gap-3 text-[#61897c] dark:text-gray-400">
                                        <span class="material-symbols-outlined text-primary !text-lg">email</span>
                                        <div>
                                            <div class="font-medium text-[#111816] dark:text-white">Email</div>
                                            <div>{{ $contact->email }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3 text-[#61897c] dark:text-gray-400">
                                        <span class="material-symbols-outlined text-primary !text-lg">phone</span>
                                        <div>
                                            <div class="font-medium text-[#111816] dark:text-white">Phone</div>
                                            <div>{{ $contact->phone }}</div>
                                        </div>
                                    </div>
                                    @if($contact->office_location)
                                    <div class="flex items-center gap-3 text-[#61897c] dark:text-gray-400">
                                        <span class="material-symbols-outlined text-primary !text-lg">location_on</span>
                                        <div>
                                            <div class="font-medium text-[#111816] dark:text-white">Office</div>
                                            <div>{{ $contact->office_location }}</div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($contact->office_hours)
                                    <div class="flex items-center gap-3 text-[#61897c] dark:text-gray-400">
                                        <span class="material-symbols-outlined text-primary !text-lg">schedule</span>
                                        <div>
                                            <div class="font-medium text-[#111816] dark:text-white">Office Hours</div>
                                            <div>{{ $contact->office_hours }}</div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Quick Actions for this contact -->
                                <div class="flex gap-2 mt-4">
                                    <a href="mailto:{{ $contact->email }}?subject=Inquiry about {{ $campaign->title }}" 
                                       class="flex-1 bg-primary text-white py-2 px-3 rounded-lg font-semibold hover:bg-primary/90 transition-all duration-200 text-center text-sm">
                                        <span class="flex items-center justify-center gap-2">
                                            <span class="material-symbols-outlined !text-sm">email</span>
                                            Email
                                        </span>
                                    </a>
                                    <a href="tel:{{ str_replace(' ', '', $contact->phone) }}" 
                                       class="flex-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 py-2 px-3 rounded-lg font-semibold hover:bg-green-200 dark:hover:bg-green-900/50 transition-all duration-200 text-center text-sm">
                                        <span class="flex items-center justify-center gap-2">
                                            <span class="material-symbols-outlined !text-sm">phone</span>
                                            Call
                                        </span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Fallback to old contact fields if no contacts exist -->
                        <div class="bg-primary/5 dark:bg-primary/10 rounded-xl p-4 mb-6">
                            <h4 class="font-semibold text-[#111816] dark:text-white mb-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary !text-lg">contact_phone</span>
                                Get In Touch
                            </h4>
                            <div class="space-y-3 text-sm">
                                <div class="flex items-center gap-3 text-[#61897c] dark:text-gray-400">
                                    <span class="material-symbols-outlined text-primary !text-lg">email</span>
                                    <div>
                                        <div class="font-medium text-[#111816] dark:text-white">Email</div>
                                        <div>{{ $campaign->contact_email ?? 'wellness@wellpath.edu' }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 text-[#61897c] dark:text-gray-400">
                                    <span class="material-symbols-outlined text-primary !text-lg">phone</span>
                                    <div>
                                        <div class="font-medium text-[#111816] dark:text-white">Phone</div>
                                        <div>{{ $campaign->contact_phone ?? '+256 123 456 789' }}</div>
                                    </div>
                                </div>
                                @if($campaign->contact_office)
                                <div class="flex items-center gap-3 text-[#61897c] dark:text-gray-400">
                                    <span class="material-symbols-outlined text-primary !text-lg">location_on</span>
                                    <div>
                                        <div class="font-medium text-[#111816] dark:text-white">Office</div>
                                        <div>{{ $campaign->contact_office }}</div>
                                    </div>
                                </div>
                                @endif
                                @if($campaign->contact_hours)
                                <div class="flex items-center gap-3 text-[#61897c] dark:text-gray-400">
                                    <span class="material-symbols-outlined text-primary !text-lg">schedule</span>
                                    <div>
                                        <div class="font-medium text-[#111816] dark:text-white">Office Hours</div>
                                        <div>{{ $campaign->contact_hours }}</div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <!-- Quick Actions -->
                            <div class="space-y-3 mt-4">
                                <a href="mailto:{{ $campaign->contact_email ?? 'wellness@wellpath.edu' }}?subject=Inquiry about {{ $campaign->title }}" 
                                   class="w-full bg-primary text-white py-3 rounded-xl font-semibold hover:bg-primary/90 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl block text-center">
                                    <span class="flex items-center justify-center gap-2">
                                        <span class="material-symbols-outlined !text-lg">email</span>
                                        Send Email
                                    </span>
                                </a>
                                <a href="tel:{{ str_replace(' ', '', $campaign->contact_phone ?? '+256123456789') }}" 
                                   class="w-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 py-3 rounded-xl font-semibold hover:bg-green-200 dark:hover:bg-green-900/50 transition-all duration-200 block text-center">
                                    <span class="flex items-center justify-center gap-2">
                                        <span class="material-symbols-outlined !text-lg">phone</span>
                                        Call Now
                                    </span>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Share Campaign -->
                <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-6 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
                    <h3 class="text-lg font-bold text-[#111816] dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">share</span>
                        Share Campaign
                    </h3>
                    <div class="space-y-3">
                        <button onclick="shareToTwitter()" class="flex items-center gap-3 w-full p-3 bg-green-50 dark:bg-blue-900/30 text-green-600 dark:text-green-400 rounded-xl hover:bg-green-100 dark:hover:bg-blue-900/50 transition-colors text-sm font-medium">
                            <span class="material-symbols-outlined !text-lg">share</span>
                            Share on Twitter
                        </button>
                        <button onclick="shareToFacebook()" class="flex items-center gap-3 w-full p-3 bg-green-50 dark:bg-blue-900/30 text-green-600 dark:text-green-400 rounded-xl hover:bg-green-100 dark:hover:bg-blue-900/50 transition-colors text-sm font-medium">
                            <span class="material-symbols-outlined !text-lg">share</span>
                            Share on Facebook
                        </button>
                        <button onclick="copyLink()" class="flex items-center gap-3 w-full p-3 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors text-sm font-medium">
                            <span class="material-symbols-outlined !text-lg">link</span>
                            Copy Link
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Information Section -->
<div class="py-20 bg-gradient-to-r from-primary/10 via-background-light to-green-500/10 dark:from-primary/20 dark:via-background-dark dark:to-green-500/20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-black text-[#111816] dark:text-white mb-6">
            Get More Information
        </h2>
        <p class="text-xl text-[#61897c] dark:text-gray-400 mb-8 max-w-2xl mx-auto">
            Interested in learning more about this campaign? Contact our wellness team for detailed information and how you can get involved.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="mailto:{{ $campaign->contact_email ?? 'wellness@wellpath.edu' }}?subject=Inquiry about {{ $campaign->title }}" class="inline-flex items-center gap-2 bg-primary text-white px-8 py-4 rounded-xl font-bold hover:bg-primary/90 transition-all duration-200 transform hover:scale-105 shadow-lg">
                <span class="material-symbols-outlined !text-xl">email</span>
                Contact Us
            </a>
            <a href="{{ route('campaigns.index') }}" class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-[#f0f4f3] dark:border-gray-700 text-[#111816] dark:text-white px-8 py-4 rounded-xl font-bold hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 transform hover:scale-105">
                <span class="material-symbols-outlined !text-xl">campaign</span>
                View All Campaigns
            </a>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
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
// Share functionality
function shareToTwitter() {
    const text = encodeURIComponent('{{ $campaign->title }} - {{ $campaign->description }}');
    const url = encodeURIComponent(window.location.href);
    window.open(`https://twitter.com/intent/tweet?text=${text}&url=${url}`, '_blank');
    showToast('Opening Twitter...', 'info');
}

function shareToFacebook() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
    showToast('Opening Facebook...', 'info');
}

function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        showToast('Link copied to clipboard! 📋', 'success');
    }).catch(() => {
        showToast('Failed to copy link', 'error');
    });
}

// Toast notification system
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    const bgColor = {
        'success': 'bg-green-500',
        'error': 'bg-red-500',
        'info': 'bg-green-500',
        'warning': 'bg-yellow-500'
    }[type] || 'bg-primary';
    
    toast.className = `fixed top-24 right-4 z-50 px-6 py-4 rounded-2xl shadow-2xl text-white font-semibold ${bgColor} transform translate-x-full transition-transform duration-300 max-w-sm`;
    toast.innerHTML = `
        <div class="flex items-center gap-3">
            <span class="material-symbols-outlined !text-xl">
                ${type === 'success' ? 'check_circle' : 
                  type === 'error' ? 'error' : 
                  type === 'warning' ? 'warning' : 'info'}
            </span>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Slide in
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove after 4 seconds
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(toast)) {
                document.body.removeChild(toast);
            }
        }, 300);
    }, 4000);
    
    // Click to dismiss
    toast.addEventListener('click', () => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(toast)) {
                document.body.removeChild(toast);
            }
        }, 300);
    });
}

// Intersection Observer for animations
document.addEventListener('DOMContentLoaded', function() {
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
    
    // Observe content sections for fade-in animation
    document.querySelectorAll('.bg-white, .bg-gradient-to-br').forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(20px)';
        element.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(element);
    });
});
</script>
@endpush
