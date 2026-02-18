@extends('layouts.public')

@section('title', 'Assessment Results - WellPath Hub')

@section('content')
<div class="min-h-screen bg-background-light dark:bg-background-dark pt-20 pb-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Success Message -->
        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6 mb-8">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-2xl">check_circle</span>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-green-900 dark:text-green-100 mb-2">Assessment Completed!</h2>
                    <p class="text-green-800 dark:text-green-200">Thank you for completing the {{ $assessmentName }}. Here are your results.</p>
                </div>
            </div>
        </div>

        <!-- Results Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-lg mb-8">
            <!-- Score Header -->
            <div class="bg-gradient-to-r {{ $gradientClass }} p-8 text-white text-center">
                <h1 class="text-3xl font-bold mb-2">Your {{ $resultTitle }}</h1>
                <div class="text-6xl font-black mb-2">{{ $severityLevel }}</div>
                <p class="text-white/80">Score: {{ $score }}/{{ $maxScore }}</p>
            </div>

            <!-- Results Content -->
            <div class="p-8">
                <!-- Score Breakdown -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">What This Means</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        {{ $interpretation }}
                    </p>
                    
                    <!-- Visual Scale -->
                    <div class="relative pt-1 mb-6">
                        <div class="flex mb-2 items-center justify-between">
                            <div class="text-xs font-semibold inline-block text-gray-600 dark:text-gray-400">Minimal</div>
                            <div class="text-xs font-semibold inline-block text-gray-600 dark:text-gray-400">Severe</div>
                        </div>
                        <div class="overflow-hidden h-4 text-xs flex rounded-full bg-gray-200 dark:bg-gray-700 relative">
                            <div class="w-1/4 bg-green-500"></div>
                            <div class="w-1/4 bg-yellow-500"></div>
                            <div class="w-1/4 bg-orange-500"></div>
                            <div class="w-1/4 bg-red-500"></div>
                            <div class="absolute top-0 h-full" style="left: {{ ($score / $maxScore) * 100 }}%;">
                                <div class="absolute -top-8 left-0 transform -translate-x-1/2">
                                    <span class="material-symbols-outlined {{ $markerColor }} text-3xl">arrow_drop_down</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recommendations -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Recommendations</h3>
                    <div class="space-y-3">
                        @foreach($recommendations as $recommendation)
                        <div class="flex gap-3 p-4 bg-{{ $recommendation['color'] }}-50 dark:bg-{{ $recommendation['color'] }}-900/20 rounded-lg">
                            <span class="material-symbols-outlined text-{{ $recommendation['color'] }}-600 dark:text-{{ $recommendation['color'] }}-400">{{ $recommendation['icon'] }}</span>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white mb-1">{{ $recommendation['title'] }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $recommendation['description'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                @if($showUrgentHelp)
                <!-- Urgent Help Notice -->
                <div class="bg-red-50 dark:bg-red-900/20 border-2 border-red-300 dark:border-red-700 rounded-xl p-6 mb-8">
                    <div class="flex gap-4">
                        <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-3xl">emergency</span>
                        <div>
                            <h3 class="text-lg font-bold text-red-900 dark:text-red-100 mb-2">Immediate Support Recommended</h3>
                            <p class="text-red-800 dark:text-red-200 mb-4">Your results suggest you may benefit from professional support. Please consider reaching out to a mental health professional.</p>
                            <div class="space-y-2">
                                <a href="tel:988" class="inline-flex items-center gap-2 bg-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                                    <span class="material-symbols-outlined">phone</span>
                                    Call Crisis Helpline: 988
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Resources -->
                <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Helpful Resources</h3>
                    <div class="space-y-2">
                        <a href="{{ route('content.index') }}" class="flex items-center gap-2 text-primary hover:underline">
                            <span class="material-symbols-outlined text-lg">library_books</span>
                            <span>Browse Mental Health Resources</span>
                        </a>
                        <a href="{{ route('public.counseling.index') }}" class="flex items-center gap-2 text-primary hover:underline">
                            <span class="material-symbols-outlined text-lg">support_agent</span>
                            <span>View Counseling Services</span>
                        </a>
                        <a href="{{ route('public.contact') }}" class="flex items-center gap-2 text-primary hover:underline">
                            <span class="material-symbols-outlined text-lg">phone</span>
                            <span>Contact Support</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 mb-8">
            <a href="{{ route('public.assessments.index') }}" class="flex-1 bg-primary text-white text-center py-3 px-6 rounded-lg font-semibold hover:bg-primary/90 transition-colors">
                Take Another Assessment
            </a>
            <button onclick="window.print()" class="flex-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-center py-3 px-6 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                Print Results
            </button>
        </div>

        <!-- Create Account CTA -->
        <div class="bg-gradient-to-r from-primary/10 to-emerald-500/10 dark:from-primary/20 dark:to-emerald-500/20 rounded-2xl p-8 text-center mb-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Want to Track Your Progress?</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-2xl mx-auto">
                Create a free account to save your assessment results, track your mental health journey, and access personalized resources.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="document.getElementById('signupModal').classList.remove('hidden')" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-lg font-bold hover:bg-primary/90 transition-colors">
                    <span class="material-symbols-outlined">person_add</span>
                    Create Free Account
                </button>
                <button onclick="document.getElementById('loginModal').classList.remove('hidden')" class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white px-6 py-3 rounded-lg font-bold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    <span class="material-symbols-outlined">login</span>
                    Sign In
                </button>
            </div>
        </div>

        <!-- Disclaimer -->
        <div class="text-center text-sm text-gray-500 dark:text-gray-400">
            <p>This assessment is a screening tool and not a diagnostic instrument. For a professional evaluation, please consult with a licensed mental health professional.</p>
        </div>
    </div>
</div>

@include('components.login-modal')
@include('components.signup-modal')
@include('components.forgot-password-modal')
@endsection

