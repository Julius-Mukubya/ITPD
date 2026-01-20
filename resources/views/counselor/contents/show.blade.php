@extends('layouts.counselor')

@section('title', $content->title . ' - Counselor')
@section('page-title', 'View Resource')

@section('content')
<div class="mb-6">
    <a href="{{ route('counselor.contents.index') }}" class="text-primary hover:underline flex items-center gap-1">
        <span class="material-symbols-outlined text-sm">arrow_back</span>
        Back to My Resources
    </a>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    @if($content->featured_image)
    <div class="h-64 bg-gray-200 dark:bg-gray-700">
        <img src="{{ asset('storage/' . $content->featured_image) }}" alt="{{ $content->title }}" class="w-full h-full object-cover">
    </div>
    @endif

    <div class="p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 rounded-full">
                    {{ $content->category->name ?? 'Uncategorized' }}
                </span>
                <span class="px-3 py-1 text-sm font-medium rounded-full {{ $content->is_published ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300' }}">
                    {{ $content->is_published ? 'Published' : 'Draft' }}
                </span>
                @if($content->is_featured)
                <span class="px-3 py-1 text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 rounded-full">
                    Featured
                </span>
                @endif
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('counselor.contents.edit', $content) }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">edit</span>
                    Edit
                </a>
            </div>
        </div>

        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $content->title }}</h1>

        @if($content->description)
        <p class="text-lg text-gray-600 dark:text-gray-400 mb-6">{{ $content->description }}</p>
        @endif

        <div class="flex items-center gap-6 text-sm text-gray-500 dark:text-gray-400 mb-8 pb-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">visibility</span>
                {{ number_format($content->views) }} views
            </div>
            <div class="flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">schedule</span>
                Created {{ $content->created_at->format('M d, Y') }}
            </div>
            @if($content->reading_time)
            <div class="flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">schedule</span>
                {{ $content->reading_time }} min read
            </div>
            @endif
        </div>

        <div class="prose prose-lg max-w-none dark:prose-invert">
            {!! $content->content !!}
        </div>
    </div>
</div>
@endsection