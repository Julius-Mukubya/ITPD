@extends('layouts.counselor')

@section('title', 'My Campaigns - Counselor')
@section('page-title', 'My Campaigns')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Campaigns</h1>
        <p class="text-gray-600 dark:text-gray-400">Manage your awareness campaigns and events</p>
    </div>
    <a href="{{ route('counselor.campaigns.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-2">
        <span class="material-symbols-outlined">add</span>
        Create Campaign
    </a>
</div>



<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    @if($campaigns->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Campaign</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Schedule</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Participants</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Created</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($campaigns as $campaign)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            @if($campaign->featured_image)
                            <img src="{{ asset('storage/' . $campaign->featured_image) }}" alt="" class="w-10 h-10 rounded-lg object-cover mr-3">
                            @else
                            <div class="w-10 h-10 bg-gray-200 dark:bg-gray-600 rounded-lg flex items-center justify-center mr-3">
                                <span class="material-symbols-outlined text-gray-400">campaign</span>
                            </div>
                            @endif
                            <div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $campaign->title }}</div>
                                @if($campaign->description)
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($campaign->description, 50) }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 dark:text-white">
                            {{ $campaign->start_date->format('M d, Y') }}
                            @if($campaign->start_time)
                                <br><span class="text-xs text-gray-500 dark:text-gray-400">{{ $campaign->start_time }} - {{ $campaign->end_time }}</span>
                            @endif
                        </div>
                        @if($campaign->location)
                        <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-1">
                            <span class="material-symbols-outlined text-xs">location_on</span>
                            {{ Str::limit($campaign->location, 20) }}
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $campaign->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300' }}">
                                {{ $campaign->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            @if($campaign->is_featured)
                            <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 rounded-full">
                                Featured
                            </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                        <div class="flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">group</span>
                            {{ $campaign->participants->count() }}
                            @if($campaign->max_participants)
                                / {{ $campaign->max_participants }}
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                        {{ $campaign->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('counselor.campaigns.show', $campaign) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="View">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                            </a>
                            <a href="{{ route('counselor.campaigns.edit', $campaign) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300" title="Edit">
                                <span class="material-symbols-outlined text-sm">edit</span>
                            </a>
                            <form action="{{ route('counselor.campaigns.destroy', $campaign) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this campaign?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Delete">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($campaigns->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
        {{ $campaigns->links() }}
    </div>
    @endif
    @else
    <div class="text-center py-12">
        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
            <span class="material-symbols-outlined text-3xl text-gray-400">campaign</span>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No campaigns yet</h3>
        <p class="text-gray-500 dark:text-gray-400 mb-6">Start creating awareness campaigns and events for students.</p>
        <a href="{{ route('counselor.campaigns.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors inline-flex items-center gap-2">
            <span class="material-symbols-outlined">add</span>
            Create Your First Campaign
        </a>
    </div>
    @endif
</div>
@endsection