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
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Session Chat -->
        <div class="lg:col-span-2">
            {{-- Video Call Section --}}
            {{-- Video call section removed - embedded video calls no longer supported --}}

            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-[700px]">
                <!-- Chat Header -->
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-t-2xl border-t-4 border-t-emerald-500">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-bold shadow-lg">
                                {{ $session->counselor ? substr($session->counselor->name, 0, 1) : 'C' }}
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $session->counselor ? $session->counselor->name : 'Counselor' }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ ucfirst(str_replace('_', ' ', $session->session_type)) }} Session
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
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
                        </div>
                    </div>
                </div>

                <!-- Messages Area -->
                <div class="flex-1 overflow-y-auto p-6 space-y-4" id="messagesContainer">
                    @forelse($session->messages ?? [] as $message)
                    <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[75%] group">
                            <div class="flex items-center gap-2 mb-1 {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $message->sender->name }}
                                </p>
                                <p class="text-xs text-gray-400">
                                    {{ $message->created_at->format('h:i A') }}
                                </p>
                            </div>
                            <div class="rounded-2xl p-4 shadow-sm {{ $message->sender_id === auth()->id() 
                                ? 'bg-gradient-to-br from-emerald-500 to-teal-600 text-white' 
                                : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' }}">
                                <div class="text-sm leading-relaxed message-content" data-sender="{{ $message->sender_id === auth()->id() ? 'self' : 'other' }}">
                                    {!! nl2br(e($message->message)) !!}
                                </div>
                                @if($message->attachment_path)
                                <div class="mt-3 pt-3 border-t {{ $message->sender_id === auth()->id() ? 'border-white/20' : 'border-gray-200 dark:border-gray-600' }}">
                                    <a href="{{ asset('storage/' . $message->attachment_path) }}" target="_blank" 
                                       class="inline-flex items-center gap-2 text-xs {{ $message->sender_id === auth()->id() ? 'text-white/90 hover:text-white' : 'text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200' }} transition-colors">
                                        <span class="material-symbols-outlined text-sm">attachment</span>
                                        View Attachment
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-2xl text-gray-400">chat</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No messages yet</h3>
                        <p class="text-gray-500 dark:text-gray-400">
                            @if($session->status === 'pending')
                                Your session request is being reviewed. You'll be notified when a counselor responds.
                            @else
                                Start the conversation by sending a message below.
                            @endif
                        </p>
                    </div>
                    @endforelse
                </div>

                <!-- Message Input -->
                @if($session->status === 'active')
                <div class="p-6 border-t border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900/50 dark:to-gray-800/50 rounded-b-2xl">
                    <form action="{{ route('public.counseling.session.message', $session) }}" method="POST" enctype="multipart/form-data" class="space-y-3" id="messageForm">
                        @csrf
                        
                        <!-- File Preview -->
                        <div id="filePreview" class="hidden bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">description</span>
                                    <div>
                                        <p class="text-sm font-medium text-blue-900 dark:text-blue-100" id="fileName">-</p>
                                        <p class="text-xs text-blue-700 dark:text-blue-300" id="fileSize">-</p>
                                    </div>
                                </div>
                                <button type="button" onclick="clearAttachment()" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200 transition-colors">
                                    <span class="material-symbols-outlined">close</span>
                                </button>
                            </div>
                        </div>
                        
                        <div class="flex gap-3">
                            <div class="flex-1">
                                <textarea name="message" rows="2" required placeholder="Type your message..." 
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white resize-none transition-all"
                                    onkeydown="if(event.key==='Enter' && !event.shiftKey){event.preventDefault(); this.form.submit();}"></textarea>
                            </div>
                            <div class="flex flex-col gap-2">
                                <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white p-3 rounded-xl hover:from-emerald-600 hover:to-teal-700 hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-300 hover:-translate-y-1" title="Send message">
                                    <span class="material-symbols-outlined">send</span>
                                </button>
                                <label class="bg-gradient-to-r from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600 text-gray-600 dark:text-gray-400 p-3 rounded-xl hover:from-gray-300 hover:to-gray-400 dark:hover:from-gray-600 dark:hover:to-gray-500 transition-all duration-300 cursor-pointer hover:shadow-lg hover:-translate-y-1" title="Attach file" id="attachLabel">
                                    <span class="material-symbols-outlined">attach_file</span>
                                    <input type="file" name="attachment" id="attachmentInput" class="hidden" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif" onchange="handleFileSelect(this)">
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="text-xs text-gray-500 dark:text-gray-400">Press Enter to send, Shift+Enter for new line</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Max file size: 10MB</p>
                        </div>
                    </form>
                </div>
                @elseif($session->status === 'pending')
                <div class="p-6 border-t border-gray-200 dark:border-gray-700 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-b-2xl">
                    <div class="flex items-center gap-3 text-amber-700 dark:text-amber-300">
                        <span class="material-symbols-outlined">pending</span>
                        <p class="text-sm font-medium">Your session request is being reviewed. You'll be notified when a counselor responds.</p>
                    </div>
                </div>
                @else
                <div class="p-6 border-t border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-b-2xl">
                    <div class="flex items-center gap-3 text-blue-700 dark:text-blue-300">
                        <span class="material-symbols-outlined">check_circle</span>
                        <p class="text-sm font-medium">This session has been completed.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Session Info Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Session Details -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-t-2xl border-t-4 border-t-emerald-500">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-emerald-600">info</span>
                        Session Details
                    </h3>
                </div>
                
                <div class="p-6">
                
                <!-- Follow-up Badge -->
                @if($session->isFollowUp())
                <div class="mb-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl p-4 border-t-4 border-t-blue-500">
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
                <div class="mb-4 bg-gradient-to-r from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 border-2 border-purple-200 dark:border-purple-800 rounded-xl p-4 border-t-4 border-t-purple-500">
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
                
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Session Type</p>
                        <p class="font-medium text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $session->session_type)) }}</p>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Priority</p>
                        <span class="px-3 py-1 text-xs font-semibold rounded-full
                            @if($session->priority === 'urgent') bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300
                            @elseif($session->priority === 'high') bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-300
                            @elseif($session->priority === 'medium') bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300
                            @else bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300
                            @endif">
                            {{ ucfirst($session->priority) }}
                        </span>
                    </div>

                    @if($session->preferred_method)
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Preferred Method</p>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm text-emerald-600 dark:text-emerald-400">
                                @if($session->preferred_method === 'zoom' || $session->preferred_method === 'google_meet') videocam
                                @elseif($session->preferred_method === 'whatsapp') chat
                                @elseif($session->preferred_method === 'phone_call') call
                                @else location_on
                                @endif
                            </span>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $session->preferred_method)) }}</p>
                        </div>
                    </div>
                    @endif

                    @if($session->meeting_link && $session->status === 'active')
                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 border-2 border-emerald-200 dark:border-emerald-800 rounded-2xl p-6 border-t-4 border-t-emerald-500 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400">contacts</span>
                            <p class="text-sm font-semibold text-emerald-900 dark:text-emerald-100">
                                Session Contact Details
                            </p>
                        </div>
                        
                        @php
                            $link = $session->meeting_link;
                            $isZoom = str_contains($link, 'zoom.us');
                            $isMeet = str_contains($link, 'meet.google.com');
                            $isWhatsApp = str_contains($link, 'wa.me') || str_contains($link, 'whatsapp');
                            $isPhone = preg_match('/^\+?[0-9\s\-\(\)]+$/', $link);
                        @endphp
                        
                        @if($isZoom)
                            <a href="{{ $link }}" target="_blank" class="block w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-6 py-4 rounded-xl font-semibold text-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1 mb-3 flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">videocam</span>
                                Join Zoom Meeting
                            </a>
                            <p class="text-xs text-emerald-700 dark:text-emerald-300 break-all">{{ $link }}</p>
                        @elseif($isMeet)
                            <a href="{{ $link }}" target="_blank" class="block w-full bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white px-6 py-4 rounded-xl font-semibold text-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1 mb-3 flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">video_call</span>
                                Join Google Meet
                            </a>
                            <p class="text-xs text-emerald-700 dark:text-emerald-300 break-all">{{ $link }}</p>
                        @elseif($isWhatsApp)
                            <a href="{{ $link }}" target="_blank" class="block w-full bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white px-6 py-4 rounded-xl font-semibold text-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1 mb-3 flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">chat</span>
                                Open WhatsApp Chat
                            </a>
                            <p class="text-xs text-emerald-700 dark:text-emerald-300 break-all">{{ $link }}</p>
                        @elseif($isPhone)
                            <a href="tel:{{ $link }}" class="block w-full bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white px-6 py-4 rounded-xl font-semibold text-center transition-all duration-300 hover:shadow-lg hover:-translate-y-1 mb-3 flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">call</span>
                                Call {{ $link }}
                            </a>
                            <p class="text-xs text-emerald-700 dark:text-emerald-300">Your counselor will call you at the scheduled time</p>
                        @else
                            <div class="bg-white dark:bg-gray-800 rounded-xl p-4 mb-3 border border-gray-200 dark:border-gray-700">
                                <p class="text-sm text-gray-900 dark:text-white font-medium flex items-start gap-2">
                                    <span class="material-symbols-outlined text-sm mt-0.5">info</span>
                                    <span class="break-all">{{ $link }}</span>
                                </p>
                            </div>
                        @endif
                        
                        <p class="text-xs text-emerald-700 dark:text-emerald-300 mt-2">
                            Check your messages for detailed instructions from your counselor
                        </p>
                    </div>
                    @endif

                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Requested</p>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $session->created_at->format('M d, Y h:i A') }}</p>
                    </div>

                    @if($session->started_at)
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Started</p>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $session->started_at->format('M d, Y h:i A') }}</p>
                    </div>
                    @endif

                    @if($session->completed_at)
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Completed</p>
                        <p class="text-sm text-gray-900 dark:text-white">{{ $session->completed_at->format('M d, Y h:i A') }}</p>
                    </div>
                    @endif
                </div>

                <!-- Student wants follow-up indicator -->
                @if($session->wants_followup && !$session->isFollowUp())
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-2 border-green-200 dark:border-green-800 rounded-xl p-4 border-t-4 border-t-green-500">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-sm">check_circle</span>
                        <p class="text-xs text-green-800 dark:text-green-200">Student interested in follow-up sessions</p>
                    </div>
                </div>
                @endif
                
                @if($session->status === 'pending')
                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button onclick="document.getElementById('cancelModal').classList.remove('hidden')" 
                        class="w-full bg-gradient-to-r from-red-100 to-red-200 dark:from-red-900/30 dark:to-red-900/50 text-red-700 dark:text-red-300 px-4 py-3 rounded-xl hover:from-red-200 hover:to-red-300 dark:hover:from-red-900/50 dark:hover:to-red-900/70 transition-all duration-300 text-sm font-medium hover:shadow-lg hover:-translate-y-1">
                        Cancel Request
                    </button>
                </div>
                @elseif(in_array($session->status, ['active', 'completed']))
                <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button onclick="document.getElementById('followUpModal').classList.remove('hidden')" 
                        class="w-full bg-gradient-to-r from-emerald-100 to-teal-100 dark:from-emerald-900/30 dark:to-teal-900/30 text-emerald-700 dark:text-emerald-300 px-4 py-3 rounded-xl hover:from-emerald-200 hover:to-teal-200 dark:hover:from-emerald-900/50 dark:hover:to-teal-900/50 transition-all duration-300 text-sm font-medium flex items-center justify-center gap-2 hover:shadow-lg hover:-translate-y-1">
                        <span class="material-symbols-outlined text-base">event_repeat</span>
                        Schedule Follow-up Session
                    </button>
                </div>
                @endif
                </div>
            </div>

            <!-- Initial Request -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-t-2xl border-t-4 border-t-blue-500">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-600">description</span>
                        Your Request
                    </h3>
                </div>
                <div class="p-6">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4">
                        <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">{{ $session->description }}</p>
                    </div>
                </div>
            </div>
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
// Auto-scroll to bottom of messages
function scrollToBottom() {
    const container = document.getElementById('messagesContainer');
    if (container) {
        container.scrollTop = container.scrollHeight;
    }
}

// Linkify URLs in messages
function linkifyMessage(text, isSender) {
    // Regular expression to detect URLs
    const urlRegex = /(https?:\/\/[^\s]+)/g;
    
    // Link styling based on sender
    const linkClass = isSender 
        ? 'underline hover:text-white/80 font-medium break-all' 
        : 'text-blue-600 dark:text-blue-400 underline hover:text-blue-800 dark:hover:text-blue-300 font-medium break-all';
    
    return text.replace(urlRegex, function(url) {
        // Clean up URL (remove trailing punctuation)
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

// Scroll to bottom on page load and linkify messages
document.addEventListener('DOMContentLoaded', function() {
    linkifyAllMessages();
    scrollToBottom();
});

// File attachment handling
function handleFileSelect(input) {
    const file = input.files[0];
    if (file) {
        // Check file size (10MB max)
        const maxSize = 10 * 1024 * 1024; // 10MB in bytes
        if (file.size > maxSize) {
            showToast('File size must be less than 10MB', 'error');
            input.value = '';
            return;
        }
        
        // Show file preview
        const preview = document.getElementById('filePreview');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const attachLabel = document.getElementById('attachLabel');
        
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        preview.classList.remove('hidden');
        
        // Change attach button color to indicate file is attached
        attachLabel.classList.remove('bg-gradient-to-r', 'from-gray-200', 'to-gray-300', 'dark:from-gray-700', 'dark:to-gray-600');
        attachLabel.classList.add('bg-emerald-100', 'dark:bg-emerald-900/30', 'text-emerald-600', 'dark:text-emerald-400');
    }
}

function clearAttachment() {
    const input = document.getElementById('attachmentInput');
    const preview = document.getElementById('filePreview');
    const attachLabel = document.getElementById('attachLabel');
    
    input.value = '';
    preview.classList.add('hidden');
    
    // Reset attach button color
    attachLabel.classList.remove('bg-emerald-100', 'dark:bg-emerald-900/30', 'text-emerald-600', 'dark:text-emerald-400');
    attachLabel.classList.add('bg-gradient-to-r', 'from-gray-200', 'to-gray-300', 'dark:from-gray-700', 'dark:to-gray-600');
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
}

// Auto-refresh messages every 30 seconds for active sessions
@if($session->status === 'active')
setInterval(() => {
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
            linkifyAllMessages(); // Linkify new messages
            scrollToBottom();
        }
    })
    .catch(error => console.log('Error refreshing messages:', error));
}, 30000);
@endif
</script>
@endpush
@endsection
