@extends('layouts.admin')

@section('title', 'Content Flags - Admin')

@section('content')
<div class="flex flex-col sm:flex-row flex-wrap justify-between items-start sm:items-center gap-3 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-3xl font-bold tracking-tight">Content Flags</p>
        <p class="text-gray-500 dark:text-gray-400 text-base font-normal">Review and manage flagged content from users</p>
    </div>
</div>

<!-- Stats Cards Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Total Flags</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total'] }}</p>
            </div>
            <span class="material-symbols-outlined text-primary text-3xl">flag</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Pending</p>
                <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['pending'] }}</p>
            </div>
            <span class="material-symbols-outlined text-yellow-500 text-3xl">pending</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Reviewed</p>
                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['reviewed'] }}</p>
            </div>
            <span class="material-symbols-outlined text-blue-500 text-3xl">visibility</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Action Taken</p>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $stats['action_taken'] }}</p>
            </div>
            <span class="material-symbols-outlined text-green-500 text-3xl">check_circle</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Dismissed</p>
                <p class="text-2xl font-bold text-gray-600 dark:text-gray-400">{{ $stats['dismissed'] }}</p>
            </div>
            <span class="material-symbols-outlined text-gray-500 text-3xl">close</span>
        </div>
    </div>
</div>

<!-- Flags Table -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Content Flags</h2>
            
            <!-- Mobile Filter Toggle Button -->
            <button id="mobileFilterToggle" class="md:hidden flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                <span class="material-symbols-outlined text-base">tune</span>
                <span>Filters</span>
                <span id="filterToggleIcon" class="material-symbols-outlined text-sm transition-transform">expand_more</span>
            </button>
        </div>
        
        <!-- Filter Section -->
        <div id="filterSection" class="hidden md:block">
            <div class="flex flex-col md:flex-row gap-3">
                <select id="statusFilter" class="flex-1 md:min-w-[140px] px-3 py-2 pr-8 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary focus:border-transparent appearance-none">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="reviewed">Reviewed</option>
                    <option value="action_taken">Action Taken</option>
                    <option value="dismissed">Dismissed</option>
                </select>
                <select id="reasonFilter" class="flex-1 md:min-w-[160px] px-3 py-2 pr-8 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary focus:border-transparent appearance-none">
                    <option value="">All Reasons</option>
                    <option value="inappropriate_content">Inappropriate Content</option>
                    <option value="harassment">Harassment</option>
                    <option value="spam">Spam</option>
                    <option value="misinformation">Misinformation</option>
                    <option value="hate_speech">Hate Speech</option>
                    <option value="violence">Violence</option>
                    <option value="self_harm">Self Harm</option>
                    <option value="other">Other</option>
                </select>
                <select id="typeFilter" class="flex-1 md:min-w-[140px] px-3 py-2 pr-8 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary focus:border-transparent appearance-none">
                    <option value="">All Types</option>
                    <option value="App\Models\ForumPost">Forum Posts</option>
                    <option value="App\Models\ForumComment">Comments</option>
                </select>
            </div>
        </div>
    </div>
    
    <!-- Desktop Table View -->
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        <input type="checkbox" id="selectAll" class="rounded border-gray-300 dark:border-gray-600">
                    </th>
                    <th scope="col" class="px-6 py-3">Content</th>
                    <th scope="col" class="px-6 py-3">Reason</th>
                    <th scope="col" class="px-6 py-3">Reporter</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Date</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody id="flagTableBody" class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($flags as $flag)
                <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 flag-row" 
                    data-status="{{ $flag->status }}" 
                    data-reason="{{ $flag->reason }}" 
                    data-type="{{ $flag->flaggable_type }}">
                    <td class="px-6 py-4">
                        <input type="checkbox" name="flag_ids[]" value="{{ $flag->id }}" class="flag-checkbox rounded border-gray-300 dark:border-gray-600">
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0">
                                @if($flag->flaggable_type === 'App\Models\ForumPost')
                                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">forum</span>
                                    </div>
                                @else
                                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                                        <span class="material-symbols-outlined text-green-600 dark:text-green-400">chat_bubble</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ $flag->flaggable_type === 'App\Models\ForumPost' ? 'Forum Post' : 'Comment' }}
                                </p>
                                @if($flag->flaggable)
                                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                        {{ Str::limit($flag->flaggable_type === 'App\Models\ForumPost' ? $flag->flaggable->title : $flag->flaggable->comment, 60) }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        by {{ $flag->flaggable->user->name ?? 'Unknown' }}
                                    </p>
                                @else
                                    <p class="text-sm text-red-500 dark:text-red-400">Content deleted</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-900 dark:text-gray-200">
                            {{ $flag->reason_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $flag->user->name }}</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit($flag->user->email, 30) }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-medium rounded-full
                            @if($flag->status === 'pending') text-yellow-800 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-300
                            @elseif($flag->status === 'reviewed') text-blue-800 bg-blue-100 dark:bg-blue-900 dark:text-blue-300
                            @elseif($flag->status === 'action_taken') text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-300
                            @else text-gray-800 bg-gray-100 dark:bg-gray-900 dark:text-gray-300
                            @endif">
                            {{ $flag->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ $flag->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.content-flags.show', $flag) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400" title="View Details">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-4xl">flag</span>
                            <p>No flags found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Card View -->
    <div class="md:hidden divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($flags as $flag)
        <div class="p-4 flag-row" 
            data-status="{{ $flag->status }}" 
            data-reason="{{ $flag->reason }}" 
            data-type="{{ $flag->flaggable_type }}">
            <div class="flex items-start gap-3 mb-3">
                <div class="flex-shrink-0">
                    @if($flag->flaggable_type === 'App\Models\ForumPost')
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">forum</span>
                        </div>
                    @else
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-green-600 dark:text-green-400">chat_bubble</span>
                        </div>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-900 dark:text-white">
                        {{ $flag->flaggable_type === 'App\Models\ForumPost' ? 'Forum Post' : 'Comment' }}
                    </p>
                    @if($flag->flaggable)
                        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2">
                            {{ Str::limit($flag->flaggable_type === 'App\Models\ForumPost' ? $flag->flaggable->title : $flag->flaggable->comment, 60) }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            by {{ $flag->flaggable->user->name ?? 'Unknown' }}
                        </p>
                    @else
                        <p class="text-sm text-red-500 dark:text-red-400">Content deleted</p>
                    @endif
                </div>
            </div>
            <div class="space-y-2 mb-3">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-900 dark:text-gray-200">
                        {{ $flag->reason_label }}
                    </span>
                    <span class="px-2 py-1 text-xs font-medium rounded-full
                        @if($flag->status === 'pending') text-yellow-800 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-300
                        @elseif($flag->status === 'reviewed') text-blue-800 bg-blue-100 dark:bg-blue-900 dark:text-blue-300
                        @elseif($flag->status === 'action_taken') text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-300
                        @else text-gray-800 bg-gray-100 dark:bg-gray-900 dark:text-gray-300
                        @endif">
                        {{ $flag->status_label }}
                    </span>
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    <p>Reporter: {{ $flag->user->name }}</p>
                    <p class="text-xs">{{ $flag->created_at->format('M d, Y') }}</p>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <input type="checkbox" name="flag_ids[]" value="{{ $flag->id }}" class="flag-checkbox rounded border-gray-300 dark:border-gray-600">
                <a href="{{ route('admin.content-flags.show', $flag) }}" class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 hover:bg-blue-200 dark:hover:bg-blue-900/50" title="View Details">
                    <span class="material-symbols-outlined text-sm">visibility</span>
                </a>
            </div>
        </div>
        @empty
        <div class="p-8 text-center text-gray-500 dark:text-gray-400">
            <div class="flex flex-col items-center gap-2">
                <span class="material-symbols-outlined text-4xl">flag</span>
                <p>No flags found</p>
            </div>
        </div>
        @endforelse
    </div>

    @if($flags->hasPages())
    <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700">
        {{ $flags->links() }}
    </div>
    @endif
</div>

<!-- Bulk Actions -->
<div id="bulkActions" class="hidden fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 p-4">
    <div class="flex items-center space-x-4">
        <span class="text-sm text-gray-600 dark:text-gray-400">
            <span id="selectedCount">0</span> items selected
        </span>
        <button onclick="showBulkUpdateModal()" class="px-3 py-1.5 bg-primary text-white rounded text-sm hover:bg-primary/90 transition-colors">
            Bulk Update
        </button>
        <button onclick="clearSelection()" class="px-3 py-1.5 bg-gray-500 text-white rounded text-sm hover:bg-gray-600 transition-colors">
            Clear
        </button>
    </div>
</div>

<!-- Bulk Update Modal -->
<div id="bulkUpdateModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Bulk Update Flags</h3>
        </div>
        <form id="bulkUpdateForm" method="POST" action="{{ route('admin.content-flags.bulk-update') }}" class="p-4">
            @csrf
            <input type="hidden" name="flag_ids" id="bulkFlagIds">
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                <select name="status" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white">
                    <option value="">Select status...</option>
                    <option value="reviewed">Reviewed</option>
                    <option value="dismissed">Dismissed</option>
                    <option value="action_taken">Action Taken</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Admin Notes</label>
                <textarea name="admin_notes" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white resize-none"></textarea>
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeBulkUpdateModal()" class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-primary text-white hover:bg-primary/90 rounded-lg transition-colors">
                    Update Flags
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Flag table filtering
document.addEventListener('DOMContentLoaded', function() {
    // Mobile filter toggle functionality
    const mobileFilterToggle = document.getElementById('mobileFilterToggle');
    const filterSection = document.getElementById('filterSection');
    const filterToggleIcon = document.getElementById('filterToggleIcon');
    
    if (mobileFilterToggle && filterSection) {
        mobileFilterToggle.addEventListener('click', function() {
            const isHidden = filterSection.classList.contains('hidden');
            
            if (isHidden) {
                filterSection.classList.remove('hidden');
                filterToggleIcon.style.transform = 'rotate(180deg)';
                filterToggleIcon.textContent = 'expand_less';
            } else {
                filterSection.classList.add('hidden');
                filterToggleIcon.style.transform = 'rotate(0deg)';
                filterToggleIcon.textContent = 'expand_more';
            }
        });
    }
    
    // Filter elements
    const statusFilter = document.getElementById('statusFilter');
    const reasonFilter = document.getElementById('reasonFilter');
    const typeFilter = document.getElementById('typeFilter');
    const tableBody = document.getElementById('flagTableBody');
    const rows = tableBody.querySelectorAll('.flag-row');
    const mobileCards = document.querySelectorAll('.flag-row');

    function filterTable() {
        const statusValue = statusFilter.value;
        const reasonValue = reasonFilter.value;
        const typeValue = typeFilter.value;

        // Filter both desktop rows and mobile cards
        mobileCards.forEach(row => {
            const status = row.dataset.status;
            const reason = row.dataset.reason;
            const type = row.dataset.type;

            const matchesStatus = !statusValue || status === statusValue;
            const matchesReason = !reasonValue || reason === reasonValue;
            const matchesType = !typeValue || type === typeValue;

            if (matchesStatus && matchesReason && matchesType) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (statusFilter) {
        statusFilter.addEventListener('change', filterTable);
    }
    
    if (reasonFilter) {
        reasonFilter.addEventListener('change', filterTable);
    }
    
    if (typeFilter) {
        typeFilter.addEventListener('change', filterTable);
    }
});

// Checkbox handling
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.flag-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateBulkActions();
});

document.querySelectorAll('.flag-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateBulkActions);
});

function updateBulkActions() {
    const selectedCheckboxes = document.querySelectorAll('.flag-checkbox:checked');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    
    if (selectedCheckboxes.length > 0) {
        bulkActions.classList.remove('hidden');
        selectedCount.textContent = selectedCheckboxes.length;
    } else {
        bulkActions.classList.add('hidden');
    }
}

function clearSelection() {
    document.querySelectorAll('.flag-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('selectAll').checked = false;
    updateBulkActions();
}

function showBulkUpdateModal() {
    const selectedCheckboxes = document.querySelectorAll('.flag-checkbox:checked');
    const flagIds = Array.from(selectedCheckboxes).map(cb => cb.value);
    
    document.getElementById('bulkFlagIds').value = JSON.stringify(flagIds);
    document.getElementById('bulkUpdateModal').classList.remove('hidden');
}

function closeBulkUpdateModal() {
    document.getElementById('bulkUpdateModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('bulkUpdateModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeBulkUpdateModal();
    }
});
</script>
@endsection