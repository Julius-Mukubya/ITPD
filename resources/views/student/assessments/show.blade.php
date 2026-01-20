@extends('layouts.student')

@section('title', $assessment->name . ' - Assessment')
@section('page-title', $assessment->name)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-8">
    <!-- Progress Bar -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Question <span id="currentQuestion">1</span> of <span id="totalQuestions">{{ $assessment->questions->count() }}</span></span>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300"><span id="progressPercent">{{ $assessment->questions->count() > 0 ? round(100 / $assessment->questions->count()) : 0 }}</span>%</span>
        </div>
        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
            <div id="progressBar" class="bg-primary h-2 rounded-full transition-all duration-300" style="width: {{ $assessment->questions->count() > 0 ? round(100 / $assessment->questions->count()) : 0 }}%"></div>
        </div>
    </div>

    <!-- Assessment Card -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-8 shadow-lg">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-4">
                <a href="{{ route('student.assessments.index') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <span class="material-symbols-outlined">arrow_back</span>
                </a>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $assessment->full_name }}</h1>
            </div>
            <p class="text-gray-600 dark:text-gray-400">{{ $assessment->description }}</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Please answer the following questions honestly. There are no right or wrong answers.</p>
            
            @if($latestAttempt)
            <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                <p class="text-sm text-blue-800 dark:text-blue-200">
                    <span class="material-symbols-outlined text-sm align-middle">info</span>
                    You last took this assessment on {{ $latestAttempt->taken_at->format('M d, Y') }}.
                    <a href="{{ route('student.assessments.result', $latestAttempt->id) }}" class="underline font-semibold">View results</a>
                </p>
            </div>
            @endif
        </div>

        <!-- Question Form -->
        <form id="assessmentForm" action="{{ route('student.assessments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">
            
            <div id="questionContainer">
                @foreach($assessment->questions as $index => $question)
                <div class="question-slide {{ $index === 0 ? '' : 'hidden' }}" data-question="{{ $index + 1 }}">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                        {{ $question->question }}
                    </h2>
                    
                    <div class="space-y-3">
                        @php
                            $options = is_array($question->options) ? $question->options : json_decode($question->options, true);
                        @endphp
                        
                        @foreach($options as $optionIndex => $option)
                        <label class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary hover:bg-primary/5 transition-all">
                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $optionIndex }}" class="w-5 h-5 text-primary" required>
                            <span class="ml-3 text-gray-700 dark:text-gray-300">{{ $option['text'] }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-between mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                <button type="button" id="prevBtn" class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    Previous
                </button>
                <button type="button" id="nextBtn" class="px-6 py-3 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition-colors">
                    Next Question
                </button>
                <button type="submit" id="submitBtn" class="hidden px-6 py-3 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition-colors">
                    Submit Assessment
                </button>
            </div>
        </form>
    </div>

    <!-- Help Section -->
    <div class="mt-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4">
        <div class="flex gap-3">
            <span class="material-symbols-outlined text-yellow-600 dark:text-yellow-400">help</span>
            <div>
                <h3 class="font-semibold text-yellow-900 dark:text-yellow-100 mb-1">Need Immediate Help?</h3>
                <p class="text-sm text-yellow-800 dark:text-yellow-200">If you're experiencing a crisis, please contact Mental Health Uganda toll-free at <a href="tel:0800212121" class="font-bold underline">0800 21 21 21</a> (Mon-Fri, 8:30 AM - 5:00 PM) or visit the counseling center.</p>
            </div>
        </div>
    </div>

    <!-- Privacy Notice -->
    <div class="mt-4 text-center text-sm text-gray-500 dark:text-gray-400">
        <p>🔒 Your responses are confidential and only visible to you.</p>
    </div>
</div>

@push('scripts')
<script>
let currentQuestion = 1;
const totalQuestions = {{ $assessment->questions->count() }};
const questionSlides = document.querySelectorAll('.question-slide');

document.getElementById('nextBtn').addEventListener('click', function() {
    const currentAnswer = document.querySelector(`input[name*="answers"]:checked`);
    const currentSlide = questionSlides[currentQuestion - 1];
    const currentSlideAnswer = currentSlide.querySelector('input[type="radio"]:checked');
    
    if (!currentSlideAnswer) {
        showToast('Please select an answer before continuing.', 'warning');
        return;
    }
    
    if (currentQuestion < totalQuestions) {
        questionSlides[currentQuestion - 1].classList.add('hidden');
        currentQuestion++;
        questionSlides[currentQuestion - 1].classList.remove('hidden');
        updateProgress();
        
        if (currentQuestion === totalQuestions) {
            document.getElementById('nextBtn').classList.add('hidden');
            document.getElementById('submitBtn').classList.remove('hidden');
        }
        
        document.getElementById('prevBtn').disabled = false;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});

document.getElementById('prevBtn').addEventListener('click', function() {
    if (currentQuestion > 1) {
        questionSlides[currentQuestion - 1].classList.add('hidden');
        currentQuestion--;
        questionSlides[currentQuestion - 1].classList.remove('hidden');
        updateProgress();
        
        document.getElementById('nextBtn').classList.remove('hidden');
        document.getElementById('submitBtn').classList.add('hidden');
        
        if (currentQuestion === 1) {
            this.disabled = true;
        }
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});

document.getElementById('assessmentForm').addEventListener('submit', function(e) {
    const lastSlideAnswer = questionSlides[totalQuestions - 1].querySelector('input[type="radio"]:checked');
    if (!lastSlideAnswer) {
        e.preventDefault();
        showToast('Please answer the current question before submitting.', 'warning');
        return false;
    }
});

function updateProgress() {
    const percent = (currentQuestion / totalQuestions) * 100;
    document.getElementById('currentQuestion').textContent = currentQuestion;
    document.getElementById('progressPercent').textContent = Math.round(percent);
    document.getElementById('progressBar').style.width = percent + '%';
}
</script>
@endpush
@endsection
