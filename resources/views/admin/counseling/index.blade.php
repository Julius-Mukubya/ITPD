@extends('layouts.admin')

@section('title', 'Counseling Management')
@section('page-title', 'Counseling')

@section('content')
<div class="flex flex-wrap justify-between items-center gap-3 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-3xl font-bold tracking-tight">Counseling Management</p>
        <p class="text-gray-500 dark:text-gray-400 text-base font-normal">Monitor counseling sessions and manage counselors</p>
    </div>
    <a href="{{ route('admin.counselors.create') }}" class="bg-primary text-white text-sm font-medium px-4 py-2 rounded-lg flex items-center gap-2 hover:opacity-90">
        <span class="material-symbols-outlined" style="font-size: 20px;">person_add</span>
        Add Counselor
    </a>
</div>

<!-- Summary Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Total Sessions</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalSessions ?? 0 }}</p>
            </div>
            <span class="material-symbols-outlined text-primary text-3xl">psychology</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">This Month</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $monthlySessions ?? 0 }}</p>
            </div>
            <span class="material-symbols-outlined text-blue-500 text-3xl">trending_up</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Active Counselors</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $activeCounselors ?? 0 }}</p>
            </div>
            <span class="material-symbols-outlined text-green-500 text-3xl">group</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Satisfaction</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $averageRating ?? '4.8' }}</p>
            </div>
            <span class="material-symbols-outlined text-purple-500 text-3xl">star</span>
        </div>
    </div>
</div>

<!-- Counselors Table -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 mb-6">
    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Active Counselors</h2>
        
        <!-- Filter -->
        <div class="flex gap-3">
            <input type="text" id="counselorSearch" placeholder="Search by name or email..." 
                class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary focus:border-transparent">
            <select id="counselorStatus" class="min-w-[140px] px-3 py-2 pr-8 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary focus:border-transparent appearance-none">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3">Counselor</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Phone</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Joined</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody id="counselorTableBody">
                @forelse($counselors ?? [] as $counselor)
                <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 counselor-row" 
                    data-name="{{ strtolower($counselor->name ?? '') }}" 
                    data-email="{{ strtolower($counselor->email ?? '') }}"
                    data-status="{{ $counselor->is_active ? 'active' : 'inactive' }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary">person</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $counselor->name ?? 'Counselor' }}</p>
                                @if($counselor->registration_number)
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $counselor->registration_number }}</p>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ $counselor->email ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $counselor->phone ?? 'N/A' }}</td>
                    <td class="px-6 py-4">
                        @if($counselor->is_active)
                        <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">Active</span>
                        @else
                        <span class="px-2 py-1 text-xs font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-900 dark:text-gray-300">Inactive</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $counselor->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.users.edit', $counselor) }}" class="text-green-600 hover:text-green-800 dark:text-green-400" title="Edit">
                                <span class="material-symbols-outlined text-sm">edit</span>
                            </a>
                            <form action="{{ route('admin.users.destroy', $counselor) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400" title="Delete">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-4xl">person_add</span>
                            <p>No counselors found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Recent Sessions Table -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3">User</th>
                    <th scope="col" class="px-6 py-3">Counselor</th>
                    <th scope="col" class="px-6 py-3">Type</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Date</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentSessions ?? [] as $session)
                <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary">person</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $session->student->name ?? 'User' }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ Str::limit($session->student->email ?? 'user@example.com', 30) }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ $session->counselor->name ?? 'Unassigned' }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                            {{ ucfirst(str_replace('_', ' ', $session->session_type ?? 'individual')) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-medium rounded-full
                            @if(($session->status ?? 'pending') === 'pending') text-yellow-800 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-300
                            @elseif(($session->status ?? 'pending') === 'active') text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-300
                            @else text-blue-800 bg-blue-100 dark:bg-blue-900 dark:text-blue-300
                            @endif">
                            {{ ucfirst($session->status ?? 'pending') }}
                        </span>
                    </td>
                    <td class="px-6 py-4">{{ ($session->created_at ?? now())->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <button class="text-blue-600 hover:text-blue-800 dark:text-blue-400" title="View Details">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                            </button>
                            <button class="text-green-600 hover:text-green-800 dark:text-green-400" title="Edit">
                                <span class="material-symbols-outlined text-sm">edit</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-4xl">psychology</span>
                            <p>No counseling sessions found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>




@endsection

@push('scripts')
<script>
// Counselor table filtering
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('counselorSearch');
    const statusSelect = document.getElementById('counselorStatus');
    const tableBody = document.getElementById('counselorTableBody');
    const rows = tableBody.querySelectorAll('.counselor-row');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusFilter = statusSelect.value;

        rows.forEach(row => {
            const name = row.dataset.name;
            const email = row.dataset.email;
            const status = row.dataset.status;

            const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
            const matchesStatus = !statusFilter || status === statusFilter;

            if (matchesSearch && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterTable);
    }
    
    if (statusSelect) {
        statusSelect.addEventListener('change', filterTable);
    }
});
</script>
@endpush

