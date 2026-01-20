@extends('layouts.student')

@section('title', 'Student Dashboard - WellPath')
@section('page-title', 'Dashboard')

@section('content')
<!-- PageHeading -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-2xl sm:text-3xl font-bold tracking-tight">Student Dashboard</p>
        <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">Welcome back, {{ auth()->user()->name }}!</p>
    </div>
    <a href="{{ route('student.assessments.index') }}" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-semibold px-6 py-3 rounded-xl flex items-center justify-center gap-2 hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-200 w-full sm:w-auto">
        <span class="material-symbols-outlined text-lg">psychology</span>
        Take Assessment
    </a>
</div>

<!-- Key Metrics Overview -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Assessments</p>
                <p class="text-3xl font-bold">{{ $data['assessments_taken'] }}</p>
                <div class="flex items-center mt-2">
                    <span class="material-symbols-outlined text-sm mr-1">trending_up</span>
                    <span class="text-sm">{{ $data['assessments_this_month'] }} this month</span>
                </div>
            </div>
            <div class="bg-white/20 rounded-lg p-3">
                <span class="material-symbols-outlined text-2xl">psychology</span>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium">Counseling Sessions</p>
                <p class="text-3xl font-bold">{{ $data['counseling_sessions'] }}</p>
                <div class="flex items-center mt-2">
                    <span class="material-symbols-outlined text-sm mr-1">support_agent</span>
                    <span class="text-sm">Active support</span>
                </div>
            </div>
            <div class="bg-white/20 rounded-lg p-3">
                <span class="material-symbols-outlined text-2xl">support_agent</span>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-medium">Content Views</p>
                <p class="text-3xl font-bold">{{ $data['contents_viewed'] }}</p>
                <div class="flex items-center mt-2">
                    <span class="material-symbols-outlined text-sm mr-1">visibility</span>
                    <span class="text-sm">Resources viewed</span>
                </div>
            </div>
            <div class="bg-white/20 rounded-lg p-3">
                <span class="material-symbols-outlined text-2xl">library_books</span>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm font-medium">Forum Posts</p>
                <p class="text-3xl font-bold">{{ $data['forum_posts'] }}</p>
                <div class="flex items-center mt-2">
                    <span class="material-symbols-outlined text-sm mr-1">forum</span>
                    <span class="text-sm">Community activity</span>
                </div>
            </div>
            <div class="bg-white/20 rounded-lg p-3">
                <span class="material-symbols-outlined text-2xl">forum</span>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Stats -->
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">Study Time</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ floor($data['total_study_time'] / 60) }}h</p>
            </div>
            <span class="material-symbols-outlined text-blue-500">schedule</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">This Week</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $data['this_week_activity'] }}</p>
            </div>
            <span class="material-symbols-outlined text-green-500">trending_up</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">Categories</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $data['assessment_categories'] }}</p>
            </div>
            <span class="material-symbols-outlined text-purple-500">category</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">Streak Days</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $data['streak_days'] }}</p>
            </div>
            <span class="material-symbols-outlined text-orange-500">local_fire_department</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">Bookmarks</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $data['bookmarks_count'] }}</p>
            </div>
            <span class="material-symbols-outlined text-pink-500">bookmark</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">This Month</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $data['this_month_activity'] }}</p>
            </div>
            <span class="material-symbols-outlined text-teal-500">calendar_month</span>
        </div>
    </div>
</div>

<!-- Analytics Charts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Weekly Activity -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Weekly Activity</h3>
            <span class="text-sm text-gray-500 dark:text-gray-400">Last 7 days</span>
        </div>
        <div class="h-64">
            <canvas id="weeklyActivityChart"></canvas>
        </div>
    </div>

    <!-- Content Engagement -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Content Engagement</h3>
            <span class="text-sm text-gray-500 dark:text-gray-400">Weekly trend</span>
        </div>
        <div class="h-64">
            <canvas id="contentViewsChart"></canvas>
        </div>
    </div>
</div>

<!-- Wellness & Progress Overview -->
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
    <!-- Wellness Journey -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Wellness Journey</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Assessments</span>
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $data['assessments_taken'] }}</span>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Sessions</span>
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $data['counseling_sessions'] }}</span>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Streak</span>
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-orange-500 rounded-full mr-2"></div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $data['streak_days'] }} days</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Metrics -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Progress</h3>
        <div class="space-y-4">
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600 dark:text-gray-400">Monthly Activity</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $data['this_month_activity'] }}</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ min(($data['this_month_activity'] / 10) * 100, 100) }}%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600 dark:text-gray-400">Weekly Activity</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $data['this_week_activity'] }}</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ min(($data['this_week_activity'] / 7) * 100, 100) }}%"></div>
                </div>
            </div>
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600 dark:text-gray-400">Engagement</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $data['contents_viewed'] }}</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-purple-500 h-2 rounded-full" style="width: {{ min(($data['contents_viewed'] / 20) * 100, 100) }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Content -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Content</h3>
        <div class="space-y-3">
            @forelse($data['recent_contents']->take(4) as $content)
            <div class="flex items-center space-x-3">
                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm text-gray-900 dark:text-white truncate">{{ Str::limit($content->title, 25) }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $content->reading_time }}min read</p>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-500 dark:text-gray-400">No recent content</p>
            @endforelse
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
        <div class="space-y-3">
            <a href="{{ route('student.assessments.index') }}" class="w-full bg-primary text-white text-sm font-medium py-2 px-3 rounded-lg hover:opacity-90 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">psychology</span>
                Take Assessment
            </a>
            <a href="{{ route('content.index') }}" class="w-full bg-blue-600 text-white text-sm font-medium py-2 px-3 rounded-lg hover:opacity-90 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">library_books</span>
                Browse Resources
            </a>
            <a href="{{ route('public.counseling.sessions') }}" class="w-full bg-green-600 text-white text-sm font-medium py-2 px-3 rounded-lg hover:opacity-90 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">support_agent</span>
                Request Counseling
            </a>
            <a href="{{ route('student.forum.index') }}" class="w-full bg-purple-600 text-white text-sm font-medium py-2 px-3 rounded-lg hover:opacity-90 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">forum</span>
                Join Forum
            </a>
        </div>
    </div>
</div>

<!-- Data Tables & Management -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    <div class="xl:col-span-2 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">My Assessment History</h3>
            <a class="text-sm font-medium text-primary hover:underline" href="{{ route('student.assessments.index') }}">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3" scope="col">Assessment</th>
                        <th class="px-6 py-3" scope="col">Type</th>
                        <th class="px-6 py-3" scope="col">Date</th>
                        <th class="px-6 py-3" scope="col">Status</th>
                        <th class="px-6 py-3" scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data['my_assessment_attempts'] as $attempt)
                    <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">{{ Str::limit($attempt->assessment->title, 30) }}</td>
                        <td class="px-6 py-4">{{ ucfirst(str_replace('_', ' ', $attempt->assessment->type)) }}</td>
                        <td class="px-6 py-4">{{ $attempt->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                Completed
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('student.assessments.show', $attempt->assessment->type) }}" class="text-primary hover:underline">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No assessments taken yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Available Assessments</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Take self-evaluation assessments to track your wellness.</p>
            <div class="space-y-2">
                @forelse($data['available_assessments']->take(3) as $assessment)
                <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ Str::limit($assessment->title, 25) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst(str_replace('_', ' ', $assessment->type)) }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-300 rounded-full">
                        Available
                    </span>
                </div>
                @empty
                <p class="text-sm text-gray-500 dark:text-gray-400">No assessments available</p>
                @endforelse
            </div>
            <a href="{{ route('student.assessments.index') }}" class="w-full bg-primary/20 text-primary dark:bg-primary/30 dark:text-primary text-sm font-medium py-2 rounded-lg hover:bg-primary/30 dark:hover:bg-primary/40 mt-4 block text-center">View All Assessments</a>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Counseling Sessions</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Track your counseling sessions and support.</p>
            <div class="space-y-2">
                @forelse($data['my_sessions'] as $session)
                <div class="flex justify-between items-center py-2 border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ Str::limit($session->subject, 25) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $session->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="px-2 py-1 text-xs font-medium 
                        @if($session->status === 'pending') text-yellow-800 bg-yellow-100 dark:bg-yellow-900 dark:text-yellow-300
                        @elseif($session->status === 'active') text-blue-800 bg-blue-100 dark:bg-blue-900 dark:text-blue-300
                        @else text-green-800 bg-green-100 dark:bg-green-900 dark:text-green-300
                        @endif rounded-full">
                        {{ ucfirst($session->status) }}
                    </span>
                </div>
                @empty
                <p class="text-sm text-gray-500 dark:text-gray-400">No counseling sessions</p>
                @endforelse
            </div>
            <a href="{{ route('student.counseling.index') }}" class="w-full bg-green-50 text-green-600 dark:bg-green-900/30 dark:text-green-400 text-sm font-medium py-2 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/50 mt-4 block text-center">View All Sessions</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Weekly Activity Chart
    const weeklyActivityCtx = document.getElementById('weeklyActivityChart');
    if (!weeklyActivityCtx) {
        console.error('weeklyActivityChart canvas not found');
        return;
    }
    const weeklyActivityChart = new Chart(weeklyActivityCtx.getContext('2d'), {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($data['weekly_assessment_activity'], 'date')) !!},
            datasets: [{
                label: 'Assessment Attempts',
                data: {!! json_encode(array_column($data['weekly_assessment_activity'], 'count')) !!},
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
    const contentViewsChart = new Chart(contentViewsCtx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($data['weekly_content_views'], 'date')) !!},
            datasets: [{
                label: 'Content Views',
                data: {!! json_encode(array_column($data['weekly_content_views'], 'count')) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: '#3b82f6',
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
});
</script>
@endpush
