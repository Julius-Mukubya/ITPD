@extends('layouts.counselor')

@section('title', 'Session Notes')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-2xl sm:text-3xl font-bold tracking-tight">Session Notes</p>
        <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">Manage and review your counseling session notes</p>
    </div>
    <a href="{{ route('counselor.notes.create') }}" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-semibold px-6 py-3 rounded-xl flex items-center justify-center gap-2 hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-200 w-full sm:w-auto">
        <span class="material-symbols-outlined text-lg">add</span>
        Add Note
    </a>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-emerald-600"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Total Notes</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-lg sm:text-xl text-emerald-600 dark:text-emerald-400">note</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['total_notes'] }}</p>
            <div class="flex items-center">
                <div class="flex items-center bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-emerald-600">description</span>
                    <span class="text-xs font-medium text-emerald-600">All Notes</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-blue-600"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Private Notes</p>
            </div>
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-lg sm:text-xl text-blue-600 dark:text-blue-400">lock</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['private_notes'] }}</p>
            <div class="flex items-center">
                <div class="flex items-center bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-blue-600">security</span>
                    <span class="text-xs font-medium text-blue-600">Confidential</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-green-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-green-600"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Public Notes</p>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-lg sm:text-xl text-green-600 dark:text-green-400">public</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['public_notes'] }}</p>
            <div class="flex items-center">
                <div class="flex items-center bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-green-600">visibility</span>
                    <span class="text-xs font-medium text-green-600">Shared</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-teal-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-teal-500 to-teal-600"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-teal-500 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">This Week</p>
            </div>
            <div class="bg-gradient-to-br from-teal-50 to-teal-100 dark:from-teal-900/20 dark:to-teal-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-lg sm:text-xl text-teal-600 dark:text-teal-400">schedule</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">{{ $stats['recent_notes'] }}</p>
            <div class="flex items-center">
                <div class="flex items-center bg-teal-50 dark:bg-teal-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-teal-600">calendar_today</span>
                    <span class="text-xs font-medium text-teal-600">Recent</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 mb-8 shadow-sm">
    <!-- Filters Header -->
    <div class="flex items-center justify-between p-4 sm:p-6 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-lg">filter_list</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filters</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Filter and search your notes</p>
            </div>
        </div>
        <button type="button" id="toggleFilters" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
            <span id="toggleFiltersText">Show Filters</span>
            <span id="toggleFiltersIcon" class="material-symbols-outlined text-lg transition-transform duration-200 rotate-180">expand_more</span>
        </button>
    </div>
    
    <!-- Filters Content -->
    <div id="filtersContent" class="hidden p-4 sm:p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <!-- Search -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                <input type="text" 
                       id="search" 
                       placeholder="Search notes, titles, or clients..."
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white">
            </div>
            
            <!-- Type Filter -->
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
                <select id="type" 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white">
                    <option value="all">All Types</option>
                    <option value="progress">Progress</option>
                    <option value="observation">Observation</option>
                    <option value="reminder">Reminder</option>
                    <option value="general">General</option>
                </select>
            </div>
            
            <!-- Privacy Filter -->
            <div>
                <label for="privacy" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Privacy</label>
                <select id="privacy" 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white">
                    <option value="all">All Notes</option>
                    <option value="private">Private Only</option>
                    <option value="public">Public Only</option>
                </select>
            </div>
            
            <!-- Client Filter -->
            <div>
                <label for="client" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Client</label>
                <select id="client" 
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white">
                    <option value="">All Clients</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Filter Actions -->
            <div class="flex items-end gap-2 sm:col-span-1 lg:col-span-1">
                <button type="button" id="clearFilters" class="flex-1 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors text-sm">
                    Clear All
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Notes List -->
@if($notes->count() > 0)
<!-- Desktop Card Grid View -->
<div class="hidden md:block">
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6" id="desktopNotesContainer">
        @foreach($notes as $note)
        <div class="note-item bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 shadow-sm hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1" 
             data-type="{{ $note->type }}" 
             data-privacy="{{ $note->is_private ? 'private' : 'public' }}" 
             data-client-id="{{ $note->session->student->id }}"
             data-client-name="{{ strtolower($note->session->student->name) }}"
             data-title="{{ strtolower($note->title ?? '') }}"
             data-content="{{ strtolower(strip_tags($note->content)) }}"
             data-session-type="{{ strtolower(str_replace('_', ' ', $note->session->session_type)) }}">
            
            <!-- Header with Type and Privacy -->
            <div class="flex items-center justify-between mb-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
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
            </div>
            
            <!-- Title and Content -->
            <div class="mb-4">
                @if($note->title)
                <div class="font-semibold text-gray-900 dark:text-white mb-2 text-lg">{{ $note->title }}</div>
                @endif
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    <span class="content-preview cursor-pointer" onclick="toggleContent(this)">
                        {{ Str::limit($note->content, 150) }}
                    </span>
                    @if(strlen($note->content) > 150)
                    <div class="content-full hidden mt-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-sm">
                        {{ $note->content }}
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Client Info -->
            <div class="flex items-center gap-3 mb-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                    {{ substr($note->session->student->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-medium text-gray-900 dark:text-white truncate">{{ $note->session->student->name }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">
                        Session #{{ $note->session->id }} • {{ ucfirst(str_replace('_', ' ', $note->session->session_type)) }}
                    </div>
                </div>
            </div>
            
            <!-- Date and Actions -->
            <div class="flex items-center justify-between pt-3 border-t border-gray-200 dark:border-gray-700">
                <div>
                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $note->created_at->format('M d, Y') }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $note->created_at->format('g:i A') }}</div>
                </div>
                
                <div class="flex items-center gap-1">
                    <a href="{{ route('counselor.notes.show', $note) }}" class="w-9 h-9 flex items-center justify-center text-emerald-600 hover:text-emerald-700 rounded-lg hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors" title="View Note">
                        <span class="material-symbols-outlined text-lg">visibility</span>
                    </a>
                    <a href="{{ route('counselor.notes.edit', $note) }}" class="w-9 h-9 flex items-center justify-center text-blue-600 hover:text-blue-700 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors" title="Edit Note">
                        <span class="material-symbols-outlined text-lg">edit</span>
                    </a>
                    <form method="POST" action="{{ route('counselor.notes.destroy', $note) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this note?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-9 h-9 flex items-center justify-center text-red-600 hover:text-red-700 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" title="Delete Note">
                            <span class="material-symbols-outlined text-lg">delete</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Mobile Grid Card View -->
<div class="md:hidden grid grid-cols-1 sm:grid-cols-2 gap-4" id="mobileNotesContainer">
    @foreach($notes as $note)
    <div class="note-item bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm" 
         data-type="{{ $note->type }}" 
         data-privacy="{{ $note->is_private ? 'private' : 'public' }}" 
         data-client-id="{{ $note->session->student->id }}"
         data-client-name="{{ strtolower($note->session->student->name) }}"
         data-title="{{ strtolower($note->title ?? '') }}"
         data-content="{{ strtolower(strip_tags($note->content)) }}"
         data-session-type="{{ strtolower(str_replace('_', ' ', $note->session->session_type)) }}">
        
        <!-- Header with Type and Privacy -->
        <div class="flex items-center justify-between mb-3">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
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
        </div>
        
        <!-- Title and Content -->
        <div class="mb-3">
            @if($note->title)
            <div class="font-semibold text-gray-900 dark:text-white mb-2">{{ $note->title }}</div>
            @endif
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <span class="content-preview cursor-pointer" onclick="toggleContent(this)">
                    {{ Str::limit($note->content, 100) }}
                </span>
                @if(strlen($note->content) > 100)
                <div class="content-full hidden mt-2 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-xs">
                    {{ $note->content }}
                </div>
                @endif
            </div>
        </div>
        
        <!-- Client Info -->
        <div class="flex items-center gap-3 mb-3 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white font-bold text-sm shadow-lg">
                {{ substr($note->session->student->name, 0, 1) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="font-medium text-gray-900 dark:text-white truncate">{{ $note->session->student->name }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    Session #{{ $note->session->id }} • {{ ucfirst(str_replace('_', ' ', $note->session->session_type)) }}
                </div>
            </div>
        </div>
        
        <!-- Date and Actions -->
        <div class="flex items-center justify-between">
            <div>
                <div class="text-sm text-gray-900 dark:text-white">{{ $note->created_at->format('M d, Y') }}</div>
                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $note->created_at->format('g:i A') }}</div>
            </div>
            
            <div class="flex items-center gap-1">
                <a href="{{ route('counselor.notes.show', $note) }}" class="w-10 h-10 flex items-center justify-center text-emerald-600 hover:text-emerald-700 rounded-lg hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors" title="View Note">
                    <span class="material-symbols-outlined text-lg">visibility</span>
                </a>
                <a href="{{ route('counselor.notes.edit', $note) }}" class="w-10 h-10 flex items-center justify-center text-blue-600 hover:text-blue-700 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors" title="Edit Note">
                    <span class="material-symbols-outlined text-lg">edit</span>
                </a>
                <form method="POST" action="{{ route('counselor.notes.destroy', $note) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this note?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-10 h-10 flex items-center justify-center text-red-600 hover:text-red-700 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors" title="Delete Note">
                        <span class="material-symbols-outlined text-lg">delete</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- No Results Message -->
<div id="noResults" class="hidden bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-8 sm:p-12 text-center shadow-sm">
    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-4 rounded-full bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 flex items-center justify-center">
        <span class="material-symbols-outlined text-4xl sm:text-5xl text-emerald-500 dark:text-emerald-400">search_off</span>
    </div>
    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-2">No Notes Found</h3>
    <p class="text-gray-500 dark:text-gray-400 mb-4 text-sm sm:text-base">No notes match your current filters. Try adjusting your search criteria.</p>
    <button id="clearFiltersFromNoResults" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-medium text-sm sm:text-base">
        <span class="material-symbols-outlined text-sm">refresh</span>
        Clear Filters
    </button>
</div>
@else
<!-- Empty State -->
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-8 sm:p-12 text-center shadow-sm">
    <div class="w-20 h-20 sm:w-24 sm:h-24 mx-auto mb-4 rounded-full bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 flex items-center justify-center">
        <span class="material-symbols-outlined text-4xl sm:text-5xl text-emerald-500 dark:text-emerald-400">note</span>
    </div>
    <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-2">No Notes Found</h3>
    <p class="text-gray-500 dark:text-gray-400 mb-4 text-sm sm:text-base">You haven't created any session notes yet. Start documenting your counseling sessions to track progress and observations.</p>
    <a href="{{ route('counselor.notes.create') }}" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-semibold px-6 py-3 rounded-xl flex items-center justify-center gap-2 hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-200 w-full sm:w-auto mx-auto">
        <span class="material-symbols-outlined text-lg">add</span>
        Create Your First Note
    </a>
</div>
@endif
@endsection

@push('scripts')
<script>
// Content toggle functionality
function toggleContent(element) {
    const contentFull = element.parentElement.querySelector('.content-full');
    if (contentFull) {
        if (contentFull.classList.contains('hidden')) {
            contentFull.classList.remove('hidden');
            element.innerHTML = element.innerHTML.replace('...', '') + ' <span class="text-emerald-600 font-medium">(Click to collapse)</span>';
        } else {
            contentFull.classList.add('hidden');
            element.innerHTML = element.innerHTML.replace(' <span class="text-emerald-600 font-medium">(Click to collapse)</span>', '...');
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const typeSelect = document.getElementById('type');
    const privacySelect = document.getElementById('privacy');
    const clientSelect = document.getElementById('client');
    const clearFiltersBtn = document.getElementById('clearFilters');
    const clearFiltersFromNoResultsBtn = document.getElementById('clearFiltersFromNoResults');
    const notesTable = document.getElementById('notesTable');
    const desktopNotesContainer = document.getElementById('desktopNotesContainer');
    const mobileNotesContainer = document.getElementById('mobileNotesContainer');
    const noResultsDiv = document.getElementById('noResults');
    const noteItems = document.querySelectorAll('.note-item');
    
    // Filters toggle functionality
    const toggleFiltersBtn = document.getElementById('toggleFilters');
    const filtersContent = document.getElementById('filtersContent');
    const toggleFiltersText = document.getElementById('toggleFiltersText');
    const toggleFiltersIcon = document.getElementById('toggleFiltersIcon');
    
    let filtersVisible = false;
    
    function toggleFilters() {
        filtersVisible = !filtersVisible;
        
        if (filtersVisible) {
            filtersContent.classList.remove('hidden');
            toggleFiltersText.textContent = 'Hide Filters';
            toggleFiltersIcon.textContent = 'expand_less';
            toggleFiltersIcon.classList.remove('rotate-180');
        } else {
            filtersContent.classList.add('hidden');
            toggleFiltersText.textContent = 'Show Filters';
            toggleFiltersIcon.textContent = 'expand_more';
            toggleFiltersIcon.classList.add('rotate-180');
        }
    }
    
    if (toggleFiltersBtn) {
        toggleFiltersBtn.addEventListener('click', toggleFilters);
    }

    function filterNotes() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedType = typeSelect.value;
        const selectedPrivacy = privacySelect.value;
        const selectedClient = clientSelect.value;
        
        let visibleCount = 0;
        let privateCount = 0;
        let publicCount = 0;
        
        noteItems.forEach(item => {
            let isVisible = true;
            
            // Search filter
            if (searchTerm) {
                const title = item.dataset.title || '';
                const content = item.dataset.content || '';
                const clientName = item.dataset.clientName || '';
                const sessionType = item.dataset.sessionType || '';
                
                const searchableText = `${title} ${content} ${clientName} ${sessionType}`;
                if (!searchableText.includes(searchTerm)) {
                    isVisible = false;
                }
            }
            
            // Type filter
            if (selectedType !== 'all' && item.dataset.type !== selectedType) {
                isVisible = false;
            }
            
            // Privacy filter
            if (selectedPrivacy !== 'all' && item.dataset.privacy !== selectedPrivacy) {
                isVisible = false;
            }
            
            // Client filter
            if (selectedClient && item.dataset.clientId !== selectedClient) {
                isVisible = false;
            }
            
            // Show/hide item
            if (isVisible) {
                // Show in both desktop cards and mobile cards
                item.style.display = 'block';
                visibleCount++;
                
                // Count for statistics
                if (item.dataset.privacy === 'private') {
                    privateCount++;
                } else {
                    publicCount++;
                }
            } else {
                item.style.display = 'none';
            }
        });
        
        // Show/hide no results message
        if (visibleCount === 0 && noteItems.length > 0) {
            if (desktopNotesContainer) desktopNotesContainer.parentElement.style.display = 'none';
            if (mobileNotesContainer) mobileNotesContainer.style.display = 'none';
            if (noResultsDiv) noResultsDiv.classList.remove('hidden');
        } else {
            if (desktopNotesContainer) desktopNotesContainer.parentElement.style.display = 'block';
            if (mobileNotesContainer) mobileNotesContainer.style.display = 'grid';
            if (noResultsDiv) noResultsDiv.classList.add('hidden');
        }
        
        // Update statistics
        updateStatistics(visibleCount, privateCount, publicCount);
    }
    
    function updateStatistics(total, privateCount, publicCount) {
        // Update the statistics cards with filtered counts
        const totalCard = document.querySelector('.group:nth-child(1) .text-3xl');
        const privateCard = document.querySelector('.group:nth-child(2) .text-3xl');
        const publicCard = document.querySelector('.group:nth-child(3) .text-3xl');
        
        if (totalCard) totalCard.textContent = total;
        if (privateCard) privateCard.textContent = privateCount;
        if (publicCard) publicCard.textContent = publicCount;
    }
    
    function clearAllFilters() {
        searchInput.value = '';
        typeSelect.value = 'all';
        privacySelect.value = 'all';
        clientSelect.value = '';
        filterNotes();
    }
    
    // Event listeners
    searchInput.addEventListener('input', filterNotes);
    typeSelect.addEventListener('change', filterNotes);
    privacySelect.addEventListener('change', filterNotes);
    clientSelect.addEventListener('change', filterNotes);
    
    if (clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', clearAllFilters);
    }
    
    if (clearFiltersFromNoResultsBtn) {
        clearFiltersFromNoResultsBtn.addEventListener('click', clearAllFilters);
    }
    
    // Real-time search with debouncing
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(filterNotes, 300);
    });
    
    // Initialize with any existing filters
    filterNotes();
});
</script>
@endpush