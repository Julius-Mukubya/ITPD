@extends('layouts.teacher')

@section('title', 'My Campaigns')
@section('header', 'My Campaigns')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <p class="text-gray-600 dark:text-gray-400">Manage your educational campaigns</p>
        <a href="{{ route('teacher.campaigns.create') }}" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/90 flex items-center">
            <span class="material-symbols-outlined mr-2">add</span>
            Create Campaign
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($campaigns as $campaign)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-lg transition">
                @if($campaign->image)
                    <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" class="w-full h-48 object-cover rounded-t-lg">
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-primary to-emerald-600 rounded-t-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-white text-6xl">campaign</span>
                    </div>
                @endif
                
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $campaign->title }}</h3>
                        <span class="px-2 py-1 rounded-full text-xs {{ $campaign->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400' }}">
                            {{ $campaign->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">{{ Str::limit($campaign->description, 100) }}</p>
                    
                    <div class="space-y-2 text-sm text-gray-500 dark:text-gray-400 mb-4">
                        <div class="flex items-center">
                            <span class="material-symbols-outlined text-sm mr-2">group</span>
                            {{ $campaign->participants_count }} participants
                        </div>
                        <div class="flex items-center">
                            <span class="material-symbols-outlined text-sm mr-2">calendar_today</span>
                            {{ $campaign->start_date->format('M d') }} - {{ $campaign->end_date->format('M d, Y') }}
                        </div>
                    </div>
                    
                    <div class="flex space-x-2">
                        <a href="{{ route('teacher.campaigns.show', $campaign) }}" class="flex-1 bg-primary text-white text-center py-2 rounded hover:bg-primary/90">
                            View Details
                        </a>
                        <a href="{{ route('teacher.campaigns.edit', $campaign) }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded hover:bg-gray-300 dark:hover:bg-gray-600">
                            <span class="material-symbols-outlined text-sm">edit</span>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 bg-white dark:bg-gray-800 rounded-lg shadow p-12 text-center">
                <span class="material-symbols-outlined text-gray-400 text-6xl mb-4">campaign</span>
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">No Campaigns Yet</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Create your first campaign to start engaging with students</p>
                <a href="{{ route('teacher.campaigns.create') }}" class="inline-flex items-center bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary/90">
                    <span class="material-symbols-outlined mr-2">add</span>
                    Create Your First Campaign
                </a>
            </div>
        @endforelse
    </div>

    @if($campaigns->hasPages())
        <div class="mt-6">
            {{ $campaigns->links() }}
        </div>
    @endif
</div>
@endsection
