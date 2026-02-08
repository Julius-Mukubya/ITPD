@extends('layouts.public')

@section('title', 'Mental Health Assessments - WellPath Hub')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden min-h-screen flex items-center">
    <!-- Background Image -->
    <div class="absolute inset-0 bg-gray-600">
        <img src="{{ asset('images/assessments-hero.avif') }}" 
             alt="Mental health assessment and self-reflection" 
             class="w-full h-full object-cover"
             loading="eager">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>
    
    <!-- Content -->
    <div class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-20">
        <div class="text-center">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-3 sm:px-4 py-2 rounded-full text-sm font-semibold mb-4 sm:mb-6">
                <span class="material-symbols-outlined !text-base sm:!text-lg">quiz</span>
                Self-Assessment Tools
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-6xl font-black text-white tracking-tight mb-4 sm:mb-6 leading-tight">Self-Assessment Tools</h1>
            <p class="text-lg sm:text-xl lg:text-2xl text-white/90 max-w-4xl mx-auto leading-relaxed mb-6 sm:mb-8 px-4">Take confidential, evidence-based assessments to better understand your mental health and wellbeing. These tools are free and anonymous.</p>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center px-4">
                <a href="#assessments-filters" class="inline-flex items-center justify-center gap-2 bg-white/20 backdrop-blur-md border border-white/30 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-bold text-base sm:text-lg hover:bg-white/30 hover:border-white/50 transition-all duration-200 transform hover:scale-105 shadow-lg backdrop-saturate-150">
                    <span class="material-symbols-outlined !text-lg sm:!text-xl">quiz</span>
                    Browse Assessments
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    <div class="flex flex-col flex-1 gap-8 sm:gap-10">
        
        <!-- Info Banner -->
        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 border border-emerald-200 dark:border-emerald-800 rounded-2xl p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <span class="material-symbols-outlined text-primary text-2xl sm:text-3xl flex-shrink-0">info</span>
                <div class="flex-1">
                    <h3 class="font-bold text-emerald-900 dark:text-emerald-100 mb-2 text-sm sm:text-base">Important Information</h3>
                    <ul class="text-xs sm:text-sm text-emerald-800 dark:text-emerald-200 space-y-1">
                        <li>• These are screening tools, not diagnostic tests</li>
                        <li>• Your responses are completely confidential and anonymous</li>
                        <li>• Results are for educational purposes only</li>
                        <li>• If you need immediate help, call 988 for crisis support</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div id="assessments-filters" class="bg-white dark:bg-gray-800/50 rounded-2xl p-4 sm:p-6 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
            <!-- Filter Header with Toggle -->
            <div class="flex items-center justify-between mb-3 sm:mb-4">
                <span class="text-sm font-semibold text-[#111816] dark:text-gray-300 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">filter_list</span>
                    <span>Filter Assessments</span>
                </span>
                <button id="filter-toggle" class="sm:hidden flex items-center gap-1 text-xs font-medium text-gray-600 dark:text-gray-400 hover:text-primary transition-colors">
                    <span id="filter-toggle-text">Show Filters</span>
                    <span id="filter-toggle-icon" class="material-symbols-outlined !text-sm transition-transform duration-200">expand_more</span>
                </button>
            </div>
            
            <!-- Filter Buttons Container -->
            <div id="filter-buttons" class="hidden sm:block">
                <div class="flex flex-wrap gap-2 sm:gap-3">
                    <button data-filter="all" class="filter-btn flex h-9 sm:h-10 items-center justify-center gap-1.5 rounded-xl bg-primary text-white px-3 sm:px-4 text-xs sm:text-sm font-semibold shadow-md hover:shadow-lg transition-all duration-200">
                        <span class="material-symbols-outlined !text-sm sm:!text-base">select_all</span>
                        <span>All Assessments</span>
                    </button>
                    <button data-filter="substance" class="filter-btn flex h-9 sm:h-10 items-center justify-center gap-1.5 rounded-xl bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-[#111816] dark:text-gray-300 px-3 sm:px-4 text-xs sm:text-sm font-medium hover:border-primary transition-all duration-200">
                        <span class="material-symbols-outlined !text-sm sm:!text-base">local_pharmacy</span>
                        <span>Substance Use</span>
                    </button>
                    <button data-filter="mental-health" class="filter-btn flex h-9 sm:h-10 items-center justify-center gap-1.5 rounded-xl bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-[#111816] dark:text-gray-300 px-3 sm:px-4 text-xs sm:text-sm font-medium hover:border-primary transition-all duration-200">
                        <span class="material-symbols-outlined !text-sm sm:!text-base">psychology</span>
                        <span>Mental Health</span>
                    </button>
                    <button data-filter="stress" class="filter-btn flex h-9 sm:h-10 items-center justify-center gap-1.5 rounded-xl bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-[#111816] dark:text-gray-300 px-3 sm:px-4 text-xs sm:text-sm font-medium hover:border-primary transition-all duration-200">
                        <span class="material-symbols-outlined !text-sm sm:!text-base">sentiment_worried</span>
                        <span>Stress & Anxiety</span>
                    </button>
                    @auth
                    <button data-filter="completed" class="filter-btn flex h-9 sm:h-10 items-center justify-center gap-1.5 rounded-xl bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-[#111816] dark:text-gray-300 px-3 sm:px-4 text-xs sm:text-sm font-medium hover:border-primary transition-all duration-200">
                        <span class="material-symbols-outlined !text-sm sm:!text-base">check_circle</span>
                        <span>Completed</span>
                    </button>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Assessment Cards Grid -->
        <div id="assessments" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8" id="assessments-grid">
            
            @if($assessments && $assessments->count() > 0)
                @foreach($assessments as $assessment)
                @php
                    $colors = [
                        'audit' => ['from' => 'from-yellow-500', 'to' => 'to-orange-600', 'icon' => 'local_bar'],
                        'dudit' => ['from' => 'from-orange-500', 'to' => 'to-red-600', 'icon' => 'medication'],
                        'phq9' => ['from' => 'from-blue-500', 'to' => 'to-cyan-600', 'icon' => 'mood_bad'],
                        'gad7' => ['from' => 'from-purple-500', 'to' => 'to-indigo-600', 'icon' => 'sentiment_worried'],
                        'dass21' => ['from' => 'from-pink-500', 'to' => 'to-rose-600', 'icon' => 'psychology'],
                        'pss' => ['from' => 'from-orange-500', 'to' => 'to-red-600', 'icon' => 'stress_management'],
                        'cage' => ['from' => 'from-amber-500', 'to' => 'to-orange-600', 'icon' => 'local_pharmacy'],
                    ];
                    $color = $colors[$assessment->type] ?? ['from' => 'from-primary', 'to' => 'to-emerald-600', 'icon' => 'psychology'];
                @endphp
                @php
                    $assessmentImages = [
                        'audit' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=400&h=300&fit=crop',
                        'dudit' => 'https://images.unsplash.com/photo-1471864190281-a93a3070b6de?w=400&h=300&fit=crop',
                        'phq9' => 'https://images.unsplash.com/photo-1499209974431-9dddcece7f88?w=400&h=300&fit=crop',
                        'gad7' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=400&h=300&fit=crop',
                        'dass21' => 'https://images.unsplash.com/photo-1544027993-37dbfe43562a?w=400&h=300&fit=crop',
                        'pss' => 'https://images.unsplash.com/photo-1499209974431-9dddcece7f88?w=400&h=300&fit=crop',
                        'cage' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=400&h=300&fit=crop',
                    ];
                    $assessmentImage = $assessmentImages[$assessment->type] ?? 'https://images.unsplash.com/photo-1544027993-37dbfe43562a?w=400&h=300&fit=crop';
                @endphp
                <article class="assessment-card group block bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary/30 hover:-translate-y-1 h-full" 
                    data-category="{{ 
                        in_array($assessment->type, ['audit', 'dudit', 'cage']) ? 'substance' : 
                        (in_array($assessment->type, ['phq9', 'dass21']) ? 'mental-health' : 
                        (in_array($assessment->type, ['gad7', 'pss']) ? 'stress' : 'other'))
                    }}"
                    @auth data-completed="{{ $completedAssessments->has($assessment->id) ? 'true' : 'false' }}" @endauth>
                    <!-- Image Section -->
                    <div class="relative h-40 sm:h-48 overflow-hidden">
                        <img src="{{ $assessmentImage }}" alt="{{ $assessment->full_name ?? $assessment->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        
                        <!-- Icon Badge -->
                        <div class="absolute top-3 sm:top-4 left-3 sm:left-4">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg">
                                <span class="material-symbols-outlined text-primary text-lg sm:text-2xl">{{ $color['icon'] }}</span>
                            </div>
                        </div>
                        
                        <!-- Time Badge -->
                        <div class="absolute top-3 sm:top-4 right-3 sm:right-4">
                            <div class="flex items-center gap-1 bg-primary/90 backdrop-blur-sm px-2 sm:px-3 py-1 sm:py-1.5 rounded-full text-xs font-semibold text-white">
                                <span class="material-symbols-outlined !text-xs sm:!text-sm">schedule</span>
                                5-15 min
                            </div>
                        </div>
                        
                        @auth
                            @php
                                $userAttempt = $completedAssessments->get($assessment->id);
                            @endphp
                            @if($userAttempt)
                                <!-- Completion Badge -->
                                <div class="absolute bottom-3 sm:bottom-4 left-3 sm:left-4">
                                    <div class="flex items-center gap-1 bg-green-500/90 backdrop-blur-sm px-2 sm:px-3 py-1 sm:py-1.5 rounded-full text-xs font-semibold text-white">
                                        <span class="material-symbols-outlined !text-xs sm:!text-sm">check_circle</span>
                                        Completed
                                    </div>
                                </div>
                                
                                <!-- Last Taken Date -->
                                <div class="absolute bottom-3 sm:bottom-4 right-3 sm:right-4">
                                    <div class="bg-black/60 backdrop-blur-sm px-2 py-1 rounded text-xs text-white">
                                        {{ $userAttempt->taken_at->format('M j, Y') }}
                                    </div>
                                </div>
                            @endif
                        @endauth
                    </div>
                    
                    <!-- Content Section -->
                    <div class="p-4 sm:p-6">
                        <h3 class="font-bold text-gray-900 dark:text-white text-base sm:text-lg mb-2 group-hover:text-primary transition-colors line-clamp-2">
                            {{ $assessment->full_name ?? $assessment->name }}
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed mb-3 sm:mb-4">
                            {{ Str::limit($assessment->description, 100) }}
                        </p>
                        
                        <!-- Questions Count -->
                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2 text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-3 sm:mb-4">
                            <div class="flex items-center gap-1 sm:gap-2">
                                <span class="material-symbols-outlined !text-sm sm:!text-base">quiz</span>
                                <span>{{ $assessment->questions->count() }} questions</span>
                            </div>
                            @auth
                                @if($userAttempt)
                                    <span class="text-green-600 dark:text-green-400 font-semibold">
                                        • Last score: {{ $userAttempt->total_score ?? 'N/A' }}
                                    </span>
                                @endif
                            @endauth
                        </div>
                        
                        <!-- Start Link -->
                        @auth
                            @if($userAttempt)
                                <div class="flex flex-col sm:flex-row gap-2">
                                    <button onclick="viewLastScore('{{ $assessment->type }}')" class="flex-1 flex items-center justify-center gap-1 text-blue-600 dark:text-blue-400 font-semibold text-xs sm:text-sm hover:text-blue-700 dark:hover:text-blue-300 transition-colors border border-blue-200 dark:border-blue-700 rounded-lg py-2">
                                        <span class="material-symbols-outlined text-sm">visibility</span>
                                        <span>View Last Score</span>
                                    </button>
                                    <a href="{{ route('public.assessments.show', $assessment->type) }}" class="flex-1 flex items-center justify-center gap-1 text-primary font-semibold text-xs sm:text-sm group-hover:gap-2 transition-all bg-primary/10 hover:bg-primary/20 rounded-lg py-2">
                                        <span>Retake</span>
                                        <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">refresh</span>
                                    </a>
                                </div>
                            @else
                                <a href="{{ route('public.assessments.show', $assessment->type) }}" class="flex items-center justify-center gap-2 text-primary font-semibold text-xs sm:text-sm group-hover:gap-3 transition-all">
                                    <span>Start Assessment</span>
                                    <span class="material-symbols-outlined text-base sm:text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </a>
                            @endif
                        @else
                            <a href="{{ route('public.assessments.show', $assessment->type) }}" class="flex items-center justify-center gap-2 text-primary font-semibold text-xs sm:text-sm group-hover:gap-3 transition-all">
                                <span>Start Assessment</span>
                                <span class="material-symbols-outlined text-base sm:text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                            </a>
                        @endauth
                    </div>
                </article>
                @endforeach
            @else
            <!-- Fallback to hardcoded assessments if database is empty -->
            
            <!-- Stress Assessment -->
            <article class="group block bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary/30 hover:-translate-y-1 h-full">
                <div class="relative h-48 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1499209974431-9dddcece7f88?w=400&h=300&fit=crop" alt="Stress Assessment" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div class="absolute top-4 left-4">
                        <div class="w-12 h-12 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg">
                            <span class="material-symbols-outlined text-primary text-2xl">psychology</span>
                        </div>
                    </div>
                    <div class="absolute top-4 right-4">
                        <div class="flex items-center gap-1 bg-primary/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-semibold text-white">
                            <span class="material-symbols-outlined !text-sm">schedule</span>
                            10-15 min
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2 group-hover:text-primary transition-colors line-clamp-2">Stress Assessment</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed mb-4">Evaluate your current stress levels and identify potential stressors affecting your daily life.</p>
                    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-4">
                        <span class="material-symbols-outlined !text-base">quiz</span>
                        <span>10 questions</span>
                    </div>
                    <a href="{{ route('public.assessments.show', 'stress') }}" class="flex items-center justify-center gap-2 text-primary font-semibold text-sm group-hover:gap-3 transition-all">
                        <span>Start Assessment</span>
                        <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>
            </article>

            <!-- Anxiety Screening -->
            <article class="group block bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary/30 hover:-translate-y-1 h-full">
                <div class="relative h-48 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=400&h=300&fit=crop" alt="Anxiety Screening" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div class="absolute top-4 left-4">
                        <div class="w-12 h-12 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg">
                            <span class="material-symbols-outlined text-primary text-2xl">sentiment_worried</span>
                        </div>
                    </div>
                    <div class="absolute top-4 right-4">
                        <div class="flex items-center gap-1 bg-primary/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-semibold text-white">
                            <span class="material-symbols-outlined !text-sm">schedule</span>
                            5-10 min
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2 group-hover:text-primary transition-colors line-clamp-2">Anxiety Screening</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed mb-4">Check your anxiety levels using the GAD-7, a validated screening tool for anxiety disorders.</p>
                    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-4">
                        <span class="material-symbols-outlined !text-base">quiz</span>
                        <span>7 questions</span>
                    </div>
                    <a href="{{ route('public.assessments.show', 'anxiety') }}" class="flex items-center justify-center gap-2 text-primary font-semibold text-sm group-hover:gap-3 transition-all">
                        <span>Start Assessment</span>
                        <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>
            </article>

            <!-- Depression Screening -->
            <article class="group block bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary/30 hover:-translate-y-1 h-full">
                <div class="relative h-48 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1499209974431-9dddcece7f88?w=400&h=300&fit=crop" alt="Depression Screening" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div class="absolute top-4 left-4">
                        <div class="w-12 h-12 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg">
                            <span class="material-symbols-outlined text-primary text-2xl">mood_bad</span>
                        </div>
                    </div>
                    <div class="absolute top-4 right-4">
                        <div class="flex items-center gap-1 bg-primary/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-semibold text-white">
                            <span class="material-symbols-outlined !text-sm">schedule</span>
                            5-10 min
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2 group-hover:text-primary transition-colors line-clamp-2">Depression Screening</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed mb-4">Screen for depression symptoms using the PHQ-9, a standard clinical questionnaire.</p>
                    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-4">
                        <span class="material-symbols-outlined !text-base">quiz</span>
                        <span>9 questions</span>
                    </div>
                    <a href="{{ route('public.assessments.show', 'depression') }}" class="flex items-center justify-center gap-2 text-primary font-semibold text-sm group-hover:gap-3 transition-all">
                        <span>Start Assessment</span>
                        <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>
            </article>

            <!-- Substance Use Screening -->
            <article class="group block bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary/30 hover:-translate-y-1 h-full">
                <div class="relative h-48 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=400&h=300&fit=crop" alt="Substance Use Screening" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div class="absolute top-4 left-4">
                        <div class="w-12 h-12 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg">
                            <span class="material-symbols-outlined text-primary text-2xl">local_pharmacy</span>
                        </div>
                    </div>
                    <div class="absolute top-4 right-4">
                        <div class="flex items-center gap-1 bg-primary/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-semibold text-white">
                            <span class="material-symbols-outlined !text-sm">schedule</span>
                            10-15 min
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2 group-hover:text-primary transition-colors line-clamp-2">Substance Use Screening</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed mb-4">Confidential screening for alcohol and substance use patterns using the AUDIT tool.</p>
                    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-4">
                        <span class="material-symbols-outlined !text-base">quiz</span>
                        <span>10 questions</span>
                    </div>
                    <a href="{{ route('public.assessments.show', 'substance') }}" class="flex items-center justify-center gap-2 text-primary font-semibold text-sm group-hover:gap-3 transition-all">
                        <span>Start Assessment</span>
                        <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>
            </article>

            <!-- Well-being Check -->
            <article class="group block bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary/30 hover:-translate-y-1 h-full">
                <div class="relative h-48 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=400&h=300&fit=crop" alt="Well-being Check" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div class="absolute top-4 left-4">
                        <div class="w-12 h-12 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg">
                            <span class="material-symbols-outlined text-primary text-2xl">favorite</span>
                        </div>
                    </div>
                    <div class="absolute top-4 right-4">
                        <div class="flex items-center gap-1 bg-primary/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-semibold text-white">
                            <span class="material-symbols-outlined !text-sm">schedule</span>
                            10 min
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2 group-hover:text-primary transition-colors line-clamp-2">Well-being Check</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed mb-4">Assess your overall mental and emotional well-being across multiple dimensions.</p>
                    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-4">
                        <span class="material-symbols-outlined !text-base">quiz</span>
                        <span>12 questions</span>
                    </div>
                    <a href="{{ route('public.assessments.show', 'wellbeing') }}" class="flex items-center justify-center gap-2 text-primary font-semibold text-sm group-hover:gap-3 transition-all">
                        <span>Start Assessment</span>
                        <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>
            </article>

            <!-- Sleep Quality -->
            <article class="group block bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary/30 hover:-translate-y-1 h-full">
                <div class="relative h-48 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1541781774459-bb2af2f05b55?w=400&h=300&fit=crop" alt="Sleep Quality" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <div class="absolute top-4 left-4">
                        <div class="w-12 h-12 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg">
                            <span class="material-symbols-outlined text-primary text-2xl">bedtime</span>
                        </div>
                    </div>
                    <div class="absolute top-4 right-4">
                        <div class="flex items-center gap-1 bg-primary/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-semibold text-white">
                            <span class="material-symbols-outlined !text-sm">schedule</span>
                            5-10 min
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2 group-hover:text-primary transition-colors line-clamp-2">Sleep Quality</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed mb-4">Evaluate your sleep patterns and identify potential sleep-related issues.</p>
                    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-4">
                        <span class="material-symbols-outlined !text-base">quiz</span>
                        <span>8 questions</span>
                    </div>
                    <a href="{{ route('public.assessments.show', 'sleep') }}" class="flex items-center justify-center gap-2 text-primary font-semibold text-sm group-hover:gap-3 transition-all">
                        <span>Start Assessment</span>
                        <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>
            </article>
            @endif
        </div>

    </div>
</div>

<!-- CTA Section -->
<section class="py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-gradient-to-r from-primary/10 to-green-50 dark:from-gray-800 dark:to-gray-800/50 rounded-2xl p-6 sm:p-8 border border-primary/20 dark:border-gray-700 overflow-hidden">
            <!-- Decorative Icons -->
            <div class="absolute top-3 sm:top-4 left-3 sm:left-4 opacity-10">
                <span class="material-symbols-outlined text-4xl sm:text-6xl text-primary">support_agent</span>
            </div>
            <div class="absolute bottom-3 sm:bottom-4 right-3 sm:right-4 opacity-10">
                <span class="material-symbols-outlined text-4xl sm:text-6xl text-primary">psychology</span>
            </div>
            
            <div class="relative text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-primary/20 rounded-full mb-3 sm:mb-4">
                    <span class="material-symbols-outlined text-2xl sm:text-3xl text-primary">favorite</span>
                </div>
                <h3 class="text-lg sm:text-xl font-bold text-[#111816] dark:text-white mb-2">Need Professional Support?</h3>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-4 sm:mb-6 max-w-2xl mx-auto px-4">If your assessment results indicate concerns, consider speaking with one of our counselors for personalized support.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center px-4">
                    <a href="{{ route('public.counseling.index') }}" class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition-colors text-sm">
                        <span class="material-symbols-outlined text-sm sm:text-base">support_agent</span>
                        <span>View Counseling Services</span>
                    </a>
                    <a href="{{ route('content.index') }}" class="inline-flex items-center justify-center gap-2 px-4 sm:px-5 py-2 sm:py-2.5 bg-white dark:bg-gray-700 text-[#111816] dark:text-white border border-gray-300 dark:border-gray-600 rounded-lg font-semibold hover:border-primary hover:text-primary transition-colors text-sm">
                        <span class="material-symbols-outlined text-sm sm:text-base">library_books</span>
                        <span>Browse Resources</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@include('components.login-modal')
@include('components.forgot-password-modal')
@endsection

@push('scripts')
<script>
// Smooth scroll functionality for Browse Assessments button
document.addEventListener('DOMContentLoaded', function() {
    const browseAssessmentsBtn = document.querySelector('a[href="#assessments-filters"]');
    if (browseAssessmentsBtn) {
        browseAssessmentsBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const filtersSection = document.getElementById('assessments-filters');
            if (filtersSection) {
                // Calculate header height for offset
                const header = document.querySelector('header');
                const headerHeight = header ? header.offsetHeight : 80; // fallback to 80px
                const additionalOffset = 20; // Extra spacing for better UX
                
                // Get the position of the filters section
                const elementPosition = filtersSection.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerHeight - additionalOffset;
                
                // Smooth scroll to the calculated position
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    }
});

function filterAssessments(category, clickedButton) {
    // Update button states - reset all buttons first
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('bg-primary', 'text-white', 'shadow-md');
        btn.classList.add('bg-white', 'dark:bg-gray-800', 'border-2', 'border-gray-200', 'dark:border-gray-700', 'text-[#111816]', 'dark:text-gray-300');
    });
    
    // Find and activate the clicked button
    const activeButton = clickedButton || document.querySelector(`[data-filter="${category}"]`);
    if (activeButton) {
        activeButton.classList.add('bg-primary', 'text-white', 'shadow-md');
        activeButton.classList.remove('bg-white', 'dark:bg-gray-800', 'border-2', 'border-gray-200', 'dark:border-gray-700', 'text-[#111816]', 'dark:text-gray-300');
    }
    
    // Filter cards with smooth animation
    const cards = document.querySelectorAll('.assessment-card, article:not(.assessment-card)');
    cards.forEach(card => {
        let shouldShow = false;
        
        if (category === 'all') {
            shouldShow = true;
        } else if (category === 'completed') {
            // Only show completed assessments for authenticated users
            shouldShow = card.getAttribute('data-completed') === 'true';
        } else {
            // Category-based filtering
            shouldShow = (card.dataset && card.dataset.category === category) ||
                        (!card.dataset && category === 'all');
        }
        
        if (shouldShow) {
            card.style.display = 'block';
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
                card.style.transition = 'all 0.3s ease';
            }, 10);
        } else {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.3s ease';
            setTimeout(() => {
                card.style.display = 'none';
            }, 300);
        }
    });
}

// Add click event listeners to filter buttons
document.addEventListener('DOMContentLoaded', function() {
    // Filter toggle functionality
    const filterToggle = document.getElementById('filter-toggle');
    const filterButtons = document.getElementById('filter-buttons');
    const filterToggleText = document.getElementById('filter-toggle-text');
    const filterToggleIcon = document.getElementById('filter-toggle-icon');
    
    if (filterToggle && filterButtons) {
        filterToggle.addEventListener('click', function() {
            const isHidden = filterButtons.classList.contains('hidden');
            
            if (isHidden) {
                // Show filters
                filterButtons.classList.remove('hidden');
                filterButtons.classList.add('block');
                filterToggleText.textContent = 'Hide Filters';
                filterToggleIcon.style.transform = 'rotate(180deg)';
                
                // Add smooth slide down animation
                filterButtons.style.opacity = '0';
                filterButtons.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    filterButtons.style.transition = 'all 0.3s ease';
                    filterButtons.style.opacity = '1';
                    filterButtons.style.transform = 'translateY(0)';
                }, 10);
            } else {
                // Hide filters
                filterButtons.style.transition = 'all 0.3s ease';
                filterButtons.style.opacity = '0';
                filterButtons.style.transform = 'translateY(-10px)';
                
                setTimeout(() => {
                    filterButtons.classList.add('hidden');
                    filterButtons.classList.remove('block');
                    filterToggleText.textContent = 'Show Filters';
                    filterToggleIcon.style.transform = 'rotate(0deg)';
                }, 300);
            }
        });
    }
    
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const category = this.getAttribute('data-filter');
            filterAssessments(category, this);
        });
    });
    
    // Handle hash navigation for completed assessments
    function handleCompletedHash() {
        console.log('Hash navigation triggered, current hash:', window.location.hash);
        
        if (window.location.hash === '#completed') {
            console.log('Processing #completed hash');
            
            // First activate the completed filter
            const completedBtn = document.querySelector('[data-filter="completed"]');
            console.log('Found completed button:', completedBtn);
            
            if (completedBtn) {
                console.log('Activating completed filter');
                filterAssessments('completed', completedBtn);
            }
            
            // Then scroll to filters section after a short delay
            setTimeout(() => {
                const filtersSection = document.getElementById('assessments-filters');
                console.log('Found filters section:', filtersSection);
                
                if (filtersSection) {
                    // Calculate header height for offset
                    const header = document.querySelector('header');
                    const headerHeight = header ? header.offsetHeight : 80;
                    const additionalOffset = 20; // Spacing for better visibility
                    
                    console.log('Header height:', headerHeight, 'Additional offset:', additionalOffset);
                    
                    // Get the current position of the filters section
                    const elementRect = filtersSection.getBoundingClientRect();
                    const elementTop = elementRect.top + window.pageYOffset;
                    const offsetPosition = elementTop - headerHeight - additionalOffset;
                    
                    console.log('Element top:', elementTop, 'Scroll to position:', offsetPosition);
                    
                    // Smooth scroll to the calculated position
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                    
                    console.log('Scroll initiated');
                } else {
                    console.log('Filters section not found');
                }
            }, 100); // Short delay to ensure filter is applied first
        }
    }
    
    // Handle hash on page load - wait for page to fully load
    window.addEventListener('load', function() {
        console.log('Window loaded, checking hash in 200ms');
        setTimeout(handleCompletedHash, 200);
    });
    
    // Also handle on DOMContentLoaded as backup
    console.log('Setting up hash handler on DOMContentLoaded');
    setTimeout(handleCompletedHash, 300);
    
    // Handle hash changes (if user navigates back/forward)
    window.addEventListener('hashchange', function() {
        console.log('Hash changed to:', window.location.hash);
        handleCompletedHash();
    });
});

// Function to view last score
function viewLastScore(assessmentType) {
    // Show loading state
    const button = event.target.closest('button');
    const originalText = button.innerHTML;
    button.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">refresh</span><span>Loading...</span>';
    button.disabled = true;
    
    // Fetch last result via AJAX
    fetch(`/assessments/${assessmentType}/last-result`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Add taken date to the result data
            if (data.data.takenAt) {
                data.data.takenAtFormatted = new Date(data.data.takenAt).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            }
            // Open the result modal with last score data
            openAssessmentResultModal(data.data);
        } else {
            showToast('Error loading last result. Please try again.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error loading last result. Please try again.', 'error');
    })
    .finally(() => {
        // Restore button state
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

// Toast notification function
function showToast(message, type = 'info') {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 translate-x-full ${
        type === 'success' ? 'bg-green-500 text-white' : 
        type === 'error' ? 'bg-red-500 text-white' : 
        type === 'warning' ? 'bg-yellow-500 text-white' :
        'bg-blue-500 text-white'
    }`;
    
    toast.innerHTML = `
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">
                ${type === 'success' ? 'check_circle' : type === 'error' ? 'error' : type === 'warning' ? 'warning' : 'info'}
            </span>
            <span class="text-sm font-medium">${message}</span>
        </div>
    `;
    
    document.body.appendChild(toast);
    
    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(toast)) {
                document.body.removeChild(toast);
            }
        }, 300);
    }, 5000);
}
</script>
@endpush
