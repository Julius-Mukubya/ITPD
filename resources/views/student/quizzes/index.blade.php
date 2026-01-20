@extends('layouts.student')

@section('title', 'Quizzes - Student')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Available Quizzes</h2>
    <p class="text-gray-500 dark:text-gray-400">Test your knowledge and track your progress</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 text-center">
        <span class="material-symbols-outlined text-4xl text-gray-400 mb-4">quiz</span>
        <p class="text-gray-500 dark:text-gray-400">No quizzes available yet</p>
    </div>
</div>
@endsection
