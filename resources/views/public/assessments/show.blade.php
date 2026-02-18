@extends('layouts.public')

@section('title', 'Take Assessment - WellPath Hub')

@section('content')
<div class="min-h-screen bg-background-light dark:bg-background-dark pt-20 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('public.assessments.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
                <span class="font-medium">Back to Assessments</span>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Sidebar - Assessment Info -->
            <div class="hidden lg:block lg:col-span-3 space-y-6">
                <!-- Assessment Overview -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 shadow-lg">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-primary/20 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-primary text-2xl">quiz</span>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 dark:text-white">Assessment Info</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ count($questions) }} questions</p>
                        </div>
                    </div>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                            <span class="material-symbols-outlined !text-base text-green-600">check_circle</span>
                            <span>Anonymous & Confidential</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                            <span class="material-symbols-outlined !text-base text-green-600">schedule</span>
                            <span>5-15 minutes</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400">
                            <span class="material-symbols-outlined !text-base text-purple-600">psychology</span>
                            <span>Evidence-based tool</span>
                        </div>
                    </div>
                </div>

                <!-- Progress Overview -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 shadow-lg">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-4">Your Progress</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Questions Completed</span>
                            <span class="font-semibold text-gray-900 dark:text-white"><span id="sidebarCurrentQuestion">1</span> / {{ count($questions) }}</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                            <div id="sidebarProgressBar" class="bg-gradient-to-r from-primary to-green-500 h-3 rounded-full transition-all duration-300" style="width: {{ count($questions) > 0 ? round(100 / count($questions)) : 0 }}%"></div>
                        </div>
                        <div class="text-center">
                            <span class="text-2xl font-bold text-primary"><span id="sidebarProgressPercent">{{ count($questions) > 0 ? round(100 / count($questions)) : 0 }}</span>%</span>
                        </div>
                    </div>
                </div>

                <!-- Tips -->
                <div class="bg-gradient-to-br from-green-50 to-indigo-50 dark:from-green-900/20 dark:to-indigo-900/20 rounded-2xl border border-green-200 dark:border-green-800 p-6">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="material-symbols-outlined text-green-600 dark:text-green-400">lightbulb</span>
                        <h3 class="font-bold text-green-900 dark:text-green-100">Tips</h3>
                    </div>
                    <ul class="space-y-2 text-sm text-green-800 dark:text-green-200">
                        <li>• Answer honestly for accurate results</li>
                        <li>• Think about the past 2 weeks</li>
                        <li>• Take your time with each question</li>
                        <li>• There are no wrong answers</li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-6">
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
            </div>

            <!-- Right Sidebar - Support & Resources -->
            <div class="hidden lg:block lg:col-span-3 space-y-6">
                <!-- What to Expect -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 shadow-lg">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">info</span>
                        What to Expect
                    </h3>
                    <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                        <div class="flex items-start gap-2">
                            <span class="w-6 h-6 bg-primary/20 rounded-full flex items-center justify-center text-primary text-xs font-bold mt-0.5">1</span>
                            <span>Complete all questions honestly</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="w-6 h-6 bg-primary/20 rounded-full flex items-center justify-center text-primary text-xs font-bold mt-0.5">2</span>
                            <span>Receive your results immediately</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="w-6 h-6 bg-primary/20 rounded-full flex items-center justify-center text-primary text-xs font-bold mt-0.5">3</span>
                            <span>Get personalized recommendations</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="w-6 h-6 bg-primary/20 rounded-full flex items-center justify-center text-primary text-xs font-bold mt-0.5">4</span>
                            <span>Access support resources if needed</span>
                        </div>
                    </div>
                </div>

                <!-- Privacy Notice -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl border border-green-200 dark:border-green-800 p-6">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="material-symbols-outlined text-green-600 dark:text-green-400">lock</span>
                        <h3 class="font-bold text-green-900 dark:text-green-100">Privacy & Security</h3>
                    </div>
                    <ul class="space-y-2 text-sm text-green-800 dark:text-green-200">
                        <li class="flex items-center gap-2">
                            <span class="material-symbols-outlined !text-base text-green-600">check</span>
                            <span>100% Anonymous</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="material-symbols-outlined !text-base text-green-600">check</span>
                            <span>No data stored</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="material-symbols-outlined !text-base text-green-600">check</span>
                            <span>Secure connection</span>
                        </li>
                    </ul>
                </div>

                <!-- Related Resources -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 shadow-lg">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">library_books</span>
                        Related Resources
                    </h3>
                    <div class="space-y-3">
                        <a href="{{ route('content.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="material-symbols-outlined text-green-600">article</span>
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white text-sm">Educational Content</div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Learn more about mental health</div>
                            </div>
                        </a>
                        <a href="{{ route('public.counseling.index') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            <span class="material-symbols-outlined text-green-600">support_agent</span>
                            <div>
                                <div class="font-medium text-gray-900 dark:text-white text-sm">Counseling Services</div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Professional support available</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
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

// Handle form submission via AJAX
document.getElementById('assessmentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.innerHTML;
    
    // Show loading state
    submitBtn.innerHTML = '<span class="material-symbols-outlined animate-spin mr-2">refresh</span>Submitting...';
    submitBtn.disabled = true;
    
    // Prepare form data
    const formData = new FormData(this);
    
    // Submit via AJAX
    fetch(this.action, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Open the result modal
            openAssessmentResultModal(data.data);
        } else {
            showToast('Error processing assessment. Please try again.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Error submitting assessment. Please try again.', 'error');
    })
    .finally(() => {
        // Restore button state
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

function updateProgress() {
    const percent = (currentQuestion / totalQuestions) * 100;
    
    // Update main progress indicators
    document.getElementById('currentQuestion').textContent = currentQuestion;
    document.getElementById('progressPercent').textContent = Math.round(percent);
    document.getElementById('progressBar').style.width = percent + '%';
    
    // Update sidebar progress indicators
    const sidebarCurrentQuestion = document.getElementById('sidebarCurrentQuestion');
    const sidebarProgressPercent = document.getElementById('sidebarProgressPercent');
    const sidebarProgressBar = document.getElementById('sidebarProgressBar');
    
    if (sidebarCurrentQuestion) sidebarCurrentQuestion.textContent = currentQuestion;
    if (sidebarProgressPercent) sidebarProgressPercent.textContent = Math.round(percent);
    if (sidebarProgressBar) sidebarProgressBar.style.width = percent + '%';
}

// Toast notification function
function showToast(message, type = 'info') {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 translate-x-full ${
        type === 'success' ? 'bg-green-500 text-white' : 
        type === 'error' ? 'bg-red-500 text-white' : 
        type === 'warning' ? 'bg-yellow-500 text-white' :
        'bg-green-500 text-white'
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
@endsection

