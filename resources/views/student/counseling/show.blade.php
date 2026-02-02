@extends('layouts.student')

@section('title', 'Counseling Session - Student')
@section('page-title', 'Counseling Session')

@section('content')
<!-- Breadcrumb -->
<div class="mb-8">
    <nav class="flex items-center gap-2 text-sm">
        <a href="{{ route('student.counseling.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-primary transition-colors">Counseling</a>
        <span class="material-symbols-outlined text-gray-400 text-sm">chevron_right</span>
        <span class="text-gray-900 dark:text-white font-medium">Session Details</span>
    </nav>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Session Chat -->
    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg flex flex-col h-[700px]">
            <!-- Chat Header -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-t-2xl">
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
                            <p class="text-sm leading-relaxed">{{ $message->message }}</p>
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
            <div class="p-6 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 rounded-b-2xl">
                <form action="{{ route('student.counseling.message', $session) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    <div class="flex gap-3">
                        <div class="flex-1">
                            <textarea name="message" rows="2" required placeholder="Type your message..." 
                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white resize-none transition-all"
                                onkeydown="if(event.key==='Enter' && !event.shiftKey){event.preventDefault(); this.form.submit();}"></textarea>
                        </div>
                        <div class="flex flex-col gap-2">
                            <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white p-3 rounded-xl hover:shadow-lg hover:shadow-emerald-500/30 transition-all">
                                <span class="material-symbols-outlined">send</span>
                            </button>
                            <label class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400 p-3 rounded-xl hover:bg-gray-300 dark:hover:bg-gray-600 transition-all cursor-pointer">
                                <span class="material-symbols-outlined">attach_file</span>
                                <input type="file" name="attachment" class="hidden" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            </label>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Press Enter to send, Shift+Enter for new line</p>
                </form>
            </div>
            @elseif($session->status === 'pending')
            <div class="p-6 border-t border-gray-200 dark:border-gray-700 bg-amber-50 dark:bg-amber-900/20 rounded-b-2xl">
                <div class="flex items-center gap-3 text-amber-700 dark:text-amber-300">
                    <span class="material-symbols-outlined">pending</span>
                    <p class="text-sm font-medium">Your session request is being reviewed. You'll be notified when a counselor responds.</p>
                </div>
            </div>
            @else
            <div class="p-6 border-t border-gray-200 dark:border-gray-700 bg-blue-50 dark:bg-blue-900/20 rounded-b-2xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 text-blue-700 dark:text-blue-300">
                        <span class="material-symbols-outlined">check_circle</span>
                        <p class="text-sm font-medium">This session has been completed.</p>
                    </div>
                    @if(!$session->hasFeedbackFrom(auth()->id(), $session->student_id === auth()->id() ? 'student_to_counselor' : 'counselor_to_student'))
                    <button onclick="openFeedbackModal({{ $session->id }})" 
                        class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-4 py-2 rounded-lg font-semibold hover:from-emerald-600 hover:to-teal-700 transition-all flex items-center gap-2 text-sm">
                        <span class="material-symbols-outlined text-sm">rate_review</span>
                        Leave Feedback
                    </button>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Session Info Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Session Details -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600">info</span>
                Session Details
            </h3>
            
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
                <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 border-2 border-emerald-200 dark:border-emerald-800 rounded-xl p-4">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400">contacts</span>
                        <p class="text-sm font-semibold text-emerald-900 dark:text-emerald-100">
                            Session Contact Details
                        </p>
                    </div>
                    
                    <!-- Smart detection of link type -->
                    @php
                        $link = $session->meeting_link;
                        $isZoom = str_contains($link, 'zoom.us');
                        $isMeet = str_contains($link, 'meet.google.com');
                        $isWhatsApp = str_contains($link, 'wa.me') || str_contains($link, 'whatsapp');
                        $isPhone = preg_match('/^\+?[0-9\s\-\(\)]+$/', $link);
                    @endphp
                    
                    @if($isZoom)
                        <a href="{{ $link }}" target="_blank" class="block w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-semibold text-center transition-all mb-2 flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">videocam</span>
                            Join Zoom Meeting
                        </a>
                        <p class="text-xs text-emerald-700 dark:text-emerald-300 break-all">{{ $link }}</p>
                    @elseif($isMeet)
                        <a href="{{ $link }}" target="_blank" class="block w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-semibold text-center transition-all mb-2 flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">video_call</span>
                            Join Google Meet
                        </a>
                        <p class="text-xs text-emerald-700 dark:text-emerald-300 break-all">{{ $link }}</p>
                    @elseif($isWhatsApp)
                        <a href="{{ $link }}" target="_blank" class="block w-full bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-3 rounded-lg font-semibold text-center transition-all mb-2 flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">chat</span>
                            Open WhatsApp Chat
                        </a>
                        <p class="text-xs text-emerald-700 dark:text-emerald-300 break-all">{{ $link }}</p>
                    @elseif($isPhone)
                        <a href="tel:{{ $link }}" class="block w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-lg font-semibold text-center transition-all mb-2 flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">call</span>
                            Call {{ $link }}
                        </a>
                        <p class="text-xs text-emerald-700 dark:text-emerald-300">Your counselor will call you at the scheduled time</p>
                    @else
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-3 mb-2">
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

            @if($session->status === 'pending')
            <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                <button onclick="document.getElementById('cancelModal').classList.remove('hidden')" 
                    class="w-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 px-4 py-2 rounded-lg hover:bg-red-200 dark:hover:bg-red-900/50 transition-all text-sm font-medium">
                    Cancel Request
                </button>
            </div>
            @endif
        </div>

        <!-- Initial Request -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-600">description</span>
                Your Request
            </h3>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4">
                <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">{{ $session->description }}</p>
            </div>
        </div>

        <!-- Resources -->
        <div class="bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 border border-purple-200 dark:border-purple-800 rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-purple-900 dark:text-purple-100 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">library_books</span>
                Helpful Resources
            </h3>
            <div class="space-y-3">
                <a href="#" class="block bg-white/50 dark:bg-white/5 rounded-lg p-3 hover:bg-white/70 dark:hover:bg-white/10 transition-all">
                    <h4 class="font-medium text-purple-900 dark:text-purple-100 text-sm">Stress Management Guide</h4>
                    <p class="text-xs text-purple-700 dark:text-purple-300">Techniques for managing academic stress</p>
                </a>
                <a href="#" class="block bg-white/50 dark:bg-white/5 rounded-lg p-3 hover:bg-white/70 dark:hover:bg-white/10 transition-all">
                    <h4 class="font-medium text-purple-900 dark:text-purple-100 text-sm">Mindfulness Exercises</h4>
                    <p class="text-xs text-purple-700 dark:text-purple-300">Daily practices for mental wellbeing</p>
                </a>
                <a href="#" class="block bg-white/50 dark:bg-white/5 rounded-lg p-3 hover:bg-white/70 dark:hover:bg-white/10 transition-all">
                    <h4 class="font-medium text-purple-900 dark:text-purple-100 text-sm">Crisis Support</h4>
                    <p class="text-xs text-purple-700 dark:text-purple-300">Emergency contacts and resources</p>
                </a>
            </div>
        </div>

        <!-- Session Feedback -->
        @if($session->status === 'completed')
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600">rate_review</span>
                Session Feedback
            </h3>
            
            @php
                $studentFeedback = $session->getStudentFeedback();
                $counselorFeedback = $session->getCounselorFeedback();
                $userFeedbackType = $session->student_id === auth()->id() ? 'student_to_counselor' : 'counselor_to_student';
                $userFeedback = $session->getFeedbackFrom(auth()->id(), $userFeedbackType);
            @endphp
            
            <!-- User's Feedback -->
            @if($userFeedback)
            <div class="mb-4 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg">
                <div class="flex items-start justify-between mb-2">
                    <h4 class="font-semibold text-emerald-900 dark:text-emerald-100 text-sm">Your Feedback</h4>
                    @if($userFeedback->rating)
                    <div class="text-yellow-500 text-sm">{{ $userFeedback->rating_stars }}</div>
                    @endif
                </div>
                <p class="text-emerald-800 dark:text-emerald-200 text-sm">{{ $userFeedback->feedback_text }}</p>
                <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-2">
                    Submitted {{ $userFeedback->created_at->diffForHumans() }}
                    @if($userFeedback->is_anonymous) • Anonymous @endif
                </p>
            </div>
            @else
            <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg">
                <div class="text-center">
                    <span class="material-symbols-outlined text-gray-400 text-2xl mb-2 block">rate_review</span>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">Share your experience with this session</p>
                    <button onclick="openFeedbackModal({{ $session->id }})" 
                        class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-4 py-2 rounded-lg font-semibold hover:from-emerald-600 hover:to-teal-700 transition-all flex items-center gap-2 text-sm mx-auto">
                        <span class="material-symbols-outlined text-sm">add</span>
                        Leave Feedback
                    </button>
                </div>
            </div>
            @endif
            
            <!-- Other Party's Feedback -->
            @php
                $otherFeedback = $session->student_id === auth()->id() ? $counselorFeedback : $studentFeedback;
                $otherPartyName = $session->student_id === auth()->id() ? 'Counselor' : 'Student';
            @endphp
            
            @if($otherFeedback)
            <div class="p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                <div class="flex items-start justify-between mb-2">
                    <h4 class="font-semibold text-blue-900 dark:text-blue-100 text-sm">{{ $otherPartyName }}'s Feedback</h4>
                    @if($otherFeedback->rating)
                    <div class="text-yellow-500 text-sm">{{ $otherFeedback->rating_stars }}</div>
                    @endif
                </div>
                <p class="text-blue-800 dark:text-blue-200 text-sm">{{ $otherFeedback->feedback_text }}</p>
                <p class="text-xs text-blue-600 dark:text-blue-400 mt-2">
                    From {{ $otherFeedback->author_name }} • {{ $otherFeedback->created_at->diffForHumans() }}
                </p>
            </div>
            @else
            <div class="p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg">
                <div class="text-center">
                    <span class="material-symbols-outlined text-gray-400 text-lg mb-1 block">schedule</span>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Waiting for {{ strtolower($otherPartyName) }}'s feedback</p>
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>

<!-- Cancel Session Modal -->
<div id="cancelModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 max-w-md w-full shadow-2xl">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-3xl text-red-600 dark:text-red-400">cancel</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Cancel Session Request</h3>
            <p class="text-gray-600 dark:text-gray-400">Are you sure you want to cancel this counseling session request?</p>
        </div>
        
        <div class="flex gap-3">
            <form action="{{ route('student.counseling.cancel', $session) }}" method="POST" class="flex-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full bg-red-600 text-white px-4 py-3 rounded-xl font-semibold hover:bg-red-700 transition-all">
                    Yes, Cancel Request
                </button>
            </form>
            <button onclick="document.getElementById('cancelModal').classList.add('hidden')" 
                class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all">
                Keep Request
            </button>
        </div>
    </div>
</div>

@include('components.session-feedback-modal')

@push('scripts')
<script>
// Auto-scroll to bottom of messages
function scrollToBottom() {
    const container = document.getElementById('messagesContainer');
    if (container) {
        container.scrollTop = container.scrollHeight;
    }
}

// Scroll to bottom on page load
document.addEventListener('DOMContentLoaded', scrollToBottom);

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
            scrollToBottom();
        }
    })
    .catch(error => console.log('Error refreshing messages:', error));
}, 30000);
@endif
</script>
@endpush
@endsection