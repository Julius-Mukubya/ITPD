@extends('layouts.admin')

@section('title', 'Analytics & Reports - Admin')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Analytics & Reports</h2>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Comprehensive insights into system performance and user engagement</p>
        </div>
        <div class="flex items-center gap-3">
            <!-- Date Range Selector -->
            <select id="dateRangeFilter" class="px-4 py-2 pr-10 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary/20 focus:border-primary appearance-none cursor-pointer min-w-[140px]">
                <option value="7">Last 7 days</option>
                <option value="30" selected>Last 30 days</option>
                <option value="90">Last 90 days</option>
                <option value="365">Last year</option>
            </select>
            <!-- Custom dropdown arrow -->
            <div class="relative -ml-10 pointer-events-none">
                <span class="material-symbols-outlined text-gray-400 text-sm">expand_more</span>
            </div>
            <!-- Export All Button -->
            <button onclick="exportAllData()" class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors">
                <span class="material-symbols-outlined text-sm">download</span>
                Export All
            </button>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_users'] ?? 0) }}</p>
                    <div class="flex items-center gap-1 mt-2">
                        <span class="material-symbols-outlined text-green-500 text-sm">trending_up</span>
                        <span class="text-sm text-green-600 dark:text-green-400">+{{ $stats['new_users_week'] ?? 0 }} this week</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-xl">group</span>
                </div>
            </div>
        </div>

        <!-- Active Sessions Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Sessions</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['active_sessions'] ?? 0) }}</p>
                    <div class="flex items-center gap-1 mt-2">
                        <span class="material-symbols-outlined text-orange-500 text-sm">schedule</span>
                        <span class="text-sm text-gray-600 dark:text-gray-400">{{ $stats['pending_sessions'] ?? 0 }} pending</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-xl">support_agent</span>
                </div>
            </div>
        </div>

        <!-- Assessment Risk Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">High Risk Cases</p>
                    <p class="text-3xl font-bold text-red-600 dark:text-red-400">{{ number_format($stats['high_risk_count'] ?? 0) }}</p>
                    <div class="flex items-center gap-1 mt-2">
                        <span class="material-symbols-outlined text-red-500 text-sm">warning</span>
                        <span class="text-sm text-red-600 dark:text-red-400">Requires attention</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-xl">psychology</span>
                </div>
            </div>
        </div>

        <!-- Content Engagement Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Content Views</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_views'] ?? 0) }}</p>
                    <div class="flex items-center gap-1 mt-2">
                        <span class="material-symbols-outlined text-purple-500 text-sm">visibility</span>
                        <span class="text-sm text-purple-600 dark:text-purple-400">{{ number_format($stats['content_engagement_rate'] ?? 0, 1) }}% engagement</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-purple-600 dark:text-purple-400 text-xl">article</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Visualizations -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- User Activity Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daily User Activity</h3>
                <button class="text-sm text-primary hover:underline">View Details</button>
            </div>
            <div class="h-64">
                <canvas id="userActivityChart"></canvas>
            </div>
        </div>

        <!-- Risk Assessment Trends -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Risk Assessment Trends</h3>
                <button class="text-sm text-primary hover:underline">View Details</button>
            </div>
            <div class="h-64">
                <canvas id="riskTrendsChart"></canvas>
            </div>
        </div>

        <!-- Content Performance -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Content Performance</h3>
                <button class="text-sm text-primary hover:underline">View All</button>
            </div>
            <div class="h-64">
                <canvas id="contentPerformanceChart"></canvas>
            </div>
        </div>

        <!-- Session Statistics -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Session Statistics</h3>
                <button class="text-sm text-primary hover:underline">View Details</button>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Completion Rate</span>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ number_format(($stats['completed_sessions'] ?? 0) / max($stats['total_sessions'] ?? 1, 1) * 100, 1) }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ ($stats['completed_sessions'] ?? 0) / max($stats['total_sessions'] ?? 1, 1) * 100 }}%"></div>
                </div>
                
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Average Rating</span>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ number_format($stats['session_satisfaction'] ?? 0, 1) }}/5.0</span>
                </div>
                <div class="flex items-center gap-1">
                    @for($i = 1; $i <= 5; $i++)
                        <span class="material-symbols-outlined text-sm {{ $i <= ($stats['session_satisfaction'] ?? 0) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}">star</span>
                    @endfor
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Avg Duration</span>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ number_format($stats['avg_session_duration'] ?? 0) }} min</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Tables Section -->
    <div class="space-y-6">
        <!-- Recent Activity Table -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent System Activity</h3>
                    <div class="flex items-center gap-2">
                        <button onclick="exportTable('recent-activity')" class="inline-flex items-center gap-1 text-sm text-gray-600 dark:text-gray-400 hover:text-primary">
                            <span class="material-symbols-outlined text-sm">download</span>
                            Export
                        </button>
                        <button class="inline-flex items-center gap-1 text-sm text-gray-600 dark:text-gray-400 hover:text-primary">
                            <span class="material-symbols-outlined text-sm">refresh</span>
                            Refresh
                        </button>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Activity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($dailyEngagement->take(10) as $activity)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-primary/20 rounded-full flex items-center justify-center">
                                        <span class="material-symbols-outlined text-primary text-sm">person</span>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">System Activity</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ $activity['users'] }} users active</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $activity['sessions'] }} sessions, {{ $activity['assessments'] }} assessments
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                    Daily Summary
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300">
                                    Active
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $activity['date'] }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                <span class="material-symbols-outlined text-4xl mb-2">analytics</span>
                                <p>No recent activity data available</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Export Options Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Users Export -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-xl">group</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Users Report</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">All user accounts and profiles</p>
                    </div>
                </div>
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Total Users:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ number_format($stats['total_users'] ?? 0) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Active This Month:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ number_format($stats['active_users_month'] ?? 0) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Counselors:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ number_format($stats['total_counselors'] ?? 0) }}</span>
                    </div>
                </div>
                <a href="{{ route('admin.reports.export', ['type' => 'users']) }}" class="w-full bg-primary text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 hover:bg-primary/90 transition-colors">
                    <span class="material-symbols-outlined text-sm">download</span>
                    Export Users CSV
                </a>
            </div>

            <!-- Assessments Export -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-xl">psychology</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Assessments Report</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Mental health assessment results</p>
                    </div>
                </div>
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Total Assessments:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ number_format($stats['total_assessments'] ?? 0) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">High Risk:</span>
                        <span class="font-medium text-red-600">{{ number_format($stats['high_risk_count'] ?? 0) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">This Week:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ number_format($stats['assessments_this_week'] ?? 0) }}</span>
                    </div>
                </div>
                <a href="{{ route('admin.reports.export', ['type' => 'assessments']) }}" class="w-full bg-primary text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 hover:bg-primary/90 transition-colors">
                    <span class="material-symbols-outlined text-sm">download</span>
                    Export Assessments CSV
                </a>
            </div>

            <!-- Sessions Export -->
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-xl">support_agent</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Sessions Report</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Counseling session data</p>
                    </div>
                </div>
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Total Sessions:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ number_format($stats['total_sessions'] ?? 0) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Completed:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ number_format($stats['completed_sessions'] ?? 0) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Active:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ number_format($stats['active_sessions'] ?? 0) }}</span>
                    </div>
                </div>
                <a href="{{ route('admin.reports.export', ['type' => 'counseling_sessions']) }}" class="w-full bg-primary text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2 hover:bg-primary/90 transition-colors">
                    <span class="material-symbols-outlined text-sm">download</span>
                    Export Sessions CSV
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Date Range Filter Functionality
    const dateRangeFilter = document.getElementById('dateRangeFilter');
    if (dateRangeFilter) {
        dateRangeFilter.addEventListener('change', function() {
            const selectedDays = this.value;
            // Show loading state
            showLoadingState();
            
            // Reload page with new date range parameter
            const url = new URL(window.location);
            url.searchParams.set('days', selectedDays);
            window.location.href = url.toString();
        });
    }

    // Show loading state function
    function showLoadingState() {
        // Add loading overlay
        const loadingOverlay = document.createElement('div');
        loadingOverlay.className = 'fixed inset-0 bg-black/20 flex items-center justify-center z-50';
        loadingOverlay.innerHTML = `
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 flex items-center gap-3 shadow-lg">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-primary"></div>
                <span class="text-gray-900 dark:text-white">Updating reports...</span>
            </div>
        `;
        document.body.appendChild(loadingOverlay);
    }

    // User Activity Chart
    const userActivityCtx = document.getElementById('userActivityChart').getContext('2d');
    new Chart(userActivityCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($dailyEngagement->pluck('date')) !!},
            datasets: [{
                label: 'Active Users',
                data: {!! json_encode($dailyEngagement->pluck('users')) !!},
                borderColor: '#14eba3',
                backgroundColor: 'rgba(20, 235, 163, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Risk Trends Chart
    const riskTrendsCtx = document.getElementById('riskTrendsChart').getContext('2d');
    new Chart(riskTrendsCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($riskTrends->pluck('date')) !!},
            datasets: [
                {
                    label: 'Low Risk',
                    data: {!! json_encode($riskTrends->pluck('low')) !!},
                    backgroundColor: '#10b981'
                },
                {
                    label: 'Medium Risk',
                    data: {!! json_encode($riskTrends->pluck('medium')) !!},
                    backgroundColor: '#f59e0b'
                },
                {
                    label: 'High Risk',
                    data: {!! json_encode($riskTrends->pluck('high')) !!},
                    backgroundColor: '#ef4444'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    stacked: true,
                    grid: {
                        display: false
                    }
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                }
            }
        }
    });

    // Content Performance Chart
    const contentPerformanceCtx = document.getElementById('contentPerformanceChart').getContext('2d');
    new Chart(contentPerformanceCtx, {
        type: 'doughnut',
        data: {
            labels: ['Published', 'Draft', 'Archived'],
            datasets: [{
                data: [{{ $stats['published_contents'] ?? 0 }}, {{ ($stats['total_contents'] ?? 0) - ($stats['published_contents'] ?? 0) }}, 0],
                backgroundColor: ['#14eba3', '#6b7280', '#ef4444']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Set the correct selected value based on URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const daysParam = urlParams.get('days');
    if (daysParam && dateRangeFilter) {
        dateRangeFilter.value = daysParam;
    }
});

// Export Functions
function exportAllData() {
    // Create a comprehensive export with all data
    window.open('{{ route("admin.reports.export", ["type" => "all"]) }}', '_blank');
}

function exportTable(tableId) {
    // Export specific table data
    console.log('Exporting table:', tableId);
    // Implementation for table-specific exports
}
</script>
@endsection