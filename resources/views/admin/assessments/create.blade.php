@extends('layouts.admin')

@section('title', 'Create Assessment')
@section('page-title', 'Create New Assessment')

@section('content')
<div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Create Assessment</h2>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Add new mental health assessment to the system</p>
        </div>
        <a href="{{ route('admin.assessments.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors text-center">
            Back to Assessments
        </a>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 sm:p-6">

    <form action="{{ route('admin.assessments.store') }}" method="POST" id="assessmentForm">
        @csrf

        <div class="space-y-6">
            <!-- Basic Information -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title *</label>
                <input type="text" name="title" value="{{ old('title') }}" required
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
                    placeholder="Brief description of what this assessment evaluates">{{ old('description') }}</textarea>
                @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Assessment Type *</label>
                <select name="type" required
                    title="Select the standardized assessment type or screening tool"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    <option value="">Select Type</option>
                    <option value="audit" {{ old('type') == 'audit' ? 'selected' : '' }}>AUDIT (Alcohol Use Disorders Identification Test)</option>
                    <option value="dudit" {{ old('type') == 'dudit' ? 'selected' : '' }}>DUDIT (Drug Use Disorders Identification Test)</option>
                    <option value="phq9" {{ old('type') == 'phq9' ? 'selected' : '' }}>PHQ-9 (Patient Health Questionnaire - Depression)</option>
                    <option value="gad7" {{ old('type') == 'gad7' ? 'selected' : '' }}>GAD-7 (Generalized Anxiety Disorder)</option>
                    <option value="dass21" {{ old('type') == 'dass21' ? 'selected' : '' }}>DASS-21 (Depression, Anxiety and Stress Scale)</option>
                    <option value="pss" {{ old('type') == 'pss' ? 'selected' : '' }}>PSS (Perceived Stress Scale)</option>
                    <option value="cage" {{ old('type') == 'cage' ? 'selected' : '' }}>CAGE (Substance Abuse Screening)</option>
                </select>
                @error('type')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <!-- Result Interpretations Section -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Result Interpretations</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Define how results are interpreted based on score percentage ranges.</p>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Minimal (0-25%)</label>
                        <textarea name="interpretation_minimal" rows="2" 
                            title="Message shown to users who score 0-25% - indicates low concern level"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white" 
                            placeholder="Your results indicate minimal concerns in this area.">{{ old('interpretation_minimal', 'Your results indicate minimal concerns in this area. Continue maintaining healthy habits and reach out if things change.') }}</textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mild (26-50%)</label>
                        <textarea name="interpretation_mild" rows="2" 
                            title="Message shown to users who score 26-50% - indicates mild concern level"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white" 
                            placeholder="Your results suggest mild concerns.">{{ old('interpretation_mild', 'Your results suggest mild concerns. Consider implementing some self-care strategies and monitoring your symptoms.') }}</textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Moderate (51-75%)</label>
                        <textarea name="interpretation_moderate" rows="2" 
                            title="Message shown to users who score 51-75% - indicates moderate concern level"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white" 
                            placeholder="Your results indicate moderate concerns.">{{ old('interpretation_moderate', 'Your results indicate moderate concerns. We recommend speaking with a counselor or mental health professional for support.') }}</textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Severe (76-100%)</label>
                        <textarea name="interpretation_severe" rows="2" 
                            title="Message shown to users who score 76-100% - indicates high concern level requiring professional attention"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white" 
                            placeholder="Your results suggest significant concerns.">{{ old('interpretation_severe', 'Your results suggest significant concerns that warrant professional attention. We strongly encourage you to reach out to a mental health professional.') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Questions Section -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Questions</h3>
                    <button type="button" onclick="addQuestion()" 
                        title="Add a new question to this assessment"
                        class="bg-primary text-white px-4 py-2 rounded-lg hover:opacity-90 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-sm">add</span>
                        Add Question
                    </button>
                </div>

                <div id="questionsContainer" class="space-y-4">
                    <!-- Questions will be added here dynamically -->
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 mt-6">
            <button type="submit" 
                title="Save and create this assessment"
                class="bg-primary text-white px-6 py-2 rounded-lg hover:opacity-90 text-center">Create Assessment</button>
            <a href="{{ route('admin.assessments.index') }}" 
                title="Cancel and return to assessments list"
                class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg hover:opacity-90 text-center">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
let questionCount = 0;

function addQuestion() {
    const container = document.getElementById('questionsContainer');
    const questionDiv = document.createElement('div');
    questionDiv.className = 'bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3 sm:p-4 border border-gray-200 dark:border-gray-600';
    questionDiv.id = `question-${questionCount}`;
    
    questionDiv.innerHTML = `
        <div class="flex items-start justify-between mb-3">
            <h4 class="font-medium text-gray-900 dark:text-white text-sm sm:text-base">Question ${questionCount + 1}</h4>
            <button type="button" onclick="removeQuestion(${questionCount})" 
                title="Remove this question"
                class="text-red-600 hover:text-red-800 p-1">
                <span class="material-symbols-outlined text-sm">delete</span>
            </button>
        </div>
        
        <div class="space-y-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question Text *</label>
                <input type="text" name="questions[${questionCount}][text]" required
                    title="Enter the question text that users will see"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white text-sm"
                    placeholder="Enter your question">
            </div>
            
            <div id="options-${questionCount}">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Answer Options *</label>
                    <button type="button" onclick="addOption(${questionCount})" 
                        title="Add a new answer option for this question"
                        class="text-primary hover:text-primary/80 text-sm flex items-center justify-center gap-1 px-3 py-1 bg-primary/10 rounded">
                        <span class="material-symbols-outlined text-sm">add</span>
                        Add Option
                    </button>
                </div>
                <div id="options-container-${questionCount}" class="space-y-2 mb-2">
                    <!-- Options will be added here -->
                </div>
                <textarea name="questions[${questionCount}][options]" id="options-json-${questionCount}" class="hidden" required></textarea>
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
        optionCounters[questionId] = 0;
    }
    
    const container = document.getElementById(`options-container-${questionId}`);
    const optionId = optionCounters[questionId];
    
    const optionDiv = document.createElement('div');
    optionDiv.className = 'flex flex-col sm:flex-row gap-2 items-stretch sm:items-start';
    optionDiv.id = `option-${questionId}-${optionId}`;
    
    optionDiv.innerHTML = `
        <div class="flex-1">
            <input type="text" 
                title="Enter the answer option text that users will see"
                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white text-sm"
                placeholder="Option text (e.g., Not at all)"
                data-question="${questionId}"
                data-option="${optionId}"
                data-field="text"
                onchange="updateOptionsJSON(${questionId})"
                required>
        </div>
        <div class="flex gap-2">
            <div class="flex-1 sm:w-24">
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
                class="text-red-600 hover:text-red-800 p-2 border border-red-300 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                <span class="material-symbols-outlined text-sm">delete</span>
            </button>
        </div>
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

// Add first question on load
document.addEventListener('DOMContentLoaded', function() {
    addQuestion();
    // Add default options to first question
    setTimeout(() => {
        addOption(0);
        addOption(0);
    }, 100);
});
</script>
@endpush
