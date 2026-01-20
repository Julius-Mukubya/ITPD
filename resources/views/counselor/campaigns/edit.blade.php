@extends('layouts.counselor')

@section('title', 'Edit Campaign - Counselor')
@section('page-title', 'Edit Campaign')

@section('content')
<div class="mb-6">
    <a href="{{ route('counselor.campaigns.index') }}" class="text-primary hover:underline flex items-center gap-1">
        <span class="material-symbols-outlined text-sm">arrow_back</span>
        Back to My Campaigns
    </a>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Edit Campaign</h1>

    <form action="{{ route('counselor.campaigns.update', $campaign) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Campaign Title *</label>
                <input type="text" name="title" value="{{ old('title', $campaign->title) }}" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Location</label>
                <input type="text" name="location" value="{{ old('location', $campaign->location) }}" placeholder="e.g., Main Hall, Online"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('location')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description *</label>
            <textarea name="description" rows="3" required placeholder="Brief description of the campaign..."
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">{{ old('description', $campaign->description) }}</textarea>
            @error('description')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Start Date *</label>
                <input type="date" name="start_date" value="{{ old('start_date', $campaign->start_date->format('Y-m-d')) }}" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('start_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">End Date *</label>
                <input type="date" name="end_date" value="{{ old('end_date', $campaign->end_date->format('Y-m-d')) }}" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('end_date')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Start Time</label>
                <input type="time" name="start_time" value="{{ old('start_time', $campaign->start_time ? \Carbon\Carbon::parse($campaign->start_time)->format('H:i') : '') }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('start_time')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">End Time</label>
                <input type="time" name="end_time" value="{{ old('end_time', $campaign->end_time ? \Carbon\Carbon::parse($campaign->end_time)->format('H:i') : '') }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('end_time')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max Participants</label>
                <input type="number" name="max_participants" value="{{ old('max_participants', $campaign->max_participants) }}" min="1" placeholder="Leave empty for unlimited"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('max_participants')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Featured Image</label>
            @if($campaign->featured_image)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $campaign->featured_image) }}" alt="Current image" class="w-32 h-32 object-cover rounded-lg">
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Current image</p>
            </div>
            @endif
            <input type="file" name="featured_image" accept="image/*"
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
            @error('featured_image')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Campaign Content *</label>
            <textarea name="content" rows="12" required placeholder="Detailed campaign content, objectives, activities, etc..."
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">{{ old('content', $campaign->content) }}</textarea>
            @error('content')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $campaign->is_active) ? 'checked' : '' }}
                    class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Campaign is active</span>
            </label>

            <label class="flex items-center">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $campaign->is_featured) ? 'checked' : '' }}
                    class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Featured campaign</span>
            </label>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/90 transition-colors">
                Update Campaign
            </button>
            <a href="{{ route('counselor.campaigns.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection