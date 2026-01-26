@extends('layouts.admin')

@section('title', 'Manage Assessments')
@section('page-title', 'Assessments')

@section('content')
<div class="flex flex-wrap justify-between items-center gap-3 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-3xl font-bold tracking-tight">Wellness Assessments</p>
        <p class="text-gray-500 dark:text-gray-400 text-base font-normal">Monitor self-evaluation tools and user engagement</p>
    </div>
    <a href="{{ route('admin.assessments.create') }}" class="bg-primary text-white text-sm font-medium px-4 py-2 rounded-lg flex items-center gap-2 hover:opacity-90">
        <span class="material-symbols-outlined" style="font-size: 20px;">add</span>
        Create Assessment
    </a>
</div>



<!-- Summary Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Total Assessments</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $assessments->total() }}</p>
            </div>
            <span class="material-symbols-outlined text-primary text-3xl">psychology</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Total Attempts</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $assessments->sum('attempts_count') }}</p>
            </div>
            <span class="material-symbols-outlined text-blue-500 text-3xl">assignment</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Avg per Assessment</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $assessments->count() > 0 ? round($assessments->sum('attempts_count') / $assessments->count()) : 0 }}</p>
            </div>
            <span class="material-symbols-outlined text-green-500 text-3xl">trending_up</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Most Popular</p>
                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $assessments->sortByDesc('attempts_count')->first()->full_name ?? $assessments->sortByDesc('attempts_count')->first()->name ?? 'N/A' }}</p>
            </div>
            <span class="material-symbols-outlined text-purple-500 text-3xl">star</span>
        </div>
    </div>
</div>

<!-- Assessments Table -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3">Assessment</th>
                    <th scope="col" class="px-6 py-3">Type</th>
                    <th scope="col" class="px-6 py-3">Questions</th>
                    <th scope="col" class="px-6 py-3">Attempts</th>
                    <th scope="col" class="px-6 py-3">Created</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assessments as $assessment)
                <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary">psychology</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $assessment->full_name ?? $assessment->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit($assessment->description, 50) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                            {{ ucfirst(str_replace('_', ' ', $assessment->type)) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $assessment->questions()->count() }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($assessment->attempts_count) }}</span>
                            @if($assessment->attempts_count > 0)
                            <span class="material-symbols-outlined text-green-500 text-sm">trending_up</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ $assessment->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.assessments.show', $assessment) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400" title="View Details">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                            </a>
                            <a href="{{ route('admin.assessments.edit', $assessment) }}" class="text-green-600 hover:text-green-800 dark:text-green-400" title="Edit">
                                <span class="material-symbols-outlined text-sm">edit</span>
                            </a>
                            <form action="{{ route('admin.assessments.destroy', $assessment) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="showDeleteModal(this.closest('form'), 'Are you sure you want to delete this assessment? This will delete the assessment and all its questions.')" class="text-red-600 hover:text-red-800 dark:text-red-400" title="Delete">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-4xl">psychology</span>
                            <p>No assessments found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($assessments->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
        {{ $assessments->links() }}
    </div>
    @endif
</div>
@endsection
