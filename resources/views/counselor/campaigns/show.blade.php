@extends('layouts.counselor')

@section('title', $campaign->title . ' - Counselor')
@section('page-title', 'Campaign Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('counselor.campaigns.index') }}" class="text-primary hover:underline flex items-center gap-1">
        <span class="material-symbols-outlined text-sm">arrow_back</span>
        Back to My Campaigns
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Campaign Details -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            @if($campaign->featured_image)
            <div class="h-64 bg-gray-200 dark:bg-gray-700">
                <img src="{{ asset('storage/' . $campaign->featured_image) }}" alt="{{ $campaign->title }}" class="w-full h-full object-cover">
            </div>
            @endif

            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 text-sm font-medium rounded-full {{ $campaign->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300' }}">
                            {{ $campaign->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        @if($campaign->is_featured)
                        <span class="px-3 py-1 text-sm font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 rounded-full">
                            Featured
                        </span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('counselor.campaigns.edit', $campaign) }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">edit</span>
                            Edit
                        </a>
                    </div>
                </div>

                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">{{ $campaign->title }}</h1>

                @if($campaign->description)
                <p class="text-lg text-gray-600 dark:text-gray-400 mb-6">{{ $campaign->description }}</p>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">event</span>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Start Date</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $campaign->start_date->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">event</span>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">End Date</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $campaign->end_date->format('M d, Y') }}</p>
                        </div>
                    </div>
                    @if($campaign->start_time)
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">schedule</span>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Time</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $campaign->start_time }} - {{ $campaign->end_time }}</p>
                        </div>
                    </div>
                    @endif
                    @if($campaign->location)
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">location_on</span>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Location</p>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $campaign->location }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="prose prose-lg max-w-none dark:prose-invert">
                    {!! nl2br(e($campaign->content)) !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Participants -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined">group</span>
                Participants
            </h3>
            
            <div class="text-center mb-4">
                <div class="text-3xl font-bold text-primary">{{ $campaign->participants->count() }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    @if($campaign->max_participants)
                        of {{ $campaign->max_participants }} registered
                    @else
                        registered
                    @endif
                </div>
            </div>

            @if($campaign->participants->count() > 0)
            <div class="space-y-3 max-h-64 overflow-y-auto">
                @foreach($campaign->participants as $participant)
                <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                    @if($participant->user && $participant->user->avatar)
                        <img src="{{ asset('storage/' . $participant->user->avatar) }}" alt="{{ $participant->user->name }}" class="w-8 h-8 rounded-full object-cover">
                    @else
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full flex items-center justify-center text-xs font-bold text-white">
                            {{ $participant->user ? strtoupper(substr($participant->user->name, 0, 2)) : strtoupper(substr($participant->name ?? 'G', 0, 2)) }}
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                            {{ $participant->user ? $participant->user->name : $participant->name }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            Registered {{ $participant->created_at->format('M d') }}
                        </p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8">
                <span class="material-symbols-outlined text-4xl text-gray-400 mb-2">person_add</span>
                <p class="text-gray-500 dark:text-gray-400">No participants yet</p>
            </div>
            @endif
        </div>

        <!-- Campaign Stats -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined">analytics</span>
                Campaign Stats
            </h3>
            
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Created</span>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $campaign->created_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Last Updated</span>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $campaign->updated_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Status</span>
                    <span class="text-sm font-medium {{ $campaign->is_active ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                        {{ $campaign->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                @if($campaign->max_participants)
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Capacity</span>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ round(($campaign->participants->count() / $campaign->max_participants) * 100) }}%
                    </span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection