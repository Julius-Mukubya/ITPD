@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : (auth()->user()->role === 'counselor' ? 'layouts.counselor' : 'layouts.student'))

@section('title', 'Notifications')
@section('page-title', 'Notifications')

@section('content')
<!-- Header -->
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Notifications</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Stay updated with your latest activities</p>
    </div>
    
    @if($notifications->where('read_at', null)->count() > 0)
    <form action="{{ route('notifications.mark-all-read') }}" method="POST">
        @csrf
        @method('PATCH')
        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:opacity-90 flex items-center gap-2 font-medium">
            <span class="material-symbols-outlined text-sm">done_all</span>
            Mark All as Read
        </button>
    </form>
    @endif
</div>



<!-- Notifications List -->
<div class="bg-gradient-to-br from-white to-emerald-50/30 dark:from-gray-800 dark:to-emerald-950/20 rounded-2xl border border-emerald-100 dark:border-emerald-900/30 shadow-lg shadow-emerald-500/5 overflow-hidden">
    @if($notifications->count() > 0)
        <div class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($notifications as $notification)
            <div class="p-4 hover:bg-emerald-50/50 dark:hover:bg-emerald-900/10 transition-colors {{ $notification->read_at ? 'opacity-60' : 'bg-emerald-50/30 dark:bg-emerald-900/20' }}">
                <div class="flex items-start gap-4">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg">
                            <span class="material-symbols-outlined text-white text-xl">
                                @if(isset($notification->data['type']))
                                    @switch($notification->data['type'])
                                        @case('quiz')
                                            quiz
                                            @break
                                        @case('content')
                                        @case('content_created')
                                            article
                                            @break
                                        @case('counseling')
                                        @case('counseling_session')
                                            support_agent
                                            @break
                                        @case('campaign')
                                        @case('campaign_created')
                                            campaign
                                            @break
                                        @case('user_registered')
                                            person_add
                                            @break
                                        @default
                                            notifications
                                    @endswitch
                                @elseif(isset($notification->type))
                                    @switch($notification->type)
                                        @case('quiz')
                                            quiz
                                            @break
                                        @case('content_created')
                                            article
                                            @break
                                        @case('counseling_session')
                                            support_agent
                                            @break
                                        @case('campaign_created')
                                            campaign
                                            @break
                                        @case('user_registered')
                                            person_add
                                            @break
                                        @default
                                            notifications
                                    @endswitch
                                @else
                                    notifications
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1">
                                    {{ $notification->data['title'] ?? $notification->title ?? 'Notification' }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                    {{ $notification->data['message'] ?? $notification->message ?? 'You have a new notification' }}
                                </p>
                                <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">schedule</span>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                    @if($notification->read_at)
                                    <span class="flex items-center gap-1 text-emerald-600 dark:text-emerald-400">
                                        <span class="material-symbols-outlined text-sm">check_circle</span>
                                        Read
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-2">
                                @if(!$notification->read_at)
                                <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="p-2 text-emerald-600 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 rounded-lg transition-colors" title="Mark as read">
                                        <span class="material-symbols-outlined text-lg">check</span>
                                    </button>
                                </form>
                                @endif
                                
                                @if(isset($notification->data['url']))
                                <a href="{{ $notification->data['url'] }}" class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors" title="View">
                                    <span class="material-symbols-outlined text-lg">arrow_forward</span>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900/50 border-t border-gray-200 dark:border-gray-700">
            {{ $notifications->links() }}
        </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="p-12 text-center">
            <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-gradient-to-br from-emerald-100 to-teal-100 dark:from-emerald-900/30 dark:to-teal-900/30 flex items-center justify-center">
                <span class="material-symbols-outlined text-5xl text-emerald-600 dark:text-emerald-400">notifications_off</span>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No Notifications</h3>
            <p class="text-gray-500 dark:text-gray-400">You're all caught up! Check back later for updates.</p>
        </div>
    @endif
</div>

@endsection
