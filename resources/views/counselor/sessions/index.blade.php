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

<!-- Pending Sessions -->
@if($pendingSessions->count() > 0)
<div class="mb-8">
    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-emerald-600">pending_actions</span>
        Pending Requests
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($pendingSessions as $session)
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                        {{ substr($session->student->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ $session->student->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $session->student->email }}</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-xs font-semibold rounded-full">
                    {{ ucfirst($session->priority) }}
                </span>
            </div>

            <div class="mb-4">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                    <span class="font-semibold">Type:</span> {{ ucfirst(str_replace('_', ' ', $session->session_type)) }}
                </p>
                <p class="text-sm text-gray-700 dark:text-gray-300 line-clamp-2">{{ $session->reason }}</p>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">schedule</span>
                    {{ $session->created_at->diffForHumans() }}
                </span>
                <a href="{{ route('counselor.sessions.show', $session) }}" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-4 py-2 rounded-lg hover:shadow-lg hover:shadow-emerald-500/30 font-medium text-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">visibility</span>
                    View Details
                </a>
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
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-green-50 dark:bg-green-900/20 border-b border-green-100 dark:border-green-900/30">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Student</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Priority</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Started</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($activeSessions as $session)
                    <tr class="hover:bg-green-50/50 dark:hover:bg-green-900/10 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white font-bold shadow-lg">
                                    {{ substr($session->student->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $session->student->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $session->student->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $session->session_type)) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-{{ $session->priority === 'high' ? 'red' : ($session->priority === 'medium' ? 'yellow' : 'green') }}-100 dark:bg-{{ $session->priority === 'high' ? 'red' : ($session->priority === 'medium' ? 'yellow' : 'green') }}-900/30 text-{{ $session->priority === 'high' ? 'red' : ($session->priority === 'medium' ? 'yellow' : 'green') }}-700 dark:text-{{ $session->priority === 'high' ? 'red' : ($session->priority === 'medium' ? 'yellow' : 'green') }}-300 text-xs font-semibold rounded-full">
                                {{ ucfirst($session->priority) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $session->started_at->diffForHumans() }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('counselor.sessions.show', $session) }}" class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 font-medium text-sm transition-all">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                                View Session
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-teal-50 dark:bg-teal-900/20 border-b border-teal-100 dark:border-teal-900/30">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Student</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Completed</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($completedSessions as $session)
                    <tr class="hover:bg-teal-50/50 dark:hover:bg-teal-900/10 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center text-white font-bold shadow-lg">
                                    {{ substr($session->student->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $session->student->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $session->student->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $session->session_type)) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $session->completed_at->format('M d, Y') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('counselor.sessions.show', $session) }}" class="inline-flex items-center gap-2 text-teal-600 hover:text-teal-700 font-medium text-sm transition-colors">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                                View Details
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($completedSessions->hasPages())
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-200 dark:border-gray-700">
            {{ $completedSessions->links() }}
        </div>
        @endif
    </div>
</div>
@endif

<!-- Empty State -->
@if($pendingSessions->count() === 0 && $activeSessions->count() === 0 && $completedSessions->count() === 0)
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-12 text-center shadow-sm">
    <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 flex items-center justify-center">
        <span class="material-symbols-outlined text-5xl text-emerald-500 dark:text-emerald-400">support_agent</span>
    </div>
    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No Sessions Yet</h3>
    <p class="text-gray-500 dark:text-gray-400">You don't have any counseling sessions at the moment. New requests will appear here.</p>
</div>
@endif
@endsection
