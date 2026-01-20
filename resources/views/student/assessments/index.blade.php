@extends('layouts.student')

@section('title', 'Mental Health Assessments')
@section('page-title', 'Mental Health Assessments')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- PageHeading -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
        <div class="flex flex-col gap-1">
            <p class="text-gray-900 dark:text-white text-2xl sm:text-3xl font-bold tracking-tight">Mental Health Assessments</p>
            <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">Take confidential self-assessments to better understand your mental health and wellbeing</p>
        </div>
    </div>

    <!-- Info Banner -->
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 mb-8 shadow-sm">
        <div class="flex gap-3">
            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-2">
                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">info</span>
            </div>
            <div class="flex-1">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Confidential & Anonymous</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Your assessment results are private and only visible to you. These are screening tools, not diagnostic tests.</p>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="relative flex-1">
                <span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">search</span>
                <input type="text" id="assessmentSearch" placeholder="Search assessments..." 
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent">
            </div>
            <div class="flex gap-2 flex-wrap">
                <button onclick="filterAssessments('all')" class="filter-btn px-4 py-3 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition-colors">
                    All
                </button>
                @foreach($categories as $category)
                <button onclick="filterAssessments('{{ $category['value'] }}')" class="filter-btn px-4 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                    {{ $category['label'] }}
                </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Assessment Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="assessmentsGrid">
        @php
        $colors = [
            'audit' => ['from' => 'yellow-500', 'to' => 'orange-600', 'icon' => 'local_bar'],
            'dudit' => ['from' => 'orange-500', 'to' => 'red-600', 'icon' => 'local_pharmacy'],
            'phq9' => ['from' => 'blue-500', 'to' => 'cyan-600', 'icon' => 'mood_bad'],
            'gad7' => ['from' => 'purple-500', 'to' => 'indigo-600', 'icon' => 'sentiment_worried'],
            'cage' => ['from' => 'red-500', 'to' => 'pink-600', 'icon' => 'warning'],
        ];
        @endphp

        @forelse($assessments as $assessment)
        @php
        $color = $colors[$assessment->type] ?? ['from' => 'gray-500', 'to' => 'gray-600', 'icon' => 'psychology'];
        $questionCount = $assessment->questions->count();
        $estimatedTime = ceil($questionCount * 0.5) . '-' . ceil($questionCount * 1) . ' minutes';
        
        // Assessment images
        $assessmentImages = [
            'audit' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=400&h=300&fit=crop',
            'dudit' => 'https://images.unsplash.com/photo-1471864190281-a93a3070b6de?w=400&h=300&fit=crop',
            'phq9' => 'https://images.unsplash.com/photo-1499209974431-9dddcece7f88?w=400&h=300&fit=crop',
            'gad7' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=400&h=300&fit=crop',
            'cage' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=400&h=300&fit=crop',
        ];
        $assessmentImage = $assessmentImages[$assessment->type] ?? 'https://images.unsplash.com/photo-1544027993-37dbfe43562a?w=400&h=300&fit=crop';
        @endphp
        <article class="assessment-card group block bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary/30 hover:-translate-y-1 h-full" 
            data-title="{{ strtolower($assessment->name . ' ' . $assessment->full_name) }}" 
            data-category="{{ $assessment->type }}">
            <!-- Image Section -->
            <div class="relative h-48 overflow-hidden">
                <img src="{{ $assessmentImage }}" alt="{{ $assessment->full_name ?? $assessment->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                
                <!-- Icon Badge -->
                <div class="absolute top-4 left-4">
                    <div class="w-12 h-12 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg">
                        <span class="material-symbols-outlined text-primary text-2xl">{{ $color['icon'] }}</span>
                    </div>
                </div>
                
                <!-- Time Badge -->
                <div class="absolute top-4 right-4">
                    <div class="flex items-center gap-1 bg-primary/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-semibold text-white">
                        <span class="material-symbols-outlined !text-sm">schedule</span>
                        {{ $estimatedTime }}
                    </div>
                </div>
            </div>
            
            <!-- Content Section -->
            <div class="p-6">
                <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2 group-hover:text-primary transition-colors line-clamp-2">
                    {{ $assessment->full_name ?? $assessment->name }}
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed mb-4">
                    {{ Str::limit($assessment->description, 100) }}
                </p>
                
                <!-- Questions Count -->
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-4">
                    <span class="material-symbols-outlined !text-base">quiz</span>
                    <span>{{ $questionCount }} questions</span>
                </div>
                
                <!-- Start Link -->
                <a href="{{ route('student.assessments.show', $assessment->id) }}" class="flex items-center justify-center gap-2 text-primary font-semibold text-sm group-hover:gap-3 transition-all">
                    <span>Start Assessment</span>
                    <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
        </article>
        @empty
        <div class="col-span-full text-center py-12">
            <span class="material-symbols-outlined text-6xl text-gray-400 mb-4">psychology</span>
            <p class="text-gray-500 dark:text-gray-400">No assessments available at this time.</p>
        </div>
        @endforelse
    </div>

    <!-- Previous Assessments -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Your Assessment History</h2>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            @forelse($myAttempts as $attempt)
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 last:border-b-0 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-1">{{ $attempt->assessment->name }} - {{ $attempt->assessment->full_name }}</h3>
                        <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">calendar_today</span>
                                {{ $attempt->taken_at->format('M d, Y') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-sm">score</span>
                                Score: {{ $attempt->total_score }}
                            </span>
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($attempt->risk_level === 'low') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                @elseif($attempt->risk_level === 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                @endif">
                                {{ ucfirst($attempt->risk_level) }} Risk
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('student.assessments.result', $attempt->id) }}" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        View Results
                    </a>
                </div>
            </div>
            @empty
            <div class="p-6">
                <p class="text-gray-500 dark:text-gray-400 text-center py-8">No assessments completed yet. Take your first assessment above!</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Search functionality
document.getElementById('assessmentSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const cards = document.querySelectorAll('.assessment-card');
    
    cards.forEach(card => {
        const title = card.dataset.title || '';
        const text = card.textContent.toLowerCase();
        
        if (title.includes(searchTerm) || text.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});

// Filter functionality
function filterAssessments(category) {
    // Update button states
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('bg-primary', 'text-white');
        btn.classList.add('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
    });
    
    event.target.classList.remove('bg-gray-100', 'dark:bg-gray-700', 'text-gray-700', 'dark:text-gray-300');
    event.target.classList.add('bg-primary', 'text-white');
    
    // Filter cards
    const cards = document.querySelectorAll('.assessment-card');
    cards.forEach(card => {
        if (category === 'all' || card.dataset.category === category) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
    
    // Clear search when filtering
    document.getElementById('assessmentSearch').value = '';
}
</script>
@endpush
