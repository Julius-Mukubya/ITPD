@extends('layouts.counselor')

@section('title', 'Counselor Dashboard - WellPath')

@section('content')
<!-- PageHeading -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-2xl sm:text-3xl font-bold tracking-tight">Counselor Dashboard</p>
        <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">Welcome back, {{ auth()->user()->name }}!</p>
    </div>
    <a href="{{ route('counselor.sessions.index') }}" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-semibold px-6 py-3 rounded-xl flex items-center justify-center gap-2 hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-200 w-full sm:w-auto">
        <span class="material-symbols-outlined text-lg">psychology</span>
        View Sessions
    </a>
</div>

<!-- Key Metrics Overview -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-emerald-600"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Pending Requests</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-xl text-emerald-600 dark:text-emerald-400">pending</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $pendingSessions ?? 0 }}</p>
            <div class="flex items-center">
                <div class="flex items-center bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-green-600">trending_up</span>
                    <span class="text-xs font-medium text-green-600">Needs Attention</span>
                </div>
            </div>
        </div>
    </div>

    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-green-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-green-600"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Active Sessions</p>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-xl text-green-600 dark:text-green-400">psychology</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $activeSessions ?? 0 }}</p>
            <div class="flex items-center">
                <div class="flex items-center bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-emerald-600">support_agent</span>
                    <span class="text-xs font-medium text-emerald-600">In Progress</span>
                </div>
            </div>
        </div>
    </div>

    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-teal-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-teal-500 to-teal-600"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-teal-500 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Weekly Completed</p>
            </div>
            <div class="bg-gradient-to-br from-teal-50 to-teal-100 dark:from-teal-900/20 dark:to-teal-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-xl text-teal-600 dark:text-teal-400">check_circle</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $weeklyCompleted ?? 0 }}</p>
            <div class="flex items-center">
                <div class="flex items-center bg-teal-50 dark:bg-teal-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-teal-600">calendar_today</span>
                    <span class="text-xs font-medium text-teal-600">This Week</span>
                </div>
            </div>
        </div>
    </div>

    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-600 to-emerald-700"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-emerald-600 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Total Impact</p>
            </div>
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-xl text-emerald-600 dark:text-emerald-400">trending_up</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalSessions ?? 0 }}</p>
            <div class="flex items-center">
                <div class="flex items-center bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-emerald-600">groups</span>
                    <span class="text-xs font-medium text-emerald-600">People Helped</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Stats -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">Today's Sessions</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ isset($todaysSessions) ? $todaysSessions->count() : 0 }}</p>
            </div>
            <span class="material-symbols-outlined text-emerald-500">today</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">Urgent Cases</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ isset($urgentSessions) ? $urgentSessions->count() : 0 }}</p>
            </div>
            <span class="material-symbols-outlined text-green-500">priority_high</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">Avg Rating</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">4.8</p>
            </div>
            <span class="material-symbols-outlined text-teal-500">star</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">Response Time</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">2.4h</p>
            </div>
            <span class="material-symbols-outlined text-emerald-600">schedule</span>
        </div>
    </div>
</div>

<!-- Platform Health Overview -->
<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
        <div class="space-y-3">
            <a href="{{ route('counselor.sessions.index', ['status' => 'pending']) }}" class="w-full bg-primary text-white text-sm font-medium py-2 px-3 rounded-lg hover:opacity-90 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">pending_actions</span>
                Review Requests
            </a>
            <a href="{{ route('counselor.sessions.index') }}" class="w-full bg-emerald-600 text-white text-sm font-medium py-2 px-3 rounded-lg hover:opacity-90 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">psychology</span>
                Active Sessions
            </a>
            <a href="{{ route('counselor.clients') }}" class="w-full bg-green-600 text-white text-sm font-medium py-2 px-3 rounded-lg hover:opacity-90 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">school</span>
                My Clients
            </a>
            <a href="{{ route('counselor.schedule') }}" class="w-full bg-teal-600 text-white text-sm font-medium py-2 px-3 rounded-lg hover:opacity-90 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">schedule</span>
                View Schedule
            </a>
            <a href="{{ route('counselor.reports') }}" class="w-full bg-emerald-700 text-white text-sm font-medium py-2 px-3 rounded-lg hover:opacity-90 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">assessment</span>
                Monthly Report
            </a>
            <a href="{{ route('counselor.contact-setup') }}" class="w-full bg-blue-600 text-white text-sm font-medium py-2 px-3 rounded-lg hover:opacity-90 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">contact_phone</span>
                Contact Setup
            </a>
            <button onclick="document.getElementById('notesModal').classList.remove('hidden')" class="w-full bg-emerald-800 text-white text-sm font-medium py-2 px-3 rounded-lg hover:opacity-90 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">note_add</span>
                Add Note
            </button>
        </div>
    </div>

    <!-- Today's Schedule -->
    <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Today's Schedule</h3>
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ now()->format('M d, Y') }}</span>
        </div>
        @if(isset($todaysSessions) && $todaysSessions->count() > 0)
        <div class="space-y-3">
            @foreach($todaysSessions->take(5) as $session)
            <div class="flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="w-2 h-8 bg-emerald-500 rounded-full"></div>
                <div class="flex-1">
                    <h4 class="font-medium text-gray-900 dark:text-white">{{ $session->student->name }}</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ ucfirst(str_replace('_', ' ', $session->session_type)) }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $session->scheduled_at ? $session->scheduled_at->format('h:i A') : 'TBD' }}</p>
                    <span class="px-2 py-1 text-xs font-medium text-emerald-800 bg-emerald-100 rounded-full dark:bg-emerald-900 dark:text-emerald-300">
                        {{ ucfirst($session->status) }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-8">
            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-gray-400 text-2xl">event_available</span>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-sm">No sessions scheduled for today</p>
        </div>
        @endif
    </div>

    <!-- Session Stats -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Session Stats</h3>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Response Rate</span>
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">98.5%</span>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Completion Rate</span>
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">94%</span>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600 dark:text-gray-400">Satisfaction</span>
                <div class="flex items-center">
                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">4.8/5</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Urgent Sessions & Recent Activity -->
<div class="grid grid-cols-1 xl:grid-cols-1 gap-6">
    @if(isset($urgentSessions) && $urgentSessions->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-red-600">priority_high</span>
                Urgent Sessions
            </h3>
            <a class="text-sm font-medium text-primary hover:underline" href="{{ route('counselor.sessions.index', ['priority' => 'urgent']) }}">View All</a>
        </div>
        <div class="space-y-3">
            @foreach($urgentSessions->take(3) as $session)
            <div class="flex items-center justify-between p-3 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-sm">person</span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">{{ $session->student->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ ucfirst(str_replace('_', ' ', $session->session_type)) }}</p>
                    </div>
                </div>
                <a href="{{ route('counselor.sessions.show', $session) }}" class="text-red-600 dark:text-red-400 hover:underline text-sm font-medium">Review</a>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Urgent Sessions</h3>
        <div class="text-center py-8">
            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-gray-400 text-2xl">check_circle</span>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-sm">No urgent sessions at the moment</p>
        </div>
    </div>
    @endif
</div>

<!-- Notes Modal -->
<div id="notesModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 max-w-3xl w-full shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Add Session Note</h3>
            <button onclick="document.getElementById('notesModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
        </div>

        @if(isset($my_active) && $my_active->count() > 0)
        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl">
            <p class="text-sm text-blue-800 dark:text-blue-200 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">info</span>
                Select an active session to add a note
            </p>
        </div>

        <div class="space-y-3 mb-6">
            @foreach($my_active as $session)
            <button type="button" onclick="showNoteForm({{ $session->id }}, '{{ $session->student->name }}', '{{ $session->subject }}')" 
                class="w-full text-left p-4 bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-xl border border-gray-200 dark:border-gray-600 transition-all">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-900 dark:text-white">{{ $session->student->name }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $session->subject }}</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                                Active
                            </span>
                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                Started {{ $session->started_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                    <span class="material-symbols-outlined text-gray-400">chevron_right</span>
                </div>
            </button>
            @endforeach
        </div>

        <div id="noteFormContainer" class="hidden">
            <div class="mb-4 p-3 bg-primary/10 rounded-lg">
                <p class="text-sm text-gray-700 dark:text-gray-300">
                    <span class="font-semibold">Session:</span> <span id="selectedSessionInfo"></span>
                </p>
            </div>

            <form id="noteForm" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-3">Note Type *</label>
                    <select name="type" required 
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white transition-all">
                        <option value="general">General Note</option>
                        <option value="progress">Progress Update</option>
                        <option value="observation">Clinical Observation</option>
                        <option value="reminder">Reminder/Follow-up</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-3">Title (Optional)</label>
                    <input type="text" name="title" placeholder="Brief title for this note..." 
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white transition-all">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-3">Note Content *</label>
                    <textarea name="content" rows="6" required placeholder="Write your note here..." 
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white resize-none transition-all"></textarea>
                </div>

                <div class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                    <input type="checkbox" name="is_private" id="is_private" value="1" checked 
                        class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                    <label for="is_private" class="text-sm text-gray-700 dark:text-gray-300 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">lock</span>
                        <span>Keep this note private (only visible to counselors and admins)</span>
                    </label>
                </div>
                
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-primary text-white px-6 py-3 rounded-xl font-semibold hover:bg-primary/90 shadow-sm hover:shadow-md transition-all">
                        Save Note
                    </button>
                    <button type="button" onclick="document.getElementById('notesModal').classList.add('hidden')" 
                        class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
        @else
        <div class="text-center py-12">
            <span class="material-symbols-outlined text-6xl text-gray-300 dark:text-gray-600 mb-4">event_busy</span>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No Active Sessions</h4>
            <p class="text-gray-600 dark:text-gray-400 mb-6">You don't have any active sessions to add notes to.</p>
            <a href="{{ route('counselor.sessions.index') }}" class="inline-flex items-center gap-2 text-primary hover:underline">
                <span class="material-symbols-outlined">arrow_forward</span>
                View All Sessions
            </a>
        </div>
        @endif
    </div>
</div>

<script>
function showNoteForm(sessionId, studentName, subject) {
    document.getElementById('selectedSessionInfo').textContent = `${studentName} - ${subject}`;
    document.getElementById('noteForm').action = `/counselor/sessions/${sessionId}/notes`;
    document.getElementById('noteFormContainer').classList.remove('hidden');
    
    // Scroll to form
    document.getElementById('noteFormContainer').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}
</script>
@endsection