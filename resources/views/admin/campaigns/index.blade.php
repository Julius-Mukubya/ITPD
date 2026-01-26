@extends(auth()->user()->role === 'counselor' ? 'layouts.counselor' : 'layouts.admin')

@section('title', 'Manage Campaigns')
@section('page-title', 'Campaigns & Events')

@section('content')


<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Campaigns</h2>
        <p class="text-gray-500 dark:text-gray-400">Manage awareness campaigns</p>
    </div>
    <a href="{{ route('admin.campaigns.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:opacity-90">
        <span class="material-symbols-outlined text-sm">add</span>
        Create Campaign
    </a>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Title</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Type</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Duration</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Participants</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($campaigns as $campaign)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        @if($campaign->banner_image)
                            <img src="{{ $campaign->banner_url }}" alt="{{ $campaign->title }}" class="w-10 h-10 rounded-lg object-cover">
                        @else
                            <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary text-sm">campaign</span>
                            </div>
                        @endif
                        <div>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $campaign->title }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($campaign->description, 50) }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @if($campaign->type === 'awareness') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                        @elseif($campaign->type === 'workshop') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300
                        @elseif($campaign->type === 'webinar') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                        @else bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300
                        @endif">
                        {{ ucfirst($campaign->type) }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                    <div class="flex items-center gap-1">
                        <span>{{ $campaign->start_date->format('M d, Y') }}</span>
                        @if($campaign->start_time)
                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ \Carbon\Carbon::parse($campaign->start_time)->format('g:i A') }}</span>
                        @endif
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                        <span>to {{ $campaign->end_date->format('M d, Y') }}</span>
                        @if($campaign->end_time)
                            <span>{{ \Carbon\Carbon::parse($campaign->end_time)->format('g:i A') }}</span>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                    <div class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm text-gray-400">group</span>
                        <span>{{ $campaign->participants_count ?? 0 }}</span>
                        @if($campaign->max_participants)
                            <span class="text-gray-400">/ {{ $campaign->max_participants }}</span>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @if($campaign->status === 'active') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                        @elseif($campaign->status === 'draft') bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300
                        @elseif($campaign->status === 'completed') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                        @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                        @endif">
                        {{ ucfirst($campaign->status) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.campaigns.show', $campaign) }}" class="text-primary hover:text-primary/80 p-1 rounded">
                            <span class="material-symbols-outlined text-sm">visibility</span>
                        </a>
                        <a href="{{ route('admin.campaigns.edit', $campaign) }}" class="text-blue-600 hover:text-blue-800 p-1 rounded">
                            <span class="material-symbols-outlined text-sm">edit</span>
                        </a>
                        <form action="{{ route('admin.campaigns.destroy', $campaign) }}" method="POST" class="inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="showDeleteModal(this.closest('form'), 'Are you sure you want to delete this campaign? This action cannot be undone.')" class="text-red-600 hover:text-red-800 p-1 rounded">
                                <span class="material-symbols-outlined text-sm">delete</span>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center">
                    <div class="flex flex-col items-center gap-4">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                            <span class="material-symbols-outlined text-2xl text-gray-400">campaign</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">No campaigns yet</h3>
                            <p class="text-gray-500 dark:text-gray-400">Create your first campaign to get started.</p>
                        </div>
                        <a href="{{ route('admin.campaigns.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:opacity-90">
                            <span class="material-symbols-outlined text-sm">add</span>
                            Create Campaign
                        </a>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
