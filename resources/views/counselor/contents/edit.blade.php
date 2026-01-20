@extends('layouts.counselor')

@section('title', 'Edit Resource - Counselor')
@section('page-title', 'Edit Resource')

@section('content')
<div class="mb-6">
    <a href="{{ route('counselor.contents.index') }}" class="text-primary hover:underline flex items-center gap-1">
        <span class="material-symbols-outlined text-sm">arrow_back</span>
        Back to My Resources
    </a>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Edit Resource</h1>

    <form action="{{ route('counselor.contents.update', $content) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title *</label>
                <input type="text" name="title" value="{{ old('title', $content->title) }}" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('title')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category *</label>
                <select name="category_id" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    <option value="">Select a category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $content->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Excerpt</label>
            <textarea name="excerpt" rows="3" placeholder="Brief description of the content..."
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">{{ old('excerpt', $content->description) }}</textarea>
            @error('excerpt')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Featured Image</label>
            @if($content->featured_image)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $content->featured_image) }}" alt="Current image" class="w-32 h-32 object-cover rounded-lg">
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
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content *</label>
            <textarea name="content" rows="12" required placeholder="Write your content here..."
                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">{{ old('content', $content->content) }}</textarea>
            @error('content')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-6">
            <label class="flex items-center">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $content->is_published) ? 'checked' : '' }}
                    class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Published</span>
            </label>

            <label class="flex items-center">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $content->is_featured) ? 'checked' : '' }}
                    class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Featured</span>
            </label>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/90 transition-colors">
                Update Resource
            </button>
            <a href="{{ route('counselor.contents.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection