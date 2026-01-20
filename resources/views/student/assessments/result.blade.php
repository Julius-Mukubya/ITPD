@extends('layouts.student')

@section('title', 'Assessment Results')
@section('page-title', 'Assessment Results')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Success Message -->
    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6 mb-8">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-2xl">check_circle</span>
            </div>
            <div>
                <h2 class="text-xl font-bold text-green-900 dark:text-green-100 mb-2">Assessment Completed!</h2>
                <p class="text-green-800 dark:text-green-200">Thank you for completing the {{ $attempt->assessment->name }}. Here are your results.</p>
            </div>
        </div>
    </div>

    <!-- Results Card -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-lg mb-8">
        <!-- Score Header -->
        @php
        $colors = [
            'low' => ['from' => 'green-500', 'to' => 'emerald-600'],
            'medium' => ['from' => 'yellow-500', 'to' => 'orange-600'],
            'high' => ['from' => 'orange-500', 'to' => 'red-600'],
        ];
        $color = $colors[$attempt->risk_level] ?? $colors['low'];
        @endphp
        <div class="bg-gradient-to-r from-{{ $color['from'] }} to-{{ $color['to'] }} p-8 text-white text-center">
            <h1 class="text-3xl font-bold mb-2">{{ $attempt->assessment->full_name }}</h1>
            <div class="text-6xl font-black mb-2">{{ ucfirst($attempt->risk_level) }} Risk</div>
            <p class="text-white/90">Score: {{ $attempt->total_score }}%</p>
            <p class="text-sm text-white/80 mt-2">Completed on {{ $attempt->taken_at->format('M d, Y \a\t g:i A') }}</p>
        </div>

        <!-- Results Content -->
        <div class="p-8">
            <!-- Score Breakdown -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">What This Means</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    {{ $attempt->recommendation }}
                </p>
                
                <!-- Visual Scale -->
                <div class="relative pt-1 mb-6">
                    <div class="flex mb-2 items-center justify-between">
                        <div class="text-xs font-semibold inline-block text-gray-600 dark:text-gray-400">Low Risk (0%)</div>
                        <div class="text-xs font-semibold inline-block text-gray-600 dark:text-gray-400">High Risk (100%)</div>
                    </div>
                    <div class="overflow-hidden h-4 text-xs flex rounded-full bg-gray-200 dark:bg-gray-700 relative">
                        <div class="absolute h-full bg-gradient-to-r from-green-500 via-yellow-500 via-orange-500 to-red-500" style="width: 100%"></div>
                        <div class="absolute h-full flex items-center" style="left: {{ $attempt->total_score }}%; transform: translateX(-50%);">
                            <div class="relative">
                                <div class="absolute -top-8 left-1/2 transform -translate-x-1/2">
                                    <span class="material-symbols-outlined text-gray-900 dark:text-white text-3xl drop-shadow-lg">arrow_drop_down</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Responses -->
            @if($attempt->responses->count() > 0)
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Your Responses</h3>
                <div class="space-y-4">
                    @foreach($attempt->responses as $response)
                    <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                        <p class="font-semibold text-gray-900 dark:text-white mb-2">{{ $response->question->question }}</p>
                        @php
                            $options = is_array($response->question->options) ? $response->question->options : json_decode($response->question->options, true);
                            $selectedOption = $options[$response->selected_option_index] ?? null;
                        @endphp
                        @if($selectedOption)
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            <span class="font-medium">Your answer:</span> {{ $selectedOption['text'] }}
                            <span class="ml-2 text-xs text-gray-500">({{ $response->score }} points)</span>
                        </p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Recommendations -->
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Next Steps</h3>
                <div class="space-y-3">
                    @if($attempt->risk_level === 'high')
                    <div class="flex gap-3 p-4 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                        <span class="material-symbols-outlined text-red-600 dark:text-red-400">warning</span>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Seek Professional Help</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">We strongly recommend speaking with a counselor as soon as possible.</p>
                        </div>
                    </div>
                    @endif
                    
                    <div class="flex gap-3 p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                        <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">psychology</span>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Book a Counseling Session</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Talk to a professional counselor about your concerns.</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-3 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">library_books</span>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Explore Resources</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Browse our content library for helpful articles and tips.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resources -->
            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Helpful Resources</h3>
                <div class="space-y-2">
                    <a href="{{ route('student.content.library') }}" class="flex items-center gap-2 text-primary hover:underline">
                        <span class="material-symbols-outlined text-lg">library_books</span>
                        <span>Browse Content Library</span>
                    </a>
                    <a href="{{ route('public.counseling.sessions') }}" class="flex items-center gap-2 text-primary hover:underline">
                        <span class="material-symbols-outlined text-lg">support_agent</span>
                        <span>Request Counseling Session</span>
                    </a>
                    <a href="tel:0800212121" class="flex items-center gap-2 text-primary hover:underline">
                        <span class="material-symbols-outlined text-lg">phone</span>
                        <span>Crisis Helpline: 0800 21 21 21 (Toll Free)</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4">
        <a href="{{ route('student.assessments.index') }}" class="flex-1 bg-primary text-white text-center py-3 px-6 rounded-lg font-semibold hover:bg-primary/90 transition-colors">
            Take Another Assessment
        </a>
        <a href="{{ route('student.assessments.show', $attempt->assessment_id) }}" class="flex-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-center py-3 px-6 rounded-lg font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
            Retake This Assessment
        </a>
        <button onclick="window.print()" class="flex-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-center py-3 px-6 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <span class="material-symbols-outlined text-sm align-middle">print</span>
            Print Results
        </button>
    </div>

    <!-- Disclaimer -->
    <div class="mt-8 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
        <p class="text-sm text-yellow-800 dark:text-yellow-200 text-center">
            <span class="material-symbols-outlined text-sm align-middle">info</span>
            This assessment is a screening tool and not a diagnostic instrument. For a professional evaluation, please consult with a licensed mental health professional.
        </p>
    </div>
</div>
@endsection
