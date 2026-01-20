@extends('layouts.counselor')

@section('title', 'Create Session Note')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-2xl sm:text-3xl font-bold tracking-tight">Create Session Note</p>
        <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">Document observations, progress, and important details from your counseling sessions</p>
    </div>
    <a href="{{ route('counselor.notes.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 font-medium transition-colors">
        <span class="material-symbols-outlined text-sm">arrow_back</span>
        Back to Notes
    </a>
</div>

<!-- Create Form -->
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
    <form method="POST" action="{{ route('counselor.notes.store') }}" class="p-6 space-y-6">
        @csrf
        
        <!-- Session Selection -->
        <div>
            <label for="session_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Counseling Session <span class="text-red-500">*</span>
            </label>
            <select id="session_id" 
                    name="session_id" 
                    required
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white @error('session_id') border-red-500 @enderror">
                <option value="">Select a session...</option>
                @foreach($sessions as $session)
                    <option value="{{ $session->id }}" 
                            {{ (old('session_id') == $session->id || ($selectedSession && $selectedSession->id == $session->id)) ? 'selected' : '' }}>
                        Session #{{ $session->id }} - {{ $session->student->name }} 
                        ({{ $session->created_at->format('M d, Y') }}) - 
                        {{ ucfirst(str_replace('_', ' ', $session->session_type)) }}
                    </option>
                @endforeach
            </select>
            @error('session_id')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Note Title -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Note Title (Optional)
            </label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   value="{{ old('title') }}"
                   placeholder="Brief title for this note..."
                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white @error('title') border-red-500 @enderror">
            @error('title')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Note Type -->
        <div>
            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Note Type <span class="text-red-500">*</span>
            </label>
            <select id="type" 
                    name="type" 
                    required
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white @error('type') border-red-500 @enderror">
                <option value="">Select note type...</option>
                <option value="progress" {{ old('type') === 'progress' ? 'selected' : '' }}>Progress Note</option>
                <option value="observation" {{ old('type') === 'observation' ? 'selected' : '' }}>Observation</option>
                <option value="reminder" {{ old('type') === 'reminder' ? 'selected' : '' }}>Reminder</option>
                <option value="general" {{ old('type') === 'general' ? 'selected' : '' }}>General Note</option>
            </select>
            @error('type')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
            
            <!-- Type Descriptions -->
            <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <div><strong>Progress:</strong> Track client improvement and milestones</div>
                    <div><strong>Observation:</strong> Note behaviors, reactions, or insights</div>
                    <div><strong>Reminder:</strong> Follow-up tasks or important reminders</div>
                    <div><strong>General:</strong> Other session-related notes</div>
                </div>
            </div>
        </div>
        
        <!-- Note Content -->
        <div>
            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                Note Content <span class="text-red-500">*</span>
            </label>
            <textarea id="content" 
                      name="content" 
                      rows="8" 
                      required
                      placeholder="Enter your detailed notes here..."
                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white @error('content') border-red-500 @enderror">{{ old('content') }}</textarea>
            @error('content')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Privacy Setting -->
        <div>
            <div class="flex items-start gap-3">
                <input type="checkbox" 
                       id="is_private" 
                       name="is_private" 
                       value="1"
                       {{ old('is_private') ? 'checked' : '' }}
                       class="mt-1 h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 dark:border-gray-600 rounded">
                <div>
                    <label for="is_private" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                        Private Note
                    </label>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Private notes are only visible to you and cannot be shared with clients or other staff members.
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Form Actions -->
        <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('counselor.notes.index') }}" class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-600 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-colors">
                Create Note
            </button>
        </div>
    </form>
</div>
@endsection