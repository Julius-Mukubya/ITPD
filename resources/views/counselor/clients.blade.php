@extends('layouts.counselor')

@section('title', 'My Clients')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-2xl sm:text-3xl font-bold tracking-tight">My Clients</p>
        <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">All clients you've counseled, including individual and group session participants</p>
    </div>
</div>

@if($students->count() > 0)
<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-emerald-600"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Total Clients</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-xl text-emerald-600 dark:text-emerald-400">group</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $students->count() }}</p>
            <div class="flex items-center">
                <div class="flex items-center bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-emerald-600">people</span>
                    <span class="text-xs font-medium text-emerald-600">All Clients</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-blue-600"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Individual Clients</p>
            </div>
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-xl text-blue-600 dark:text-blue-400">person</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $students->filter(function($s) { return in_array('individual', $s->session_types ?? []); })->count() }}</p>
            <div class="flex items-center">
                <div class="flex items-center bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-blue-600">person_outline</span>
                    <span class="text-xs font-medium text-blue-600">One-on-One</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-green-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-green-600"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Group Participants</p>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-xl text-green-600 dark:text-green-400">groups</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $students->filter(function($s) { return in_array('group', $s->session_types ?? []); })->count() }}</p>
            <div class="flex items-center">
                <div class="flex items-center bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-green-600">group_work</span>
                    <span class="text-xs font-medium text-green-600">Group Sessions</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endif



<!-- Clients List -->
@if($students->count() > 0)
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-emerald-50 dark:bg-emerald-900/20 border-b border-emerald-100 dark:border-emerald-900/30">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Client</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Total Sessions</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Last Session</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($students as $student)
                <tr class="hover:bg-emerald-50/50 dark:hover:bg-emerald-900/10 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white font-bold shadow-lg">
                                {{ substr($student->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $student->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $student->email }}</p>
                                @if(isset($student->session_types) && count($student->session_types) > 0)
                                <div class="flex gap-1 mt-1">
                                    @foreach($student->session_types as $type)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                            @if($type === 'individual') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300
                                            @else bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300
                                            @endif">
                                            @if($type === 'individual')
                                                <span class="material-symbols-outlined text-xs mr-1">person</span>
                                            @else
                                                <span class="material-symbols-outlined text-xs mr-1">group</span>
                                            @endif
                                            {{ ucfirst($type) }}
                                        </span>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
                            {{ $student->total_sessions }} {{ $student->total_sessions == 1 ? 'session' : 'sessions' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($student->last_session)
                            <div class="flex flex-col">
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $student->last_session->created_at->format('M d, Y') }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-500">
                                    {{ ucfirst(str_replace('_', ' ', $student->last_session->session_type)) }}
                                </span>
                            </div>
                        @else
                            <span class="text-sm text-gray-400">No sessions</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('counselor.sessions.index') }}?student={{ $student->id }}" class="inline-flex items-center gap-2 text-emerald-600 hover:text-emerald-700 font-medium text-sm transition-colors">
                            <span class="material-symbols-outlined text-sm">history</span>
                            View History
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<!-- Empty State -->
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-12 text-center shadow-sm">
    <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 flex items-center justify-center">
        <span class="material-symbols-outlined text-5xl text-emerald-500 dark:text-emerald-400">school</span>
    </div>
    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No Clients Yet</h3>
    <p class="text-gray-500 dark:text-gray-400">You haven't counseled any clients yet. Clients will appear here after your first session.</p>
    
    @if(\App\Models\CounselingSession::where('counselor_id', auth()->user()->id)->count() == 0)
        <div class="mt-4 p-4 bg-blue-50 rounded-lg">
            <p class="text-sm text-blue-700">
                <strong>Tip:</strong> You need to be assigned as a counselor to sessions, or accept pending sessions to see clients here.
                Check the <a href="{{ route('counselor.sessions.index') }}" class="underline">Sessions page</a> for pending requests.
            </p>
        </div>
    @endif
</div>
@endif
@endsection