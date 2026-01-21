@extends('layouts.counselor')

@section('title', 'Notifications')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-2xl sm:text-3xl font-bold tracking-tight">Notifications</p>
        <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">Stay updated with session requests, upcoming sessions, and messages</p>
    </div>
    <div class="flex items-center gap-2">
        <form action="{{ route('notifications.mark-all-read') }}" method="POST">
            @csrf
            <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-semibold px-6 py-3 rounded-xl flex items-center justify-center gap-2 hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-200">
                <span class="material-symbols-outlined text-lg">done_all</span>
                Mark All Read
            </button>
        </form>
    </div>
</div>

<!-- Notification Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Pending Sessions -->
    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-yellow-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-yellow-500 to-yellow-600"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Pending Requests</p>
            </div>
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-xl text-yellow-600 dark:text-yellow-400">pending</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $pendingSessions->count() }}</p>
            <div class="flex items-center">
                <div class="flex items-center bg-yellow-50 dark:bg-yellow-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-yellow-600">schedule</span>
                    <span class="text-xs font-medium text-yellow-600">Awaiting Response</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Sessions -->
    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-blue-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-blue-600"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Upcoming Sessions</p>
            </div>
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-xl text-blue-600 dark:text-blue-400">schedule</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $upcomingSessions->count() }}</p>
            <div class="flex items-center">
                <div class="flex items-center bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-blue-600">event</span>
                    <span class="text-xs font-medium text-blue-600">Next 7 Days</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Unread Messages -->
    <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-green-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-green-600"></div>
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Unread Messages</p>
            </div>
            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                <span class="material-symbols-outlined text-xl text-green-600 dark:text-green-400">message</span>
            </div>
        </div>
        <div class="space-y-2">
            <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $unreadMessages->count() }}</p>
            <div class="flex items-center">
                <div class="flex items-center bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">
                    <span class="material-symbols-outlined text-xs mr-1 text-green-600">chat</span>
                    <span class="text-xs font-medium text-green-600">Session Chats</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Notifications List -->
<div class="space-y-6">
    <!-- Pending Session Requests -->
    @if($pendingSessions->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="bg-yellow-50 dark:bg-yellow-900/20 px-6 py-4 border-b border-yellow-100 dark:border-yellow-900/30">
            <div class="flex items-center gap-3">
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 rounded-xl p-2">
                    <span class="material-symbols-outlined text-xl text-yellow-600 dark:text-yellow-400">pending</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Pending Session Requests</h3>
            </div>
        </div>
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($pendingSessions as $session)
            <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <div class="flex items-start justify-between">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-yellow-500 to-yellow-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                            {{ substr($session->student->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $session->student->name }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $session->subject }}</p>
                            <div class="flex items-center gap-4 mt-2">
                                <span class="text-xs text-gray-500 dark:text-gray-500">{{ $session->created_at->diffForHumans() }}</span>
                                <span class="px-2 py-1 bg-{{ $session->priority_badge['color'] }}-100 dark:bg-{{ $session->priority_badge['color'] }}-900/20 text-{{ $session->priority_badge['color'] }}-800 dark:text-{{ $session->priority_badge['color'] }}-200 text-xs font-medium rounded-full">
                                    {{ $session->priority_badge['text'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('counselor.sessions.show', $session) }}" class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:shadow-lg hover:shadow-yellow-500/30 transition-all duration-200">
                        Review
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Upcoming Sessions -->
    @if($upcomingSessions->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="bg-blue-50 dark:bg-blue-900/20 px-6 py-4 border-b border-blue-100 dark:border-blue-900/30">
            <div class="flex items-center gap-3">
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-2">
                    <span class="material-symbols-outlined text-xl text-blue-600 dark:text-blue-400">schedule</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Upcoming Sessions</h3>
            </div>
        </div>
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($upcomingSessions as $session)
            <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <div class="flex items-start justify-between">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                            {{ substr($session->student->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $session->student->name }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $session->subject }}</p>
                            <div class="flex items-center gap-4 mt-2">
                                <span class="text-sm font-medium text-blue-600 dark:text-blue-400">
                                    {{ $session->scheduled_at->format('M j, Y \a\t g:i A') }}
                                </span>
                                <span class="text-xs text-gray-500 dark:text-gray-500">
                                    {{ $session->scheduled_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('counselor.sessions.show', $session) }}" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:shadow-lg hover:shadow-blue-500/30 transition-all duration-200">
                        View Session
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Unread Messages -->
    @if($unreadMessages->count() > 0)
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
        <div class="bg-green-50 dark:bg-green-900/20 px-6 py-4 border-b border-green-100 dark:border-green-900/30">
            <div class="flex items-center gap-3">
                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-2">
                    <span class="material-symbols-outlined text-xl text-green-600 dark:text-green-400">message</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Unread Messages</h3>
            </div>
        </div>
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($unreadMessages as $message)
            <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <div class="flex items-start justify-between">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center text-white font-bold text-lg shadow-lg">
                            {{ substr($message->sender->name, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 dark:text-white">{{ $message->sender->name }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ Str::limit($message->message, 100) }}</p>
                            <div class="flex items-center gap-4 mt-2">
                                <span class="text-xs text-gray-500 dark:text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-500">Session: {{ $message->session->subject }}</span>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('counselor.sessions.show', $message->session) }}" class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:shadow-lg hover:shadow-green-500/30 transition-all duration-200">
                        Reply
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- No Notifications -->
    @if($pendingSessions->count() === 0 && $upcomingSessions->count() === 0 && $unreadMessages->count() === 0)
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-12 text-center">
        <span class="material-symbols-outlined text-6xl text-gray-400 dark:text-gray-600 mb-4">notifications_none</span>
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">All caught up!</h3>
        <p class="text-gray-500 dark:text-gray-400">You have no new notifications at the moment.</p>
    </div>
    @endif
</div>
@endsection