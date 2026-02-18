@extends('layouts.teacher')

@section('title', 'Teacher Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Campaigns</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $total_campaigns }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-blue-100 dark:bg-blue-900/20">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">campaign</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $active_campaigns }} active</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Participants</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $total_participants }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-green-100 dark:bg-green-900/20">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">group</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $this_month_participants }} this month</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Assessment Attempts</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $total_assessment_attempts }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-purple-100 dark:bg-purple-900/20">
                    <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">assignment</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $this_week_attempts }} this week</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Content Views</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $total_content_views }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-orange-100 dark:bg-orange-900/20">
                    <span class="material-symbols-outlined text-orange-600 dark:text-orange-400">visibility</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $this_week_views }} this week</p>
        </div>
    </div>

    <!-- Engagement Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Student Engagement</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Students Taking Assessments</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $students_taking_assessments }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Students Viewing Content</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $students_viewing_content }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Students in Counseling</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $students_in_counseling }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Assessment Distribution</h3>
            <div class="space-y-3">
                @forelse($assessment_type_distribution as $type => $count)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600 dark:text-gray-400 capitalize">{{ str_replace('_', ' ', $type) }}</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $count }}</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-primary h-2 rounded-full" style="width: {{ ($count / max(array_values($assessment_type_distribution))) * 100 }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-sm">No assessment data yet</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Weekly Assessment Activity</h3>
            <div class="relative" style="height: 250px;">
                <canvas id="assessmentChart"></canvas>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Weekly Content Views</h3>
            <div class="relative" style="height: 250px;">
                <canvas id="contentChart"></canvas>
            </div>
        </div>
    </div>

    <!-- My Campaigns -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">My Campaigns</h3>
            <a href="{{ route('teacher.campaigns.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors">
                Create Campaign
            </a>
        </div>
        <div class="p-6">
            @forelse($my_campaigns as $campaign)
                <div class="border-b border-gray-200 dark:border-gray-700 last:border-b-0 py-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h4 class="font-semibold text-gray-800 dark:text-white">{{ $campaign->title }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ Str::limit($campaign->description, 100) }}</p>
                            <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500 dark:text-gray-400">
                                <span>{{ $campaign->participants_count ?? 0 }} participants</span>
                                <span>{{ $campaign->start_date->format('M d') }} - {{ $campaign->end_date->format('M d, Y') }}</span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="px-3 py-1 rounded-full text-xs {{ $campaign->is_active ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-400' }}">
                                {{ $campaign->is_active ? 'Active' : 'Inactive' }}
                            </span>
                            <a href="{{ route('teacher.campaigns.show', $campaign) }}" class="text-primary hover:text-primary/80">
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-center py-8">No campaigns yet. Create your first campaign to get started!</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Participants -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Participants</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Campaign</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($recent_participants as $participant)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $participant->campaign->title ?? 'N/A' }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $participant->name ?? $participant->email }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $participant->created_at->diffForHumans() }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                    Registered
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">No participants yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Assessment Chart
    const assessmentCtx = document.getElementById('assessmentChart').getContext('2d');
    new Chart(assessmentCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($weekly_assessment_trend, 'date')) !!},
            datasets: [{
                label: 'Assessments',
                data: {!! json_encode(array_column($weekly_assessment_trend, 'count')) !!},
                borderColor: 'rgb(16, 183, 127)',
                backgroundColor: 'rgba(16, 183, 127, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false }
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

    // Content Chart
    const contentCtx = document.getElementById('contentChart').getContext('2d');
    new Chart(contentCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($weekly_content_trend, 'date')) !!},
            datasets: [{
                label: 'Views',
                data: {!! json_encode(array_column($weekly_content_trend, 'count')) !!},
                borderColor: 'rgb(249, 115, 22)',
                backgroundColor: 'rgba(249, 115, 22, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false }
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
</script>
@endsection
