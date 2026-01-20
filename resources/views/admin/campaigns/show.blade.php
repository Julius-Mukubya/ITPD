@extends(auth()->user()->role === 'counselor' ? 'layouts.counselor' : 'layouts.admin')

@section('title', 'Campaign Details')
@section('page-title', 'Campaign Details')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Campaign Details</h2>
            <p class="text-gray-600 dark:text-gray-400">View campaign information and participants</p>
        </div>
        <a href="{{ route('admin.campaigns.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
            Back to Campaigns
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Campaign Header -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            @if($campaign->banner_image)
                <div class="h-64 bg-cover bg-center" style="background-image: url('{{ $campaign->banner_url }}')">
                    <div class="h-full bg-black bg-opacity-40 flex items-end p-6">
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">{{ $campaign->title }}</h1>
                            <p class="text-gray-200">{{ $campaign->description }}</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="p-6">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $campaign->title }}</h1>
                    <p class="text-gray-600 dark:text-gray-400">{{ $campaign->description }}</p>
                </div>
            @endif
        </div>

        <!-- Campaign Content -->
        @if($campaign->content)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Campaign Details</h2>
            <div class="prose dark:prose-invert max-w-none">
                {!! nl2br(e($campaign->content)) !!}
            </div>
        </div>
        @endif

        <!-- Participants -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Participants</h2>
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    {{ $campaign->participants->count() }} 
                    @if($campaign->max_participants)
                        / {{ $campaign->max_participants }}
                    @endif
                    registered
                </span>
            </div>
            
            @if($campaign->participants->count() > 0)
                <div class="space-y-3">
                    @foreach($campaign->participants->take(10) as $participant)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-semibold">
                                {{ substr($participant->display_name ?? 'U', 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900 dark:text-white">
                                    {{ $participant->display_name ?? 'Unknown User' }}
                                    @if($participant->is_guest_registration)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 ml-2">
                                            Guest
                                        </span>
                                    @endif
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    @if($participant->is_guest_registration)
                                        {{ $participant->guest_email }}
                                    @else
                                        {{ $participant->user->email ?? 'No email' }}
                                    @endif
                                </div>
                                <div class="text-xs text-gray-400 dark:text-gray-500">
                                    Registered {{ $participant->created_at->format('M d, Y') }}
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($participant->status === 'registered') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                                @elseif($participant->status === 'attended') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                                @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300
                                @endif">
                                {{ ucfirst($participant->status) }}
                            </span>
                        </div>
                    @endforeach
                    
                    @if($campaign->participants->count() > 10)
                        <div class="text-center py-3">
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                And {{ $campaign->participants->count() - 10 }} more participants...
                            </span>
                        </div>
                    @endif
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-2xl text-gray-400">group</span>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">No participants yet</h3>
                    <p class="text-gray-500 dark:text-gray-400">Participants will appear here once they register.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Campaign Info -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Campaign Information</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Type</label>
                    <div class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($campaign->type === 'awareness') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                            @elseif($campaign->type === 'workshop') bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300
                            @elseif($campaign->type === 'webinar') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                            @else bg-orange-100 text-orange-800 dark:bg-orange-900/30 dark:text-orange-300
                            @endif">
                            {{ ucfirst($campaign->type) }}
                        </span>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                    <div class="mt-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($campaign->status === 'active') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                            @elseif($campaign->status === 'draft') bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300
                            @elseif($campaign->status === 'completed') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                            @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300
                            @endif">
                            {{ ucfirst($campaign->status) }}
                        </span>
                    </div>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Duration</label>
                    <div class="mt-1 text-sm text-gray-900 dark:text-white">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm text-gray-400">event</span>
                            <span>{{ $campaign->start_date->format('M d, Y') }} - {{ $campaign->end_date->format('M d, Y') }}</span>
                        </div>
                        @if($campaign->start_time || $campaign->end_time)
                        <div class="flex items-center gap-2 mt-1">
                            <span class="material-symbols-outlined text-sm text-gray-400">schedule</span>
                            <span>
                                @if($campaign->start_time)
                                    {{ \Carbon\Carbon::parse($campaign->start_time)->format('g:i A') }}
                                @else
                                    All day
                                @endif
                                @if($campaign->end_time)
                                    - {{ \Carbon\Carbon::parse($campaign->end_time)->format('g:i A') }}
                                @endif
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                @if($campaign->location)
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Location</label>
                    <div class="mt-1 text-sm text-gray-900 dark:text-white">{{ $campaign->location }}</div>
                </div>
                @endif

                @if($campaign->max_participants)
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Max Participants</label>
                    <div class="mt-1 text-sm text-gray-900 dark:text-white">{{ $campaign->max_participants }}</div>
                </div>
                @endif

                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Created By</label>
                    <div class="mt-1 text-sm text-gray-900 dark:text-white">{{ $campaign->creator->name ?? 'Unknown' }}</div>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</label>
                    <div class="mt-1 text-sm text-gray-900 dark:text-white">{{ $campaign->created_at->format('M d, Y g:i A') }}</div>
                </div>

                @if($campaign->is_featured)
                <div>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">
                        <span class="material-symbols-outlined !text-xs">star</span>
                        Featured
                    </span>
                </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Actions</h3>
            
            <div class="space-y-3">
                <a href="{{ route('admin.campaigns.edit', $campaign) }}" class="w-full bg-primary text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 hover:opacity-90">
                    <span class="material-symbols-outlined text-sm">edit</span>
                    Edit Campaign
                </a>
                
                <form action="{{ route('admin.campaigns.destroy', $campaign) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this campaign? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 hover:bg-red-700">
                        <span class="material-symbols-outlined text-sm">delete</span>
                        Delete Campaign
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection