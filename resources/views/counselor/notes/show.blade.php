@extends('layouts.counselor')

@section('title', 'Session Note Details')

@section('content')
<div class="px-2 sm:px-0">
<!-- Header -->
<div class="flex flex-col gap-4 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-xl sm:text-2xl lg:text-3xl font-bold tracking-tight">Session Note Details</p>
        <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">View detailed information about this session note</p>
    </div>
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:justify-end">
        <a href="{{ route('counselor.notes.edit', $note) }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-sm sm:text-base">
            <span class="material-symbols-outlined text-sm">edit</span>
            <span class="hidden sm:inline">Edit Note</span>
            <span class="sm:hidden">Edit</span>
        </a>
        <a href="{{ route('counselor.notes.index') }}" class="inline-flex items-center justify-center gap-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 font-medium transition-colors text-sm sm:text-base">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            <span class="hidden sm:inline">Back to Notes</span>
            <span class="sm:hidden">Back</span>
        </a>
    </div>
</div>

<!-- Note Details -->
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
    <!-- Note Header -->
    <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
            <div class="flex-1 min-w-0">
                <!-- Title -->
                @if($note->title)
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-2 break-words">{{ $note->title }}</h1>
                @else
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-2">Session Note</h1>
                @endif
                
                <!-- Badges -->
                <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-4">
                    <!-- Note Type Badge -->
                    <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium
                        @if($note->type === 'progress') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                        @elseif($note->type === 'observation') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                        @elseif($note->type === 'reminder') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                        @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300
                        @endif">
                        @if($note->type === 'progress')
                            <span class="material-symbols-outlined text-sm mr-1">trending_up</span>
                        @elseif($note->type === 'observation')
                            <span class="material-symbols-outlined text-sm mr-1">visibility</span>
                        @elseif($note->type === 'reminder')
                            <span class="material-symbols-outlined text-sm mr-1">alarm</span>
                        @else
                            <span class="material-symbols-outlined text-sm mr-1">note</span>
                        @endif
                        <span class="hidden sm:inline">{{ ucfirst($note->type) }} Note</span>
                        <span class="sm:hidden">{{ ucfirst($note->type) }}</span>
                    </span>
                    
                    <!-- Privacy Badge -->
                    @if($note->is_private)
                    <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                        <span class="material-symbols-outlined text-sm mr-1">lock</span>
                        <span class="hidden sm:inline">Private</span>
                        <span class="sm:hidden">Priv</span>
                    </span>
                    @else
                    <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                        <span class="material-symbols-outlined text-sm mr-1">public</span>
                        <span class="hidden sm:inline">Public</span>
                        <span class="sm:hidden">Pub</span>
                    </span>
                    @endif
                </div>
                
                <!-- Meta Information -->
                <div class="grid grid-cols-1 gap-2 sm:gap-4 text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm flex-shrink-0">schedule</span>
                        <span class="break-all">Created: {{ $note->created_at->format('M j, Y \a\t g:i A') }}</span>
                    </div>
                    @if($note->updated_at->ne($note->created_at))
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm flex-shrink-0">update</span>
                        <span class="break-all">Updated: {{ $note->updated_at->format('M j, Y \a\t g:i A') }}</span>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex items-center justify-end lg:justify-start gap-2">
                <form method="POST" action="{{ route('counselor.notes.destroy', $note) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this note? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Session Information -->
    <div class="p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
        <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-3">Related Session</h2>
        <div class="bg-white dark:bg-gray-800 rounded-lg p-3 sm:p-4 border border-gray-200 dark:border-gray-600">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="min-w-0 flex-1">
                    <h3 class="font-medium text-gray-900 dark:text-white text-sm sm:text-base">Session #{{ $note->session->id }}</h3>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 text-xs sm:text-sm text-gray-600 dark:text-gray-400 mt-1">
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm flex-shrink-0">person</span>
                            <span class="truncate">{{ $note->session->student->name }}</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm flex-shrink-0">calendar_today</span>
                            <span>{{ $note->session->created_at->format('M d, Y') }}</span>
                        </span>
                        <span class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm flex-shrink-0">psychology</span>
                            <span class="truncate">{{ ucfirst(str_replace('_', ' ', $note->session->session_type)) }}</span>
                        </span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            @if($note->session->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                            @elseif($note->session->status === 'active') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                            @else bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                            @endif">
                            {{ ucfirst($note->session->status) }}
                        </span>
                    </div>
                </div>
                <a href="{{ route('counselor.sessions.show', $note->session) }}" class="text-emerald-600 hover:text-emerald-700 font-medium text-xs sm:text-sm whitespace-nowrap">
                    <span class="hidden sm:inline">View Session →</span>
                    <span class="sm:hidden">View →</span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Note Content -->
    <div class="p-4 sm:p-6">
        <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-4">Note Content</h2>
        <div class="prose prose-sm sm:prose prose-gray dark:prose-invert max-w-none">
            <div class="whitespace-pre-wrap text-gray-700 dark:text-gray-300 leading-relaxed text-sm sm:text-base break-words">{{ $note->content }}</div>
        </div>
    </div>
</div>

<!-- Related Notes -->
@php
    $relatedNotes = \App\Models\SessionNote::where('session_id', $note->session_id)
        ->where('id', '!=', $note->id)
        ->where('counselor_id', auth()->id())
        ->latest()
        ->limit(5)
        ->get();
@endphp

@if($relatedNotes->count() > 0)
<div class="mt-6 sm:mt-8">
    <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-emerald-600">note</span>
        <span class="hidden sm:inline">Other Notes from This Session</span>
        <span class="sm:hidden">Related Notes</span>
    </h2>
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($relatedNotes as $relatedNote)
            <div class="p-3 sm:p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                    <div class="flex-1 min-w-0">
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                @if($relatedNote->type === 'progress') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                @elseif($relatedNote->type === 'observation') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                                @elseif($relatedNote->type === 'reminder') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                                @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300
                                @endif">
                                {{ ucfirst($relatedNote->type) }}
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $relatedNote->created_at->format('M d, Y \a\t g:i A') }}
                            </span>
                        </div>
                        @if($relatedNote->title)
                        <h4 class="font-medium text-gray-900 dark:text-white mb-1 text-sm sm:text-base break-words">{{ $relatedNote->title }}</h4>
                        @endif
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 line-clamp-2 break-words">{{ Str::limit($relatedNote->content, 150) }}</p>
                    </div>
                    <a href="{{ route('counselor.notes.show', $relatedNote) }}" class="text-emerald-600 hover:text-emerald-700 p-2 rounded-lg hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors flex-shrink-0">
                        <span class="material-symbols-outlined text-sm">visibility</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
</div>
@endsection