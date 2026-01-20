@extends('layouts.student')

@section('title', 'Create Forum Post')
@section('page-title', 'Create New Post')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('student.forum.index') }}" class="inline-flex items-center gap-2 text-gray-600 dark:text-gray-400 hover:text-primary transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
            Back to Forum
        </a>
    </div>

    <!-- Create Post Form -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Share Your Thoughts</h2>
        
        <form action="{{ route('student.forum.store') }}" method="POST">
            @csrf
            
            <!-- Category Selection -->
            <div class="mb-6">
                <label for="category_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Category <span class="text-red-500">*</span>
                </label>
                <select name="category_id" id="category_id" required
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                    <option value="">Select a category</option>
                    <option value="1">Mental Health</option>
                    <option value="2">Substance Abuse</option>
                    <option value="3">Support & Recovery</option>
                    <option value="4">General Discussion</option>
                    <option value="5">Resources & Tips</option>
                </select>
                @error('category_id')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Post Title <span class="text-red-500">*</span>
                </label>
                <input type="text" name="title" id="title" required
                       value="{{ old('title') }}"
                       placeholder="What's on your mind?"
                       class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary focus:border-primary">
                @error('title')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label for="content" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Post Content <span class="text-red-500">*</span>
                </label>
                <textarea name="content" id="content" rows="10" required
                          placeholder="Share your thoughts, experiences, or questions..."
                          class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-primary focus:border-primary resize-none">{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    Be respectful and supportive. Your post will be visible to other students.
                </p>
            </div>

            <!-- Anonymous Option -->
            <div class="mb-6">
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="checkbox" name="is_anonymous" value="1" {{ old('is_anonymous') ? 'checked' : '' }}
                           class="w-5 h-5 text-primary border-gray-300 dark:border-gray-600 rounded focus:ring-2 focus:ring-primary">
                    <div>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Post Anonymously</span>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Your name will be hidden from other users</p>
                    </div>
                </label>
            </div>

            <!-- Guidelines -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                <div class="flex gap-3">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 flex-shrink-0">info</span>
                    <div>
                        <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Community Guidelines</h4>
                        <ul class="text-sm text-blue-800 dark:text-blue-200 space-y-1">
                            <li>• Be respectful and supportive of others</li>
                            <li>• No hate speech, harassment, or bullying</li>
                            <li>• Keep discussions relevant to mental health and wellness</li>
                            <li>• Protect your privacy - don't share personal information</li>
                            <li>• If you're in crisis, seek immediate professional help</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <button type="submit" 
                        class="flex-1 bg-primary text-white py-3 px-6 rounded-lg font-semibold hover:bg-primary/90 transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">send</span>
                    Post to Forum
                </button>
                <a href="{{ route('student.forum.index') }}" 
                   class="flex-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 py-3 px-6 rounded-lg font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Help Section -->
    <div class="mt-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4">
        <div class="flex gap-3">
            <span class="material-symbols-outlined text-yellow-600 dark:text-yellow-400">help</span>
            <div>
                <h4 class="font-semibold text-yellow-900 dark:text-yellow-100 mb-1">Need Immediate Help?</h4>
                <p class="text-sm text-yellow-800 dark:text-yellow-200">
                    If you're experiencing a crisis, please contact Mental Health Uganda toll-free at <a href="tel:0800212121" class="font-bold underline">0800 21 21 21</a> 
                    or <a href="{{ route('public.counseling.sessions') }}" class="font-bold underline">request counseling</a>.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
