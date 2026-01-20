@extends('layouts.admin')

@section('title', 'Manage Quizzes - Admin')

@section('content')
<div class="flex flex-wrap justify-between items-center gap-3 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-3xl font-bold tracking-tight">Quizzes</p>
        <p class="text-gray-500 dark:text-gray-400 text-base font-normal">Manage quizzes and assessments</p>
    </div>
    <a href="{{ route('admin.quizzes.create') }}" class="bg-primary text-white text-sm font-medium px-4 py-2 rounded-lg flex items-center gap-2 hover:opacity-90">
        <span class="material-symbols-outlined" style="font-size: 20px;">add</span>
        Create Quiz
    </a>
</div>



<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3">Title</th>
                    <th scope="col" class="px-6 py-3">Category</th>
                    <th scope="col" class="px-6 py-3">Questions</th>
                    <th scope="col" class="px-6 py-3">Difficulty</th>
                    <th scope="col" class="px-6 py-3">Attempts</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Created</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($quizzes as $quiz)
                <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4">
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">{{ Str::limit($quiz->title, 50) }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $quiz->duration_minutes ?? 'No' }} min • {{ $quiz->passing_score }}% to pass</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                            {{ $quiz->category->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-medium text-gray-900 dark:text-white">{{ $quiz->questions_count }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $difficultyColors = [
                                'easy' => 'text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-300',
                                'medium' => 'text-yellow-800 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-300',
                                'hard' => 'text-red-800 bg-red-100 dark:bg-red-900 dark:text-red-300',
                            ];
                        @endphp
                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $difficultyColors[$quiz->difficulty] ?? '' }}">
                            {{ ucfirst($quiz->difficulty) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ number_format($quiz->attempts_count) }}</td>
                    <td class="px-6 py-4">
                        @if($quiz->is_active)
                        <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">
                            Active
                        </span>
                        @else
                        <span class="px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300">
                            Inactive
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $quiz->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                <span class="material-symbols-outlined text-sm">edit</span>
                            </a>
                            <form action="{{ route('admin.quizzes.destroy', $quiz) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this quiz?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-4xl">quiz</span>
                            <p>No quizzes found</p>
                            <a href="{{ route('admin.quizzes.create') }}" class="text-primary hover:underline">Create your first quiz</a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($quizzes->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
        {{ $quizzes->links() }}
    </div>
    @endif
</div>
@endsection
