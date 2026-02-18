@extends('layouts.public')

@section('title', 'Counseling Services - WellPath')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden min-h-screen flex items-center">
    <!-- Background Image -->
    <div class="absolute inset-0 overflow-hidden">
        <img src="{{ asset('images/counselling-hero.avif') }}" 
             alt="Counseling session and mental health support" 
             class="w-full h-full object-cover animate-hero-zoom">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>
    
    <!-- Content -->
    <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
        <div class="text-center">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-3 sm:px-4 py-2 rounded-full text-sm font-semibold mb-4 sm:mb-6">
                <span class="material-symbols-outlined !text-base sm:!text-lg">psychology</span>
                Counseling Services
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-6xl font-black text-white tracking-tight mb-4 sm:mb-6 leading-tight">Your Mental Health Matters</h1>
            <p class="text-lg sm:text-xl lg:text-2xl text-white/90 max-w-4xl mx-auto leading-relaxed mb-6 sm:mb-8 px-4">Connect with professional counselors who provide confidential, compassionate support for your mental health and wellbeing journey.</p>
            <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center px-4">
                <button onclick="scrollToCounselingServices()" class="inline-flex items-center justify-center gap-2 px-6 sm:px-8 py-3 sm:py-4 bg-white text-primary rounded-xl font-bold text-base sm:text-lg hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <span class="material-symbols-outlined !text-lg sm:!text-xl">psychology</span>
                    View Services
                </button>
                <button onclick="scrollToMeetCounselors()" class="inline-flex items-center justify-center gap-2 px-6 sm:px-8 py-3 sm:py-4 bg-white/10 backdrop-blur-sm text-white border-2 border-white rounded-xl font-bold text-base sm:text-lg hover:bg-white/20 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <span class="material-symbols-outlined !text-lg sm:!text-xl">group</span>
                    View Counselors
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<div class="bg-white dark:bg-gray-800/50 border-b border-[#f0f4f3] dark:border-gray-800 py-6 sm:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row gap-6 sm:gap-8 justify-center items-center">
            <div class="flex items-center gap-3 text-[#61897c] dark:text-gray-400 min-h-[60px]">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-primary !text-lg sm:!text-xl">group</span>
                </div>
                <div class="text-center sm:text-left flex flex-col justify-center">
                    <div class="text-xl sm:text-2xl font-bold text-[#111816] dark:text-white leading-tight">{{ $counselors->count() }}</div>
                    <div class="text-sm font-medium leading-tight">Counselors</div>
                </div>
            </div>
            <div class="hidden sm:block w-1 h-12 bg-[#61897c]/20 dark:bg-gray-600"></div>
            <div class="flex items-center gap-3 text-[#61897c] dark:text-gray-400 min-h-[60px]">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-primary !text-lg sm:!text-xl">security</span>
                </div>
                <div class="text-center sm:text-left flex flex-col justify-center">
                    <div class="text-xl sm:text-2xl font-bold text-[#111816] dark:text-white leading-tight">100%</div>
                    <div class="text-sm font-medium leading-tight">Confidential</div>
                </div>
            </div>
            <div class="hidden sm:block w-1 h-12 bg-[#61897c]/20 dark:bg-gray-600"></div>
            <div class="flex items-center gap-3 text-[#61897c] dark:text-gray-400 min-h-[60px]">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-primary/20 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-primary !text-lg sm:!text-xl">schedule</span>
                </div>
                <div class="text-center sm:text-left flex flex-col justify-center">
                    <div class="text-xl sm:text-2xl font-bold text-[#111816] dark:text-white leading-tight">24/7</div>
                    <div class="text-sm font-medium leading-tight">Crisis Support</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Section -->
<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    <div class="flex flex-col flex-1 gap-8 sm:gap-10">

                <!-- Services Overview -->
                <div id="counseling-services" class="text-center mb-8 sm:mb-12">
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-3 sm:mb-4 flex flex-col sm:flex-row items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-emerald-600 !text-3xl sm:!text-4xl">psychology</span>
                        Our Counseling Services
                    </h2>
                    <p class="text-base sm:text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto px-4">
                        Professional support tailored to your needs
                    </p>
                </div>

                <!-- Carousel Container -->
                <div class="relative max-w-full mx-auto px-4 sm:px-0">
                    <!-- Navigation Buttons -->
                    <button id="services-prev" class="flex absolute -left-2 sm:-left-6 top-1/2 -translate-y-1/2 z-10 w-10 h-10 sm:w-12 sm:h-12 bg-white dark:bg-gray-800 rounded-full shadow-lg border border-gray-200 dark:border-gray-700 items-center justify-center text-gray-600 dark:text-gray-400 hover:text-primary hover:border-primary transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        <span class="material-symbols-outlined text-lg sm:text-xl">chevron_left</span>
                    </button>
                    <button id="services-next" class="flex absolute -right-2 sm:-right-6 top-1/2 -translate-y-1/2 z-10 w-10 h-10 sm:w-12 sm:h-12 bg-white dark:bg-gray-800 rounded-full shadow-lg border border-gray-200 dark:border-gray-700 items-center justify-center text-gray-600 dark:text-gray-400 hover:text-primary hover:border-primary transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                        <span class="material-symbols-outlined text-lg sm:text-xl">chevron_right</span>
                    </button>

                    <!-- Carousel Track -->
                    <div class="overflow-hidden">
                        <div id="services-track" class="flex transition-transform duration-300 ease-in-out gap-4 sm:gap-6">
                            <!-- Service Items -->
                            <div class="flex-none w-72 sm:w-80 group rounded-xl bg-gradient-to-br from-green-50 to-indigo-50 dark:from-green-900/10 dark:to-indigo-900/10 border border-green-100 dark:border-green-900/30 hover:shadow-lg hover:shadow-green-500/10 transition-all cursor-pointer overflow-hidden">
                                <div class="relative h-28 sm:h-32 overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=400&h=200&fit=crop" alt="Individual Counseling" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-blue-900/60 to-transparent"></div>
                                    <div class="absolute bottom-2 sm:bottom-3 left-2 sm:left-3">
                                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg">
                                            <span class="material-symbols-outlined text-green-600 text-base sm:text-lg">person</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3 sm:p-4">
                                    <h3 class="font-bold text-gray-900 dark:text-white mb-1 text-sm sm:text-base">Individual Counseling</h3>
                                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">One-on-one sessions for personal challenges.</p>
                                </div>
                            </div>

                            <div class="flex-none w-72 sm:w-80 group rounded-xl bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/10 dark:to-teal-900/10 border border-emerald-100 dark:border-emerald-900/30 hover:shadow-lg hover:shadow-emerald-500/10 transition-all cursor-pointer overflow-hidden">
                                <div class="relative h-28 sm:h-32 overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=400&h=200&fit=crop" alt="Group Therapy" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-emerald-900/60 to-transparent"></div>
                                    <div class="absolute bottom-2 sm:bottom-3 left-2 sm:left-3">
                                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg">
                                            <span class="material-symbols-outlined text-emerald-600 text-base sm:text-lg">groups</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3 sm:p-4">
                                    <h3 class="font-bold text-gray-900 dark:text-white mb-1 text-sm sm:text-base">Group Therapy</h3>
                                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Supportive sessions with peers.</p>
                                </div>
                            </div>

                            <div class="flex-none w-72 sm:w-80 group rounded-xl bg-gradient-to-br from-red-50 to-pink-50 dark:from-red-900/10 dark:to-pink-900/10 border border-red-100 dark:border-red-900/30 hover:shadow-lg hover:shadow-red-500/10 transition-all cursor-pointer overflow-hidden">
                                <div class="relative h-28 sm:h-32 overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1584515933487-779824d29309?w=400&h=200&fit=crop" alt="Crisis Intervention" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-red-900/60 to-transparent"></div>
                                    <div class="absolute bottom-2 sm:bottom-3 left-2 sm:left-3">
                                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg">
                                            <span class="material-symbols-outlined text-red-600 text-base sm:text-lg">emergency</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3 sm:p-4">
                                    <h3 class="font-bold text-gray-900 dark:text-white mb-1 text-sm sm:text-base">Crisis Intervention</h3>
                                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">24/7 immediate emergency support.</p>
                                </div>
                            </div>

                            <div class="flex-none w-72 sm:w-80 group rounded-xl bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-purple-900/10 dark:to-indigo-900/10 border border-purple-100 dark:border-purple-900/30 hover:shadow-lg hover:shadow-purple-500/10 transition-all cursor-pointer overflow-hidden">
                                <div class="relative h-28 sm:h-32 overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=400&h=200&fit=crop" alt="Academic Counseling" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-purple-900/60 to-transparent"></div>
                                    <div class="absolute bottom-2 sm:bottom-3 left-2 sm:left-3">
                                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg">
                                            <span class="material-symbols-outlined text-purple-600 text-base sm:text-lg">school</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3 sm:p-4">
                                    <h3 class="font-bold text-gray-900 dark:text-white mb-1 text-sm sm:text-base">Academic Counseling</h3>
                                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Support for academic stress.</p>
                                </div>
                            </div>

                            <div class="flex-none w-72 sm:w-80 group rounded-xl bg-gradient-to-br from-orange-50 to-red-50 dark:from-orange-900/10 dark:to-red-900/10 border border-orange-100 dark:border-orange-900/30 hover:shadow-lg hover:shadow-orange-500/10 transition-all cursor-pointer overflow-hidden">
                                <div class="relative h-28 sm:h-32 overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=400&h=200&fit=crop" alt="Wellness Workshops" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-orange-900/60 to-transparent"></div>
                                    <div class="absolute bottom-2 sm:bottom-3 left-2 sm:left-3">
                                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg">
                                            <span class="material-symbols-outlined text-orange-600 text-base sm:text-lg">self_improvement</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3 sm:p-4">
                                    <h3 class="font-bold text-gray-900 dark:text-white mb-1 text-sm sm:text-base">Wellness Workshops</h3>
                                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Educational mental health seminars.</p>
                                </div>
                            </div>

                            <div class="flex-none w-72 sm:w-80 group rounded-xl bg-gradient-to-br from-teal-50 to-cyan-50 dark:from-teal-900/10 dark:to-cyan-900/10 border border-teal-100 dark:border-teal-900/30 hover:shadow-lg hover:shadow-teal-500/10 transition-all cursor-pointer overflow-hidden">
                                <div class="relative h-28 sm:h-32 overflow-hidden">
                                    <img src="https://images.unsplash.com/photo-1511632765486-a01980e01a18?w=400&h=200&fit=crop" alt="Peer Support" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-teal-900/60 to-transparent"></div>
                                    <div class="absolute bottom-2 sm:bottom-3 left-2 sm:left-3">
                                        <div class="w-8 h-8 sm:w-10 sm:h-10 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg">
                                            <span class="material-symbols-outlined text-teal-600 text-base sm:text-lg">diversity_3</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3 sm:p-4">
                                    <h3 class="font-bold text-gray-900 dark:text-white mb-1 text-sm sm:text-base">Peer Support</h3>
                                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Student-led support groups.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dots Indicator -->
                    <div id="services-dots" class="flex justify-center mt-8 gap-2">
                        <!-- Dots will be generated by JavaScript -->
                    </div>
                </div>

        <!-- Meet Our Counselors Section -->
        <div id="meet-counselors" class="text-center mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-3 sm:mb-4 flex flex-col sm:flex-row items-center justify-center gap-2">
                <span class="material-symbols-outlined text-purple-600 !text-3xl sm:!text-4xl">group</span>
                Meet Our Counselors
            </h2>
            <p class="text-base sm:text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto px-4">
                {{ $counselors->count() }} Professional counselors ready to support you
            </p>
        </div>

        <!-- Carousel Container -->
        <div class="relative max-w-full mx-auto px-4 sm:px-0">
            <!-- Navigation Buttons -->
            <button id="counselors-prev" class="flex absolute -left-2 sm:-left-6 top-1/2 -translate-y-1/2 z-10 w-10 h-10 sm:w-12 sm:h-12 bg-white dark:bg-gray-800 rounded-full shadow-lg border border-gray-200 dark:border-gray-700 items-center justify-center text-gray-600 dark:text-gray-400 hover:text-purple-600 hover:border-purple-600 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                <span class="material-symbols-outlined text-lg sm:text-xl">chevron_left</span>
            </button>
            <button id="counselors-next" class="flex absolute -right-2 sm:-right-6 top-1/2 -translate-y-1/2 z-10 w-10 h-10 sm:w-12 sm:h-12 bg-white dark:bg-gray-800 rounded-full shadow-lg border border-gray-200 dark:border-gray-700 items-center justify-center text-gray-600 dark:text-gray-400 hover:text-purple-600 hover:border-purple-600 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                <span class="material-symbols-outlined text-lg sm:text-xl">chevron_right</span>
            </button>

            <!-- Carousel Track -->
            <div class="overflow-hidden">
                <div id="counselors-track" class="flex transition-transform duration-300 ease-in-out gap-4 sm:gap-6">
                    @php
                        $gradients = [
                            ['bg' => 'from-green-500 to-indigo-600', 'light' => 'from-green-50 to-indigo-50', 'dark' => 'dark:from-green-900/20 dark:to-indigo-900/20'],
                            ['bg' => 'from-emerald-500 to-teal-600', 'light' => 'from-emerald-50 to-teal-50', 'dark' => 'dark:from-emerald-900/20 dark:to-teal-900/20'],
                            ['bg' => 'from-purple-500 to-pink-600', 'light' => 'from-purple-50 to-pink-50', 'dark' => 'dark:from-purple-900/20 dark:to-pink-900/20'],
                        ];
                    @endphp
                    
                @forelse($counselors as $index => $counselor)
                    @php
                        $gradient = $gradients[$index % count($gradients)];
                        $initials = strtoupper(substr($counselor->name, 0, 2));
                    @endphp
                    <div class="flex-none w-72 sm:w-80 group rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:shadow-lg hover:shadow-purple-500/10 transition-all overflow-hidden">
                        <!-- Image Section -->
                        <div class="relative h-40 sm:h-48 overflow-hidden">
                            @if($counselor->avatar)
                                <img src="{{ asset('storage/' . $counselor->avatar) }}" alt="{{ $counselor->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-gradient-to-br {{ $gradient['bg'] }} flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                                    <span class="text-4xl sm:text-6xl font-bold text-white">{{ $initials }}</span>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                            
                            <!-- Available Badge -->
                            <div class="absolute top-3 sm:top-4 right-3 sm:right-4">
                                <div class="flex items-center gap-1 sm:gap-1.5 bg-green-500/90 backdrop-blur-sm px-2 sm:px-3 py-1 sm:py-1.5 rounded-full">
                                    <span class="h-1.5 w-1.5 sm:h-2 sm:w-2 rounded-full bg-white animate-pulse"></span>
                                    <span class="text-xs font-semibold text-white">Available</span>
                                </div>
                            </div>
                            
                            <!-- Name Overlay -->
                            <div class="absolute bottom-3 sm:bottom-4 left-3 sm:left-4 right-3 sm:right-4">
                                <h3 class="text-lg sm:text-xl font-bold text-white mb-1">{{ $counselor->name }}</h3>
                                <p class="text-white/90 text-xs sm:text-sm font-medium">Professional Counselor</p>
                            </div>
                        </div>
                        
                        <!-- Content Section -->
                        <div class="p-4 sm:p-6">
                            <div class="space-y-2 sm:space-y-3 mb-3 sm:mb-4">
                                @if($counselor->email)
                                <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                                    <span class="material-symbols-outlined !text-sm sm:!text-base text-primary">email</span>
                                    <span class="truncate">{{ $counselor->email }}</span>
                                </div>
                                @endif
                                
                                @if($counselor->phone)
                                <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                                    <span class="material-symbols-outlined !text-sm sm:!text-base text-primary">phone</span>
                                    <span>{{ $counselor->phone }}</span>
                                </div>
                                @endif
                                
                                <div class="flex items-center gap-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                                    <span class="material-symbols-outlined !text-sm sm:!text-base text-primary">calendar_today</span>
                                    <span>Member since {{ $counselor->created_at->format('M Y') }}</span>
                                </div>
                            </div>
                            
                            <!-- Action Button -->
                            @auth
                                <a href="{{ route('public.counseling.sessions') }}" class="flex items-center justify-center gap-2 text-primary font-semibold text-xs sm:text-sm group-hover:gap-3 transition-all">
                                    <span>Request Session</span>
                                    <span class="material-symbols-outlined text-base sm:text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </a>
                            @else
                            <button onclick="document.getElementById('loginModal').classList.remove('hidden')" class="flex items-center justify-center gap-2 text-primary font-semibold text-xs sm:text-sm group-hover:gap-3 transition-all w-full">
                                <span>Login to Book</span>
                                <span class="material-symbols-outlined text-base sm:text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </button>
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="flex-none w-72 sm:w-80 text-center py-8 sm:py-12">
                        <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-2xl sm:text-3xl text-gray-400">person_search</span>
                        </div>
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">No counselors available</p>
                    </div>
                @endforelse
                </div>
            </div>

            <!-- Dots Indicator -->
            <div id="counselors-dots" class="flex justify-center mt-6 sm:mt-8 gap-2">
                <!-- Dots will be generated by JavaScript -->
            </div>
        </div>

        <!-- View All Counselors Button -->
        @if($counselors->isNotEmpty())
        <div class="mt-8 sm:mt-10 text-center">
            <a href="{{ route('public.counseling.counselors') }}" class="inline-flex items-center justify-center gap-2 px-6 sm:px-8 py-3 sm:py-4 bg-primary text-white rounded-xl font-bold text-base sm:text-lg hover:bg-primary/90 transition-all duration-200 transform hover:scale-105 shadow-lg">
                <span class="material-symbols-outlined !text-lg sm:!text-xl">group</span>
                View All Counselors
            </a>
        </div>
        @endif

    </div>
</div>

@include('components.login-modal')
@include('components.forgot-password-modal')
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
// Smooth scroll to counseling services section
function scrollToCounselingServices() {
    const servicesSection = document.getElementById('counseling-services');
    if (servicesSection) {
        // Get the header height to offset the scroll position
        const header = document.querySelector('header');
        const headerHeight = header ? header.offsetHeight : 80; // fallback to 80px if header not found
        
        // Calculate the position to scroll to
        const elementPosition = servicesSection.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - headerHeight - 20; // 20px extra padding
        
        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
        });
    }
}

// Smooth scroll to meet counselors section
function scrollToMeetCounselors() {
    const counselorsSection = document.getElementById('meet-counselors');
    if (counselorsSection) {
        // Get the header height to offset the scroll position
        const header = document.querySelector('header');
        const headerHeight = header ? header.offsetHeight : 80; // fallback to 80px if header not found
        
        // Calculate the position to scroll to
        const elementPosition = counselorsSection.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - headerHeight - 20; // 20px extra padding
        
        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
        });
    }
}

// Counselors Carousel
const counselorsTrack = document.getElementById('counselors-track');
const counselorsPrev = document.getElementById('counselors-prev');
const counselorsNext = document.getElementById('counselors-next');
const counselorsDotsContainer = document.getElementById('counselors-dots');
let currentCounselorIndex = 0;

function getCounselorCardsPerView() {
    // Determine how many cards are visible at once based on screen size
    const width = window.innerWidth;
    if (width >= 1024) return 3; // lg screens
    if (width >= 640) return 2;  // sm screens
    return 1; // mobile
}

function getCounselorCardWidth() {
    if (!counselorsTrack || counselorsTrack.children.length === 0) return 0;
    const cardWidth = counselorsTrack.children[0].offsetWidth;
    const gap = window.innerWidth >= 640 ? 24 : 16; // sm:gap-6 vs gap-4
    return cardWidth + gap;
}

function updateCounselorsCarousel() {
    if (!counselorsTrack || counselorsTrack.children.length === 0) return;
    
    const slideWidth = getCounselorCardWidth();
    const translateX = -(currentCounselorIndex * slideWidth);
    counselorsTrack.style.transform = `translateX(${translateX}px)`;
    
    // Always show both arrows (infinite loop)
    if (counselorsPrev) {
        counselorsPrev.style.display = 'flex';
    }
    
    if (counselorsNext) {
        counselorsNext.style.display = 'flex';
    }
    
    // Update dots
    updateCounselorsDots();
}

function updateCounselorsDots() {
    if (!counselorsDotsContainer || !counselorsTrack) return;
    
    const totalCards = counselorsTrack.children.length;
    const cardsPerView = getCounselorCardsPerView();
    const maxIndex = Math.max(0, totalCards - cardsPerView);
    
    counselorsDotsContainer.innerHTML = '';
    for (let i = 0; i <= maxIndex; i++) {
        const dot = document.createElement('button');
        dot.className = `w-2 h-2 rounded-full transition-all ${i === currentCounselorIndex ? 'bg-purple-600 w-8' : 'bg-gray-300 dark:bg-gray-600'}`;
        dot.onclick = () => {
            currentCounselorIndex = i;
            updateCounselorsCarousel();
        };
        counselorsDotsContainer.appendChild(dot);
    }
}

if (counselorsPrev) {
    counselorsPrev.addEventListener('click', () => {
        if (!counselorsTrack) return;
        
        const totalCards = counselorsTrack.children.length;
        const cardsPerView = getCounselorCardsPerView();
        const maxIndex = Math.max(0, totalCards - cardsPerView);
        
        if (currentCounselorIndex > 0) {
            currentCounselorIndex--;
        } else {
            // Loop to last position
            currentCounselorIndex = maxIndex;
        }
        updateCounselorsCarousel();
    });
}

if (counselorsNext) {
    counselorsNext.addEventListener('click', () => {
        if (!counselorsTrack) return;
        
        const totalCards = counselorsTrack.children.length;
        const cardsPerView = getCounselorCardsPerView();
        const maxIndex = Math.max(0, totalCards - cardsPerView);
        
        if (currentCounselorIndex < maxIndex) {
            currentCounselorIndex++;
        } else {
            // Loop back to first position
            currentCounselorIndex = 0;
        }
        updateCounselorsCarousel();
    });
}

document.addEventListener('DOMContentLoaded', function() {
    updateCounselorsCarousel();
    // Wait a bit for images to load
    setTimeout(initServicesCarousel, 100);
});

function initServicesCarousel() {
    // Services Carousel
    const carousel = document.getElementById('services-track');
    const prevBtn = document.getElementById('services-prev');
    const nextBtn = document.getElementById('services-next');
    const dotsContainer = document.getElementById('services-dots');
    
    if (!carousel || !prevBtn || !nextBtn) {
        console.error('Carousel elements not found');
        return;
    }
    
    console.log('Carousel initialized with', carousel.children.length, 'cards');
    
    const cards = carousel.children;
    const totalCards = cards.length;
    const cardsPerView = 3; // Show 3 cards at a time
    const maxIndex = Math.max(0, totalCards - cardsPerView);
    
    let currentIndex = 0;
    let isUserInteracting = false;
    let autoSlideTimer = null;
    
    // Calculate slide width dynamically
    function getSlideWidth() {
        if (cards.length === 0) return 0;
        const cardWidth = cards[0].offsetWidth;
        const gap = window.innerWidth >= 640 ? 24 : 16; // sm:gap-6 vs gap-4
        return cardWidth + gap;
    }
    
    // Create dots
    function createDots() {
        if (!dotsContainer) return;
        dotsContainer.innerHTML = '';
        for (let i = 0; i <= maxIndex; i++) {
            const dot = document.createElement('button');
            dot.className = 'w-2 h-2 rounded-full bg-gray-400 dark:bg-gray-600 transition-all duration-300';
            if (i === 0) {
                dot.classList.add('!bg-primary', 'w-8');
            }
            dot.addEventListener('click', () => {
                isUserInteracting = true;
                goToSlide(i);
                resetAutoSlide();
            });
            dotsContainer.appendChild(dot);
        }
    }
    
    function updateCarousel() {
        const slideWidth = getSlideWidth(); // Calculate dynamically
        const offset = -(currentIndex * slideWidth);
        carousel.style.transform = `translateX(${offset}px)`;
        
        // Always show both arrows (infinite loop)
        prevBtn.style.display = 'flex';
        nextBtn.style.display = 'flex';
        
        // Update dots
        if (dotsContainer) {
            const dots = dotsContainer.children;
            for (let i = 0; i < dots.length; i++) {
                if (i === currentIndex) {
                    dots[i].classList.add('!bg-primary', 'w-8');
                    dots[i].classList.remove('bg-gray-400', 'dark:bg-gray-600');
                } else {
                    dots[i].classList.remove('!bg-primary', 'w-8');
                    dots[i].classList.add('bg-gray-400', 'dark:bg-gray-600');
                }
            }
        }
    }
    
    function goToSlide(index) {
        currentIndex = Math.max(0, Math.min(index, maxIndex));
        updateCarousel();
    }
    
    function nextSlide() {
        if (currentIndex < maxIndex) {
            currentIndex++;
        } else {
            // Loop back to first slide
            currentIndex = 0;
        }
        updateCarousel();
    }
    
    function prevSlide() {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            // Loop to last slide
            currentIndex = maxIndex;
        }
        updateCarousel();
    }
    
    // Auto-slide functionality
    function startAutoSlide() {
        autoSlideTimer = setInterval(() => {
            if (!isUserInteracting && currentIndex < maxIndex) {
                nextSlide();
            } else if (currentIndex >= maxIndex) {
                stopAutoSlide(); // Stop when reaching the end
            }
        }, 5000); // 5 seconds
    }
    
    function stopAutoSlide() {
        if (autoSlideTimer) {
            clearInterval(autoSlideTimer);
            autoSlideTimer = null;
        }
    }
    
    function resetAutoSlide() {
        stopAutoSlide();
        setTimeout(() => {
            if (!isUserInteracting) {
                startAutoSlide();
            }
        }, 1000);
    }
    
    // Event listeners
    prevBtn.addEventListener('click', () => {
        isUserInteracting = true;
        prevSlide();
        resetAutoSlide();
    });
    
    nextBtn.addEventListener('click', () => {
        isUserInteracting = true;
        nextSlide();
        resetAutoSlide();
    });
    
    // Pause auto-slide on hover
    carousel.addEventListener('mouseenter', () => {
        isUserInteracting = true;
        stopAutoSlide();
    });
    
    carousel.addEventListener('mouseleave', () => {
        isUserInteracting = false;
        startAutoSlide();
    });
    
    // Touch/swipe support
    let touchStartX = 0;
    let touchEndX = 0;
    
    carousel.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
        isUserInteracting = true;
        stopAutoSlide();
    });
    
    carousel.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
        resetAutoSlide();
    });
    
    function handleSwipe() {
        const swipeThreshold = 50;
        if (touchStartX - touchEndX > swipeThreshold) {
            nextSlide();
        } else if (touchEndX - touchStartX > swipeThreshold) {
            prevSlide();
        }
    }
    
    // Initialize
    createDots();
    updateCarousel();
    startAutoSlide();
    
    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            updateCarousel();
            updateCounselorsCarousel();
        }, 250);
    });
}

// Intersection Observer for fade-in animations
window.addEventListener('load', function() {
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
    
    // Observe counselor cards for fade-in animation (not service carousel cards)
    document.querySelectorAll('.group.bg-white').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});
</script>
@endpush
