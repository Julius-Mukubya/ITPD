@extends('layouts.public')

@section('title', 'Counseling Session')

@section('content')
<!-- Breadcrumb -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-8">
    <nav class="flex items-center gap-2 text-sm">
        <a href="{{ route('public.counseling.sessions') }}" class="text-gray-500 dark:text-gray-400 hover:text-primary transition-colors">My Sessions</a>
        <span class="material-symbols-outlined text-gray-400 text-sm">chevron_right</span>
        <span class="text-gray-900 dark:text-white font-medium">Session Details</span>
    </nav>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-4">
        <!-- Session Info Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 flex flex-col" style="height: calc(100vh - 12rem);">
                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">info</span>
                    Session Info
                </h3>
                
                <div class="space-y-3 flex-1 overflow-y-auto">
                    <!-- Follow-up Badge -->
                    @if($session->isFollowUp())
                    <div class="mb-3 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-sm">repeat</span>
                            <div>
                                <p class="text-xs font-semibold text-blue-900 dark:text-blue-100">Follow-up Session</p>
                                <a href="{{ route('public.counseling.session.show', $session->parentSession) }}" class="text-xs text-blue-600 dark:text-blue-400 hover:underline">
                                    View original session →
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Session Series -->
                    @if($session->followUpSessions()->count() > 0 || $session->isFollowUp())
                    <div class="mb-3 bg-gradient-to-r from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-3">
                        <p class="text-xs font-semibold text-purple-900 dark:text-purple-100 mb-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">history</span>
                            Session Series ({{ $session->getSessionSeries()->count() }} sessions)
                        </p>
                        <div class="space-y-1">
                            @foreach($session->getSessionSeries() as $index => $seriesSession)
                            <a href="{{ route('public.counseling.session.show', $seriesSession) }}" 
                               class="block text-xs {{ $seriesSession->id === $session->id ? 'text-purple-900 dark:text-purple-100 font-bold' : 'text-purple-700 dark:text-purple-300 hover:underline' }}">
                                {{ $index + 1 }}. {{ $seriesSession->created_at->format('M d, Y') }} - {{ ucfirst($seriesSession->status) }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">Counselor</p>
                        <p class="font-medium text-sm text-gray-900 dark:text-white">{{ $session->counselor ? $session->counselor->name : 'Assigned Counselor' }}</p>
                        @if($session->counselor && $session->counselor->email)
                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $session->counselor->email }}</p>
                        @endif
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">Type</p>
                        <p class="text-sm text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $session->session_type)) }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">Priority</p>
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full
                            @if($session->priority === 'urgent') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                            @elseif($session->priority === 'high') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300
                            @elseif($session->priority === 'medium') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                            @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                            @endif">
                            {{ ucfirst($session->priority) }}
                        </span>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">Status</p>
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full
                            @if($session->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                            @elseif($session->status === 'active') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                            @elseif($session->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                            @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                            @endif">
                            {{ ucfirst($session->status) }}
                        </span>
                    </div>

                    @if($session->preferred_method)
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">Method</p>
                        <p class="text-sm text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $session->preferred_method)) }}</p>
                    </div>
                    @endif

                    <!-- Group Participants -->
                    @if($session->isGroupSession())
                    <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">Group Participants</p>
                        <div class="space-y-2">
                            <!-- Session Creator -->
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white text-xs font-bold">
                                    {{ substr($session->student->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-medium text-gray-900 dark:text-white">{{ $session->student->name }}</p>
                                    <p class="text-xs text-emerald-600 dark:text-emerald-400">Session Creator</p>
                                </div>
                            </div>
                            
                            <!-- Other Participants -->
                            @foreach($session->participants as $participant)
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold">
                                    {{ substr($participant->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-medium text-gray-900 dark:text-white">{{ $participant->name }}</p>
                                    <p class="text-xs 
                                        @if($participant->status === 'joined') text-green-600 dark:text-green-400
                                        @elseif($participant->status === 'invited') text-yellow-600 dark:text-yellow-400
                                        @elseif($participant->status === 'left') text-gray-500 dark:text-gray-400
                                        @else text-red-600 dark:text-red-400
                                        @endif">
                                        {{ ucfirst($participant->status) }}
                                        @if($participant->status === 'left' && $participant->left_at)
                                            ({{ $participant->left_at->diffForHumans() }})
                                        @endif
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">Requested</p>
                        <p class="text-xs text-gray-900 dark:text-white">{{ $session->created_at->diffForHumans() }}</p>
                    </div>

                    @if($session->started_at)
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">Started</p>
                        <p class="text-xs text-gray-900 dark:text-white">{{ $session->started_at->diffForHumans() }}</p>
                    </div>
                    @endif

                    @if($session->completed_at)
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">Completed</p>
                        <p class="text-xs text-gray-900 dark:text-white">{{ $session->completed_at->diffForHumans() }}</p>
                    </div>
                    @endif

                    <!-- Your Request -->
                    <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Your Request</p>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-2">
                            <p class="text-xs text-gray-700 dark:text-gray-300 leading-relaxed">{{ $session->description }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-700">
                    @if($session->status === 'pending')
                    <button onclick="document.getElementById('cancelModal').classList.remove('hidden')" 
                        class="w-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 px-4 py-2.5 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/50 transition-all text-sm font-medium">
                        Cancel Request
                    </button>
                    @elseif($session->status === 'active')
                        @if($session->isGroupSession())
                            @if($session->isInitiator(auth()->id()))
                            <button onclick="document.getElementById('endSessionModal').classList.remove('hidden')" 
                                class="w-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 px-4 py-2.5 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/50 transition-all text-sm font-medium flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-base">stop_circle</span>
                                End Session for All
                            </button>
                            @elseif($session->isParticipant(auth()->id()))
                            <button onclick="document.getElementById('leaveSessionModal').classList.remove('hidden')" 
                                class="w-full bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 px-4 py-2.5 rounded-lg hover:bg-orange-200 dark:hover:bg-orange-900/50 transition-all text-sm font-medium flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-base">exit_to_app</span>
                                Leave Session
                            </button>
                            @endif
                        @else
                        <button onclick="document.getElementById('endSessionModal').classList.remove('hidden')" 
                            class="w-full bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300 px-4 py-2.5 rounded-lg hover:bg-orange-200 dark:hover:bg-orange-900/50 transition-all text-sm font-medium flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-base">stop_circle</span>
                            End Session
                        </button>
                        @endif
                    @elseif($session->status === 'completed')
                    <button onclick="document.getElementById('followUpModal').classList.remove('hidden')" 
                        class="w-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 px-4 py-2.5 rounded-lg hover:bg-emerald-200 dark:hover:bg-emerald-900/50 transition-all text-sm font-medium flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-base">event_repeat</span>
                        Schedule Follow-up
                    </button>
                    @endif
                </div>
            </div>

            @if($session->is_anonymous)
            <div class="bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 border border-purple-200 dark:border-purple-800 rounded-xl p-3 mt-4">
                <div class="flex items-center gap-2 mb-1">
                    <span class="material-symbols-outlined text-sm text-purple-600 dark:text-purple-400">visibility_off</span>
                    <h3 class="text-sm font-semibold text-purple-900 dark:text-purple-100">Anonymous</h3>
                </div>
                <p class="text-xs text-purple-700 dark:text-purple-300">You requested anonymity.</p>
            </div>
            @endif
        </div>

        <!-- Session Chat -->
        <div class="lg:col-span-3" id="chatContainer">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col transition-all duration-300" id="chatWindow" style="height: calc(100vh - 12rem);">
                <!-- Chat Header -->
                <div class="p-3 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900/50 dark:to-gray-800/50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-bold shadow-lg">
                                {{ $session->counselor ? substr($session->counselor->name, 0, 1) : 'C' }}
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                                    {{ $session->counselor ? $session->counselor->name : 'Counselor' }}
                                </h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    {{ ucfirst(str_replace('_', ' ', $session->session_type)) }} Session
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($session->status === 'pending') bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300
                                @elseif($session->status === 'active') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300
                                @else bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300
                                @endif">
                                {{ ucfirst($session->status) }}
                            </span>
                            @if($session->status === 'active')
                            <div class="flex items-center gap-1 text-emerald-600 dark:text-emerald-400">
                                <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                                <span class="text-xs font-medium">Online</span>
                            </div>
                            @endif
                            <!-- Maximize/Minimize Button -->
                            <button onclick="toggleChatSize()" 
                                class="p-1.5 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors" 
                                id="chatToggleBtn" 
                                title="Maximize Chat">
                                <span class="material-symbols-outlined text-lg text-gray-600 dark:text-gray-400" id="chatToggleIcon">
                                    fullscreen
                                </span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Messages Area -->
                <div class="flex-1 overflow-y-auto p-3 space-y-3" id="messagesContainer">
                    @forelse($session->messages ?? [] as $message)
                    <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[75%]">
                            <div class="flex items-center gap-1.5 mb-0.5 {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $message->sender->name }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    {{ $message->created_at->format('h:i A') }}
                                </p>
                            </div>
                            <div class="rounded-lg p-2.5 {{ $message->sender_id === auth()->id() ? 'bg-primary text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' }}">
                                <div class="text-sm message-content" data-sender="{{ $message->sender_id === auth()->id() ? 'self' : 'other' }}">
                                    {!! nl2br(e($message->message)) !!}
                                </div>
                                @if($message->attachment_path)
                                <a href="{{ asset('storage/' . $message->attachment_path) }}" target="_blank" class="text-xs underline mt-1.5 block">
                                    View Attachment
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="flex items-center justify-center h-full">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="material-symbols-outlined text-3xl text-gray-400">chat</span>
                            </div>
                            <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1">No messages yet</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                @if($session->status === 'pending')
                                    Your session request is being reviewed. You'll be notified when a counselor responds.
                                @else
                                    Start the conversation by sending a message below.
                                @endif
                            </p>
                        </div>
                    </div>
                    @endforelse
                </div>

                @if($session->status === 'pending')
                <div class="p-3 border-t border-gray-200 dark:border-gray-700 bg-yellow-50 dark:bg-yellow-900/20">
                    <div class="flex items-center gap-2 text-yellow-700 dark:text-yellow-300">
                        <span class="material-symbols-outlined text-sm">info</span>
                        <p class="text-xs font-medium">Your session request is being reviewed.</p>
                    </div>
                </div>
                @elseif($session->status === 'active')
                <div class="p-3 border-t border-gray-200 dark:border-gray-700">
                    <form action="{{ route('public.counseling.session.message', $session) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex gap-2">
                            <input type="text" name="message" required placeholder="Type your message..." 
                                class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors">
                                <span class="material-symbols-outlined">send</span>
                            </button>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- End Session Modal -->
<div id="endSessionModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full border border-gray-200 dark:border-gray-700 hover:shadow-3xl transition-all duration-300">
        <div class="p-8 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 rounded-t-2xl border-t-4 border-t-orange-500">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-100 to-red-100 dark:from-orange-900/30 dark:to-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-3xl text-orange-600 dark:text-orange-400">stop_circle</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                    @if($session->isGroupSession() && $session->isInitiator(auth()->id()))
                        End Session for Everyone
                    @else
                        End Session
                    @endif
                </h3>
                <p class="text-gray-600 dark:text-gray-400">
                    @if($session->isGroupSession() && $session->isInitiator(auth()->id()))
                        Are you sure you want to end this group session for all participants?
                    @else
                        Are you sure you want to end this counseling session?
                    @endif
                </p>
            </div>
        </div>
        
        <div class="p-8">
            <form action="{{ route('public.counseling.session.end', $session) }}" method="POST">
                @csrf
                @method('PATCH')
                
                @if($session->isGroupSession() && $session->isInitiator(auth()->id()))
                <input type="hidden" name="action" value="end_for_all">
                @else
                <input type="hidden" name="action" value="end_for_all">
                @endif
                
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                            Session Feedback (Optional)
                        </label>
                        <textarea name="feedback" rows="3" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white resize-none text-sm"
                            placeholder="How was your session? Any feedback for your counselor?"></textarea>
                    </div>
                    
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl p-4">
                        <p class="text-xs text-blue-800 dark:text-blue-200">
                            <strong>Note:</strong> 
                            @if($session->isGroupSession() && $session->isInitiator(auth()->id()))
                                Ending the session will mark it as completed for all participants. You can schedule a follow-up session afterwards if needed.
                            @else
                                Ending the session will mark it as completed. You can schedule a follow-up session afterwards if needed.
                            @endif
                        </p>
                    </div>
                </div>
                
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-orange-600 to-red-600 text-white px-4 py-3 rounded-xl font-semibold hover:from-orange-700 hover:to-red-700 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        @if($session->isGroupSession() && $session->isInitiator(auth()->id()))
                            End for Everyone
                        @else
                            End Session
                        @endif
                    </button>
                    <button type="button" onclick="document.getElementById('endSessionModal').classList.add('hidden')" 
                        class="px-6 py-3 bg-gradient-to-r from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:from-gray-300 hover:to-gray-400 dark:hover:from-gray-600 dark:hover:to-gray-500 transition-all duration-300">
                        Continue Session
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Leave Session Modal (for group participants) -->
<div id="leaveSessionModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full border border-gray-200 dark:border-gray-700 hover:shadow-3xl transition-all duration-300">
        <div class="p-8 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-orange-50 to-yellow-50 dark:from-orange-900/20 dark:to-yellow-900/20 rounded-t-2xl border-t-4 border-t-orange-500">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-100 to-yellow-100 dark:from-orange-900/30 dark:to-yellow-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-3xl text-orange-600 dark:text-orange-400">exit_to_app</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Leave Group Session</h3>
                <p class="text-gray-600 dark:text-gray-400">Are you sure you want to leave this group session? The session will continue for other participants.</p>
            </div>
        </div>
        
        <div class="p-8">
            <form action="{{ route('public.counseling.session.end', $session) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <input type="hidden" name="action" value="leave_session">
                
                <div class="space-y-4 mb-6">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl p-4">
                        <p class="text-xs text-blue-800 dark:text-blue-200">
                            <strong>Note:</strong> Leaving the session will remove you from the group chat. The session will continue for other participants and the session creator.
                        </p>
                    </div>
                </div>
                
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-orange-600 to-yellow-600 text-white px-4 py-3 rounded-xl font-semibold hover:from-orange-700 hover:to-yellow-700 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        Leave Session
                    </button>
                    <button type="button" onclick="document.getElementById('leaveSessionModal').classList.add('hidden')" 
                        class="px-6 py-3 bg-gradient-to-r from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:from-gray-300 hover:to-gray-400 dark:hover:from-gray-600 dark:hover:to-gray-500 transition-all duration-300">
                        Stay in Session
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Follow-up Session Modal -->
<div id="followUpModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full border border-gray-200 dark:border-gray-700 hover:shadow-3xl transition-all duration-300">
        <div class="p-8 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-t-2xl border-t-4 border-t-emerald-500">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-100 to-teal-100 dark:from-emerald-900/30 dark:to-teal-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-3xl text-emerald-600 dark:text-emerald-400">event_repeat</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Schedule Follow-up Session</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Continue your counseling journey with a follow-up session</p>
            </div>
        </div>
        
        <div class="p-8">
            <form action="{{ route('public.counseling.session.followup', $session) }}" method="POST">
                @csrf
                
                <div class="space-y-4 mb-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                            Reason for Follow-up (Optional)
                        </label>
                        <textarea name="reason" rows="3" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white resize-none text-sm"
                            placeholder="What would you like to discuss in the follow-up session?"></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                            Preferred Date & Time (Optional)
                        </label>
                        <input type="datetime-local" name="preferred_datetime" 
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white text-sm">
                    </div>
                    
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl p-4">
                        <p class="text-xs text-blue-800 dark:text-blue-200">
                            <strong>Note:</strong> Your follow-up session will be with the same counselor ({{ $session->counselor ? $session->counselor->name : 'assigned counselor' }}) for continuity of care.
                        </p>
                    </div>
                </div>
                
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-gradient-to-r from-emerald-600 to-teal-600 text-white px-4 py-3 rounded-xl font-semibold hover:from-emerald-700 hover:to-teal-700 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        Schedule Follow-up
                    </button>
                    <button type="button" onclick="document.getElementById('followUpModal').classList.add('hidden')" 
                        class="px-6 py-3 bg-gradient-to-r from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:from-gray-300 hover:to-gray-400 dark:hover:from-gray-600 dark:hover:to-gray-500 transition-all duration-300">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Cancel Session Modal -->
<div id="cancelModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full border border-gray-200 dark:border-gray-700 hover:shadow-3xl transition-all duration-300">
        <div class="p-8 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 rounded-t-2xl border-t-4 border-t-red-500">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-br from-red-100 to-orange-100 dark:from-red-900/30 dark:to-orange-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-3xl text-red-600 dark:text-red-400">cancel</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Cancel Session Request</h3>
                <p class="text-gray-600 dark:text-gray-400">Are you sure you want to cancel this counseling session request?</p>
            </div>
        </div>
        
        <div class="p-8">
            <div class="flex gap-3">
                <form action="{{ route('public.counseling.session.cancel', $session) }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-gradient-to-r from-red-600 to-red-700 text-white px-4 py-3 rounded-xl font-semibold hover:from-red-700 hover:to-red-800 transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                        Yes, Cancel Request
                    </button>
                </form>
                <button onclick="document.getElementById('cancelModal').classList.add('hidden')" 
                    class="px-6 py-3 bg-gradient-to-r from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:from-gray-300 hover:to-gray-400 dark:hover:from-gray-600 dark:hover:to-gray-500 transition-all duration-300">
                    Keep Request
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Linkify URLs in messages
function linkifyMessage(text, isSender) {
    const urlRegex = /(https?:\/\/[^\s]+)/g;
    const linkClass = isSender 
        ? 'underline hover:opacity-80 font-medium break-all' 
        : 'text-blue-600 dark:text-blue-400 underline hover:text-blue-800 dark:hover:text-blue-300 font-medium break-all';
    
    return text.replace(urlRegex, function(url) {
        let cleanUrl = url.replace(/[.,;:!?)]$/, '');
        let punctuation = url.slice(cleanUrl.length);
        return `<a href="${cleanUrl}" target="_blank" rel="noopener noreferrer" class="${linkClass}">${cleanUrl}</a>${punctuation}`;
    });
}

// Apply linkification to all messages
function linkifyAllMessages() {
    document.querySelectorAll('.message-content').forEach(function(element) {
        const isSender = element.dataset.sender === 'self';
        const originalHtml = element.innerHTML;
        const linkifiedHtml = linkifyMessage(originalHtml, isSender);
        if (originalHtml !== linkifiedHtml) {
            element.innerHTML = linkifiedHtml;
        }
    });
}

// Auto-scroll to bottom of messages
function scrollToBottom() {
    const container = document.getElementById('messagesContainer');
    if (container) {
        container.scrollTop = container.scrollHeight;
    }
}

// Chat maximize/minimize functionality
let isChatMaximized = localStorage.getItem('chatMaximized') === 'true';
let originalChatState = null;

function toggleChatSize() {
    const chatContainer = document.getElementById('chatContainer');
    const chatWindow = document.getElementById('chatWindow');
    const chatToggleIcon = document.getElementById('chatToggleIcon');
    const chatToggleBtn = document.getElementById('chatToggleBtn');
    const sidebar = chatContainer.previousElementSibling; // Session info sidebar
    const mainContainer = chatContainer.closest('.max-w-7xl'); // Main container
    
    if (!isChatMaximized) {
        // Store original state
        originalChatState = {
            chatContainerClass: chatContainer.className,
            chatWindowStyle: chatWindow.style.cssText,
            sidebarDisplay: sidebar.style.display,
            mainContainerClass: mainContainer.className
        };
        
        // Maximize chat - make it cover entire viewport
        chatContainer.className = 'fixed inset-0 z-[9999] bg-black/20 flex items-center justify-center p-4';
        chatWindow.style.cssText = 'height: calc(100vh - 2rem); width: calc(100vw - 2rem); max-width: none; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);';
        sidebar.style.display = 'none';
        
        // Update button
        chatToggleIcon.textContent = 'fullscreen_exit';
        chatToggleBtn.title = 'Minimize Chat';
        isChatMaximized = true;
        
        // Store state in localStorage
        localStorage.setItem('chatMaximized', 'true');
        
        // Prevent body scroll
        document.body.style.overflow = 'hidden';
        
        // Add click outside to close functionality
        chatContainer.addEventListener('click', function(e) {
            if (e.target === chatContainer) {
                toggleChatSize();
            }
        });
        
    } else {
        // Restore original state
        if (originalChatState) {
            chatContainer.className = originalChatState.chatContainerClass;
            chatWindow.style.cssText = originalChatState.chatWindowStyle;
            sidebar.style.display = originalChatState.sidebarDisplay;
            mainContainer.className = originalChatState.mainContainerClass;
        }
        
        // Update button
        chatToggleIcon.textContent = 'fullscreen';
        chatToggleBtn.title = 'Maximize Chat';
        isChatMaximized = false;
        
        // Remove state from localStorage
        localStorage.removeItem('chatMaximized');
        
        // Restore body scroll
        document.body.style.overflow = '';
        
        // Remove event listeners
        chatContainer.removeEventListener('click', arguments.callee);
    }
    
    // Scroll to bottom after resize
    setTimeout(scrollToBottom, 100);
}

// Apply maximized state on page load
function applyChatState() {
    if (isChatMaximized) {
        // Delay to ensure DOM is ready
        setTimeout(() => {
            toggleChatSize();
        }, 100);
    }
}

// Handle message form submission with AJAX to prevent page refresh
function setupMessageForm() {
    const messageForm = document.querySelector('form[action*="message"]');
    if (messageForm) {
        messageForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const messageInput = this.querySelector('input[name="message"]');
            const submitButton = this.querySelector('button[type="submit"]');
            
            // Disable form during submission
            messageInput.disabled = true;
            submitButton.disabled = true;
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Clear the input
                    messageInput.value = '';
                    
                    // Refresh messages
                    refreshMessages();
                } else {
                    alert('Failed to send message. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error sending message:', error);
                alert('Failed to send message. Please try again.');
            })
            .finally(() => {
                // Re-enable form
                messageInput.disabled = false;
                submitButton.disabled = false;
                messageInput.focus();
            });
        });
    }
}

// Refresh messages function
function refreshMessages() {
    fetch(window.location.href, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newMessages = doc.getElementById('messagesContainer');
        if (newMessages) {
            document.getElementById('messagesContainer').innerHTML = newMessages.innerHTML;
            linkifyAllMessages();
            scrollToBottom();
        }
    })
    .catch(error => console.log('Error refreshing messages:', error));
}

// Handle escape key to minimize chat
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && isChatMaximized) {
        toggleChatSize();
    }
});

// Linkify on page load and scroll to bottom
document.addEventListener('DOMContentLoaded', function() {
    linkifyAllMessages();
    scrollToBottom();
    applyChatState();
    setupMessageForm();
});

// Auto-refresh messages every 30 seconds for active sessions
@if($session->status === 'active')
setInterval(() => {
    refreshMessages();
}, 30000);
@endif
</script>
@endpush
@endsection
