@extends('layouts.teacher')

@section('title', 'Assessment Analytics')
@section('header', 'Assessment Analytics')

@section('content')
<div class="space-y-6">
    <!-- Overview Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Attempts</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $total_attempts }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-blue-100 dark:bg-blue-900/20">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">assignment</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $this_week_attempts }} this week</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Active Students</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $active_students }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-green-100 dark:bg-green-900/20">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">group</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Taking assessments</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Completion Rate</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $completion_rate }}%</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-purple-100 dark:bg-purple-900/20">
                    <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">check_circle</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Of started assessments</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Avg. Per Student</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $avg_per_student }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-orange-100 dark:bg-orange-900/20">
                    <span class="material-symbols-outlined text-orange-600 dark:text-orange-400">trending_up</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Assessments taken</p>
        </div>
    </div>

    <!-- Assessment Type Distribution -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Assessment Type Distribution</h3>
        <div class="space-y-3">
            @forelse($type_distribution as $type => $count)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600 dark:text-gray-400 capitalize">{{ str_replace('_', ' ', $type) }}</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $count }} attempts</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-primary h-2 rounded-full" style="width: {{ ($count / max(array_values($type_distribution))) * 100 }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-sm">No assessment data yet</p>
            @endforelse
        </div>
    </div>

    <!-- Most Popular Assessments -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Most Popular Assessments</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Assessments your students are taking</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Assessment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Attempts</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Unique Students</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($popular_assessments as $assessment)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $assessment->title }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400 capitalize">
                                    {{ str_replace('_', ' ', $assessment->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-semibold">
                                {{ $assessment->attempts_count }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-semibold">
                                {{ $assessment->unique_students_count }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">No assessment attempts yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Weekly Trend -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Weekly Assessment Trend</h3>
        <div class="relative" style="height: 250px;">
            <canvas id="assessmentTrendChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('assessmentTrendChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($weekly_trend, 'date')) !!},
            datasets: [{
                label: 'Attempts',
                data: {!! json_encode(array_column($weekly_trend, 'count')) !!},
                backgroundColor: 'rgba(16, 183, 127, 0.8)',
                borderColor: 'rgb(16, 183, 127)',
                borderWidth: 1
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
