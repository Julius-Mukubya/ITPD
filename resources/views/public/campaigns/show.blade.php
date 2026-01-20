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
            @if($campaign->status === 'active') from-green-500 via-primary to-green-600
            @elseif($campaign->status === 'upcoming') from-blue-500 via-purple-600 to-blue-700
            @else from-gray-500 via-gray-600 to-gray-700
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
                        @if($campaign->status === 'active') bg-green-500 
                        @elseif($campaign->status === 'upcoming') bg-blue-500 
                        @else bg-gray-500 
                        @endif text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
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
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined !text-xl">group</span>
                        <span class="font-medium">{{ $campaign->participants ? $campaign->participants()->count() : 0 }} participants</span>
                    </div>
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

            <!-- Impact & Statistics -->
            <div class="bg-gradient-to-br from-primary/10 to-green-500/10 dark:from-primary/20 dark:to-green-500/20 rounded-3xl p-8 border border-primary/20">
                <h3 class="text-2xl font-bold text-[#111816] dark:text-white mb-8 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary !text-2xl">trending_up</span>
                    Campaign Impact
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-black text-primary mb-2">{{ $campaign->participants ? $campaign->participants()->count() : 0 }}</div>
                        <div class="text-sm font-medium text-[#61897c] dark:text-gray-400">Participants</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-primary mb-2">
                            {{ $campaign->start_date && $campaign->end_date ? $campaign->start_date->diffInDays($campaign->end_date) : 0 }}
                        </div>
                        <div class="text-sm font-medium text-[#61897c] dark:text-gray-400">Days Duration</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-primary mb-2">100%</div>
                        <div class="text-sm font-medium text-[#61897c] dark:text-gray-400">Free to Join</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-primary mb-2">24/7</div>
                        <div class="text-sm font-medium text-[#61897c] dark:text-gray-400">Support</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="lg:col-span-1">
            <div class="sticky top-24 space-y-8">

                <!-- Join Campaign Card -->
                <div id="registration-form" class="bg-white dark:bg-gray-800/50 rounded-2xl p-6 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
                    <h3 class="text-xl font-bold text-[#111816] dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">volunteer_activism</span>
                        Join Campaign
                    </h3>
                    
                    @auth
                        @if($campaign->status === 'active')
                            @if($isRegistered)
                                <!-- Already Registered -->
                                <div class="text-center mb-6">
                                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <span class="material-symbols-outlined text-green-600 dark:text-green-400 !text-2xl">check_circle</span>
                                    </div>
                                    <p class="font-semibold text-green-600 dark:text-green-400 mb-2">You're Registered!</p>
                                    <p class="text-sm text-[#61897c] dark:text-gray-400">You're part of this campaign. Check your dashboard for updates and activities.</p>
                                </div>
                                
                                <!-- Registration Benefits -->
                                <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4 mb-6">
                                    <h4 class="font-semibold text-green-800 dark:text-green-300 mb-2 flex items-center gap-2">
                                        <span class="material-symbols-outlined !text-lg">star</span>
                                        Your Benefits
                                    </h4>
                                    <ul class="text-sm text-green-700 dark:text-green-400 space-y-1">
                                        <li class="flex items-center gap-2">
                                            <span class="material-symbols-outlined !text-sm">notifications</span>
                                            Campaign updates & reminders
                                        </li>
                                        <li class="flex items-center gap-2">
                                            <span class="material-symbols-outlined !text-sm">event</span>
                                            Access to all activities
                                        </li>
                                        <li class="flex items-center gap-2">
                                            <span class="material-symbols-outlined !text-sm">certificate</span>
                                            Participation certificate
                                        </li>
                                        <li class="flex items-center gap-2">
                                            <span class="material-symbols-outlined !text-sm">support</span>
                                            Priority support access
                                        </li>
                                    </ul>
                                </div>
                                
                                <div class="space-y-3">
                                    <a href="{{ route('student.campaigns.index') }}" class="w-full bg-primary text-white py-3 rounded-xl font-semibold hover:bg-primary/90 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl block text-center">
                                        View My Campaigns
                                    </a>
                                    <form method="POST" action="{{ route('campaigns.unregister', $campaign) }}" onsubmit="return confirm('Are you sure you want to leave this campaign?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-300 py-3 rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-200">
                                            Leave Campaign
                                        </button>
                                    </form>
                                </div>
                            @else
                                <!-- Registration Form -->
                                <div class="text-center mb-6">
                                    <div class="text-3xl font-black text-primary mb-2">FREE</div>
                                    <p class="text-sm text-[#61897c] dark:text-gray-400">Open to all students</p>
                                </div>
                                
                                <!-- Registration Benefits Preview -->
                                <div class="bg-primary/5 dark:bg-primary/10 rounded-xl p-4 mb-6">
                                    <h4 class="font-semibold text-[#111816] dark:text-white mb-3 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary !text-lg">volunteer_activism</span>
                                        What You'll Get
                                    </h4>
                                    <ul class="text-sm text-[#61897c] dark:text-gray-400 space-y-2">
                                        <li class="flex items-center gap-2">
                                            <span class="w-2 h-2 bg-primary rounded-full"></span>
                                            Exclusive campaign materials & resources
                                        </li>
                                        <li class="flex items-center gap-2">
                                            <span class="w-2 h-2 bg-primary rounded-full"></span>
                                            Direct updates on activities & events
                                        </li>
                                        <li class="flex items-center gap-2">
                                            <span class="w-2 h-2 bg-primary rounded-full"></span>
                                            Connect with like-minded students
                                        </li>
                                        <li class="flex items-center gap-2">
                                            <span class="w-2 h-2 bg-primary rounded-full"></span>
                                            Certificate of participation
                                        </li>
                                    </ul>
                                </div>
                                
                                <form method="POST" action="{{ route('campaigns.register', $campaign) }}">
                                    @csrf
                                    <button type="submit" class="w-full bg-gradient-to-r from-primary to-green-500 text-white py-4 rounded-xl font-bold hover:from-primary/90 hover:to-green-500/90 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                        <span class="flex items-center justify-center gap-2">
                                            <span class="material-symbols-outlined !text-xl">volunteer_activism</span>
                                            Register for Campaign
                                        </span>
                                    </button>
                                </form>
                                
                                <p class="text-xs text-[#61897c] dark:text-gray-400 text-center mt-3">
                                    By registering, you agree to participate actively and receive campaign communications.
                                </p>
                            @endif
                        @elseif($campaign->status === 'upcoming')
                            <!-- Upcoming Campaign -->
                            <div class="text-center py-6">
                                <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 !text-2xl">schedule</span>
                                </div>
                                <p class="font-semibold text-[#111816] dark:text-white mb-2">Coming Soon</p>
                                <p class="text-sm text-[#61897c] dark:text-gray-400 mb-4">
                                    Campaign starts {{ $campaign->start_date ? $campaign->start_date->format('M d, Y') : 'soon' }}
                                    @if($campaign->start_time)
                                        at {{ \Carbon\Carbon::parse($campaign->start_time)->format('g:i A') }}
                                    @endif
                                </p>
                                
                                <!-- Pre-registration if available -->
                                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-4 mb-4">
                                    <p class="text-sm text-blue-800 dark:text-blue-300 mb-3">
                                        Get notified when registration opens!
                                    </p>
                                    <button class="w-full bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition-colors">
                                        <span class="flex items-center justify-center gap-2">
                                            <span class="material-symbols-outlined !text-lg">notifications</span>
                                            Notify Me
                                        </span>
                                    </button>
                                </div>
                            </div>
                        @else
                            <!-- Campaign Ended -->
                            <div class="text-center py-6">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <span class="material-symbols-outlined text-gray-400 !text-2xl">check_circle</span>
                                </div>
                                <p class="font-semibold text-[#111816] dark:text-white mb-2">Campaign Ended</p>
                                <p class="text-sm text-[#61897c] dark:text-gray-400 mb-4">
                                    This campaign concluded on {{ $campaign->end_date ? $campaign->end_date->format('M d, Y') : 'recently' }}
                                </p>
                                <a href="{{ route('campaigns.index') }}" class="inline-flex items-center gap-2 text-primary hover:text-primary/80 font-semibold">
                                    <span class="material-symbols-outlined !text-lg">campaign</span>
                                    View Active Campaigns
                                </a>
                            </div>
                        @endif
                    @else
                        <!-- Guest Registration Form -->
                        <div class="text-center mb-6">
                            <div class="w-16 h-16 bg-primary/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="material-symbols-outlined text-primary !text-2xl">person_add</span>
                            </div>
                            <div class="text-3xl font-black text-primary mb-2">FREE</div>
                            <p class="text-sm text-[#61897c] dark:text-gray-400 mb-4">Register with your details below</p>
                        </div>

                        <!-- Registration Form -->
                        <form method="POST" action="{{ route('campaigns.register', $campaign) }}" class="space-y-4">
                            @csrf
                            
                            <!-- Personal Information -->
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-[#111816] dark:text-white mb-2">Full Name *</label>
                                    <input type="text" name="guest_name" value="{{ old('guest_name') }}" required
                                           class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-[#111816] dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200"
                                           placeholder="Enter your full name">
                                    @error('guest_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-[#111816] dark:text-white mb-2">Email Address *</label>
                                    <input type="email" name="guest_email" value="{{ old('guest_email') }}" required
                                           class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-[#111816] dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200"
                                           placeholder="your.email@example.com">
                                    @error('guest_email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-[#111816] dark:text-white mb-2">Phone Number *</label>
                                    <input type="tel" name="guest_phone" value="{{ old('guest_phone') }}" required
                                           class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-[#111816] dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200"
                                           placeholder="+256 700 000 000">
                                    @error('guest_phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>



                            <!-- Motivation -->
                            <div>
                                <label class="block text-sm font-medium text-[#111816] dark:text-white mb-2">Why do you want to join this campaign? (Optional)</label>
                                <textarea name="motivation" rows="3"
                                          class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-[#111816] dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all duration-200 resize-none"
                                          placeholder="Share your motivation for joining this campaign...">{{ old('motivation') }}</textarea>
                                @error('motivation')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="w-full bg-gradient-to-r from-primary to-green-500 text-white py-4 rounded-xl font-bold hover:from-primary/90 hover:to-green-500/90 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                <span class="flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined !text-xl">volunteer_activism</span>
                                    Register for Campaign
                                </span>
                            </button>
                        </form>

                        <!-- Alternative Login Option -->
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <p class="text-center text-sm text-[#61897c] dark:text-gray-400 mb-4">
                                Already have an account?
                            </p>
                            <div class="flex gap-3">
                                <button onclick="openLoginModal()" class="flex-1 bg-white dark:bg-gray-800 border border-primary text-primary py-3 rounded-xl font-semibold hover:bg-primary/5 dark:hover:bg-primary/10 transition-all duration-200">
                                    <span class="flex items-center justify-center gap-2">
                                        <span class="material-symbols-outlined !text-lg">login</span>
                                        Login
                                    </span>
                                </button>
                                <button onclick="openSignupModal()" class="flex-1 bg-gray-100 dark:bg-gray-700 text-[#61897c] dark:text-gray-300 py-3 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200">
                                    <span class="flex items-center justify-center gap-2">
                                        <span class="material-symbols-outlined !text-lg">person_add</span>
                                        Sign Up
                                    </span>
                                </button>
                            </div>
                        </div>
                    @endauth
                    
                    <!-- Participation Stats -->
                    <div class="mt-6 pt-6 border-t border-[#f0f4f3] dark:border-gray-700">
                        <div class="flex items-center justify-between text-sm text-[#61897c] dark:text-gray-400 mb-2">
                            <span>{{ $campaign->participants ? $campaign->participants()->count() : 0 }} participants</span>
                            <span>{{ $campaign->participants ? min(100, ($campaign->participants()->count() / 200) * 100) : 0 }}% capacity</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-primary h-2 rounded-full transition-all duration-500" 
                                 style="width: {{ $campaign->participants ? min(100, ($campaign->participants()->count() / 200) * 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Campaign Organizer -->
                <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-6 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
                    <h3 class="text-lg font-bold text-[#111816] dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">person</span>
                        Campaign Organizer
                    </h3>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-primary/20 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary">person</span>
                        </div>
                        <div>
                            <div class="font-semibold text-[#111816] dark:text-white">
                                {{ $campaign->creator ? $campaign->creator->name : 'WellPath Team' }}
                            </div>
                            <div class="text-sm text-[#61897c] dark:text-gray-400">Campaign Coordinator</div>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-[#f0f4f3] dark:border-gray-700">
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center gap-2 text-[#61897c] dark:text-gray-400">
                                <span class="material-symbols-outlined !text-lg">email</span>
                                <span>wellness@wellpath.edu</span>
                            </div>
                            <div class="flex items-center gap-2 text-[#61897c] dark:text-gray-400">
                                <span class="material-symbols-outlined !text-lg">phone</span>
                                <span>+256 123 456 789</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Share Campaign -->
                <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-6 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
                    <h3 class="text-lg font-bold text-[#111816] dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">share</span>
                        Share Campaign
                    </h3>
                    <div class="space-y-3">
                        <button onclick="shareToTwitter()" class="flex items-center gap-3 w-full p-3 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-colors text-sm font-medium">
                            <span class="material-symbols-outlined !text-lg">share</span>
                            Share on Twitter
                        </button>
                        <button onclick="shareToFacebook()" class="flex items-center gap-3 w-full p-3 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-colors text-sm font-medium">
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

<!-- Call to Action Section -->
@if($campaign->status === 'active')
<div class="py-20 bg-gradient-to-r from-primary/10 via-background-light to-green-500/10 dark:from-primary/20 dark:via-background-dark dark:to-green-500/20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        @auth
            @if(!$isRegistered)
                <h2 class="text-3xl md:text-4xl font-black text-[#111816] dark:text-white mb-6">
                    Ready to Make a Difference?
                </h2>
                <p class="text-xl text-[#61897c] dark:text-gray-400 mb-8 max-w-2xl mx-auto">
                    Join {{ $campaign->participants ? $campaign->participants()->count() : 0 }} other students in this important wellness initiative and help create positive change on campus.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <form method="POST" action="{{ route('campaigns.register', $campaign) }}" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 bg-primary text-white px-8 py-4 rounded-xl font-bold hover:bg-primary/90 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <span class="material-symbols-outlined !text-xl">volunteer_activism</span>
                            Register for Campaign
                        </button>
                    </form>
                    <a href="{{ route('campaigns.index') }}" class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-[#f0f4f3] dark:border-gray-700 text-[#111816] dark:text-white px-8 py-4 rounded-xl font-bold hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 transform hover:scale-105">
                        <span class="material-symbols-outlined !text-xl">campaign</span>
                        View All Campaigns
                    </a>
                </div>
            @else
                <h2 class="text-3xl md:text-4xl font-black text-[#111816] dark:text-white mb-6">
                    You're Part of Something Great!
                </h2>
                <p class="text-xl text-[#61897c] dark:text-gray-400 mb-8 max-w-2xl mx-auto">
                    Thank you for joining this campaign! Stay engaged and check your student dashboard for updates, activities, and ways to contribute.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('student.campaigns.index') }}" class="inline-flex items-center gap-2 bg-primary text-white px-8 py-4 rounded-xl font-bold hover:bg-primary/90 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="material-symbols-outlined !text-xl">dashboard</span>
                        My Campaign Dashboard
                    </a>
                    <a href="{{ route('campaigns.index') }}" class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-[#f0f4f3] dark:border-gray-700 text-[#111816] dark:text-white px-8 py-4 rounded-xl font-bold hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 transform hover:scale-105">
                        <span class="material-symbols-outlined !text-xl">campaign</span>
                        Explore More Campaigns
                    </a>
                </div>
            @endif
        @else
            <h2 class="text-3xl md:text-4xl font-black text-[#111816] dark:text-white mb-6">
                Join the Movement
            </h2>
            <p class="text-xl text-[#61897c] dark:text-gray-400 mb-8 max-w-2xl mx-auto">
                Register using the form above or create an account to join {{ $campaign->participants ? $campaign->participants()->count() : 0 }} other students working towards positive change on campus.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="document.getElementById('registration-form').scrollIntoView({behavior: 'smooth'})" class="inline-flex items-center gap-2 bg-primary text-white px-8 py-4 rounded-xl font-bold hover:bg-primary/90 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <span class="material-symbols-outlined !text-xl">edit</span>
                    Fill Registration Form
                </button>
                <button onclick="openSignupModal()" class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-[#f0f4f3] dark:border-gray-700 text-[#111816] dark:text-white px-8 py-4 rounded-xl font-bold hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 transform hover:scale-105">
                    <span class="material-symbols-outlined !text-xl">person_add</span>
                    Create Account Instead
                </button>
            </div>
        @endauth
    </div>
</div>
@endif

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
        'info': 'bg-blue-500',
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