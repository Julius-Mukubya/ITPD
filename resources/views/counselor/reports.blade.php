@extends('layouts.counselor')

@section('title', 'My Reports')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-2xl sm:text-3xl font-bold tracking-tight">My Reports</p>
        <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">Monthly statistics and session summaries</p>
    </div>
    <div class="flex items-center gap-2">
        <button onclick="document.getElementById('exportModal').classList.remove('hidden')" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-semibold px-6 py-3 rounded-xl flex items-center justify-center gap-2 hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-200">
            <span class="material-symbols-outlined text-lg">download</span>
            Export Data
        </button>
    </div>
</div>

<!-- Monthly Statistics -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Current Month -->
    <div class="group bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-emerald-600"></div>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ now()->format('F Y') }}</h3>
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
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
    <div class="group bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm hover:shadow-lg hover:shadow-teal-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-teal-500 to-teal-600"></div>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ now()->subMonth()->format('F Y') }}</h3>
            <div class="bg-gradient-to-br from-teal-50 to-teal-100 dark:from-teal-900/20 dark:to-teal-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
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
    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-emerald-600"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Completion Rate</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-xl text-emerald-600 dark:text-emerald-400">psychology</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">
                @if($monthlyStats['current_month']['total'] > 0)
                    {{ round(($monthlyStats['current_month']['completed'] / $monthlyStats['current_month']['total']) * 100) }}%
                @else
                    0%
                @endif
            </p>
            <div class="flex items-center">
                <div class="flex items-center bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-emerald-600">check_circle</span>
                    <span class="text-xs font-medium text-emerald-600">This Month</span>
                </div>
            </div>
        </div>
    </div>

    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-green-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-green-600"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Clients Helped</p>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-xl text-green-600 dark:text-green-400">groups</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ \App\Models\User::where('role', 'user')->whereHas('counselingSessions', function($query) {
                    $query->where('counselor_id', auth()->id())->where('status', 'completed');
                })->count() }}
            </p>
            <div class="flex items-center">
                <div class="flex items-center bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-green-600">people</span>
                    <span class="text-xs font-medium text-green-600">Unique Clients</span>
                </div>
            </div>
        </div>
    </div>

    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-teal-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-teal-500 to-teal-600"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-teal-500 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Avg Session Time</p>
            </div>
            <div class="bg-gradient-to-br from-teal-50 to-teal-100 dark:from-teal-900/20 dark:to-teal-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-xl text-teal-600 dark:text-teal-400">schedule</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">
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
            <div class="flex items-center">
                <div class="flex items-center bg-teal-50 dark:bg-teal-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-teal-600">timer</span>
                    <span class="text-xs font-medium text-teal-600">Average Duration</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div id="exportModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4" style="z-index: 9999;">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 max-w-md w-full shadow-2xl border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Export Reports</h3>
            <button onclick="document.getElementById('exportModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <form id="exportForm" method="GET" action="{{ route('counselor.reports.export') }}" class="space-y-4">
            <!-- Export Type -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Export Type</label>
                <div class="space-y-2">
                    <label class="flex items-center gap-2 p-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                        <input type="radio" name="type" value="sessions" checked class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500">
                        <div>
                            <div class="font-medium text-gray-900 dark:text-white text-sm">Sessions Data</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Detailed session information</div>
                        </div>
                    </label>
                    <label class="flex items-center gap-2 p-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                        <input type="radio" name="type" value="notes" class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500">
                        <div>
                            <div class="font-medium text-gray-900 dark:text-white text-sm">Session Notes</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">All notes and observations</div>
                        </div>
                    </label>
                    <label class="flex items-center gap-2 p-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                        <input type="radio" name="type" value="summary" class="w-4 h-4 text-emerald-600 border-gray-300 focus:ring-emerald-500">
                        <div>
                            <div class="font-medium text-gray-900 dark:text-white text-sm">Summary Report</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Statistical summary</div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Time Period -->
            <div>
                <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Time Period</label>
                <select name="period" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white transition-all">
                    <option value="current_month">Current Month</option>
                    <option value="last_month">Last Month</option>
                    <option value="all_time">All Time</option>
                </select>
            </div>

            <!-- Export Info -->
            <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg">
                <div class="flex items-start gap-2">
                    <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-sm mt-0.5">info</span>
                    <div class="text-xs text-emerald-800 dark:text-emerald-200">
                        <p class="font-medium mb-1">Export Information</p>
                        <p>Data will be exported as CSV for Excel analysis.</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex gap-2 pt-2">
                <button type="submit" class="flex-1 bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-4 py-2 rounded-lg font-semibold hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-200 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">download</span>
                    Export CSV
                </button>
                <button type="button" onclick="document.getElementById('exportModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-300 dark:hover:bg-gray-500 transition-all">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Handle export form submission
document.getElementById('exportForm').addEventListener('submit', function(e) {
    // Close modal after a short delay to allow download to start
    setTimeout(function() {
        document.getElementById('exportModal').classList.add('hidden');
    }, 500);
});

// Close modal when clicking outside
document.getElementById('exportModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});
</script>
@endsection