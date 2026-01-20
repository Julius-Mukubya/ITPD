@extends('layouts.public')

@section('title', 'Take Assessment - WellPath Hub')

@section('content')
<div class="min-h-screen bg-background-light dark:bg-background-dark pt-20 pb-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('public.assessments.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
                <span class="font-medium">Back to Assessments</span>
            </a>
        </div>

        <!-- Assessment Title -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                @if(isset($assessment) && $assessment)
                    {{ $assessment->full_name ?? $assessment->name }}
                @elseif($type === 'audit') AUDIT - Alcohol Use Assessment
                @elseif($type === 'anxiety') GAD-7 - Anxiety Screening
                @elseif($type === 'depression') PHQ-9 - Depression Screening
                @elseif($type === 'substance') Substance Use Screening
                @elseif($type === 'wellbeing') Well-being Check
                @elseif($type === 'sleep') Sleep Quality Assessment
                @else Mental Health Assessment
                @endif
            </h1>
            <p class="text-gray-600 dark:text-gray-400">Please answer honestly. There are no right or wrong answers. Your responses are completely anonymous.</p>
        </div>



        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Question <span id="currentQuestion">1</span> of <span id="totalQuestions">{{ count($questions) }}</span></span>
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300"><span id="progressPercent">{{ count($questions) > 0 ? round(100 / count($questions)) : 0 }}</span>%</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div id="progressBar" class="bg-primary h-2 rounded-full transition-all duration-300" style="width: {{ count($questions) > 0 ? round(100 / count($questions)) : 0 }}%"></div>
            </div>
        </div>

        <!-- Assessment Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-8 shadow-lg">

            <!-- Question Form -->
            <form id="assessmentForm" action="{{ route('public.assessments.result', $type) }}" method="POST">
                @csrf
                <div id="questionContainer">
                    <!-- Questions will be loaded dynamically -->
                    @foreach($questions as $index => $question)
                    <div class="question-slide {{ $index === 0 ? '' : 'hidden' }}" data-question="{{ $index + 1 }}">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
                            @if(is_object($question))
                                {{ $question->question ?? $question->question_text }}
                            @else
                                {{ $question['text'] }}
                            @endif
                        </h2>
                        
                        <div class="space-y-3">
                            @php
                                // Handle both database and hardcoded questions
                                if (is_object($question)) {
                                    $options = is_array($question->options) ? $question->options : json_decode($question->options, true);
                                } else {
                                    $options = $question['options'];
                                }
                            @endphp
                            
                            @if(is_array($options) && isset($options[0]) && is_array($options[0]))
                                {{-- Database format with score --}}
                                @foreach($options as $option)
                                <label class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary hover:bg-primary/5 transition-all">
                                    <input type="radio" name="q{{ $index + 1 }}" value="{{ $option['score'] }}" class="w-5 h-5 text-primary" required>
                                    <span class="ml-3 text-gray-700 dark:text-gray-300">{{ $option['text'] }}</span>
                                </label>
                                @endforeach
                            @else
                                {{-- Hardcoded format --}}
                                @foreach($options as $value => $label)
                                <label class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary hover:bg-primary/5 transition-all">
                                    <input type="radio" name="q{{ $index + 1 }}" value="{{ $value }}" class="w-5 h-5 text-primary" required>
                                    <span class="ml-3 text-gray-700 dark:text-gray-300">{{ $label }}</span>
                                </label>
                                @endforeach
                            @endif
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
                    <p class="text-sm text-yellow-800 dark:text-yellow-200">If you're experiencing a crisis, please contact the crisis helpline at <a href="tel:988" class="font-bold underline">988</a> or visit your nearest emergency room.</p>
                </div>
            </div>
        </div>

        <!-- Privacy Notice -->
        <div class="mt-4 text-center text-sm text-gray-500 dark:text-gray-400">
            <p>🔒 Your responses are anonymous and will not be stored or shared.</p>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentQuestion = 1;
const totalQuestions = {{ count($questions) }};
const questionSlides = document.querySelectorAll('.question-slide');

document.getElementById('nextBtn').addEventListener('click', function() {
    const currentAnswer = document.querySelector(`input[name="q${currentQuestion}"]:checked`);
    if (!currentAnswer) {
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

function updateProgress() {
    const percent = (currentQuestion / totalQuestions) * 100;
    document.getElementById('currentQuestion').textContent = currentQuestion;
    document.getElementById('progressPercent').textContent = Math.round(percent);
    document.getElementById('progressBar').style.width = percent + '%';
}
</script>
@endpush
@endsection
