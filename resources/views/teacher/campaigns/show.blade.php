@extends('layouts.teacher')

@section('title', $campaign->title)
@section('header', $campaign->title)

@section('content')
<div class="space-y-6">
    <!-- Campaign Header -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start">
            <div class="flex-1">
                @if($campaign->image)
                    <img src="{{ asset('storage/' . $campaign->image) }}" alt="{{ $campaign->title }}" class="w-full h-64 object-cover rounded-lg mb-4">
                @endif
                
                <div class="flex items-center space-x-3 mb-4">
                    <span class="px-3 py-1 rounded-full text-sm {{ $campaign->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $campaign->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    <span class="text-gray-500">{{ $campaign->start_date->format('M d, Y') }} - {{ $campaign->end_date->format('M d, Y') }}</span>
                </div>
                
                <p class="text-gray-700 mb-4">{{ $campaign->description }}</p>
                
                @if($campaign->target_audience)
                    <p class="text-sm text-gray-600"><strong>Target Audience:</strong> {{ $campaign->target_audience }}</p>
                @endif
            </div>
            
            <div class="ml-6 flex space-x-2">
                <a href="{{ route('teacher.campaigns.edit', $campaign) }}" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary/90">
                    Edit
                </a>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Participants</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['total_participants'] }}</p>
                </div>
                <span class="material-symbols-outlined text-primary text-4xl">group</span>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Assessments</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['assessment_attempts'] }}</p>
                </div>
                <span class="material-icons text-purple-500 text-4xl">assignment</span>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Content Views</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['content_views'] }}</p>
                </div>
                <span class="material-icons text-orange-500 text-4xl">visibility</span>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Counseling</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $stats['counseling_sessions'] }}</p>
                </div>
                <span class="material-icons text-green-500 text-4xl">psychology</span>
            </div>
        </div>
    </div>

    <!-- Participants List -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h3 class="text-lg font-semibold">Participants</h3>
            <p class="text-sm text-gray-600">Aggregate data only - individual details are private</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name/Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($campaign->participants as $participant)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $participant->name ?? 'Anonymous' }}
                                </div>
                                <div class="text-sm text-gray-500">{{ $participant->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $participant->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                    Registered
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">No participants yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Campaign Link -->
    <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg p-6">
        <h4 class="font-semibold text-emerald-900 dark:text-emerald-300 mb-2">Share Campaign</h4>
        <p class="text-sm text-emerald-700 dark:text-emerald-400 mb-3">Share this link with students to join the campaign:</p>
        <div class="flex items-center space-x-2">
            <input type="text" readonly value="{{ route('campaigns.show', $campaign) }}" 
                class="flex-1 px-4 py-2 bg-white dark:bg-gray-800 border border-emerald-300 dark:border-emerald-700 rounded text-sm">
            <button onclick="copyLink()" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary/90">
                Copy Link
            </button>
        </div>
    </div>
</div>

<script>
function copyLink() {
    const input = document.querySelector('input[readonly]');
    input.select();
    document.execCommand('copy');
    alert('Link copied to clipboard!');
}
</script>
@endsection
