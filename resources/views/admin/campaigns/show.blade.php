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

        <!-- Campaign Overview -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Campaign Overview</h2>
            
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Duration</label>
                    <div class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $campaign->start_date && $campaign->end_date ? $campaign->start_date->diffInDays($campaign->end_date) : 0 }} days
                    </div>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Campaign Type</label>
                    <div class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ ucfirst($campaign->type ?? 'General') }}
                    </div>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Current Status</label>
                    <div class="mt-1 text-sm text-gray-900 dark:text-white">
                        @if($campaign->start_date && $campaign->end_date)
                            @if(now()->between($campaign->start_date, $campaign->end_date))
                                Active
                            @elseif(now()->lt($campaign->start_date))
                                Upcoming
                            @else
                                Completed
                            @endif
                        @else
                            {{ ucfirst($campaign->status) }}
                        @endif
                    </div>
                </div>
                
                <div>
                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</label>
                    <div class="mt-1 text-sm text-gray-900 dark:text-white">
                        {{ $campaign->created_at->format('M Y') }}
                    </div>
                </div>
            </div>
            
            <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <span class="material-symbols-outlined text-lg text-primary">info</span>
                    <span>This is an informational campaign. Interested parties can contact the organizers using the contact information provided.</span>
                </div>
            </div>
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

        <!-- Contact Information -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">contact_support</span>
                Contact Information
            </h3>
            
            @if($campaign->contacts && $campaign->contacts->count() > 0)
                <div class="space-y-4">
                    @foreach($campaign->contacts as $contact)
                        <div class="pb-4 {{ !$loop->last ? 'border-b border-gray-200 dark:border-gray-600' : '' }}">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $contact->name }}</h4>
                                @if($contact->is_primary)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary text-white">
                                        Primary
                                    </span>
                                @endif
                            </div>
                            
                            @if($contact->title)
                                <div class="mb-3">
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Title</label>
                                    <div class="mt-1 text-sm text-gray-900 dark:text-white">{{ $contact->title }}</div>
                                </div>
                            @endif
                            
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                                    <div class="mt-1 text-sm text-gray-900 dark:text-white">
                                        <a href="mailto:{{ $contact->email }}" class="text-primary hover:underline">
                                            {{ $contact->email }}
                                        </a>
                                    </div>
                                </div>

                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</label>
                                    <div class="mt-1 text-sm text-gray-900 dark:text-white">
                                        <a href="tel:{{ str_replace(' ', '', $contact->phone) }}" class="text-primary hover:underline">
                                            {{ $contact->phone }}
                                        </a>
                                    </div>
                                </div>

                                @if($contact->office_location)
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Office Location</label>
                                    <div class="mt-1 text-sm text-gray-900 dark:text-white">{{ $contact->office_location }}</div>
                                </div>
                                @endif

                                @if($contact->office_hours)
                                <div>
                                    <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Office Hours</label>
                                    <div class="mt-1 text-sm text-gray-900 dark:text-white">{{ $contact->office_hours }}</div>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Fallback to old contact fields if no contacts exist -->
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                        <div class="mt-1 text-sm text-gray-900 dark:text-white">
                            <a href="mailto:{{ $campaign->contact_email ?? 'wellness@wellpath.edu' }}" class="text-primary hover:underline">
                                {{ $campaign->contact_email ?? 'wellness@wellpath.edu' }}
                            </a>
                        </div>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</label>
                        <div class="mt-1 text-sm text-gray-900 dark:text-white">
                            <a href="tel:{{ str_replace(' ', '', $campaign->contact_phone ?? '+256123456789') }}" class="text-primary hover:underline">
                                {{ $campaign->contact_phone ?? '+256 123 456 789' }}
                            </a>
                        </div>
                    </div>

                    @if($campaign->contact_office)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Office Location</label>
                        <div class="mt-1 text-sm text-gray-900 dark:text-white">{{ $campaign->contact_office }}</div>
                    </div>
                    @endif

                    @if($campaign->contact_hours)
                    <div>
                        <label class="text-sm font-medium text-gray-500 dark:text-gray-400">Office Hours</label>
                        <div class="mt-1 text-sm text-gray-900 dark:text-white">{{ $campaign->contact_hours }}</div>
                    </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Actions</h3>
            
            <div class="space-y-3">
                <a href="{{ route('admin.campaigns.edit', $campaign) }}" class="w-full bg-primary text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 hover:opacity-90">
                    <span class="material-symbols-outlined text-sm">edit</span>
                    Edit Campaign
                </a>
                
                <form action="{{ route('admin.campaigns.destroy', $campaign) }}" method="POST" class="delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="showDeleteModal(this.closest('form'), 'Are you sure you want to delete this campaign? This action cannot be undone.')" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 hover:bg-red-700">
                        <span class="material-symbols-outlined text-sm">delete</span>
                        Delete Campaign
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection