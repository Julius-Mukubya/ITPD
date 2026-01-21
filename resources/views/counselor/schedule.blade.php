@extends('layouts.counselor')

@section('title', 'My Schedule')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-2xl sm:text-3xl font-bold tracking-tight">My Schedule</p>
        <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">Your upcoming counseling sessions</p>
    </div>
</div>

<!-- Today's Sessions -->
@if($todaysSessions->count() > 0)
<div class="mb-8">
    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-emerald-600">today</span>
        Today's Sessions
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($todaysSessions as $session)
        <div class="group bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-emerald-600"></div>
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                        {{ substr($session->student->name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">{{ $session->student->name }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ ucfirst(str_replace('_', ' ', $session->session_type)) }}</p>
                    </div>
                </div>
                <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-xs font-semibold rounded-full">
                    {{ $session->scheduled_at ? $session->scheduled_at->format('g:i A') : 'TBD' }}
                </span>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-gray-200 dark:border-gray-700">
                <span class="px-3 py-1 bg-{{ $session->status === 'active' ? 'green' : 'yellow' }}-100 dark:bg-{{ $session->status === 'active' ? 'green' : 'yellow' }}-900/30 text-{{ $session->status === 'active' ? 'green' : 'yellow' }}-700 dark:text-{{ $session->status === 'active' ? 'green' : 'yellow' }}-300 text-xs font-semibold rounded-full">
                    {{ ucfirst($session->status) }}
                </span>
                <a href="{{ route('counselor.sessions.show', $session) }}" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-4 py-2 rounded-lg hover:shadow-lg hover:shadow-emerald-500/30 font-medium text-sm transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">visibility</span>
                    View Session
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- This Week's Sessions -->
@if($weekSessions->count() > 0)
<div class="mb-8">
    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-green-600">calendar_month</span>
        This Week's Sessions
    </h2>
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-green-50 dark:bg-green-900/20 border-b border-green-100 dark:border-green-900/30">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Date & Time</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($weekSessions as $session)
                    <tr class="hover:bg-green-50/50 dark:hover:bg-green-900/10 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ $session->scheduled_at ? $session->scheduled_at->format('M d, Y') : 'TBD' }}
                                </p>
                                <p class="text-gray-500 dark:text-gray-400">
                                    {{ $session->scheduled_at ? $session->scheduled_at->format('g:i A') : 'Time TBD' }}
                                </p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                    {{ substr($session->student->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $session->student->name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $session->session_type)) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-{{ $session->status === 'active' ? 'green' : 'yellow' }}-100 dark:bg-{{ $session->status === 'active' ? 'green' : 'yellow' }}-900/30 text-{{ $session->status === 'active' ? 'green' : 'yellow' }}-700 dark:text-{{ $session->status === 'active' ? 'green' : 'yellow' }}-300 text-xs font-semibold rounded-full">
                                {{ ucfirst($session->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('counselor.sessions.show', $session) }}" class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 font-medium text-sm transition-colors">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                                View
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

<!-- All Upcoming Sessions -->
@if($upcomingSessions->count() > 0)
<div class="mb-8">
    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-teal-600">schedule</span>
        All Upcoming Sessions
    </h2>
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-teal-50 dark:bg-teal-900/20 border-b border-teal-100 dark:border-teal-900/30">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Date & Time</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($upcomingSessions as $session)
                    <tr class="hover:bg-teal-50/50 dark:hover:bg-teal-900/10 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm">
                                <p class="font-medium text-gray-900 dark:text-white">
                                    {{ $session->scheduled_at ? $session->scheduled_at->format('M d, Y') : 'TBD' }}
                                </p>
                                <p class="text-gray-500 dark:text-gray-400">
                                    {{ $session->scheduled_at ? $session->scheduled_at->format('g:i A') : 'Time TBD' }}
                                </p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-teal-500 to-teal-600 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                                    {{ substr($session->student->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $session->student->name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ ucfirst(str_replace('_', ' ', $session->session_type)) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-{{ $session->status === 'active' ? 'green' : 'yellow' }}-100 dark:bg-{{ $session->status === 'active' ? 'green' : 'yellow' }}-900/30 text-{{ $session->status === 'active' ? 'green' : 'yellow' }}-700 dark:text-{{ $session->status === 'active' ? 'green' : 'yellow' }}-300 text-xs font-semibold rounded-full">
                                {{ ucfirst($session->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('counselor.sessions.show', $session) }}" class="inline-flex items-center gap-2 text-teal-600 hover:text-teal-700 font-medium text-sm transition-colors">
                                <span class="material-symbols-outlined text-sm">visibility</span>
                                View
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

<!-- Empty State -->
@if($upcomingSessions->count() === 0)
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-12 text-center shadow-sm">
    <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 flex items-center justify-center">
        <span class="material-symbols-outlined text-5xl text-emerald-500 dark:text-emerald-400">event_available</span>
    </div>
    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No Upcoming Sessions</h3>
    <p class="text-gray-500 dark:text-gray-400">You don't have any scheduled sessions at the moment. New sessions will appear here.</p>
</div>
@endif
@endsection