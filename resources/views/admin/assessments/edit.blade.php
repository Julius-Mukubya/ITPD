@extends('layouts.admin')

@section('title', 'Edit Assessment')
@section('page-title', 'Edit Assessment')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Assessment</h2>
            <p class="text-gray-600 dark:text-gray-400">Update assessment information and questions</p>
        </div>
        <a href="{{ route('admin.assessments.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
            Back to Assessments
        </a>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">

    <form action="{{ route('admin.assessments.update', $assessment) }}" method="POST" id="assessmentForm">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Basic Information -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title *</label>
                <input type="text" name="title" value="{{ old('title', $assessment->full_name ?? $assessment->name) }}" required
                    title="Enter a clear, descriptive title for this assessment"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white"
                    placeholder="e.g., Depression Screening Assessment">
                @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description *</label>
                <textarea name="description" rows="3" required
                    title="Provide a brief description of what this assessment measures and who it's for"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white"
                    placeholder="Brief description of what this assessment evaluates">{{ old('description', $assessment->description) }}</textarea>
                @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Assessment Type *</label>
                <select name="type" required
                    title="Select the standardized assessment type or screening tool"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    <option value="">Select Type</option>
                    <option value="audit" {{ old('type', $assessment->type) == 'audit' ? 'selected' : '' }}>AUDIT (Alcohol Use Disorders Identification Test)</option>
                    <option value="dudit" {{ old('type', $assessment->type) == 'dudit' ? 'selected' : '' }}>DUDIT (Drug Use Disorders Identification Test)</option>
                    <option value="phq9" {{ old('type', $assessment->type) == 'phq9' ? 'selected' : '' }}>PHQ-9 (Patient Health Questionnaire - Depression)</option>
                    <option value="gad7" {{ old('type', $assessment->type) == 'gad7' ? 'selected' : '' }}>GAD-7 (Generalized Anxiety Disorder)</option>
                    <option value="dass21" {{ old('type', $assessment->type) == 'dass21' ? 'selected' : '' }}>DASS-21 (Depression, Anxiety and Stress Scale)</option>
                    <option value="pss" {{ old('type', $assessment->type) == 'pss' ? 'selected' : '' }}>PSS (Perceived Stress Scale)</option>
                    <option value="cage" {{ old('type', $assessment->type) == 'cage' ? 'selected' : '' }}>CAGE (Substance Abuse Screening)</option>
                </select>
                @error('type')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Result Interpretations Section -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Result Interpretations</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Define how results are interpreted based on score percentage ranges.</p>
                
                @php
                    $guidelines = is_array($assessment->scoring_guidelines) ? $assessment->scoring_guidelines : json_decode($assessment->scoring_guidelines, true);
                    $ranges = $guidelines['ranges'] ?? [];
                    $interpretations = [
                        'minimal' => $ranges[0]['interpretation'] ?? 'Your results indicate minimal concerns in this area.',
                        'mild' => $ranges[1]['interpretation'] ?? 'Your results suggest mild concerns.',
                        'moderate' => $ranges[2]['interpretation'] ?? 'Your results indicate moderate concerns.',
                        'severe' => $ranges[3]['interpretation'] ?? 'Your results suggest significant concerns.',
                    ];
                @endphp
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Minimal (0-25%)</label>
                        <textarea name="interpretation_minimal" rows="2" 
                            title="Message shown to users who score 0-25% - indicates low concern level"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">{{ old('interpretation_minimal', $interpretations['minimal']) }}</textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mild (26-50%)</label>
                        <textarea name="interpretation_mild" rows="2" 
                            title="Message shown to users who score 26-50% - indicates mild concern level"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">{{ old('interpretation_mild', $interpretations['mild']) }}</textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Moderate (51-75%)</label>
                        <textarea name="interpretation_moderate" rows="2" 
                            title="Message shown to users who score 51-75% - indicates moderate concern level"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">{{ old('interpretation_moderate', $interpretations['moderate']) }}</textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Severe (76-100%)</label>
                        <textarea name="interpretation_severe" rows="2" 
                            title="Message shown to users who score 76-100% - indicates high concern level requiring professional attention"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">{{ old('interpretation_severe', $interpretations['severe']) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Questions Section -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Questions</h3>
                    <button type="button" onclick="addQuestion()" 
                        title="Add a new question to this assessment"
                        class="bg-primary text-white px-4 py-2 rounded-lg hover:opacity-90 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">add</span>
                        Add Question
                    </button>
                </div>

                <div id="questionsContainer" class="space-y-4">
                    @foreach($assessment->questions as $index => $question)
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 border border-gray-200 dark:border-gray-600" id="question-{{ $index }}">
                        <div class="flex items-start justify-between mb-3">
                            <h4 class="font-medium text-gray-900 dark:text-white">Question {{ $index + 1 }}</h4>
                            <button type="button" onclick="removeQuestion({{ $index }})" 
                                title="Remove this question"
                                class="text-red-600 hover:text-red-800">
                                <span class="material-symbols-outlined text-sm">delete</span>
                            </button>
                        </div>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question Text *</label>
                                <input type="text" name="questions[{{ $index }}][text]" value="{{ old('questions.'.$index.'.text', $question->question) }}" required
                                    title="Enter the question text that users will see"
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white text-sm"
                                    placeholder="Enter your question">
                            </div>
                            
                            <div id="options-{{ $index }}">
                                <div class="flex items-center justify-between mb-2">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Answer Options *</label>
                                    <button type="button" onclick="addOption({{ $index }})" 
                                        title="Add a new answer option for this question"
                                        class="text-primary hover:text-primary/80 text-sm flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">add</span>
                                        Add Option
                                    </button>
                                </div>
                                <div id="options-container-{{ $index }}" class="space-y-2 mb-2">
                                    @php
                                        $existingOptions = is_string($question->options) ? json_decode($question->options, true) : $question->options;
                                    @endphp
                                    @if(is_array($existingOptions))
                                        @foreach($existingOptions as $optIndex => $option)
                                        <div class="flex gap-2 items-start" id="option-{{ $index }}-{{ $optIndex }}">
                                            <div class="flex-1">
                                                <input type="text" 
                                                    title="Enter the answer option text that users will see"
                                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white text-sm"
                                                    placeholder="Option text"
                                                    value="{{ $option['text'] ?? '' }}"
                                                    data-question="{{ $index }}"
                                                    data-option="{{ $optIndex }}"
                                                    data-field="text"
                                                    onchange="updateOptionsJSON({{ $index }})"
                                                    required>
                                            </div>
                                            <div class="w-24">
                                                <input type="number" 
                                                    title="Score value for this option (higher scores indicate greater severity)"
                                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white text-sm"
                                                    placeholder="Score"
                                                    value="{{ $option['score'] ?? 0 }}"
                                                    data-question="{{ $index }}"
                                                    data-option="{{ $optIndex }}"
                                                    data-field="score"
                                                    onchange="updateOptionsJSON({{ $index }})"
                                                    required>
                                            </div>
                                            <button type="button" onclick="removeOption({{ $index }}, {{ $optIndex }})" 
                                                title="Remove this answer option"
                                                class="text-red-600 hover:text-red-800 p-2">
                                                <span class="material-symbols-outlined text-sm">delete</span>
                                            </button>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                                <textarea name="questions[{{ $index }}][options]" id="options-json-{{ $index }}" class="hidden" required>{{ old('questions.'.$index.'.options', is_string($question->options) ? $question->options : json_encode($question->options)) }}</textarea>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <button type="submit" 
                title="Save changes to this assessment"
                class="bg-primary text-white px-6 py-2 rounded-lg hover:opacity-90">Update Assessment</button>
            <a href="{{ route('admin.assessments.index') }}" 
                title="Cancel and return to assessments list"
                class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg hover:opacity-90">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
let questionCount = {{ $assessment->questions->count() }};

function addQuestion() {
    const container = document.getElementById('questionsContainer');
    const questionDiv = document.createElement('div');
    questionDiv.className = 'bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 border border-gray-200 dark:border-gray-600';
    questionDiv.id = `question-${questionCount}`;
    
    questionDiv.innerHTML = `
        <div class="flex items-start justify-between mb-3">
            <h4 class="font-medium text-gray-900 dark:text-white">Question ${questionCount + 1}</h4>
            <button type="button" onclick="removeQuestion(${questionCount})" class="text-red-600 hover:text-red-800">
                <span class="material-symbols-outlined text-sm">delete</span>
            </button>
        </div>
        
        <div class="space-y-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question Text *</label>
                <input type="text" name="questions[${questionCount}][text]" required
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white text-sm"
                    placeholder="Enter your question">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question Type *</label>
                <select name="questions[${questionCount}][type]" required onchange="handleQuestionTypeChange(${questionCount}, this.value)"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white text-sm">
                    <option value="scale">Scale (1-5)</option>
                    <option value="yes_no">Yes/No</option>
                    <option value="multiple_choice">Multiple Choice</option>
                </select>
            </div>
            
            <div id="options-${questionCount}" class="hidden">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Options (comma-separated)</label>
                <input type="text" name="questions[${questionCount}][options]"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white text-sm"
                    placeholder="Option 1, Option 2, Option 3">
            </div>
        </div>
    `;
    
    container.appendChild(questionDiv);
    questionCount++;
}

function removeQuestion(id) {
    const element = document.getElementById(`question-${id}`);
    if (element) {
        element.remove();
    }
}

let optionCounters = {};

function addOption(questionId) {
    if (!optionCounters[questionId]) {
        // Count existing options
        const container = document.getElementById(`options-container-${questionId}`);
        const existingOptions = container.querySelectorAll('[data-option]');
        optionCounters[questionId] = existingOptions.length;
    }
    
    const container = document.getElementById(`options-container-${questionId}`);
    const optionId = optionCounters[questionId];
    
    const optionDiv = document.createElement('div');
    optionDiv.className = 'flex gap-2 items-start';
    optionDiv.id = `option-${questionId}-${optionId}`;
    
    optionDiv.innerHTML = `
        <div class="flex-1">
            <input type="text" 
                title="Enter the answer option text that users will see"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white text-sm"
                placeholder="Option text"
                data-question="${questionId}"
                data-option="${optionId}"
                data-field="text"
                onchange="updateOptionsJSON(${questionId})"
                required>
        </div>
        <div class="w-24">
            <input type="number" 
                title="Score value for this option (higher scores indicate greater severity)"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white text-sm"
                placeholder="Score"
                value="${optionId}"
                data-question="${questionId}"
                data-option="${optionId}"
                data-field="score"
                onchange="updateOptionsJSON(${questionId})"
                required>
        </div>
        <button type="button" onclick="removeOption(${questionId}, ${optionId})" 
            title="Remove this answer option"
            class="text-red-600 hover:text-red-800 p-2">
            <span class="material-symbols-outlined text-sm">delete</span>
        </button>
    `;
    
    container.appendChild(optionDiv);
    optionCounters[questionId]++;
    updateOptionsJSON(questionId);
}

function removeOption(questionId, optionId) {
    const element = document.getElementById(`option-${questionId}-${optionId}`);
    if (element) {
        element.remove();
        updateOptionsJSON(questionId);
    }
}

function updateOptionsJSON(questionId) {
    const container = document.getElementById(`options-container-${questionId}`);
    const inputs = container.querySelectorAll('input[data-question="' + questionId + '"]');
    const options = [];
    const optionMap = {};
    
    inputs.forEach(input => {
        const optionId = input.dataset.option;
        const field = input.dataset.field;
        
        if (!optionMap[optionId]) {
            optionMap[optionId] = {};
        }
        
        if (field === 'text') {
            optionMap[optionId].text = input.value;
        } else if (field === 'score') {
            optionMap[optionId].score = parseInt(input.value) || 0;
        }
    });
    
    // Convert map to array
    Object.values(optionMap).forEach(option => {
        if (option.text) {
            options.push(option);
        }
    });
    
    const jsonTextarea = document.getElementById(`options-json-${questionId}`);
    if (jsonTextarea) {
        jsonTextarea.value = JSON.stringify(options);
    }
}
</script>
@endpush
