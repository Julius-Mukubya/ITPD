@extends('layouts.counselor')

@section('title', 'Edit Session Note')

@section('content')
<div class="px-2 sm:px-0">
<!-- Header -->
<div class="flex flex-col gap-4 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-xl sm:text-2xl lg:text-3xl font-bold tracking-tight">Edit Session Note</p>
        <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">Update your session note details and content</p>
    </div>
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:justify-end">
        <a href="{{ route('counselor.notes.show', $note) }}" class="inline-flex items-center justify-center gap-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 font-medium transition-colors text-sm sm:text-base">
            <span class="material-symbols-outlined text-sm">visibility</span>
            <span class="hidden sm:inline">View Note</span>
            <span class="sm:hidden">View</span>
        </a>
        <a href="{{ route('counselor.notes.index') }}" class="inline-flex items-center justify-center gap-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 font-medium transition-colors text-sm sm:text-base">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            <span class="hidden sm:inline">Back to Notes</span>
            <span class="sm:hidden">Back</span>
        </a>
    </div>
</div>

<!-- Edit Form -->
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
    <form method="POST" action="{{ route('counselor.notes.update', $note) }}" class="p-4 sm:p-6 space-y-4 sm:space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Current Session Info -->
        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-3 sm:p-4 border border-gray-200 dark:border-gray-600">
            <h3 class="font-medium text-gray-900 dark:text-white mb-2 text-sm sm:text-base">Current Session</h3>
            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm flex-shrink-0">tag</span>
                    <span>Session #{{ $note->session->id }}</span>
                </span>
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm flex-shrink-0">person</span>
                    <span class="truncate">{{ $note->session->student->name }}</span>
                </span>
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm flex-shrink-0">calendar_today</span>
                    <span>{{ $note->session->created_at->format('M d, Y') }}</span>
                </span>
                <span class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm flex-shrink-0">psychology</span>
                    <span class="truncate">{{ ucfirst(str_replace('_', ' ', $note->session->session_type)) }}</span>
                </span>
            </div>
        </div>
        
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
                            {{ (old('session_id', $note->session_id) == $session->id) ? 'selected' : '' }}>
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
                   value="{{ old('title', $note->title) }}"
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
                <option value="progress" {{ old('type', $note->type) === 'progress' ? 'selected' : '' }}>Progress Note</option>
                <option value="observation" {{ old('type', $note->type) === 'observation' ? 'selected' : '' }}>Observation</option>
                <option value="reminder" {{ old('type', $note->type) === 'reminder' ? 'selected' : '' }}>Reminder</option>
                <option value="general" {{ old('type', $note->type) === 'general' ? 'selected' : '' }}>General Note</option>
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
                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white @error('content') border-red-500 @enderror">{{ old('content', $note->content) }}</textarea>
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
                       {{ old('is_private', $note->is_private) ? 'checked' : '' }}
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
        
        <!-- Note Metadata -->
        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
            <h3 class="font-medium text-gray-900 dark:text-white mb-2">Note Information</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-600 dark:text-gray-400">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">schedule</span>
                    <span>Created: {{ $note->created_at->format('M d, Y \a\t g:i A') }}</span>
                </div>
                @if($note->updated_at->ne($note->created_at))
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">update</span>
                    <span>Last Updated: {{ $note->updated_at->format('M d, Y \a\t g:i A') }}</span>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Form Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-4 sm:pt-6 border-t border-gray-200 dark:border-gray-700">
            <form method="POST" action="{{ route('counselor.notes.destroy', $note) }}" class="inline order-2 sm:order-1" onsubmit="return confirm('Are you sure you want to delete this note? This action cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center justify-center gap-2 px-4 py-2 text-red-600 hover:text-red-700 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-colors text-sm sm:text-base w-full sm:w-auto">
                    <span class="material-symbols-outlined text-sm">delete</span>
                    <span class="hidden sm:inline">Delete Note</span>
                    <span class="sm:hidden">Delete</span>
                </button>
            </form>
            
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3 order-1 sm:order-2">
                <a href="{{ route('counselor.notes.show', $note) }}" class="inline-flex items-center justify-center px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-600 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors text-sm sm:text-base">
                    <span class="hidden sm:inline">Cancel</span>
                    <span class="sm:hidden">Cancel</span>
                </a>
                <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-semibold px-4 sm:px-6 py-2 sm:py-3 rounded-xl hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-200">
                    <span class="hidden sm:inline">Update Note</span>
                    <span class="sm:hidden">Update</span>
                </button>
            </div>
        </div>
    </form>
</div>
@endsection