@extends('layouts.admin')

@section('title', 'User Details - Admin')

@section('content')
<div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">User Details</h2>
            <p class="text-gray-500 dark:text-gray-400">View user information and activity</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 hover:bg-green-700 flex-1 sm:flex-initial">
                <span class="material-symbols-outlined text-sm">edit</span>
                Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 hover:bg-gray-700 flex-1 sm:flex-initial">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Back
            </a>
        </div>
    </div>
</div>

<!-- User Information Card -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 sm:p-6 mb-6">
    <div class="flex flex-col sm:flex-row items-start gap-4 sm:gap-6">
        <div class="w-20 h-20 rounded-full bg-primary/20 flex items-center justify-center flex-shrink-0 mx-auto sm:mx-0">
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
            @else
                <span class="material-symbols-outlined text-primary text-3xl">person</span>
            @endif
        </div>
        
        <div class="flex-1 w-full">
            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 mb-3 text-center sm:text-left">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $user->name ?? 'Unknown User' }}</h3>
                <div class="flex items-center justify-center sm:justify-start gap-2 flex-wrap">
                    <span class="px-3 py-1 text-sm font-medium rounded-full
                        @if($user->role === 'admin') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                        @elseif($user->role === 'counselor') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                        @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                        @endif">
                        {{ ucfirst($user->role ?? 'user') }}
                    </span>
                    @if($user->is_active)
                        <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-800 rounded-full dark:bg-green-900 dark:text-green-300">Active</span>
                    @else
                        <span class="px-3 py-1 text-sm font-medium bg-gray-100 text-gray-800 rounded-full dark:bg-gray-900 dark:text-gray-300">Inactive</span>
                    @endif
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 text-sm">
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Email</p>
                    <p class="text-gray-900 dark:text-white font-medium break-all">{{ $user->email ?? 'N/A' }}</p>
                </div>
                
                @if($user->phone)
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Phone</p>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $user->phone }}</p>
                </div>
                @endif
                
                @if($user->registration_number)
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Registration Number</p>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $user->registration_number }}</p>
                </div>
                @endif
                
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Joined</p>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</p>
                </div>
                
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Last Updated</p>
                    <p class="text-gray-900 dark:text-white font-medium">{{ $user->updated_at ? $user->updated_at->format('M d, Y') : 'N/A' }}</p>
                </div>
                
                <div>
                    <p class="text-gray-500 dark:text-gray-400">Email Verified</p>
                    <p class="text-gray-900 dark:text-white font-medium">
                        @if($user->email_verified_at)
                            <span class="text-green-600">{{ $user->email_verified_at->format('M d, Y') }}</span>
                        @else
                            <span class="text-red-600">Not verified</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@if(isset($sessions) && $sessions->count() > 0)
<!-- Sessions Section -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            @if($user->role === 'counselor')
                Counseling Sessions (as Counselor)
            @else
                Counseling Sessions (as Student)
            @endif
        </h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Recent counseling session activity</p>
    </div>
    
    <!-- Mobile Card View -->
    <div class="md:hidden divide-y divide-gray-200 dark:divide-gray-700">
        @foreach($sessions as $session)
        <div class="p-4">
            <div class="flex items-start gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-primary/20 flex items-center justify-center flex-shrink-0">
                    @if($user->role === 'counselor')
                        <span class="material-symbols-outlined text-primary text-sm">person</span>
                    @else
                        <span class="material-symbols-outlined text-primary text-sm">psychology</span>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    @if($user->role === 'counselor')
                        <p class="font-medium text-gray-900 dark:text-white">{{ $session->student->name ?? 'Unknown' }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $session->student->email ?? 'N/A' }}</p>
                    @else
                        <p class="font-medium text-gray-900 dark:text-white">{{ $session->counselor->name ?? 'Unassigned' }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $session->counselor->email ?? 'N/A' }}</p>
                    @endif
                </div>
            </div>
            
            <div class="space-y-2 text-sm">
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Type:</span>
                    <span class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                        {{ ucfirst(str_replace('_', ' ', $session->session_type ?? 'individual')) }}
                    </span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Status:</span>
                    <span class="px-2 py-1 text-xs font-medium rounded-full
                        @if(($session->status ?? 'pending') === 'pending') text-yellow-800 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-300
                        @elseif(($session->status ?? 'pending') === 'active') text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-300
                        @elseif(($session->status ?? 'pending') === 'completed') text-blue-800 bg-blue-100 dark:bg-blue-900 dark:text-blue-300
                        @else text-gray-800 bg-gray-100 dark:bg-gray-900 dark:text-gray-300
                        @endif">
                        {{ ucfirst($session->status ?? 'pending') }}
                    </span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Date:</span>
                    <span class="text-gray-900 dark:text-white">{{ $session->created_at ? $session->created_at->format('M d, Y g:i A') : 'N/A' }}</span>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-gray-500 dark:text-gray-400">Duration:</span>
                    <span class="text-gray-900 dark:text-white">
                        @if(isset($session->duration) && $session->duration)
                            {{ $session->duration }} min
                        @else
                            <span class="text-gray-400">N/A</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Desktop Table View -->
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                <tr>
                    @if($user->role === 'counselor')
                        <th scope="col" class="px-6 py-3">Student</th>
                        <th scope="col" class="px-6 py-3">Type</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Date</th>
                        <th scope="col" class="px-6 py-3">Duration</th>
                    @else
                        <th scope="col" class="px-6 py-3">Counselor</th>
                        <th scope="col" class="px-6 py-3">Type</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Date</th>
                        <th scope="col" class="px-6 py-3">Duration</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($sessions as $session)
                <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                    @if($user->role === 'counselor')
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-sm">person</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $session->student->name ?? 'Unknown' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $session->student->email ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                    @else
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-sm">psychology</span>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $session->counselor->name ?? 'Unassigned' }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $session->counselor->email ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                    @endif
                    
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                            {{ ucfirst(str_replace('_', ' ', $session->session_type ?? 'individual')) }}
                        </span>
                    </td>
                    
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-medium rounded-full
                            @if(($session->status ?? 'pending') === 'pending') text-yellow-800 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-300
                            @elseif(($session->status ?? 'pending') === 'active') text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-300
                            @elseif(($session->status ?? 'pending') === 'completed') text-blue-800 bg-blue-100 dark:bg-blue-900 dark:text-blue-300
                            @else text-gray-800 bg-gray-100 dark:bg-gray-900 dark:text-gray-300
                            @endif">
                            {{ ucfirst($session->status ?? 'pending') }}
                        </span>
                    </td>
                    
                    <td class="px-6 py-4">{{ $session->created_at ? $session->created_at->format('M d, Y g:i A') : 'N/A' }}</td>
                    
                    <td class="px-6 py-4">
                        @if(isset($session->duration) && $session->duration)
                            {{ $session->duration }} min
                        @else
                            <span class="text-gray-400">N/A</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @if($sessions->hasPages())
    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
        {{ $sessions->links() }}
    </div>
    @endif
</div>
@else
<!-- No Sessions Message -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-8 text-center">
    <span class="material-symbols-outlined text-4xl text-gray-400 mb-4">psychology</span>
    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No Sessions Found</h3>
    <p class="text-gray-500 dark:text-gray-400">
        @if($user->role === 'counselor')
            This counselor hasn't conducted any sessions yet.
        @else
            This user hasn't participated in any counseling sessions yet.
        @endif
    </p>
</div>
@endif

@endsection