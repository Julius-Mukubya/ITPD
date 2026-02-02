@extends('layouts.admin')

@section('title', 'Flag Details - Admin')

@section('content')
<div class="flex flex-wrap justify-between items-center gap-3 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-3xl font-bold tracking-tight">Flag Details</p>
        <p class="text-gray-500 dark:text-gray-400 text-base font-normal">Review flagged content and take appropriate action</p>
    </div>
    <a href="{{ route('admin.content-flags.index') }}" 
       class="bg-gray-500 text-white text-sm font-medium px-4 py-2 rounded-lg flex items-center gap-2 hover:opacity-90">
        <span class="material-symbols-outlined" style="font-size: 20px;">arrow_back</span>
        Back to Flags
    </a>
</div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Flag Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Flag Details Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Flag Information</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reason</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-200">
                            {{ $flag->reason_label }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            @if($flag->status === 'pending') bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-200
                            @elseif($flag->status === 'reviewed') bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200
                            @elseif($flag->status === 'action_taken') bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200
                            @else bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200
                            @endif">
                            {{ $flag->status_label }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reported By</label>
                        <div class="text-sm text-gray-900 dark:text-white">{{ $flag->user->name }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $flag->user->email }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reported On</label>
                        <div class="text-sm text-gray-900 dark:text-white">{{ $flag->created_at->format('M j, Y g:i A') }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $flag->created_at->diffForHumans() }}</div>
                    </div>

                    @if($flag->reviewed_by)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reviewed By</label>
                        <div class="text-sm text-gray-900 dark:text-white">{{ $flag->reviewer->name }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $flag->reviewed_at->format('M j, Y g:i A') }}</div>
                    </div>
                    @endif
                </div>

                @if($flag->description)
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Additional Details</label>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 text-sm text-gray-700 dark:text-gray-300">
                        {{ $flag->description }}
                    </div>
                </div>
                @endif

                @if($flag->admin_notes)
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Admin Notes</label>
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-3 text-sm text-blue-700 dark:text-blue-300">
                        {{ $flag->admin_notes }}
                    </div>
                </div>
                @endif
            </div>

            <!-- Flagged Content -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Flagged Content</h2>
                
                @if($flag->flaggable)
                    @if($flag->flaggable_type === 'App\Models\ForumPost')
                        <!-- Forum Post -->
                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                            <div class="flex items-start space-x-3 mb-3">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">forum</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $flag->flaggable->title }}</h3>
                                    <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        <span>by {{ $flag->flaggable->author_name }}</span>
                                        <span>{{ $flag->flaggable->created_at->format('M j, Y') }}</span>
                                        <span>{{ $flag->flaggable->views }} views</span>
                                        <span>{{ $flag->flaggable->upvotes }} upvotes</span>
                                    </div>
                                </div>
                            </div>
                            <div class="prose prose-sm max-w-none dark:prose-invert">
                                {!! nl2br(e($flag->flaggable->content)) !!}
                            </div>
                            
                            @if($flag->flaggable->category)
                            <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-600">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                    {{ $flag->flaggable->category->name }}
                                </span>
                            </div>
                            @endif
                        </div>
                    @else
                        <!-- Forum Comment -->
                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                            <div class="flex items-start space-x-3 mb-3">
                                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">chat_bubble</span>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Comment</h3>
                                    <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        <span>by {{ $flag->flaggable->author_name }}</span>
                                        <span>{{ $flag->flaggable->created_at->format('M j, Y') }}</span>
                                        <span>{{ $flag->flaggable->upvotes }} upvotes</span>
                                        @if($flag->flaggable->post)
                                            <span>on "{{ Str::limit($flag->flaggable->post->title, 30) }}"</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="prose prose-sm max-w-none dark:prose-invert">
                                {!! nl2br(e($flag->flaggable->comment)) !!}
                            </div>
                        </div>
                    @endif
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-4xl text-gray-400">delete</span>
                        </div>
                        <p class="text-lg font-medium text-gray-900 dark:text-white">Content Deleted</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">The flagged content has been removed.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions Sidebar -->
        <div class="space-y-6">
            @if($flag->status === 'pending')
            <!-- Review Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Review Actions</h3>
                
                <form method="POST" action="{{ route('admin.content-flags.update', $flag) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Decision</label>
                        <select name="status" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white">
                            <option value="">Select decision...</option>
                            <option value="dismissed">Dismiss Flag</option>
                            <option value="reviewed">Mark as Reviewed</option>
                            <option value="action_taken">Take Action</option>
                        </select>
                    </div>

                    <div class="mb-4" id="actionField" style="display: none;">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Action to Take</label>
                        <select name="action" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white">
                            <option value="">Select action...</option>
                            <option value="delete_content">Delete Content</option>
                            <option value="hide_content">Hide Content</option>
                            <option value="warn_user">Warn User</option>
                            <option value="ban_user">Ban User</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Admin Notes</label>
                        <textarea name="admin_notes" rows="4" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white resize-none" placeholder="Add notes about your decision..."></textarea>
                    </div>

                    <button type="submit" class="w-full px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">
                        Submit Review
                    </button>
                </form>
            </div>
            @endif

            <!-- Flag Statistics -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Content Statistics</h3>
                
                @if($flag->flaggable)
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Total Flags</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $flag->flaggable->flags_count }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Pending Flags</span>
                        <span class="text-sm font-medium text-yellow-600 dark:text-yellow-400">{{ $flag->flaggable->pending_flags_count }}</span>
                    </div>
                    @if($flag->flaggable_type === 'App\Models\ForumPost')
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Views</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $flag->flaggable->views }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Upvotes</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $flag->flaggable->upvotes }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Created</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $flag->flaggable->created_at->format('M j, Y') }}</span>
                    </div>
                </div>
                @else
                <p class="text-sm text-gray-500 dark:text-gray-400">Content has been deleted.</p>
                @endif
            </div>

            <!-- Other Flags for Same Content -->
            @if($flag->flaggable && $flag->flaggable->flags()->where('id', '!=', $flag->id)->exists())
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Other Flags</h3>
                
                <div class="space-y-3">
                    @foreach($flag->flaggable->flags()->where('id', '!=', $flag->id)->with('user')->get() as $otherFlag)
                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $otherFlag->reason_label }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">by {{ $otherFlag->user->name }}</div>
                        </div>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                            @if($otherFlag->status === 'pending') bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-200
                            @elseif($otherFlag->status === 'reviewed') bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200
                            @elseif($otherFlag->status === 'action_taken') bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200
                            @else bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200
                            @endif">
                            {{ $otherFlag->status_label }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>

<script>
// Show/hide action field based on status selection
document.querySelector('select[name="status"]').addEventListener('change', function() {
    const actionField = document.getElementById('actionField');
    if (this.value === 'action_taken') {
        actionField.style.display = 'block';
        actionField.querySelector('select').required = true;
    } else {
        actionField.style.display = 'none';
        actionField.querySelector('select').required = false;
    }
});
</script>
@endsection