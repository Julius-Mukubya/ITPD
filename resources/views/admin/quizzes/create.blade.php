@extends('layouts.admin')

@section('title', 'Create Quiz - Admin')

@section('content')
<div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Create Quiz</h2>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Add new quiz to the system</p>
        </div>
        <a href="{{ route('admin.quizzes.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors text-center">
            Back to Quizzes
        </a>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 sm:p-6">

    <form action="{{ route('admin.quizzes.store') }}" method="POST" id="quizForm">
        @csrf

        <!-- Quiz Settings -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quiz Settings</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Quiz Title *</label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">{{ old('description') }}</textarea>
                    @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category *</label>
                    <select name="category_id" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Difficulty *</label>
                    <select name="difficulty" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                        <option value="easy" {{ old('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                        <option value="medium" {{ old('difficulty') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="hard" {{ old('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                    </select>
                    @error('difficulty')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Duration (minutes)</label>
                    <input type="number" name="duration_minutes" value="{{ old('duration_minutes') }}" min="1"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    @error('duration_minutes')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Passing Score (%) *</label>
                    <input type="number" name="passing_score" value="{{ old('passing_score', 70) }}" required min="0" max="100"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    @error('passing_score')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max Attempts</label>
                    <input type="number" name="max_attempts" value="{{ old('max_attempts') }}" min="1"
                        placeholder="Unlimited if empty"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    @error('max_attempts')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2 space-y-3">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Active (visible to students)</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="shuffle_questions" value="1" {{ old('shuffle_questions') ? 'checked' : '' }} class="rounded">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Shuffle questions order</span>
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="show_correct_answers" value="1" {{ old('show_correct_answers', true) ? 'checked' : '' }} class="rounded">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Show correct answers after completion</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Questions Section -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Questions *</h3>
                <button type="button" onclick="addQuestion()" class="bg-primary text-white px-4 py-2 rounded-lg hover:opacity-90 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">add</span>
                    Add Question
                </button>
            </div>

            <div id="questionsContainer" class="space-y-6">
                <!-- Questions will be added here dynamically -->
            </div>

            <div id="emptyState" class="text-center py-8 bg-gray-50 dark:bg-gray-900 rounded-lg">
                <span class="material-symbols-outlined text-4xl text-gray-400 mb-2">quiz</span>
                <p class="text-gray-500 dark:text-gray-400 mb-4">No questions added yet</p>
                <button type="button" onclick="addQuestion()" class="bg-primary text-white px-6 py-2 rounded-lg hover:opacity-90">
                    Add First Question
                </button>
            </div>
        </div>

        <div class="flex gap-3 mt-8">
            <button type="submit" class="bg-primary text-white px-8 py-3 rounded-lg hover:opacity-90 font-semibold">Create Quiz</button>
            <a href="{{ route('admin.quizzes.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-8 py-3 rounded-lg hover:opacity-90 font-semibold">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
let questionCount = 0;

function addQuestion() {
    questionCount++;
    const container = document.getElementById('questionsContainer');
    const emptyState = document.getElementById('emptyState');
    
    emptyState.style.display = 'none';
    
    const questionHtml = `
        <div class="question-item bg-gray-50 dark:bg-gray-900 rounded-lg p-6 border-2 border-gray-200 dark:border-gray-700" data-question="${questionCount}">
            <div class="flex justify-between items-start mb-4">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white">Question ${questionCount}</h4>
                <button type="button" onclick="removeQuestion(${questionCount})" class="text-red-600 hover:text-red-800 dark:text-red-400">
                    <span class="material-symbols-outlined">delete</span>
                </button>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Question Text *</label>
                    <textarea name="questions[${questionCount}][question]" rows="3" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white"></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Points *</label>
                        <input type="number" name="questions[${questionCount}][points]" value="1" min="1" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Explanation (optional)</label>
                    <textarea name="questions[${questionCount}][explanation]" rows="2"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white"></textarea>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Answer Options *</label>
                        <button type="button" onclick="addOption(${questionCount})" class="text-primary hover:underline text-sm flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">add</span>
                            Add Option
                        </button>
                    </div>
                    <div id="options-${questionCount}" class="space-y-3">
                        ${createOption(questionCount, 0)}
                        ${createOption(questionCount, 1)}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', questionHtml);
}

function createOption(questionIndex, optionIndex) {
    return `
        <div class="flex gap-3 items-start option-item" data-option="${optionIndex}">
            <div class="flex-1">
                <input type="text" name="questions[${questionIndex}][options][${optionIndex}][text]" 
                    placeholder="Option ${optionIndex + 1}" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
            </div>
            <label class="flex items-center gap-2 pt-2">
                <input type="radio" name="questions[${questionIndex}][correct]" value="${optionIndex}" required class="w-4 h-4">
                <span class="text-sm text-gray-600 dark:text-gray-400">Correct</span>
            </label>
            ${optionIndex > 1 ? `
            <button type="button" onclick="removeOption(this)" class="text-red-600 hover:text-red-800 pt-2">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
            ` : ''}
        </div>
    `;
}

function addOption(questionIndex) {
    const container = document.getElementById(`options-${questionIndex}`);
    const optionCount = container.querySelectorAll('.option-item').length;
    container.insertAdjacentHTML('beforeend', createOption(questionIndex, optionCount));
}

function removeOption(button) {
    button.closest('.option-item').remove();
}

function removeQuestion(questionIndex) {
    const question = document.querySelector(`[data-question="${questionIndex}"]`);
    question.remove();
    
    const container = document.getElementById('questionsContainer');
    const emptyState = document.getElementById('emptyState');
    
    if (container.children.length === 0) {
        emptyState.style.display = 'block';
    }
    
    // Renumber remaining questions
    const questions = container.querySelectorAll('.question-item');
    questions.forEach((q, index) => {
        q.querySelector('h4').textContent = `Question ${index + 1}`;
    });
}

// Form submission handler to convert correct answer radio to boolean
document.getElementById('quizForm').addEventListener('submit', function(e) {
    const questions = document.querySelectorAll('.question-item');
    
    questions.forEach((question, qIndex) => {
        const correctRadio = question.querySelector('input[type="radio"]:checked');
        if (correctRadio) {
            const correctIndex = correctRadio.value;
            const options = question.querySelectorAll('.option-item');
            
            options.forEach((option, oIndex) => {
                const isCorrect = oIndex == correctIndex;
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = option.querySelector('input[type="text"]').name.replace('[text]', '[is_correct]');
                input.value = isCorrect ? '1' : '0';
                option.appendChild(input);
            });
        }
    });
});

// Add first question on page load
window.addEventListener('DOMContentLoaded', function() {
    addQuestion();
});
</script>
@endpush
