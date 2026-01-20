@extends('layouts.counselor')

@section('title', 'My Reports')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-2xl sm:text-3xl font-bold tracking-tight">My Reports</p>
        <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">Monthly statistics and session summaries</p>
    </div>
</div>

<!-- Monthly Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Current Month -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ now()->format('F Y') }}</h3>
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 rounded-xl p-2">
                <span class="material-symbols-outlined text-xl text-emerald-600 dark:text-emerald-400">trending_up</span>
            </div>
        </div>
        
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Total Sessions</span>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $monthlyStats['current_month']['total'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Completed</span>
                <span class="text-lg font-semibold text-emerald-600">{{ $monthlyStats['current_month']['completed'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Active</span>
                <span class="text-lg font-semibold text-green-600">{{ $monthlyStats['current_month']['active'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Pending</span>
                <span class="text-lg font-semibold text-yellow-600">{{ $monthlyStats['current_month']['pending'] }}</span>
            </div>
        </div>
    </div>

    <!-- Last Month Comparison -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ now()->subMonth()->format('F Y') }}</h3>
            <div class="bg-gradient-to-br from-teal-50 to-teal-100 dark:from-teal-900/20 dark:to-teal-800/20 rounded-xl p-2">
                <span class="material-symbols-outlined text-xl text-teal-600 dark:text-teal-400">history</span>
            </div>
        </div>
        
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Total Sessions</span>
                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $monthlyStats['last_month']['total'] }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Completed</span>
                <span class="text-lg font-semibold text-teal-600">{{ $monthlyStats['last_month']['completed'] }}</span>
            </div>
            
            @php
                $currentTotal = $monthlyStats['current_month']['total'];
                $lastTotal = $monthlyStats['last_month']['total'];
                $change = $currentTotal - $lastTotal;
                $changePercent = $lastTotal > 0 ? round(($change / $lastTotal) * 100) : 0;
            @endphp
            
            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">vs This Month</span>
                    <div class="flex items-center gap-1">
                        @if($change > 0)
                            <span class="material-symbols-outlined text-sm text-green-600">trending_up</span>
                            <span class="text-sm font-medium text-green-600">+{{ $change }} (+{{ $changePercent }}%)</span>
                        @elseif($change < 0)
                            <span class="material-symbols-outlined text-sm text-red-600">trending_down</span>
                            <span class="text-sm font-medium text-red-600">{{ $change }} ({{ $changePercent }}%)</span>
                        @else
                            <span class="text-sm font-medium text-gray-600">No change</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Completed Sessions -->
@if($recentSessions->count() > 0)
<div class="mb-8">
    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-emerald-600">history</span>
        Recent Completed Sessions
    </h2>
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-emerald-50 dark:bg-emerald-900/20 border-b border-emerald-100 dark:border-emerald-900/30">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Completed</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Duration</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($recentSessions as $session)
                    <tr class="hover:bg-emerald-50/50 dark:hover:bg-emerald-900/10 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white font-bold text-sm shadow-lg">
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
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $session->completed_at->format('M d, Y') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($session->started_at && $session->completed_at)
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $session->started_at->diffInMinutes($session->completed_at) }} min
                                </span>
                            @else
                                <span class="text-sm text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('counselor.sessions.show', $session) }}" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-medium text-sm transition-colors">
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

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 rounded-2xl p-6 border border-emerald-200 dark:border-emerald-800">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-white">psychology</span>
            </div>
            <h3 class="font-semibold text-emerald-900 dark:text-emerald-100">Completion Rate</h3>
        </div>
        <p class="text-2xl font-bold text-emerald-900 dark:text-emerald-100">
            @if($monthlyStats['current_month']['total'] > 0)
                {{ round(($monthlyStats['current_month']['completed'] / $monthlyStats['current_month']['total']) * 100) }}%
            @else
                0%
            @endif
        </p>
        <p class="text-sm text-emerald-700 dark:text-emerald-300 mt-1">This month</p>
    </div>

    <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-2xl p-6 border border-green-200 dark:border-green-800">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-white">groups</span>
            </div>
            <h3 class="font-semibold text-green-900 dark:text-green-100">Clients Helped</h3>
        </div>
        <p class="text-2xl font-bold text-green-900 dark:text-green-100">
            {{ \App\Models\User::where('role', 'user')->whereHas('counselingSessions', function($query) {
                $query->where('counselor_id', auth()->id())->where('status', 'completed');
            })->count() }}
        </p>
        <p class="text-sm text-green-700 dark:text-green-300 mt-1">Total unique clients</p>
    </div>

    <div class="bg-gradient-to-br from-teal-50 to-teal-100 dark:from-teal-900/20 dark:to-teal-800/20 rounded-2xl p-6 border border-teal-200 dark:border-teal-800">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-white">schedule</span>
            </div>
            <h3 class="font-semibold text-teal-900 dark:text-teal-100">Avg Session Time</h3>
        </div>
        <p class="text-2xl font-bold text-teal-900 dark:text-teal-100">
            @php
                $completedWithTime = auth()->user()->counselingAsProvider()
                    ->where('status', 'completed')
                    ->whereNotNull('started_at')
                    ->whereNotNull('completed_at')
                    ->get();
                $avgMinutes = $completedWithTime->count() > 0 
                    ? $completedWithTime->avg(function($session) {
                        return $session->started_at->diffInMinutes($session->completed_at);
                    }) 
                    : 0;
            @endphp
            {{ round($avgMinutes) }} min
        </p>
        <p class="text-sm text-teal-700 dark:text-teal-300 mt-1">Average duration</p>
    </div>
</div>
@endsection