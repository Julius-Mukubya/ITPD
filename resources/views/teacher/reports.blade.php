@extends('layouts.teacher')

@section('title', 'Reports & Analytics')
@section('header', 'Reports & Analytics')

@section('content')
<div class="space-y-6">
    <!-- Header with Export -->
    <div class="flex justify-between items-center">
        <div>
            <p class="text-gray-600 dark:text-gray-400">Comprehensive overview of student engagement across all your campaigns</p>
        </div>
        <a href="{{ route('teacher.reports.export') }}" class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors">
            <span class="material-symbols-outlined text-sm">download</span>
            Export Excel
        </a>
    </div>

    <!-- Key Metrics Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Students</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['total_students'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-blue-100 dark:bg-blue-900/20">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">group</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">In {{ $stats['total_campaigns'] }} campaigns</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Engagement Rate</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['engagement_rate'] }}%</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-green-100 dark:bg-green-900/20">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">trending_up</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Overall participation</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Active Campaigns</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $stats['active_campaigns'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-purple-100 dark:bg-purple-900/20">
                    <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">campaign</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Currently running</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Interactions</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ number_format($stats['total_content_views'] + $stats['total_assessments'] + $stats['total_posts']) }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-orange-100 dark:bg-orange-900/20">
                    <span class="material-symbols-outlined text-orange-600 dark:text-orange-400">touch_app</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">All activities</p>
        </div>
    </div>

    <!-- Activity Breakdown -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Content Engagement -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-600">article</span>
                Content Engagement
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Total Views</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($stats['total_content_views']) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Unique Viewers</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $stats['unique_content_viewers'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Bookmarks</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $stats['total_bookmarks'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Reviews</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $stats['total_reviews'] }}</span>
                </div>
            </div>
        </div>

        <!-- Assessment Activity -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-green-600">psychology</span>
                Assessment Activity
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Total Attempts</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($stats['total_assessments']) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Completed</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $stats['completed_assessments'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Participants</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $stats['assessment_takers'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Completion Rate</span>
                    <span class="font-semibold text-gray-900 dark:text-white">
                        {{ $stats['total_assessments'] > 0 ? round(($stats['completed_assessments'] / $stats['total_assessments']) * 100) : 0 }}%
                    </span>
                </div>
            </div>
        </div>

        <!-- Forum Participation -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-purple-600">forum</span>
                Forum Participation
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Total Posts</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($stats['total_posts']) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Total Comments</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($stats['total_comments']) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Active Participants</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $stats['forum_participants'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Avg per Student</span>
                    <span class="font-semibold text-gray-900 dark:text-white">
                        {{ $stats['forum_participants'] > 0 ? round($stats['total_posts'] / $stats['forum_participants'], 1) : 0 }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Activity Trend -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Weekly Activity Trend</h3>
        <div style="height: 300px;">
            <canvas id="weeklyTrendChart"></canvas>
        </div>
    </div>

    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Performing Content -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Top Performing Content</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Most viewed educational resources</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($topContent as $content)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-900 rounded-lg">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $content->title }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $content->category->name ?? 'N/A' }}</p>
                            </div>
                            <div class="ml-4 flex items-center gap-1">
                                <span class="material-symbols-outlined text-blue-600 text-sm">visibility</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $content->views_count }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-sm text-center py-4">No content views yet</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Campaign Performance -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Campaign Performance</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Participation rates by campaign</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($campaignPerformance as $campaign)
                        <div class="p-3 bg-gray-50 dark:bg-gray-900 rounded-lg">
                            <div class="flex justify-between items-start mb-2">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $campaign->title }}</p>
                                <span class="text-xs px-2 py-1 rounded-full {{ $campaign->end_date >= now() ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                    {{ $campaign->end_date >= now() ? 'Active' : 'Ended' }}
                                </span>
                            </div>
                            <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400">
                                <span>{{ $campaign->total_participants }} participants</span>
                                <span>{{ $campaign->active_participants }} active this week</span>
                            </div>
                            <div class="mt-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                @php
                                    $activeRate = $campaign->total_participants > 0 ? ($campaign->active_participants / $campaign->total_participants) * 100 : 0;
                                @endphp
                                <div class="bg-primary h-2 rounded-full" style="width: {{ $activeRate }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-sm text-center py-4">No campaigns yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Section -->
    <div class="bg-gradient-to-r from-primary/10 to-blue-500/10 dark:from-primary/20 dark:to-blue-500/20 rounded-lg p-6">
        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Summary</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-300">
            <div>
                <p class="mb-2">
                    <span class="font-semibold">Student Reach:</span> 
                    You're currently engaging with {{ $stats['total_students'] }} students across {{ $stats['total_campaigns'] }} campaigns.
                </p>
                <p>
                    <span class="font-semibold">Content Impact:</span> 
                    Your educational content has been viewed {{ number_format($stats['total_content_views']) }} times by {{ $stats['unique_content_viewers'] }} unique students.
                </p>
            </div>
            <div>
                <p class="mb-2">
                    <span class="font-semibold">Assessment Engagement:</span> 
                    {{ $stats['assessment_takers'] }} students have completed {{ $stats['completed_assessments'] }} assessments.
                </p>
                <p>
                    <span class="font-semibold">Community Building:</span> 
                    Students have created {{ number_format($stats['total_posts']) }} forum posts and {{ number_format($stats['total_comments']) }} comments.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('weeklyTrendChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($weeklyData, 'date')) !!},
            datasets: [
                {
                    label: 'Content Views',
                    data: {!! json_encode(array_column($weeklyData, 'views')) !!},
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Assessments',
                    data: {!! json_encode(array_column($weeklyData, 'assessments')) !!},
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Forum Posts',
                    data: {!! json_encode(array_column($weeklyData, 'posts')) !!},
                    borderColor: '#8b5cf6',
                    backgroundColor: 'rgba(139, 92, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#4b5563',
                        usePointStyle: true,
                        padding: 15
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#4b5563'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: document.documentElement.classList.contains('dark') ? '#9ca3af' : '#4b5563'
                    }
                }
            }
        }
    });
});
</script>
@endsection
