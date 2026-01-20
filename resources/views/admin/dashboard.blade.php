@extends('layouts.admin')

@section('title', 'Admin Dashboard - WellPath')

@section('content')
<!-- PageHeading -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-2xl sm:text-3xl font-bold tracking-tight">Admin Dashboard</p>
        <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">Welcome back, {{ auth()->user()->name }}!</p>
    </div>
    <a href="{{ route('admin.reports.index') }}" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-semibold px-6 py-3 rounded-xl flex items-center justify-center gap-2 hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-200 w-full sm:w-auto">
        <span class="material-symbols-outlined text-lg">summarize</span>
        View Reports
    </a>
</div>

<!-- Key Metrics Overview -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-emerald-600"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Total Users</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-xl text-emerald-600 dark:text-emerald-400">school</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $data['total_users'] }}</p>
            <div class="flex items-center">
                <div class="flex items-center bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-green-600">trending_up</span>
                    <span class="text-xs font-medium text-green-600">+{{ $data['user_growth'] }}%</span>
                </div>
                <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">this month</span>
            </div>
        </div>
    </div>

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
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $data['active_sessions'] }}</p>
            <div class="flex items-center">
                <div class="flex items-center bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-emerald-600">support_agent</span>
                    <span class="text-xs font-medium text-emerald-600">{{ $data['this_month_sessions'] }}</span>
                </div>
                <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">this month</span>
            </div>
        </div>
    </div>

    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-teal-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-teal-500 to-teal-600"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-teal-500 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Content Views</p>
            </div>
            <div class="bg-gradient-to-br from-teal-50 to-teal-100 dark:from-teal-900/20 dark:to-teal-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-xl text-teal-600 dark:text-teal-400">library_books</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($data['total_content_views']) }}</p>
            <div class="flex items-center">
                <div class="flex items-center bg-teal-50 dark:bg-teal-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-teal-600">visibility</span>
                    <span class="text-xs font-medium text-teal-600">{{ $data['published_contents'] }}</span>
                </div>
                <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">published</span>
            </div>
        </div>
    </div>

    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-600 to-emerald-700"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-emerald-600 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Assessment Attempts</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-xl text-emerald-600 dark:text-emerald-400">assignment</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $data['total_assessment_attempts'] }}</p>
            <div class="flex items-center">
                <div class="flex items-center bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-emerald-600">psychology</span>
                    <span class="text-xs font-medium text-emerald-600">{{ $data['this_week_assessments'] }}</span>
                </div>
                <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">this week</span>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Stats -->
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">Daily Active</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $data['daily_active_users'] }}</p>
            </div>
            <span class="material-symbols-outlined text-emerald-500">today</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">System Status</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">Online</p>
            </div>
            <span class="material-symbols-outlined text-green-500">check_circle</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">Forum Posts</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $data['this_week_posts'] }}</p>
            </div>
            <span class="material-symbols-outlined text-teal-500">forum</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">Counselors</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $data['total_counselors'] }}</p>
            </div>
            <span class="material-symbols-outlined text-emerald-600">person</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">Campaigns</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $data['active_campaigns'] }}</p>
            </div>
            <span class="material-symbols-outlined text-green-600">campaign</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">Assessments</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $data['this_month_assessments'] }}</p>
            </div>
            <span class="material-symbols-outlined text-teal-500">assessment</span>
        </div>
    </div>
</div>

<!-- Analytics Charts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- User Registration Trend -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">User Registrations</h3>
            <span class="text-sm text-gray-500 dark:text-gray-400">Last 7 days</span>
        </div>
        <div class="h-64">
            <canvas id="userRegistrationChart"></canvas>
        </div>
    </div>

    <!-- Content Engagement -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Content Views</h3>
            <span class="text-sm text-gray-500 dark:text-gray-400">Weekly trend</span>
        </div>
        <div class="h-64">
            <canvas id="contentViewsChart"></canvas>
        </div>
    </div>
</div>

<!-- Platform Health Overview -->
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
    <!-- System Health -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">System Health</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Active Users</span>
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $data['weekly_active_users'] }}</span>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Response Rate</span>
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">98.5%</span>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">System Status</span>
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">Operational</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Engagement Metrics -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Engagement</h3>
        <div class="space-y-4">
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600 dark:text-gray-400">Assessment Growth</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $data['this_month_assessments'] }} this month</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-emerald-500 h-2 rounded-full" style="width: {{ $data['total_assessments'] > 0 ? min(round(($data['this_month_assessments'] / $data['total_assessments']) * 100, 1), 100) : 0 }}%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600 dark:text-gray-400">Content Published</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $data['total_contents'] > 0 ? round(($data['published_contents'] / $data['total_contents']) * 100, 1) : 0 }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $data['total_contents'] > 0 ? round(($data['published_contents'] / $data['total_contents']) * 100, 1) : 0 }}%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600 dark:text-gray-400">Session Success</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $data['total_sessions'] > 0 ? round(($data['completed_sessions'] / $data['total_sessions']) * 100, 1) : 0 }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-teal-500 h-2 rounded-full" style="width: {{ $data['total_sessions'] > 0 ? round(($data['completed_sessions'] / $data['total_sessions']) * 100, 1) : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Activity</h3>
        <div class="space-y-3">
            @forelse(($data['recent_activities'] ?? collect())->take(5) as $activity)
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center
                    @if($activity['color'] === 'blue') bg-emerald-100 dark:bg-emerald-900/20
                    @elseif($activity['color'] === 'green') bg-green-100 dark:bg-green-900/20
                    @elseif($activity['color'] === 'purple') bg-teal-100 dark:bg-teal-900/20
                    @elseif($activity['color'] === 'orange') bg-emerald-100 dark:bg-emerald-900/20
                    @else bg-gray-100 dark:bg-gray-700
                    @endif">
                    <span class="material-symbols-outlined text-sm
                        @if($activity['color'] === 'blue') text-emerald-600 dark:text-emerald-400
                        @elseif($activity['color'] === 'green') text-green-600 dark:text-green-400
                        @elseif($activity['color'] === 'purple') text-teal-600 dark:text-teal-400
                        @elseif($activity['color'] === 'orange') text-emerald-600 dark:text-emerald-400
                        @else text-gray-600 dark:text-gray-400
                        @endif">{{ $activity['icon'] }}</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $activity['title'] }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $activity['description'] }}</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500">{{ $activity['created_at']->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <div class="text-center py-8">
                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-gray-400 text-2xl">timeline</span>
                </div>
                <p class="text-gray-500 dark:text-gray-400 text-sm">No recent activity</p>
                <p class="text-gray-400 dark:text-gray-500 text-xs mt-1">Platform activity will appear here as users engage</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
        <div class="space-y-3">
            <a href="{{ route('admin.contents.create') }}" class="w-full bg-primary text-white text-sm font-medium py-2 px-3 rounded-lg hover:opacity-90 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">add</span>
                Create Content
            </a>
            <a href="{{ route('public.assessments.index') }}" class="w-full bg-emerald-600 text-white text-sm font-medium py-2 px-3 rounded-lg hover:opacity-90 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">psychology</span>
                View Assessments
            </a>
            <a href="{{ route('admin.users.create') }}" class="w-full bg-green-600 text-white text-sm font-medium py-2 px-3 rounded-lg hover:opacity-90 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">person_add</span>
                Add User
            </a>
            <a href="{{ route('admin.campaigns.create') }}" class="w-full bg-teal-600 text-white text-sm font-medium py-2 px-3 rounded-lg hover:opacity-90 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">campaign</span>
                New Campaign
            </a>
        </div>
    </div>
</div>

<!-- Data Tables & Management -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <div class="xl:col-span-2 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent User Registrations</h3>
            <a class="text-sm font-medium text-primary hover:underline" href="{{ route('admin.users.index') }}">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3" scope="col">Name</th>
                        <th class="px-6 py-3" scope="col">Email</th>
                        <th class="px-6 py-3" scope="col">Date</th>
                        <th class="px-6 py-3" scope="col">Role</th>
                        <th class="px-6 py-3" scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data['recent_users'] as $user)
                    <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ $user->name }}</td>
                        <td class="px-6 py-4">{{ $user->email }}</td>
                        <td class="px-6 py-4">{{ $user->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium text-emerald-800 bg-emerald-100 rounded-full dark:bg-emerald-900 dark:text-emerald-300">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-primary hover:underline">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No recent users</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>    <di
v class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Content Management</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Oversee all articles, videos, and informational content.</p>
            <div class="space-y-2">
                @forelse($data['recent_contents']->take(3) as $content)
                <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ Str::limit($content->title, 30) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $content->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium {{ $content->is_published ? 'text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-300' : 'text-yellow-800 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-300' }} rounded-full">
                        {{ $content->is_published ? 'Published' : 'Draft' }}
                    </span>
                </div>
                @empty
                <p class="text-sm text-gray-500 dark:text-gray-400">No recent content</p>
                @endforelse
            </div>
            <a href="{{ route('admin.contents.index') }}" class="w-full bg-primary/20 text-primary dark:bg-primary/30 dark:text-primary text-sm font-medium py-2 rounded-lg hover:bg-primary/30 dark:hover:bg-primary/40 mt-4 block text-center">Manage Content</a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">System Health</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Monitor platform performance and status.</p>
            <div class="space-y-2">
                <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Database</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Connected</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">
                        Online
                    </span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700">
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Server</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Running</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">
                        Healthy
                    </span>
                </div>
            </div>
            <a href="{{ route('admin.settings.index') }}" class="w-full bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-400 text-sm font-medium py-2 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/50 mt-4 block text-center">System Settings</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Dashboard charts initializing...');
    
    // User Registration Chart
    const userRegCtx = document.getElementById('userRegistrationChart');
    if (!userRegCtx) {
        console.error('userRegistrationChart canvas not found');
        return;
    }
    
    const userRegData = {!! json_encode($data['weekly_registrations']) !!};
    console.log('User registration data:', userRegData);
    
    const userRegistrationChart = new Chart(userRegCtx.getContext('2d'), {
    type: 'line',
    data: {
        labels: {!! json_encode(array_column($data['weekly_registrations'], 'date')) !!},
        datasets: [{
            label: 'New Registrations',
            data: {!! json_encode(array_column($data['weekly_registrations'], 'count')) !!},
            borderColor: '#10b77f',
            backgroundColor: 'rgba(16, 183, 127, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
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

    // Content Views Chart
    const contentViewsCtx = document.getElementById('contentViewsChart');
    if (!contentViewsCtx) {
        console.error('contentViewsChart canvas not found');
        return;
    }
    
    const contentViewsData = {!! json_encode($data['weekly_content_views']) !!};
    console.log('Content views data:', contentViewsData);
    
    const contentViewsChart = new Chart(contentViewsCtx.getContext('2d'), {
    type: 'bar',
    data: {
        labels: {!! json_encode(array_column($data['weekly_content_views'], 'date')) !!},
        datasets: [{
            label: 'Content Views',
            data: {!! json_encode(array_column($data['weekly_content_views'], 'count')) !!},
            backgroundColor: 'rgba(16, 183, 127, 0.8)',
            borderColor: '#10b77f',
            borderWidth: 1,
            borderRadius: 4
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
    
    console.log('Charts initialized successfully');
});
</script>
@endpush