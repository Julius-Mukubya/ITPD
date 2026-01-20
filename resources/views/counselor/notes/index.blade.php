@extends('layouts.counselor')

@section('title', 'Session Notes')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-2xl sm:text-3xl font-bold tracking-tight">Session Notes</p>
        <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">Manage and review your counseling session notes</p>
    </div>
    <a href="{{ route('counselor.notes.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
        <span class="material-symbols-outlined text-sm">add</span>
        Add Note
    </a>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-xl">note</span>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_notes'] }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Notes</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-xl">lock</span>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['private_notes'] }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Private Notes</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-purple-600 dark:text-purple-400 text-xl">public</span>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['public_notes'] }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Public Notes</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-orange-600 dark:text-orange-400 text-xl">schedule</span>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['recent_notes'] }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">This Week</p>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 mb-6 shadow-sm">
    <form method="GET" action="{{ route('counselor.notes.index') }}" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <!-- Search -->
        <div>
            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
            <input type="text" 
                   id="search" 
                   name="search" 
                   value="{{ request('search') }}"
                   placeholder="Search notes, titles, or clients..."
                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white">
        </div>
        
        <!-- Type Filter -->
        <div>
            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
            <select id="type" 
                    name="type"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white">
                <option value="all" {{ request('type') === 'all' ? 'selected' : '' }}>All Types</option>
                <option value="progress" {{ request('type') === 'progress' ? 'selected' : '' }}>Progress</option>
                <option value="observation" {{ request('type') === 'observation' ? 'selected' : '' }}>Observation</option>
                <option value="reminder" {{ request('type') === 'reminder' ? 'selected' : '' }}>Reminder</option>
                <option value="general" {{ request('type') === 'general' ? 'selected' : '' }}>General</option>
            </select>
        </div>
        
        <!-- Privacy Filter -->
        <div>
            <label for="privacy" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Privacy</label>
            <select id="privacy" 
                    name="privacy"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white">
                <option value="all" {{ request('privacy') === 'all' ? 'selected' : '' }}>All Notes</option>
                <option value="private" {{ request('privacy') === 'private' ? 'selected' : '' }}>Private Only</option>
                <option value="public" {{ request('privacy') === 'public' ? 'selected' : '' }}>Public Only</option>
            </select>
        </div>
        
        <!-- Client Filter -->
        <div>
            <label for="client" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Client</label>
            <select id="client" 
                    name="client"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white">
                <option value="">All Clients</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ request('client') == $client->id ? 'selected' : '' }}>
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <!-- Filter Actions -->
        <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                Filter
            </button>
            <a href="{{ route('counselor.notes.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors">
                Clear
            </a>
        </div>
    </form>
</div>

<!-- Notes List -->
@if($notes->count() > 0)
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
    <div class="divide-y divide-gray-200 dark:divide-gray-700">
        @foreach($notes as $note)
        <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <!-- Note Type Badge -->
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            @if($note->type === 'progress') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300
                            @elseif($note->type === 'observation') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                            @elseif($note->type === 'reminder') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300
                            @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300
                            @endif">
                            @if($note->type === 'progress')
                                <span class="material-symbols-outlined text-xs mr-1">trending_up</span>
                            @elseif($note->type === 'observation')
                                <span class="material-symbols-outlined text-xs mr-1">visibility</span>
                            @elseif($note->type === 'reminder')
                                <span class="material-symbols-outlined text-xs mr-1">alarm</span>
                            @else
                                <span class="material-symbols-outlined text-xs mr-1">note</span>
                            @endif
                            {{ ucfirst($note->type) }}
                        </span>
                        
                        <!-- Privacy Badge -->
                        @if($note->is_private)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">
                            <span class="material-symbols-outlined text-xs mr-1">lock</span>
                            Private
                        </span>
                        @else
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                            <span class="material-symbols-outlined text-xs mr-1">public</span>
                            Public
                        </span>
                        @endif
                        
                        <!-- Date -->
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $note->created_at->format('M d, Y \a\t g:i A') }}
                        </span>
                    </div>
                    
                    <!-- Title -->
                    @if($note->title)
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $note->title }}</h3>
                    @endif
                    
                    <!-- Content Preview -->
                    <p class="text-gray-600 dark:text-gray-400 mb-3 line-clamp-3">{{ Str::limit($note->content, 200) }}</p>
                    
                    <!-- Client Info -->
                    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                        <span class="material-symbols-outlined text-sm">person</span>
                        <span>{{ $note->session->student->name }}</span>
                        <span>•</span>
                        <span>Session #{{ $note->session->id }}</span>
                        <span>•</span>
                        <span>{{ ucfirst(str_replace('_', ' ', $note->session->session_type)) }}</span>
                    </div>
                </div>
                
                <!-- Actions -->
                <div class="flex items-center gap-2 ml-4">
                    <a href="{{ route('counselor.notes.show', $note) }}" class="text-emerald-600 hover:text-emerald-700 p-2 rounded-lg hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors">
                        <span class="material-symbols-outlined text-sm">visibility</span>
                    </a>
                    <a href="{{ route('counselor.notes.edit', $note) }}" class="text-blue-600 hover:text-blue-700 p-2 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                        <span class="material-symbols-outlined text-sm">edit</span>
                    </a>
                    <form method="POST" action="{{ route('counselor.notes.destroy', $note) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this note?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                            <span class="material-symbols-outlined text-sm">delete</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Pagination -->
<div class="mt-6">
    {{ $notes->withQueryString()->links() }}
</div>
@else
<!-- Empty State -->
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-12 text-center shadow-sm">
    <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 flex items-center justify-center">
        <span class="material-symbols-outlined text-5xl text-emerald-500 dark:text-emerald-400">note</span>
    </div>
    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No Notes Found</h3>
    @if(request()->hasAny(['search', 'type', 'privacy', 'client']))
        <p class="text-gray-500 dark:text-gray-400 mb-4">No notes match your current filters. Try adjusting your search criteria.</p>
        <a href="{{ route('counselor.notes.index') }}" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-medium">
            <span class="material-symbols-outlined text-sm">refresh</span>
            Clear Filters
        </a>
    @else
        <p class="text-gray-500 dark:text-gray-400 mb-4">You haven't created any session notes yet. Start documenting your counseling sessions to track progress and observations.</p>
        <a href="{{ route('counselor.notes.create') }}" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
            <span class="material-symbols-outlined text-sm">add</span>
            Create Your First Note
        </a>
    @endif
</div>
@endif
@endsection