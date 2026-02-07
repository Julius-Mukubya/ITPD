@extends('layouts.admin')

@section('title', 'Edit Quiz - Admin')

@section('content')
<div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Edit Quiz</h2>
            <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Update quiz information and questions</p>
        </div>
        <a href="{{ route('admin.quizzes.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors text-center">
            Back to Quizzes
        </a>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 sm:p-6">

    <form action="{{ route('admin.quizzes.update', $quiz) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Quiz Title *</label>
                <input type="text" name="title" value="{{ old('title', $quiz->title) }}" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">{{ old('description', $quiz->description) }}</textarea>
                @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category *</label>
                <select name="category_id" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $quiz->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Difficulty *</label>
                <select name="difficulty" required class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    <option value="easy" {{ old('difficulty', $quiz->difficulty) == 'easy' ? 'selected' : '' }}>Easy</option>
                    <option value="medium" {{ old('difficulty', $quiz->difficulty) == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="hard" {{ old('difficulty', $quiz->difficulty) == 'hard' ? 'selected' : '' }}>Hard</option>
                </select>
                @error('difficulty')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Duration (minutes)</label>
                <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $quiz->duration_minutes) }}" min="1"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('duration_minutes')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Passing Score (%) *</label>
                <input type="number" name="passing_score" value="{{ old('passing_score', $quiz->passing_score) }}" required min="0" max="100"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('passing_score')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max Attempts</label>
                <input type="number" name="max_attempts" value="{{ old('max_attempts', $quiz->max_attempts) }}" min="1"
                    placeholder="Unlimited if empty"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('max_attempts')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2 space-y-3">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $quiz->is_active) ? 'checked' : '' }} class="rounded">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Active (visible to students)</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="shuffle_questions" value="1" {{ old('shuffle_questions', $quiz->shuffle_questions) ? 'checked' : '' }} class="rounded">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Shuffle questions order</span>
                </label>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="show_correct_answers" value="1" {{ old('show_correct_answers', $quiz->show_correct_answers) ? 'checked' : '' }} class="rounded">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Show correct answers after completion</span>
                </label>
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:opacity-90">Update Quiz</button>
            <a href="{{ route('admin.quizzes.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg hover:opacity-90">Cancel</a>
        </div>
    </form>

    <!-- Questions Section -->
    @if($quiz->questions->count() > 0)
    <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Questions ({{ $quiz->questions->count() }})</h3>
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:opacity-90 text-sm">
                <span class="material-symbols-outlined text-sm">add</span>
                Add Question
            </button>
        </div>

        <div class="space-y-4">
            @foreach($quiz->questions as $index => $question)
            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="bg-primary text-white text-xs font-bold px-2 py-1 rounded">Q{{ $index + 1 }}</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $question->points }} points</span>
                        </div>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $question->question }}</p>
                    </div>
                    <div class="flex gap-2">
                        <button class="text-blue-600 hover:text-blue-800 dark:text-blue-400">
                            <span class="material-symbols-outlined text-sm">edit</span>
                        </button>
                        <button class="text-red-600 hover:text-red-800 dark:text-red-400">
                            <span class="material-symbols-outlined text-sm">delete</span>
                        </button>
                    </div>
                </div>

                <div class="space-y-2 ml-4">
                    @foreach($question->options as $option)
                    <div class="flex items-center gap-2">
                        @if($option->is_correct)
                        <span class="material-symbols-outlined text-green-500 text-sm">check_circle</span>
                        @else
                        <span class="material-symbols-outlined text-gray-400 text-sm">radio_button_unchecked</span>
                        @endif
                        <span class="text-sm {{ $option->is_correct ? 'text-green-600 dark:text-green-400 font-medium' : 'text-gray-600 dark:text-gray-400' }}">
                            {{ $option->option_text }}
                        </span>
                    </div>
                    @endforeach
                </div>

                @if($question->explanation)
                <div class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded border-l-4 border-blue-500">
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        <strong>Explanation:</strong> {{ $question->explanation }}
                    </p>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
        <div class="text-center py-8">
            <span class="material-symbols-outlined text-4xl text-gray-400 mb-2">quiz</span>
            <p class="text-gray-500 dark:text-gray-400 mb-4">No questions added yet</p>
            <button class="bg-primary text-white px-6 py-2 rounded-lg hover:opacity-90">
                Add First Question
            </button>
        </div>
    </div>
    @endif
</div>
@endsection
