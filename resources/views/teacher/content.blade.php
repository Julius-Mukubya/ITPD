@extends('layouts.teacher')

@section('title', 'Content Engagement')
@section('header', 'Content Engagement')

@section('content')
<div class="space-y-6">
    <!-- Overview Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Views</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $total_views }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-blue-100 dark:bg-blue-900/20">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">visibility</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $this_week_views }} this week</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Unique Students</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $unique_students }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-green-100 dark:bg-green-900/20">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">group</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Engaged with content</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Avg. Time</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $avg_time }}m</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-purple-100 dark:bg-purple-900/20">
                    <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">schedule</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Per student</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Bookmarks</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $total_bookmarks }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-orange-100 dark:bg-orange-900/20">
                    <span class="material-symbols-outlined text-orange-600 dark:text-orange-400">bookmark</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">By students</p>
        </div>
    </div>

    <!-- Reviews & Ratings Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Total Reviews</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ $total_reviews }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-pink-100 dark:bg-pink-900/20">
                    <span class="material-symbols-outlined text-pink-600 dark:text-pink-400">rate_review</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ $this_week_reviews }} this week</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 dark:text-gray-400 text-sm">Average Rating</p>
                    <p class="text-3xl font-bold text-gray-800 dark:text-white">{{ number_format($avg_rating, 1) }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg flex items-center justify-center bg-yellow-100 dark:bg-yellow-900/20">
                    <span class="material-symbols-outlined text-yellow-600 dark:text-yellow-400">star</span>
                </div>
            </div>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Out of 5.0</p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Rating Distribution</h4>
            <div class="space-y-2">
                @for($i = 5; $i >= 1; $i--)
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-600 dark:text-gray-400 w-8">{{ $i }} ★</span>
                        <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            @php
                                $count = $rating_distribution[$i] ?? 0;
                                $percentage = $total_reviews > 0 ? ($count / $total_reviews) * 100 : 0;
                            @endphp
                            <div class="bg-yellow-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                        <span class="text-xs text-gray-600 dark:text-gray-400 w-8">{{ $count }}</span>
                    </div>
                @endfor
            </div>
        </div>
    </div>

    <!-- Most Viewed Content -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Most Viewed Content</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Content your students are engaging with most</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-900">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Content Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Views</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Unique Students</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Reviews</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($most_viewed as $content)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $content->title }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                {{ $content->category->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-semibold">
                                {{ $content->student_views_count }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-semibold">
                                {{ $content->unique_students_count }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-semibold">
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-yellow-500 text-sm">star</span>
                                    <span>{{ $content->reviews_count }}</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">No content views yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Category Breakdown -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Views by Category</h3>
        <div class="space-y-3">
            @forelse($category_breakdown as $category => $count)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600 dark:text-gray-400">{{ $category }}</span>
                        <span class="font-semibold text-gray-900 dark:text-white">{{ $count }} views</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-primary h-2 rounded-full" style="width: {{ ($count / max(array_values($category_breakdown))) * 100 }}%"></div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 dark:text-gray-400 text-sm">No category data yet</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
