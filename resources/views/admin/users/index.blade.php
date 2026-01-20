@extends('layouts.admin')

@section('title', 'Manage Users - Admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Users</h2>
        <p class="text-gray-500 dark:text-gray-400">Manage system users</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg flex items-center gap-2 hover:opacity-90">
        <span class="material-symbols-outlined text-sm">add</span>
        Add User
    </a>
</div>



<!-- Users Table -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">System Users</h2>
        
        <!-- Filter -->
        <div class="flex gap-3">
            <input type="text" id="userSearch" placeholder="Search by name, email, or registration number..." 
                class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary focus:border-transparent">
            <select id="userRole" class="min-w-[120px] px-3 py-2 pr-8 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary focus:border-transparent appearance-none">
                <option value="">All Roles</option>
                <option value="user">User</option>
                <option value="counselor">Counselor</option>
                <option value="admin">Admin</option>
            </select>
            <select id="userStatus" class="min-w-[120px] px-3 py-2 pr-8 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white text-sm focus:ring-2 focus:ring-primary focus:border-transparent appearance-none">
                <option value="">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Joined</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody id="userTableBody">
            @forelse($users as $user)
            <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 user-row" 
                data-name="{{ strtolower($user->name ?? '') }}" 
                data-email="{{ strtolower($user->email ?? '') }}"
                data-role="{{ $user->role }}"
                data-status="{{ $user->is_active ? 'active' : 'inactive' }}">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center">
                            @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                            @else
                            <span class="material-symbols-outlined text-primary">person</span>
                            @endif
                        </div>
                        <div>
                            <p class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                            @if($user->registration_number)
                            <p class="text-xs text-gray-500">{{ $user->registration_number }}</p>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $user->email }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs font-medium rounded-full
                        @if($user->role === 'admin') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                        @elseif($user->role === 'counselor') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                        @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                        @endif">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    @if($user->is_active)
                    <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full dark:bg-green-900 dark:text-green-300">Active</span>
                    @else
                    <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full dark:bg-gray-900 dark:text-gray-300">Inactive</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $user->created_at->format('M d, Y') }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400">
                            <span class="material-symbols-outlined text-sm">edit</span>
                        </a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400">
                                <span class="material-symbols-outlined text-sm">delete</span>
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                    <div class="flex flex-col items-center gap-2">
                        <span class="material-symbols-outlined text-4xl">person</span>
                        <p>No users found</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
@if($users->hasPages())
<div class="mt-6">
    {{ $users->links() }}
</div>
@endif
@endsection

@push('scripts')
<script>
// User table filtering
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('userSearch');
    const roleSelect = document.getElementById('userRole');
    const statusSelect = document.getElementById('userStatus');
    const tableBody = document.getElementById('userTableBody');
    const rows = tableBody.querySelectorAll('.user-row');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const roleFilter = roleSelect.value;
        const statusFilter = statusSelect.value;

        rows.forEach(row => {
            const name = row.dataset.name;
            const email = row.dataset.email;
            const role = row.dataset.role;
            const status = row.dataset.status;

            const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
            const matchesRole = !roleFilter || role === roleFilter;
            const matchesStatus = !statusFilter || status === statusFilter;

            if (matchesSearch && matchesRole && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', filterTable);
    }
    
    if (roleSelect) {
        roleSelect.addEventListener('change', filterTable);
    }
    
    if (statusSelect) {
        statusSelect.addEventListener('change', filterTable);
    }
});
</script>
@endpush
