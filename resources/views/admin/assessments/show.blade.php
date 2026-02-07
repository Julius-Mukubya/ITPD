@extends('layouts.admin')

@section('title', $assessment->title . ' - Assessment Details')
@section('page-title', 'Assessment Details')

@section('content')
<div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Assessment Details</h2>
            <p class="text-gray-600 dark:text-gray-400">View assessment information and questions</p>
        </div>
        <a href="{{ route('admin.assessments.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors text-center">
            Back to Assessments
        </a>
    </div>
</div>

<!-- Assessment Header -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 sm:p-6 mb-6">
    <div class="flex flex-col sm:flex-row items-start gap-4">
        <div class="w-16 h-16 rounded-xl bg-primary/10 flex items-center justify-center flex-shrink-0 mx-auto sm:mx-0">
            <span class="material-symbols-outlined text-primary text-3xl">psychology</span>
        </div>
        <div class="flex-1 text-center sm:text-left">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $assessment->full_name ?? $assessment->name }}</h1>
            <p class="text-gray-600 dark:text-gray-400 mb-3">{{ $assessment->description }}</p>
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3 text-sm">
                <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-full font-medium">
                    {{ strtoupper($assessment->type) }}
                </span>
                <span class="text-gray-500 dark:text-gray-400">
                    {{ $assessment->questions()->count() }} questions
                </span>
                <span class="text-gray-500 dark:text-gray-400">
                    Created {{ $assessment->created_at->format('M d, Y') }}
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-3 sm:p-4">
        <div class="flex flex-col sm:flex-row items-center sm:justify-between gap-2">
            <div class="text-center sm:text-left">
                <p class="text-gray-600 dark:text-gray-400 text-xs sm:text-sm">Total Attempts</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_attempts']) }}</p>
            </div>
            <span class="material-symbols-outlined text-primary text-2xl sm:text-3xl">assignment</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-3 sm:p-4">
        <div class="flex flex-col sm:flex-row items-center sm:justify-between gap-2">
            <div class="text-center sm:text-left">
                <p class="text-gray-600 dark:text-gray-400 text-xs sm:text-sm">This Week</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['this_week']) }}</p>
            </div>
            <span class="material-symbols-outlined text-blue-500 text-2xl sm:text-3xl">calendar_today</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-3 sm:p-4">
        <div class="flex flex-col sm:flex-row items-center sm:justify-between gap-2">
            <div class="text-center sm:text-left">
                <p class="text-gray-600 dark:text-gray-400 text-xs sm:text-sm">This Month</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['this_month']) }}</p>
            </div>
            <span class="material-symbols-outlined text-green-500 text-2xl sm:text-3xl">trending_up</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-3 sm:p-4">
        <div class="flex flex-col sm:flex-row items-center sm:justify-between gap-2">
            <div class="text-center sm:text-left">
                <p class="text-gray-600 dark:text-gray-400 text-xs sm:text-sm">Unique Users</p>
                <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['unique_users']) }}</p>
            </div>
            <span class="material-symbols-outlined text-purple-500 text-2xl sm:text-3xl">people</span>
        </div>
    </div>
</div>

<!-- Questions -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 mb-6">
    <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Assessment Questions</h2>
    </div>
    <div class="p-4 sm:p-6">
        <div class="space-y-4">
            @foreach($assessment->questions as $index => $question)
            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3 sm:p-4 border border-gray-200 dark:border-gray-600">
                <div class="flex items-start justify-between mb-3">
                    <h4 class="font-medium text-gray-900 dark:text-white">Question {{ $index + 1 }}</h4>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Order: {{ $question->order }}</span>
                </div>
                
                <p class="text-sm sm:text-base text-gray-700 dark:text-gray-300 mb-3">{{ $question->question }}</p>
                
                <div class="bg-white dark:bg-gray-800 rounded p-3 border border-gray-200 dark:border-gray-600">
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400 mb-2">Answer Options:</p>
                    @php
                        $options = is_string($question->options) ? json_decode($question->options, true) : $question->options;
                    @endphp
                    @if(is_array($options) && !empty($options))
                        <ul class="space-y-1">
                            @foreach($options as $option)
                                @if(is_array($option) && isset($option['text']))
                                    <li class="text-xs sm:text-sm text-gray-700 dark:text-gray-300">
                                        <span class="font-medium">{{ $option['text'] }}</span>
                                        <span class="text-gray-500 dark:text-gray-400">(Score: {{ $option['score'] ?? 0 }})</span>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">No options defined</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Recent Attempts -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
    <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Attempts</h2>
    </div>
    
    <!-- Desktop Table View -->
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3">User</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Date</th>
                    <th scope="col" class="px-6 py-3">Time Taken</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentAttempts as $attempt)
                <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                        {{ $attempt->user->name }}
                    </td>
                    <td class="px-6 py-4">{{ $attempt->user->email }}</td>
                    <td class="px-6 py-4">{{ $attempt->created_at->format('M d, Y H:i') }}</td>
                    <td class="px-6 py-4">
                        @if($attempt->completed_at)
                            {{ $attempt->created_at->diffInMinutes($attempt->completed_at) }} min
                        @else
                            <span class="text-gray-400">In progress</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($attempt->completed_at)
                            <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">
                                Completed
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-900 dark:text-yellow-300">
                                In Progress
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        No attempts yet
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Mobile Card View -->
    <div class="md:hidden divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($recentAttempts as $attempt)
        <div class="p-4">
            <div class="flex items-start gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-primary text-sm">person</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-900 dark:text-white">{{ $attempt->user->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $attempt->user->email }}</p>
                </div>
            </div>
            
            <div class="space-y-2 text-sm">
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Date:</span>
                    <span class="text-gray-900 dark:text-white">{{ $attempt->created_at->format('M d, Y H:i') }}</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Time Taken:</span>
                    <span class="text-gray-900 dark:text-white">
                        @if($attempt->completed_at)
                            {{ $attempt->created_at->diffInMinutes($attempt->completed_at) }} min
                        @else
                            <span class="text-gray-400">In progress</span>
                        @endif
                    </span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Status:</span>
                    @if($attempt->completed_at)
                        <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">
                            Completed
                        </span>
                    @else
                        <span class="px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-100 rounded-full dark:bg-yellow-900 dark:text-yellow-300">
                            In Progress
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
            No attempts yet
        </div>
        @endforelse
    </div>
</div>
@endsection
