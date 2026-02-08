@extends('layouts.counselor')

@section('title', 'Counseling Sessions')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-2xl sm:text-3xl font-bold tracking-tight">Counseling Sessions</p>
        <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">Manage and respond to counseling requests</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Pending Sessions -->
    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-emerald-600"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Pending Requests</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-xl text-emerald-600 dark:text-emerald-400">pending</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $pendingSessions->count() }}</p>
            <div class="flex items-center">
                <div class="flex items-center bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-emerald-600">trending_up</span>
                    <span class="text-xs font-medium text-emerald-600">Awaiting Response</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Sessions -->
    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-green-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-green-600"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Active Sessions</p>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-xl text-green-600 dark:text-green-400">psychology</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $activeSessions->count() }}</p>
            <div class="flex items-center">
                <div class="flex items-center bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-green-600">support_agent</span>
                    <span class="text-xs font-medium text-green-600">In Progress</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Completed Sessions -->
    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-teal-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-teal-500 to-teal-600"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-teal-500 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Completed Sessions</p>
            </div>
            <div class="bg-gradient-to-br from-teal-50 to-teal-100 dark:from-teal-900/20 dark:to-teal-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-xl text-teal-600 dark:text-teal-400">check_circle</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $completedSessions->total() }}</p>
            <div class="flex items-center">
                <div class="flex items-center bg-teal-50 dark:bg-teal-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-teal-600">history</span>
                    <span class="text-xs font-medium text-teal-600">Finished</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 mb-8 shadow-sm">
    <!-- Filters Header -->
    <div class="flex items-center justify-between p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-lg">filter_list</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filters</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Filter and search your sessions</p>
            </div>
        </div>
        <button type="button" onclick="toggleFilters()" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
            <span id="filter-toggle-text">Hide Filters</span>
            <span id="filter-toggle-icon" class="material-symbols-outlined text-lg transition-transform duration-200">expand_less</span>
        </button>
    </div>
    
    <!-- Filters Content -->
    <div id="filter-panel" class="p-4 sm:p-6">
        <form method="GET" action="{{ route('counselor.sessions.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Search -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" 
                           placeholder="Search by subject, description, or student name..."
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
                
                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ ($filters['status'] ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ ($filters['status'] ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ ($filters['status'] ?? '') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                
                <!-- Session Type Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Session Type</label>
                    <select name="session_type" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="">All Types</option>
                        <option value="individual" {{ ($filters['session_type'] ?? '') === 'individual' ? 'selected' : '' }}>Individual</option>
                        <option value="group" {{ ($filters['session_type'] ?? '') === 'group' ? 'selected' : '' }}>Group</option>
                    </select>
                </div>
                
                <!-- Priority Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Priority</label>
                    <select name="priority" class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        <option value="">All Priorities</option>
                        <option value="low" {{ ($filters['priority'] ?? '') === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ ($filters['priority'] ?? '') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ ($filters['priority'] ?? '') === 'high' ? 'selected' : '' }}>High</option>
                        <option value="urgent" {{ ($filters['priority'] ?? '') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                </div>
                
                <!-- Filter Actions -->
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                        Apply Filters
                    </button>
                </div>
            </div>
            
            <!-- Date Range -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">From Date</label>
                    <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">To Date</label>
                    <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}"
                           class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
            </div>
            
            <!-- Clear Filters -->
            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('counselor.sessions.index') }}" class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm">
                    <span class="material-symbols-outlined text-sm">clear</span>
                    Clear All Filters
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Active Filters Display -->
@if(array_filter($filters))
<div class="mb-6">
    <div class="flex flex-wrap items-center gap-2">
        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Active Filters:</span>
        
        @if($filters['search'])
        <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200 text-sm rounded-full">
            Search: "{{ $filters['search'] }}"
            <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="ml-1 text-blue-600 hover:text-blue-800">
                <span class="material-symbols-outlined text-xs">close</span>
            </a>
        </span>
        @endif
        
        @if($filters['status'])
        <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200 text-sm rounded-full">
            Status: {{ ucfirst($filters['status']) }}
            <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" class="ml-1 text-green-600 hover:text-green-800">
                <span class="material-symbols-outlined text-xs">close</span>
            </a>
        </span>
        @endif
        
        @if($filters['session_type'])
        <span class="inline-flex items-center gap-1 px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-200 text-sm rounded-full">
            Type: {{ ucfirst($filters['session_type']) }}
            <a href="{{ request()->fullUrlWithQuery(['session_type' => null]) }}" class="ml-1 text-purple-600 hover:text-purple-800">
                <span class="material-symbols-outlined text-xs">close</span>
            </a>
        </span>
        @endif
        
        @if($filters['priority'])
        <span class="inline-flex items-center gap-1 px-3 py-1 bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-200 text-sm rounded-full">
            Priority: {{ ucfirst($filters['priority']) }}
            <a href="{{ request()->fullUrlWithQuery(['priority' => null]) }}" class="ml-1 text-orange-600 hover:text-orange-800">
                <span class="material-symbols-outlined text-xs">close</span>
            </a>
        </span>
        @endif
        
        @if($filters['date_from'] || $filters['date_to'])
        <span class="inline-flex items-center gap-1 px-3 py-1 bg-teal-100 dark:bg-teal-900/30 text-teal-800 dark:text-teal-200 text-sm rounded-full">
            Date: 
            @if($filters['date_from'] && $filters['date_to'])
                {{ $filters['date_from'] }} to {{ $filters['date_to'] }}
            @elseif($filters['date_from'])
                From {{ $filters['date_from'] }}
            @else
                Until {{ $filters['date_to'] }}
            @endif
            <a href="{{ request()->fullUrlWithQuery(['date_from' => null, 'date_to' => null]) }}" class="ml-1 text-teal-600 hover:text-teal-800">
                <span class="material-symbols-outlined text-xs">close</span>
            </a>
        </span>
        @endif
        
        <a href="{{ route('counselor.sessions.index') }}" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 underline">
            Clear All
        </a>
    </div>
</div>
@endif

<!-- Pending Sessions -->
@if($pendingSessions->count() > 0)
<div class="mb-8">
    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-emerald-600">pending_actions</span>
        Pending Requests
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($pendingSessions as $session)
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
            <!-- Background Image -->
            <div class="relative h-48 bg-gradient-to-br from-emerald-400 via-teal-500 to-blue-600 overflow-hidden">
                <img src="{{ asset('images/' . ($session->session_type === 'group' ? 'pending-group-session.avif' : 'pending-individual-session.avif')) }}" 
                     alt="{{ ucfirst($session->session_type) }} session" 
                     class="w-full h-full object-cover opacity-80">
                
                <!-- Badges -->
                <div class="absolute top-4 left-4 right-4 flex justify-between items-start">
                    <span class="bg-white/90 dark:bg-gray-800/90 text-gray-700 dark:text-gray-300 px-3 py-1 rounded-full text-sm font-medium flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">person</span>
                        {{ ucfirst(str_replace('_', ' ', $session->session_type)) }}
                    </span>
                    <span class="bg-amber-100 dark:bg-amber-900/80 text-amber-700 dark:text-amber-300 px-3 py-1 rounded-full text-sm font-semibold">
                        Pending
                    </span>
                </div>
                
                <!-- Center Icon -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-4xl text-white">pending</span>
                    </div>
                </div>
            </div>
            
            <!-- Content -->
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $session->student->name }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">schedule</span>
                    {{ $session->created_at->format('M d, Y') }}
                </p>
                
                <div class="flex justify-end">
                    <a href="{{ route('counselor.sessions.show', $session) }}" class="text-emerald-600 dark:text-emerald-400 font-semibold text-sm hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors flex items-center gap-1">
                        View Details
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Active Sessions -->
@if($activeSessions->count() > 0)
<div class="mb-8">
    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-green-600">support_agent</span>
        Active Sessions
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($activeSessions as $session)
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
            <!-- Background Image -->
            <div class="relative h-48 bg-gradient-to-br from-green-400 via-emerald-500 to-teal-600 overflow-hidden">
                <img src="{{ asset('images/' . ($session->session_type === 'group' ? 'active-group-session.avif' : 'active-individual-session.avif')) }}" 
                     alt="{{ ucfirst($session->session_type) }} session" 
                     class="w-full h-full object-cover opacity-80">
                
                <!-- Badges -->
                <div class="absolute top-4 left-4 right-4 flex justify-between items-start">
                    <span class="bg-white/90 dark:bg-gray-800/90 text-gray-700 dark:text-gray-300 px-3 py-1 rounded-full text-sm font-medium flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">person</span>
                        {{ ucfirst(str_replace('_', ' ', $session->session_type)) }}
                    </span>
                    <span class="bg-green-100 dark:bg-green-900/80 text-green-700 dark:text-green-300 px-3 py-1 rounded-full text-sm font-semibold">
                        Active
                    </span>
                </div>
                
                <!-- Center Icon -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-4xl text-white">psychology</span>
                    </div>
                </div>
            </div>
            
            <!-- Content -->
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $session->student->name }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">schedule</span>
                    Started {{ $session->started_at->diffForHumans() }}
                </p>
                
                <div class="flex justify-end">
                    <a href="{{ route('counselor.sessions.show', $session) }}" class="text-green-600 dark:text-green-400 font-semibold text-sm hover:text-green-700 dark:hover:text-green-300 transition-colors flex items-center gap-1">
                        Continue Session
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Completed Sessions -->
@if($completedSessions->count() > 0)
<div class="mb-8">
    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-teal-600">history</span>
        Completed Sessions
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        @foreach($completedSessions as $session)
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden">
            <!-- Background Image -->
            <div class="relative h-48 bg-gradient-to-br from-blue-400 via-indigo-500 to-purple-600 overflow-hidden">
                <img src="{{ asset('images/' . ($session->session_type === 'group' ? 'completed-group-session.avif' : 'completed-individual-session.avif')) }}" 
                     alt="{{ ucfirst($session->session_type) }} session" 
                     class="w-full h-full object-cover opacity-80">
                
                <!-- Badges -->
                <div class="absolute top-4 left-4 right-4 flex justify-between items-start">
                    <span class="bg-white/90 dark:bg-gray-800/90 text-gray-700 dark:text-gray-300 px-3 py-1 rounded-full text-sm font-medium flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">person</span>
                        {{ ucfirst(str_replace('_', ' ', $session->session_type)) }}
                    </span>
                    <span class="bg-blue-100 dark:bg-blue-900/80 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full text-sm font-semibold">
                        Completed
                    </span>
                </div>
                
                <!-- Center Icon -->
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-4xl text-white">check_circle</span>
                    </div>
                </div>
            </div>
            
            <!-- Content -->
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $session->student->name }}</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">schedule</span>
                    {{ $session->completed_at->format('M d, Y') }}
                </p>
                
                <div class="flex justify-end">
                    <a href="{{ route('counselor.sessions.show', $session) }}" class="text-teal-600 dark:text-teal-400 font-semibold text-sm hover:text-teal-700 dark:hover:text-teal-300 transition-colors flex items-center gap-1">
                        View Details
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    @if($completedSessions->hasPages())
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 px-6 py-4 shadow-sm">
        {{ $completedSessions->links() }}
    </div>
    @endif
</div>
@endif

<!-- Empty State -->
@if($pendingSessions->count() === 0 && $activeSessions->count() === 0 && $completedSessions->count() === 0)
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-12 text-center shadow-sm">
    <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 flex items-center justify-center">
        <span class="material-symbols-outlined text-5xl text-emerald-500 dark:text-emerald-400">support_agent</span>
    </div>
    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
        @if(array_filter($filters))
            No Sessions Found
        @else
            No Sessions Yet
        @endif
    </h3>
    <p class="text-gray-500 dark:text-gray-400">
        @if(array_filter($filters))
            No sessions match your current filter criteria. Try adjusting your filters or clearing them to see all sessions.
        @else
            You don't have any counseling sessions at the moment. New requests will appear here.
        @endif
    </p>
    @if(array_filter($filters))
    <div class="mt-4">
        <a href="{{ route('counselor.sessions.index') }}" class="text-blue-600 hover:text-blue-700 font-medium text-sm">
            Clear all filters
        </a>
    </div>
    @endif
</div>
@endif

<script>
function toggleFilters() {
    const panel = document.getElementById('filter-panel');
    const toggleText = document.getElementById('filter-toggle-text');
    const toggleIcon = document.getElementById('filter-toggle-icon');
    
    if (panel.classList.contains('hidden')) {
        panel.classList.remove('hidden');
        toggleText.textContent = 'Hide Filters';
        toggleIcon.textContent = 'expand_less';
        toggleIcon.classList.remove('rotate-180');
    } else {
        panel.classList.add('hidden');
        toggleText.textContent = 'Show Filters';
        toggleIcon.textContent = 'expand_more';
        toggleIcon.classList.add('rotate-180');
    }
}

// Auto-show filters if any are active
document.addEventListener('DOMContentLoaded', function() {
    const hasActiveFilters = {{ array_filter($filters) ? 'true' : 'false' }};
    if (hasActiveFilters) {
        // Show filters by default if any are active
        const panel = document.getElementById('filter-panel');
        const toggleText = document.getElementById('filter-toggle-text');
        const toggleIcon = document.getElementById('filter-toggle-icon');
        
        panel.classList.remove('hidden');
        toggleText.textContent = 'Hide Filters';
        toggleIcon.textContent = 'expand_less';
        toggleIcon.classList.remove('rotate-180');
    } else {
        // Hide filters by default if none are active
        const panel = document.getElementById('filter-panel');
        panel.classList.add('hidden');
    }
});
</script>
@endsection
