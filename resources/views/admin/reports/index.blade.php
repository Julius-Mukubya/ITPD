@extends('layouts.admin')

@section('title', 'Analytics Dashboard - WellPath')

@section('content')
<!-- Analytics Header with Dark Theme -->
<div class="bg-gradient-to-r from-slate-900 via-purple-900 to-slate-900 rounded-2xl p-8 mb-8 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-600/20 to-purple-600/20"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-white/5 to-transparent rounded-full -translate-y-48 translate-x-48"></div>
    <div class="relative z-10">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-2xl text-white">analytics</span>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold">Analytics Dashboard</h1>
                        <p class="text-blue-100">Advanced insights and performance metrics</p>
                    </div>
                </div>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 text-center">
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3">
                        <div class="text-2xl font-bold">{{ number_format($stats['total_users']) }}</div>
                        <div class="text-xs text-blue-100">Total Users</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3">
                        <div class="text-2xl font-bold">{{ number_format($stats['total_sessions']) }}</div>
                        <div class="text-xs text-blue-100">Sessions</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3">
                        <div class="text-2xl font-bold">{{ number_format($stats['total_views']) }}</div>
                        <div class="text-xs text-blue-100">Content Views</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-lg p-3">
                        <div class="text-2xl font-bold">{{ number_format($stats['pass_rate'], 1) }}%</div>
                        <div class="text-xs text-blue-100">Pass Rate</div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin.reports.export', ['type' => 'users']) }}" class="bg-white/20 backdrop-blur-sm text-white border border-white/30 text-sm font-semibold px-6 py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-white/30 transition-all duration-200">
                    <span class="material-symbols-outlined text-lg">download</span>
                    Export Users
                </a>
                <a href="{{ route('admin.reports.export', ['type' => 'quiz_attempts']) }}" class="bg-white text-slate-900 text-sm font-semibold px-6 py-3 rounded-xl flex items-center justify-center gap-2 hover:bg-gray-100 transition-all duration-200">
                    <span class="material-symbols-outlined text-lg">download</span>
                    Export Data
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Key Performance Indicators -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- User Growth KPI -->
    <div class="bg-gradient-to-br from-slate-50 to-blue-50 dark:from-slate-800 dark:to-blue-900/20 border-l-4 border-blue-500 rounded-lg p-6 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="text-blue-600 dark:text-blue-400">
                <span class="material-symbols-outlined text-2xl">trending_up</span>
            </div>
            <div class="text-right">
                <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">User Growth</div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">+{{ $stats['new_users_week'] }}</div>
            </div>
        </div>
        <div class="text-xs text-gray-600 dark:text-gray-300">
            <span class="text-green-600 font-medium">{{ number_format($stats['user_retention_rate'], 1) }}%</span> retention rate
        </div>
    </div>

    <!-- Engagement KPI -->
    <div class="bg-gradient-to-br from-slate-50 to-emerald-50 dark:from-slate-800 dark:to-emerald-900/20 border-l-4 border-emerald-500 rounded-lg p-6 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="text-emerald-600 dark:text-emerald-400">
                <span class="material-symbols-outlined text-2xl">psychology</span>
            </div>
            <div class="text-right">
                <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Engagement</div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['content_engagement_rate'], 1) }}%</div>
            </div>
        </div>
        <div class="text-xs text-gray-600 dark:text-gray-300">
            <span class="text-emerald-600 font-medium">{{ number_format($stats['avg_views']) }}</span> avg views per content
        </div>
    </div>

    <!-- Performance KPI -->
    <div class="bg-gradient-to-br from-slate-50 to-purple-50 dark:from-slate-800 dark:to-purple-900/20 border-l-4 border-purple-500 rounded-lg p-6 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="text-purple-600 dark:text-purple-400">
                <span class="material-symbols-outlined text-2xl">assessment</span>
            </div>
            <div class="text-right">
                <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Performance</div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['quiz_completion_rate'], 1) }}%</div>
            </div>
        </div>
        <div class="text-xs text-gray-600 dark:text-gray-300">
            <span class="text-purple-600 font-medium">{{ number_format($stats['avg_quiz_score'], 1) }}%</span> average score
        </div>
    </div>

    <!-- Risk Assessment KPI -->
    <div class="bg-gradient-to-br from-slate-50 to-orange-50 dark:from-slate-800 dark:to-orange-900/20 border-l-4 border-orange-500 rounded-lg p-6 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <div class="text-orange-600 dark:text-orange-400">
                <span class="material-symbols-outlined text-2xl">health_and_safety</span>
            </div>
            <div class="text-right">
                <div class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Risk Assessments</div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['assessments_this_week'] }}</div>
            </div>
        </div>
        <div class="text-xs text-gray-600 dark:text-gray-300">
            <span class="text-red-600 font-medium">{{ $stats['high_risk_count'] }}</span> high risk cases
        </div>
    </div>
</div>

<!-- Primary Analytics Charts -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- User Growth Chart - Larger -->
    <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-600">show_chart</span>
                    User Growth Trend
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Monthly registration analysis</p>
            </div>
            <div class="flex items-center gap-2 bg-blue-50 dark:bg-blue-900/20 px-3 py-1 rounded-lg">
                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                <span class="text-xs font-medium text-blue-600 dark:text-blue-400">12 Months</span>
            </div>
        </div>
        <div class="h-80">
            <canvas id="userGrowthChart"></canvas>
        </div>
    </div>

    <!-- Daily Engagement Metrics -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-lg">
        <div class="mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600">bar_chart</span>
                Daily Activity
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Last 7 days</p>
        </div>
        <div class="h-80">
            <canvas id="dailyEngagementChart"></canvas>
        </div>
    </div>
</div>

<!-- Secondary Analytics Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Risk Assessment Trends -->
    <div class="bg-gradient-to-br from-white to-red-50/30 dark:from-gray-800 dark:to-red-900/10 rounded-xl border border-red-200 dark:border-red-900/30 p-6 shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-red-600">warning</span>
                    Risk Level Distribution
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Assessment risk tracking</p>
            </div>
        </div>
        <div class="h-72">
            <canvas id="riskTrendsChart"></canvas>
        </div>
    </div>

    <!-- Hourly Activity Pattern -->
    <div class="bg-gradient-to-br from-white to-purple-50/30 dark:from-gray-800 dark:to-purple-900/10 rounded-xl border border-purple-200 dark:border-purple-900/30 p-6 shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-purple-600">schedule</span>
                    Peak Activity Hours
                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">User activity heatmap</p>
            </div>
        </div>
        <div class="h-72">
            <canvas id="hourlyActivityChart"></canvas>
        </div>
    </div>
</div>

<!-- Detailed Analytics Tables -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- User Activity Breakdown -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-600">people</span>
                User Activity
            </h3>
            <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs px-2 py-1 rounded-full font-medium">Live</span>
        </div>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">Active Today</span>
                </div>
                <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $stats['active_users_today'] }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">This Week</span>
                </div>
                <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $stats['active_users_week'] }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="flex items-center gap-3">
                    <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">This Month</span>
                </div>
                <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $stats['active_users_month'] }}</span>
            </div>
            <div class="pt-3 border-t border-gray-200 dark:border-gray-600">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Retention Rate</span>
                    <span class="font-bold text-green-600">{{ number_format($stats['user_retention_rate'], 1) }}%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Metrics -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600">analytics</span>
                Performance
            </h3>
            <span class="bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 text-xs px-2 py-1 rounded-full font-medium">Metrics</span>
        </div>
        <div class="space-y-4">
            <div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-600 dark:text-gray-400">Content Engagement</span>
                    <span class="font-bold text-gray-900 dark:text-white">{{ number_format($stats['content_engagement_rate'], 1) }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-gradient-to-r from-emerald-500 to-blue-500 h-2 rounded-full transition-all duration-500" style="width: {{ $stats['content_engagement_rate'] }}%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-600 dark:text-gray-400">Quiz Pass Rate</span>
                    <span class="font-bold text-gray-900 dark:text-white">{{ number_format($stats['pass_rate'], 1) }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-500 h-2 rounded-full transition-all duration-500" style="width: {{ $stats['pass_rate'] }}%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-sm mb-2">
                    <span class="text-gray-600 dark:text-gray-400">Completion Rate</span>
                    <span class="font-bold text-gray-900 dark:text-white">{{ number_format($stats['quiz_completion_rate'], 1) }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-2 rounded-full transition-all duration-500" style="width: {{ $stats['quiz_completion_rate'] }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Risk Assessment Summary -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-red-600">health_and_safety</span>
                Risk Levels
            </h3>
            <span class="bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-xs px-2 py-1 rounded-full font-medium">Critical</span>
        </div>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                <div class="flex items-center gap-3">
                    <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                    <span class="text-sm font-medium text-green-700 dark:text-green-300">Low Risk</span>
                </div>
                <span class="text-lg font-bold text-green-700 dark:text-green-300">{{ $stats['low_risk_count'] }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg border border-yellow-200 dark:border-yellow-800">
                <div class="flex items-center gap-3">
                    <div class="w-4 h-4 bg-yellow-500 rounded-full"></div>
                    <span class="text-sm font-medium text-yellow-700 dark:text-yellow-300">Medium Risk</span>
                </div>
                <span class="text-lg font-bold text-yellow-700 dark:text-yellow-300">{{ $stats['medium_risk_count'] }}</span>
            </div>
            <div class="flex items-center justify-between p-3 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                <div class="flex items-center gap-3">
                    <div class="w-4 h-4 bg-red-500 rounded-full animate-pulse"></div>
                    <span class="text-sm font-medium text-red-700 dark:text-red-300">High Risk</span>
                </div>
                <span class="text-lg font-bold text-red-700 dark:text-red-300">{{ $stats['high_risk_count'] }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Performance Leaderboards -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Top Content Leaderboard -->
    <div class="bg-gradient-to-br from-white to-blue-50/50 dark:from-gray-800 dark:to-blue-900/10 rounded-xl border border-blue-200 dark:border-blue-900/30 p-6 shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-600">trending_up</span>
                Content Leaderboard
            </h3>
            <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs px-2 py-1 rounded-full font-medium">Top 5</span>
        </div>
        <div class="space-y-3">
            @forelse($contentPerformance->take(5) as $index => $content)
            <div class="flex items-center gap-4 p-3 bg-white dark:bg-gray-700 rounded-lg border border-gray-100 dark:border-gray-600">
                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                    {{ $index + 1 }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ Str::limit($content->title, 35) }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $content->created_at->diffForHumans() }}</p>
                </div>
                <div class="flex items-center gap-1 bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded-lg">
                    <span class="material-symbols-outlined text-blue-500 text-sm">visibility</span>
                    <span class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ number_format($content->views) }}</span>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-gray-400 text-2xl">article</span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">No content data available</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Counselor Performance Leaderboard -->
    <div class="bg-gradient-to-br from-white to-emerald-50/50 dark:from-gray-800 dark:to-emerald-900/10 rounded-xl border border-emerald-200 dark:border-emerald-900/30 p-6 shadow-lg">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600">leaderboard</span>
                Counselor Rankings
            </h3>
            <span class="bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 text-xs px-2 py-1 rounded-full font-medium">Top 5</span>
        </div>
        <div class="space-y-3">
            @forelse($counselorStats->take(5) as $index => $counselor)
            <div class="flex items-center gap-4 p-3 bg-white dark:bg-gray-700 rounded-lg border border-gray-100 dark:border-gray-600">
                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-full flex items-center justify-center text-white text-sm font-bold">
                    {{ $index + 1 }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $counselor['name'] }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $counselor['total_sessions'] }} sessions • {{ number_format($counselor['completion_rate'], 1) }}% completion</p>
                </div>
                <div class="flex items-center gap-1">
                    <div class="flex text-yellow-400">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="material-symbols-outlined text-xs">{{ $i <= $counselor['avg_rating'] ? 'star' : 'star_border' }}</span>
                        @endfor
                    </div>
                    <span class="text-sm font-bold text-gray-900 dark:text-white ml-1">{{ number_format($counselor['avg_rating'], 1) }}</span>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-gray-400 text-2xl">support_agent</span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">No counselor data available</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Data Export Center -->
<div class="bg-gradient-to-r from-slate-900 via-gray-900 to-slate-900 rounded-2xl p-8 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-purple-600/10"></div>
    <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-br from-white/5 to-transparent rounded-full -translate-y-48 -translate-x-48"></div>
    <div class="relative z-10">
        <div class="text-center mb-8">
            <h3 class="text-2xl font-bold mb-2 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-3xl">cloud_download</span>
                Data Export Center
            </h3>
            <p class="text-gray-300">Export comprehensive reports and analytics data</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('admin.reports.export', ['type' => 'users']) }}" class="group bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-6 hover:bg-white/20 transition-all duration-200 hover:-translate-y-1">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-200">
                        <span class="material-symbols-outlined text-2xl text-white">group</span>
                    </div>
                    <h4 class="font-bold text-lg mb-2">User Analytics</h4>
                    <p class="text-sm text-gray-300 mb-4">Complete user data, activity patterns, and engagement metrics</p>
                    <div class="flex items-center justify-center gap-2 text-emerald-400">
                        <span class="material-symbols-outlined text-sm">download</span>
                        <span class="text-sm font-medium">Export CSV</span>
                    </div>
                </div>
            </a>
            <a href="{{ route('admin.reports.export', ['type' => 'quiz_attempts']) }}" class="group bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-6 hover:bg-white/20 transition-all duration-200 hover:-translate-y-1">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-200">
                        <span class="material-symbols-outlined text-2xl text-white">quiz</span>
                    </div>
                    <h4 class="font-bold text-lg mb-2">Assessment Data</h4>
                    <p class="text-sm text-gray-300 mb-4">Quiz attempts, scores, performance analytics and trends</p>
                    <div class="flex items-center justify-center gap-2 text-blue-400">
                        <span class="material-symbols-outlined text-sm">download</span>
                        <span class="text-sm font-medium">Export CSV</span>
                    </div>
                </div>
            </a>
            <a href="{{ route('admin.reports.export', ['type' => 'counseling_sessions']) }}" class="group bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-6 hover:bg-white/20 transition-all duration-200 hover:-translate-y-1">
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-200">
                        <span class="material-symbols-outlined text-2xl text-white">support_agent</span>
                    </div>
                    <h4 class="font-bold text-lg mb-2">Session Reports</h4>
                    <p class="text-sm text-gray-300 mb-4">Counseling sessions, outcomes, and satisfaction data</p>
                    <div class="flex items-center justify-center gap-2 text-purple-400">
                        <span class="material-symbols-outlined text-sm">download</span>
                        <span class="text-sm font-medium">Export CSV</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // User Growth Chart
    const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
    new Chart(userGrowthCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyUsers->pluck('month')) !!},
            datasets: [{
                label: 'New Users',
                data: {!! json_encode($monthlyUsers->pluck('count')) !!},
                borderColor: '#10b77f',
                backgroundColor: 'rgba(16, 183, 127, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 2
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
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // Daily Engagement Chart
    const dailyEngagementCtx = document.getElementById('dailyEngagementChart').getContext('2d');
    new Chart(dailyEngagementCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($dailyEngagement->pluck('date')) !!},
            datasets: [
                {
                    label: 'Active Users',
                    data: {!! json_encode($dailyEngagement->pluck('users')) !!},
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderColor: '#3b82f6',
                    borderWidth: 1
                },
                {
                    label: 'Sessions',
                    data: {!! json_encode($dailyEngagement->pluck('sessions')) !!},
                    backgroundColor: 'rgba(16, 183, 127, 0.8)',
                    borderColor: '#10b77f',
                    borderWidth: 1
                },
                {
                    label: 'Assessments',
                    data: {!! json_encode($dailyEngagement->pluck('assessments')) !!},
                    backgroundColor: 'rgba(168, 85, 247, 0.8)',
                    borderColor: '#a855f7',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // Risk Trends Chart
    const riskTrendsCtx = document.getElementById('riskTrendsChart').getContext('2d');
    new Chart(riskTrendsCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($riskTrends->pluck('date')) !!},
            datasets: [
                {
                    label: 'Low Risk',
                    data: {!! json_encode($riskTrends->pluck('low')) !!},
                    borderColor: '#22c55e',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 2
                },
                {
                    label: 'Medium Risk',
                    data: {!! json_encode($riskTrends->pluck('medium')) !!},
                    borderColor: '#eab308',
                    backgroundColor: 'rgba(234, 179, 8, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 2
                },
                {
                    label: 'High Risk',
                    data: {!! json_encode($riskTrends->pluck('high')) !!},
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 2
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });

    // Hourly Activity Chart
    const hourlyActivityCtx = document.getElementById('hourlyActivityChart').getContext('2d');
    new Chart(hourlyActivityCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($hourlyActivity->pluck('hour')->map(function($h) { return $h . ':00'; })) !!},
            datasets: [{
                label: 'Active Users',
                data: {!! json_encode($hourlyActivity->pluck('activity')) !!},
                backgroundColor: function(context) {
                    const value = context.parsed.y;
                    const max = Math.max(...context.dataset.data);
                    const intensity = value / max;
                    return `rgba(16, 183, 127, ${0.3 + intensity * 0.7})`;
                },
                borderColor: '#10b77f',
                borderWidth: 1
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
                    ticks: {
                        precision: 0
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 45,
                        minRotation: 45
                    }
                }
            }
        }
    });
});
</script>
@endpush
