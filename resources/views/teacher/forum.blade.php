@extends('layouts.teacher')

@section('title', 'Forum Activity')
@section('header', 'Forum Activity')

@section('content')
<div class="space-y-6">
    <!-- Overview Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Posts</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $total_posts }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-blue-100 dark:bg-blue-900/20">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">forum</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $this_week_posts }} this week</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Comments</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $total_comments }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-green-100 dark:bg-green-900/20">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">comment</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $this_week_comments }} this week</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Active Students</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $active_students }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-purple-100 dark:bg-purple-900/20">
                    <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">group</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Participating in forum</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Engagement Rate</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $engagement_rate }}%</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-orange-100 dark:bg-orange-900/20">
                    <span class="material-symbols-outlined text-orange-600 dark:text-orange-400">trending_up</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Of campaign students</p>
        </div>
    </div>

    <!-- Most Active Categories -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Most Active Categories</h3>
        <div class="space-y-3">
            @forelse($category_activity as $category => $count)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600 dark:text-gray-400">{{ $category }}</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $count }} posts</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-primary h-2 rounded-full" style="width: {{ ($count / max(array_values($category_activity))) * 100 }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-sm">No forum activity yet</p>
            @endforelse
        </div>
    </div>

    <!-- Recent Posts -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Forum Posts</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Latest discussions from your students</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Post Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Comments</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Posted</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($recent_posts as $post)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ Str::limit($post->title, 50) }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">By: Anonymous Student</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400">
                                    {{ $post->category->name ?? 'General' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-semibold">
                                {{ $post->comments_count }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $post->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">No forum posts yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Weekly Activity -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Weekly Forum Activity</h3>
        <div class="relative" style="height: 250px;">
            <canvas id="forumActivityChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('forumActivityChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($weekly_activity, 'date')) !!},
            datasets: [
                {
                    label: 'Posts',
                    data: {!! json_encode(array_column($weekly_activity, 'posts')) !!},
                    borderColor: 'rgb(16, 183, 127)',
                    backgroundColor: 'rgba(16, 183, 127, 0.1)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Comments',
                    data: {!! json_encode(array_column($weekly_activity, 'comments')) !!},
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: true, position: 'top' }
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
