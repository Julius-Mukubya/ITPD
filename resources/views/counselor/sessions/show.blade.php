@extends('layouts.counselor')

@section('title', 'Session Details - Counselor')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Session with {{ $session->student->name }}</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ ucfirst($session->session_type) }} • {{ ucfirst($session->status) }} • {{ $session->created_at->format('M d, Y') }}</p>
    </div>
    <a href="{{ route('counselor.sessions.index') }}" class="inline-flex items-center gap-2 bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
        <span class="material-symbols-outlined text-sm">arrow_back</span>
        Back to Sessions
    </a>
</div>

@if($session->status === 'pending')
<!-- Pending Session Alert -->
<div class="bg-gradient-to-br from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 border-2 border-yellow-200 dark:border-yellow-800 rounded-2xl p-6 mb-6">
    <div class="flex items-start gap-4">
        <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
            <span class="material-symbols-outlined text-2xl text-yellow-600 dark:text-yellow-400">pending_actions</span>
        </div>
        <div class="flex-1">
            <h3 class="text-lg font-bold text-yellow-900 dark:text-yellow-100 mb-2">New Session Request</h3>
            <p class="text-yellow-800 dark:text-yellow-200 mb-4">
                Please review the session details below. If you can accommodate this request, click "Accept Session" to begin working with the student.
            </p>
            <div class="flex items-center gap-4 text-sm">
                <div class="flex items-center gap-2 text-yellow-700 dark:text-yellow-300">
                    <span class="material-symbols-outlined text-sm">schedule</span>
                    <span>Requested {{ $session->created_at->diffForHumans() }}</span>
                </div>
                <div class="flex items-center gap-2 text-yellow-700 dark:text-yellow-300">
                    <span class="material-symbols-outlined text-sm">flag</span>
                    <span>{{ ucfirst($session->priority) }} Priority</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Session Info and Messages Row -->
<div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-4">
    <!-- Session Info Sidebar -->
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 flex flex-col" style="height: calc(100vh - 12rem);">
            <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">info</span>
                Session Info
            </h3>
            
            <div class="space-y-3 flex-1 overflow-y-auto">
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">Student</p>
                    <p class="font-medium text-sm text-gray-900 dark:text-white">{{ $session->student->name }}</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ $session->student->email }}</p>
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

                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-0.5">Requested</p>
                    <p class="text-xs text-gray-900 dark:text-white">{{ $session->created_at->diffForHumans() }}</p>
                </div>

                <!-- Student's Request -->
                <div class="mt-4 pt-3 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Student's Request</p>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-2">
                        <p class="text-xs text-gray-700 dark:text-gray-300 leading-relaxed">{{ $session->description }}</p>
                    </div>
                </div>
            </div>

            @if($session->status === 'pending')
            <form action="{{ route('counselor.sessions.accept', $session) }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="w-full bg-primary text-white px-4 py-2.5 rounded-lg hover:bg-primary/90 font-semibold transition-all flex items-center justify-center gap-2 text-sm">
                    <span class="material-symbols-outlined text-lg">check_circle</span>
                    Accept
                </button>
            </form>
            @elseif($session->status === 'active')
            <button onclick="document.getElementById('completeModal').classList.remove('hidden')" 
                class="w-full mt-4 bg-green-600 text-white px-4 py-2.5 rounded-lg hover:bg-green-700 text-sm font-semibold">
                Complete Session
            </button>
            @endif
        </div>

        @if($session->is_anonymous)
        <div class="bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 border border-purple-200 dark:border-purple-800 rounded-xl p-3 mt-4">
            <div class="flex items-center gap-2 mb-1">
                <span class="material-symbols-outlined text-sm text-purple-600 dark:text-purple-400">visibility_off</span>
                <h3 class="text-sm font-semibold text-purple-900 dark:text-purple-100">Anonymous</h3>
            </div>
            <p class="text-xs text-purple-700 dark:text-purple-300">Student requested anonymity.</p>
        </div>
        @endif
    </div>

    <!-- Chat Area -->
    <div class="lg:col-span-3">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col" style="height: calc(100vh - 12rem);">
            <div class="p-3 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900/50 dark:to-gray-800/50">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">chat</span>
                        Messages
                    </h3>
                    <button onclick="maximizeChat()" 
                            class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-all flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-sm">fullscreen</span>
                        Maximize
                    </button>
                </div>
            </div>

            <div id="chat-messages" class="flex-1 overflow-y-auto p-3 space-y-3">
                @forelse($session->messages->sortBy('created_at') as $message)
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
                                Accept this session to start communicating.
                            @else
                                Start the conversation below.
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
                    <p class="text-xs font-medium">Accept this session to start messaging.</p>
                </div>
            </div>
            @elseif($session->status === 'active')
            <div class="p-3 border-t border-gray-200 dark:border-gray-700">
                <form action="{{ route('counselor.sessions.message', $session) }}" method="POST" enctype="multipart/form-data">
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

{{-- Video Meeting Link Section - Below Messages --}}
@if($session->status === 'active')
<div class="mt-4 grid grid-cols-1 lg:grid-cols-2 gap-4">
    <!-- Contact Information Section -->
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-t-2xl">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-green-600">contact_phone</span>
                    My Contact Info
                </h3>
                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Enter your contact details to share with the student</p>
            </div>
            
            <div class="p-4 space-y-4">
                <!-- Phone Number -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-blue-600 text-sm">phone</span>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</span>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <input type="text" id="counselor-phone" placeholder="Enter your phone number..." 
                               value="{{ auth()->user()->phone ?? '' }}"
                               class="flex-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded px-2 py-1 text-sm">
                        <button onclick="saveContactField('phone')" 
                                class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs">
                            Save
                        </button>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="copyContactField('counselor-phone', 'Phone number')" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs">
                            Copy
                        </button>
                        <button onclick="shareContactField('phone', 'counselor-phone')" 
                                class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs">share</span>
                            Share in Chat
                        </button>
                    </div>
                </div>
                
                <!-- WhatsApp -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-green-600 text-sm">chat</span>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">WhatsApp</span>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <input type="text" id="counselor-whatsapp" placeholder="Enter your WhatsApp number..." 
                               value="{{ auth()->user()->whatsapp_number ?? auth()->user()->phone ?? '' }}"
                               class="flex-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded px-2 py-1 text-sm">
                        <button onclick="saveContactField('whatsapp')" 
                                class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs">
                            Save
                        </button>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="copyContactField('counselor-whatsapp', 'WhatsApp number')" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs">
                            Copy
                        </button>
                        <button onclick="shareContactField('whatsapp', 'counselor-whatsapp')" 
                                class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs">share</span>
                            Share in Chat
                        </button>
                    </div>
                </div>
                
                <!-- Email -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-blue-600 text-sm">email</span>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Email</span>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <input type="email" id="counselor-email" placeholder="Enter your email address..." 
                               value="{{ auth()->user()->counselor_email ?? auth()->user()->email ?? '' }}"
                               class="flex-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded px-2 py-1 text-sm">
                        <button onclick="saveContactField('email')" 
                                class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs">
                            Save
                        </button>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="copyContactField('counselor-email', 'Email address')" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs">
                            Copy
                        </button>
                        <button onclick="shareContactField('email', 'counselor-email')" 
                                class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs flex items-center gap-1">
                            <span class="material-symbols-outlined text-xs">share</span>
                            Share in Chat
                        </button>
                    </div>
                </div>

                <!-- Custom Contact Information -->
                @if(auth()->user()->custom_contact_info)
                    @foreach(auth()->user()->custom_contact_info as $key => $contact)
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="material-symbols-outlined text-purple-600 text-sm">{{ $contact['icon'] ?? 'contact_page' }}</span>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ $contact['label'] }}</span>
                        </div>
                        <div class="flex items-center gap-2 mb-2">
                            <input type="text" id="custom-{{ $key }}" 
                                   value="{{ $contact['value'] }}"
                                   class="flex-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded px-2 py-1 text-sm">
                            <button onclick="saveCustomContactField('{{ $key }}')" 
                                    class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs">
                                Save
                            </button>
                        </div>
                        <div class="flex items-center gap-2">
                            <button onclick="copyContactField('custom-{{ $key }}', '{{ $contact['label'] }}')" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-xs">
                                Copy
                            </button>
                            <button onclick="shareCustomContactField('{{ $key }}', '{{ $contact['label'] }}', '{{ $contact['value'] }}')" 
                                    class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">share</span>
                                Share in Chat
                            </button>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    
    <!-- Video Meeting Link Section -->
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-t-2xl">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-600">videocam</span>
                    Video Meeting
                </h3>
                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Set up and share video meeting details</p>
            </div>

            <div class="p-4 space-y-4">
                <!-- Multiple Meeting Links -->
                <div id="meeting-links-container">
                    @if($session->meeting_link)
                        @php
                            // Try to parse multiple links if they exist (separated by newlines)
                            $meetingLinks = explode("\n", trim($session->meeting_link));
                            $meetingLinks = array_filter(array_map('trim', $meetingLinks));
                        @endphp
                        
                        @foreach($meetingLinks as $index => $link)
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 meeting-link-item">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="material-symbols-outlined text-green-600">check_circle</span>
                                <h4 class="font-semibold text-green-800 dark:text-green-200">Meeting Link {{ $index + 1 }}</h4>
                                <button onclick="removeMeetingLink(this)" class="ml-auto text-red-500 hover:text-red-700">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            </div>
                            
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meeting Link</label>
                                    <div class="flex items-center gap-2">
                                        <input type="text" readonly value="{{ $link }}" 
                                               class="flex-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-sm text-gray-900 dark:text-white">
                                        <button onclick="copyMeetingLink('{{ $link }}')" 
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-all">
                                            Copy
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="flex gap-2">
                                    <button onclick="shareMeetingLinkInChat('{{ $link }}', '{{ $session->preferred_method }}')" 
                                            class="flex-1 bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition-all flex items-center justify-center gap-2">
                                        <span class="material-symbols-outlined text-sm">share</span>
                                        Share in Chat
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="material-symbols-outlined text-blue-600">videocam</span>
                                <h4 class="font-semibold text-blue-800 dark:text-blue-200">Set Up Video Meeting</h4>
                            </div>
                            <p class="text-blue-700 dark:text-blue-300 text-sm mb-4">
                                Create meeting links in your preferred platforms and share them with the student.
                            </p>
                        </div>
                    @endif
                </div>
                
                <!-- Add New Meeting Link Button -->
                <button onclick="openMeetingLinkModal()" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-semibold transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">add</span>
                    Add Meeting Link
                </button>
                
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3">
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-sm text-gray-600 dark:text-gray-400 mt-0.5">info</span>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <p class="font-medium mb-1">Supported Platforms:</p>
                            <ul class="text-xs space-y-1">
                                <li>• Zoom: Create meeting in your Zoom account</li>
                                <li>• Google Meet: Create meeting in Google Calendar</li>
                                <li>• Microsoft Teams: Create meeting in Teams</li>
                                <li>• Any other video platform link</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Notes Section - Full Width -->
@if($session->status !== 'pending')
<div class="mt-4 px-4 py-4 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-sm text-primary">note_alt</span>
                Notes
            </h3>
            <button onclick="document.getElementById('addNoteModal').classList.remove('hidden')" 
                class="text-primary hover:text-primary/80 transition-colors">
                <span class="material-symbols-outlined text-sm">add_circle</span>
            </button>
        </div>

        <div class="space-y-2 max-h-80 overflow-y-auto">
            @forelse($session->notes as $note)
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 border border-gray-200 dark:border-gray-600">
                <div class="flex items-start justify-between mb-2">
                    <div class="flex-1">
                        @if($note->title)
                        <h4 class="font-semibold text-gray-900 dark:text-white text-sm">{{ $note->title }}</h4>
                        @endif
                        <div class="flex items-center gap-2 mt-1">
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full
                                @if($note->type === 'progress') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300
                                @elseif($note->type === 'observation') bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300
                                @elseif($note->type === 'reminder') bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300
                                @else bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-300
                                @endif">
                                {{ ucfirst($note->type) }}
                            </span>
                            @if($note->is_private)
                            <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">lock</span>
                                Private
                            </span>
                            @endif
                        </div>
                    </div>
                    <form action="{{ route('counselor.sessions.notes.delete', [$session, $note->id]) }}" method="POST" 
                        onsubmit="return confirm('Delete this note?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-gray-400 hover:text-red-600 dark:hover:text-red-400">
                            <span class="material-symbols-outlined text-sm">delete</span>
                        </button>
                    </form>
                </div>
                <p class="text-xs text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $note->content }}</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    {{ $note->created_at->format('M d, h:i A') }}
                </p>
            </div>
            @empty
            <div class="text-center py-6">
                <span class="material-symbols-outlined text-3xl text-gray-300 dark:text-gray-600 mb-2">note</span>
                <p class="text-xs text-gray-500 dark:text-gray-400">No notes yet</p>
                <button onclick="document.getElementById('addNoteModal').classList.remove('hidden')" 
                    class="text-primary hover:underline text-xs mt-1">
                    Add note
                </button>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endif

<!-- Meeting Link Modal -->
<div id="meetingLinkModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Add Meeting Link</h3>
        
        <form action="{{ route('counselor.sessions.update-meeting-link', $session) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <!-- Method Selection -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Select Communication Method</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="contact_method" value="zoom" class="sr-only peer" {{ ($session->preferred_method === 'zoom') ? 'checked' : '' }}>
                            <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg p-3 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-blue-600">videocam</span>
                                    <span class="font-medium text-gray-900 dark:text-white">Zoom</span>
                                </div>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" name="contact_method" value="google_meet" class="sr-only peer" {{ ($session->preferred_method === 'google_meet') ? 'checked' : '' }}>
                            <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg p-3 peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20 transition-all">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-green-600">video_call</span>
                                    <span class="font-medium text-gray-900 dark:text-white">Google Meet</span>
                                </div>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" name="contact_method" value="whatsapp" class="sr-only peer" {{ ($session->preferred_method === 'whatsapp') ? 'checked' : '' }}>
                            <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg p-3 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20 transition-all">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-emerald-600">chat</span>
                                    <span class="font-medium text-gray-900 dark:text-white">WhatsApp</span>
                                </div>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" name="contact_method" value="phone_call" class="sr-only peer" {{ ($session->preferred_method === 'phone_call') ? 'checked' : '' }}>
                            <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg p-3 peer-checked:border-purple-500 peer-checked:bg-purple-50 dark:peer-checked:bg-purple-900/20 transition-all">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-purple-600">call</span>
                                    <span class="font-medium text-gray-900 dark:text-white">Phone Call</span>
                                </div>
                            </div>
                        </label>

                        <label class="relative cursor-pointer md:col-span-2">
                            <input type="radio" name="contact_method" value="physical" class="sr-only peer" {{ ($session->preferred_method === 'physical') ? 'checked' : '' }}>
                            <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-lg p-3 peer-checked:border-orange-500 peer-checked:bg-orange-50 dark:peer-checked:bg-orange-900/20 transition-all">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-orange-600">location_on</span>
                                    <span class="font-medium text-gray-900 dark:text-white">Physical (In-Person)</span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Contact Details Input -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Meeting Link / Contact Details
                    </label>
                    <input type="text" name="meeting_link" required
                        placeholder="Enter meeting link, phone number, WhatsApp link, or physical address..."
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Examples: https://zoom.us/j/123456, +1234567890, https://wa.me/1234567890, Building A Room 101
                    </p>
                </div>
                
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-3">
                    <p class="text-xs text-blue-700 dark:text-blue-300 flex items-start gap-2">
                        <span class="material-symbols-outlined text-sm mt-0.5">info</span>
                        <span>This will be added to your meeting links. You can share it with the student manually using the "Share in Chat" button.</span>
                    </p>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold">
                    Add Meeting Link
                </button>
                <button type="button" onclick="document.getElementById('meetingLinkModal').classList.add('hidden')" 
                    class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:opacity-90">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Complete Session Modal -->
<div id="completeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 max-w-2xl w-full mx-4">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Complete Session</h3>
        
        <form action="{{ route('counselor.sessions.complete', $session) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Outcome Notes *</label>
                    <textarea name="outcome_notes" rows="4" required 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Private Notes (Optional)</label>
                    <textarea name="counselor_notes" rows="3" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white"></textarea>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                    Complete Session
                </button>
                <button type="button" onclick="document.getElementById('completeModal').classList.add('hidden')" 
                    class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg hover:opacity-90">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Complete Session Modal -->
<div id="completeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 max-w-2xl w-full mx-4">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Complete Session</h3>
        
        <form action="{{ route('counselor.sessions.complete', $session) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Outcome Notes *</label>
                    <textarea name="outcome_notes" rows="4" required 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Private Notes (Optional)</label>
                    <textarea name="counselor_notes" rows="3" 
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white"></textarea>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                    Complete Session
                </button>
                <button type="button" onclick="document.getElementById('completeModal').classList.add('hidden')" 
                    class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg hover:opacity-90">
                    Cancel
                </button>
            </div>
        </form>
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

// Linkify on page load
document.addEventListener('DOMContentLoaded', linkifyAllMessages);

// Meeting link functions
function openMeetingLinkModal() {
    document.getElementById('meetingLinkModal').classList.remove('hidden');
}

function removeMeetingLink(button) {
    const linkItem = button.closest('.meeting-link-item');
    const linkValue = linkItem.querySelector('input[readonly]').value;
    
    // Send AJAX request to remove the link
    fetch('{{ route("counselor.sessions.remove-meeting-link", $session) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'link_to_remove': linkValue
        })
    })
    .then(response => {
        if (response.ok) {
            // Remove the link item from the DOM
            linkItem.remove();
            
            // Check if there are no more links
            const container = document.getElementById('meeting-links-container');
            const remainingLinks = container.querySelectorAll('.meeting-link-item');
            
            if (remainingLinks.length === 0) {
                // Add the "Set Up Video Meeting" placeholder
                container.innerHTML = `
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="material-symbols-outlined text-blue-600">videocam</span>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-200">Set Up Video Meeting</h4>
                        </div>
                        <p class="text-blue-700 dark:text-blue-300 text-sm mb-4">
                            Create meeting links in your preferred platforms and share them with the student.
                        </p>
                    </div>
                `;
            }
            
            showContactNotification('Meeting link removed successfully!', 'success');
        } else {
            throw new Error('Failed to remove meeting link');
        }
    })
    .catch(error => {
        console.error('Error removing meeting link:', error);
        showContactNotification('Failed to remove meeting link.', 'error');
    });
}

// Copy meeting link (for non-Jitsi meetings)
function copyMeetingLink(link) {
    // Create temporary input to copy text
    const tempInput = document.createElement('input');
    tempInput.value = link;
    document.body.appendChild(tempInput);
    tempInput.select();
    tempInput.setSelectionRange(0, 99999);
    
    try {
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        
        // Show temporary success feedback
        const button = event.target.closest('button');
        const originalHTML = button.innerHTML;
        button.innerHTML = '<span class="material-symbols-outlined text-sm">check</span> Copied!';
        button.classList.add('bg-green-600');
        button.classList.remove('bg-blue-600');
        
        setTimeout(() => {
            button.innerHTML = originalHTML;
            button.classList.remove('bg-green-600');
            button.classList.add('bg-blue-600');
        }, 2000);
    } catch (err) {
        document.body.removeChild(tempInput);
        console.error('Failed to copy: ', err);
        alert('Failed to copy link. Please copy manually: ' + link);
    }
}

// Share meeting link in chat (for non-Jitsi meetings)
function shareMeetingLinkInChat(meetingLink, provider) {
    const button = event.target.closest('button');
    const originalHTML = button.innerHTML;
    button.innerHTML = '<span class="material-symbols-outlined animate-spin text-sm">refresh</span> Sharing...';
    button.disabled = true;
    
    // Determine provider name
    const providerNames = {
        'zoom': 'Zoom',
        'google_meet': 'Google Meet'
    };
    const providerName = providerNames[provider] || 'Video Call';
    
    // Create share message
    const shareMessage = `🎥 ${providerName} Video Call Ready!

Join our video session using the link below:

🔗 ${meetingLink}

Click the link to join the meeting. Looking forward to our session!`;
    
    // Send message via AJAX
    fetch('{{ route("counselor.sessions.message", $session) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'message': shareMessage
        })
    })
    .then(response => {
        if (response.ok) {
            alert('Meeting link shared in chat!');
            
            // Reload page to show the new message
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            throw new Error('Failed to send message');
        }
    })
    .catch(error => {
        console.error('Error sharing meeting link:', error);
        alert('Failed to share meeting link in chat. You can copy and paste it manually.');
    })
    .finally(() => {
        // Reset button
        button.innerHTML = originalHTML;
        button.disabled = false;
    });
}

// Contact information functions
function copyToClipboard(text, type) {
    // Create temporary input to copy text
    const tempInput = document.createElement('input');
    tempInput.value = text;
    document.body.appendChild(tempInput);
    tempInput.select();
    tempInput.setSelectionRange(0, 99999);
    
    try {
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        
        // Show temporary success feedback
        const button = event.target;
        const originalText = button.textContent;
        button.textContent = 'Copied!';
        button.classList.add('bg-green-600');
        button.classList.remove('bg-blue-600');
        
        setTimeout(() => {
            button.textContent = originalText;
            button.classList.remove('bg-green-600');
            button.classList.add('bg-blue-600');
        }, 2000);
        
        // Show notification
        showContactNotification(`${type} copied to clipboard!`, 'success');
    } catch (err) {
        document.body.removeChild(tempInput);
        console.error('Failed to copy: ', err);
        alert(`Failed to copy ${type.toLowerCase()}. Please copy manually: ${text}`);
    }
}

// Contact notification function
function showContactNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 translate-x-full ${
        type === 'success' ? 'bg-green-500 text-white' : 
        type === 'error' ? 'bg-red-500 text-white' : 
        'bg-blue-500 text-white'
    }`;
    
    notification.innerHTML = `
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">
                ${type === 'success' ? 'check_circle' : type === 'error' ? 'error' : 'info'}
            </span>
            <span class="text-sm font-medium">${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // Auto remove after 4 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 4000);
}

// Save contact field function
function saveContactField(type) {
    const button = event.target;
    const originalHTML = button.innerHTML;
    button.innerHTML = '<span class="material-symbols-outlined animate-spin text-xs">refresh</span>';
    button.disabled = true;
    
    // Get the input field value based on type
    let inputId = '';
    let value = '';
    
    // Find the correct input field (there are multiple sections)
    const inputFields = document.querySelectorAll(`#counselor-${type}, #counselor-${type}-2, #counselor-${type}-3`);
    for (let field of inputFields) {
        if (field.closest('.bg-gray-50').contains(button)) {
            value = field.value.trim();
            inputId = field.id;
            break;
        }
    }
    
    if (!value) {
        showContactNotification(`Please enter your ${type} information.`, 'error');
        button.innerHTML = originalHTML;
        button.disabled = false;
        return;
    }
    
    // Save to database instead of localStorage
    fetch('{{ route("counselor.contact-setup.update-field") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            field: type === 'phone' ? 'phone' : type === 'whatsapp' ? 'whatsapp_number' : 'counselor_email',
            value: value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update all matching fields
            inputFields.forEach(field => {
                field.value = value;
            });
            
            showContactNotification(`${type.charAt(0).toUpperCase() + type.slice(1)} saved successfully!`, 'success');
        } else {
            showContactNotification(data.message || 'Failed to save.', 'error');
        }
    })
    .catch(error => {
        console.error('Error saving contact field:', error);
        showContactNotification('Failed to save. Please try again.', 'error');
    })
    .finally(() => {
        // Reset button
        button.innerHTML = originalHTML;
        button.disabled = false;
    });
}

// Save custom contact field function
function saveCustomContactField(key) {
    const button = event.target;
    const originalHTML = button.innerHTML;
    button.innerHTML = '<span class="material-symbols-outlined animate-spin text-xs">refresh</span>';
    button.disabled = true;
    
    const field = document.getElementById(`custom-${key}`);
    const value = field.value.trim();
    
    if (!value) {
        showContactNotification('Please enter a value for this contact field.', 'error');
        button.innerHTML = originalHTML;
        button.disabled = false;
        return;
    }
    
    // Update custom contact in database
    fetch('{{ route("counselor.contact-setup.update-custom") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            key: key,
            value: value
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showContactNotification('Custom contact updated successfully!', 'success');
        } else {
            showContactNotification(data.message || 'Failed to save.', 'error');
        }
    })
    .catch(error => {
        console.error('Error saving custom contact field:', error);
        showContactNotification('Failed to save. Please try again.', 'error');
    })
    .finally(() => {
        // Reset button
        button.innerHTML = originalHTML;
        button.disabled = false;
    });
}

// Copy contact field function
function copyContactField(fieldId, type) {
    const field = document.getElementById(fieldId);
    const value = field.value.trim();
    
    if (!value) {
        showContactNotification(`No ${type.toLowerCase()} to copy.`, 'error');
        return;
    }
    
    // Create temporary input to copy text
    const tempInput = document.createElement('input');
    tempInput.value = value;
    document.body.appendChild(tempInput);
    tempInput.select();
    tempInput.setSelectionRange(0, 99999);
    
    try {
        document.execCommand('copy');
        document.body.removeChild(tempInput);
        
        // Show temporary success feedback
        const button = event.target;
        const originalText = button.textContent;
        button.textContent = 'Copied!';
        button.classList.add('bg-green-600');
        button.classList.remove('bg-blue-600');
        
        setTimeout(() => {
            button.textContent = originalText;
            button.classList.remove('bg-green-600');
            button.classList.add('bg-blue-600');
        }, 2000);
        
        showContactNotification(`${type} copied to clipboard!`, 'success');
    } catch (err) {
        document.body.removeChild(tempInput);
        console.error('Failed to copy: ', err);
        alert(`Failed to copy ${type.toLowerCase()}. Please copy manually: ${value}`);
    }
}

// Share contact field function
function shareContactField(type, fieldId) {
    const field = document.getElementById(fieldId);
    const value = field.value.trim();
    
    if (!value) {
        showContactNotification(`Please enter your ${type} information first.`, 'error');
        return;
    }
    
    const button = event.target;
    const originalHTML = button.innerHTML;
    button.innerHTML = '<span class="material-symbols-outlined animate-spin text-xs">refresh</span>';
    button.disabled = true;
    
    // Create share message based on type
    let shareMessage = '';
    let contactLabel = '';
    
    switch(type) {
        case 'phone':
            contactLabel = 'Phone Number';
            shareMessage = `📞 Counselor Contact Information

Phone Number: ${value}

You can reach me at this number for session coordination or any questions you may have.`;
            break;
        case 'whatsapp':
            contactLabel = 'WhatsApp';
            shareMessage = `💬 Counselor WhatsApp Contact

WhatsApp: ${value}
Direct Link: https://wa.me/${value.replace(/[^0-9]/g, '')}

You can message me on WhatsApp using this number for quick communication.`;
            break;
        case 'email':
            contactLabel = 'Email Address';
            shareMessage = `📧 Counselor Email Contact

Email: ${value}

You can reach me via email for session coordination, questions, or follow-up communication.`;
            break;
    }
    
    // Send message via AJAX
    fetch('{{ route("counselor.sessions.message", $session) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'message': shareMessage
        })
    })
    .then(response => {
        if (response.ok) {
            showContactNotification(`${contactLabel} shared in chat successfully!`, 'success');
            
            // Reload page to show the new message
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            throw new Error('Failed to send message');
        }
    })
    .catch(error => {
        console.error('Error sharing contact info:', error);
        showContactNotification(`Failed to share ${contactLabel.toLowerCase()}.`, 'error');
    })
    .finally(() => {
        // Reset button
        button.innerHTML = originalHTML;
        button.disabled = false;
    });
}

// Share custom contact field function
function shareCustomContactField(key, label, value) {
    const button = event.target;
    const originalHTML = button.innerHTML;
    button.innerHTML = '<span class="material-symbols-outlined animate-spin text-xs">refresh</span>';
    button.disabled = true;
    
    // Create share message for custom contact
    const shareMessage = `📋 Counselor Contact Information

${label}: ${value}

You can reach me using this contact method for session coordination or any questions you may have.`;
    
    // Send message via AJAX
    fetch('{{ route("counselor.sessions.message", $session) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'message': shareMessage
        })
    })
    .then(response => {
        if (response.ok) {
            showContactNotification(`${label} shared in chat successfully!`, 'success');
            
            // Reload page to show the new message
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            throw new Error('Failed to send message');
        }
    })
    .catch(error => {
        console.error('Error sharing custom contact info:', error);
        showContactNotification(`Failed to share ${label.toLowerCase()}.`, 'error');
    })
    .finally(() => {
        // Reset button
        button.innerHTML = originalHTML;
        button.disabled = false;
    });
}

// Load saved contact info on page load
document.addEventListener('DOMContentLoaded', function() {
    // Scroll chat to bottom on page load
    scrollChatToBottom();
});

// Chat maximize/minimize functions
function maximizeChat() {
    const modal = document.getElementById('fullscreenChatModal');
    modal.classList.remove('hidden');
    
    // Add body class to prevent scrolling and ensure full coverage
    document.body.classList.add('fullscreen-chat-active');
    
    // Scroll fullscreen chat to bottom
    setTimeout(() => {
        scrollFullscreenChatToBottom();
    }, 100);
    
    // Add escape key listener
    document.addEventListener('keydown', handleEscapeKey);
}

function minimizeChat() {
    const modal = document.getElementById('fullscreenChatModal');
    modal.classList.add('hidden');
    
    // Remove body class to restore normal scrolling
    document.body.classList.remove('fullscreen-chat-active');
    
    // Remove escape key listener
    document.removeEventListener('keydown', handleEscapeKey);
}

function handleEscapeKey(event) {
    if (event.key === 'Escape') {
        minimizeChat();
    }
}

// Scroll chat to bottom functions
function scrollChatToBottom() {
    const chatContainer = document.getElementById('chat-messages');
    if (chatContainer) {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
}

// Message form handling with AJAX
document.addEventListener('DOMContentLoaded', function() {
    // Handle both regular and fullscreen message forms
    const messageForms = document.querySelectorAll('form[action*="message"]');
    
    messageForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const messageInput = this.querySelector('input[name="message"]');
            const submitButton = this.querySelector('button[type="submit"]');
            const originalButtonContent = submitButton.innerHTML;
            
            // Check if message is not empty
            if (!messageInput.value.trim()) {
                showNotification('Please enter a message', 'error');
                return;
            }
            
            // Disable form and show loading
            messageInput.disabled = true;
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="material-symbols-outlined animate-spin">refresh</span>';
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (response.ok) {
                    // Add message to chat immediately
                    const messageText = messageInput.value.trim();
                    addMessageToChat(messageText, true); // true = sent by current user
                    
                    // Clear the message input
                    messageInput.value = '';
                    
                    // Reset button state immediately
                    messageInput.disabled = false;
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonContent;
                    
                    showNotification('Message sent successfully!', 'success');
                    
                    // Reload the page after a short delay to ensure consistency
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    return response.text().then(text => {
                        console.error('Server response:', text);
                        throw new Error(`Server error: ${response.status}`);
                    });
                }
            })
            .catch(error => {
                console.error('Error sending message:', error);
                showNotification('Failed to send message. Please try again.', 'error');
                
                // Re-enable form
                messageInput.disabled = false;
                submitButton.disabled = false;
                submitButton.innerHTML = originalButtonContent;
            });
        });
    });
});

// Function to add message to chat immediately
function addMessageToChat(messageText, isSentByCurrentUser) {
    const chatContainer = document.getElementById('chat-messages');
    const fullscreenChatContainer = document.getElementById('fullscreen-chat-messages');
    
    if (!chatContainer && !fullscreenChatContainer) return;
    
    const currentTime = new Date().toLocaleTimeString('en-US', { 
        hour: 'numeric', 
        minute: '2-digit',
        hour12: true 
    });
    
    const messageHtml = `
        <div class="flex ${isSentByCurrentUser ? 'justify-end' : 'justify-start'}">
            <div class="max-w-[75%]">
                <div class="flex items-center gap-1.5 mb-0.5 ${isSentByCurrentUser ? 'justify-end' : 'justify-start'}">
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        ${isSentByCurrentUser ? '{{ auth()->user()->name }}' : 'Student'}
                    </p>
                    <p class="text-xs text-gray-400">
                        ${currentTime}
                    </p>
                </div>
                <div class="rounded-lg p-2.5 ${isSentByCurrentUser ? 'bg-primary text-white' : 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white'}">
                    <div class="text-sm message-content" data-sender="${isSentByCurrentUser ? 'self' : 'other'}">
                        ${messageText.replace(/\n/g, '<br>')}
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Add to regular chat
    if (chatContainer) {
        chatContainer.insertAdjacentHTML('beforeend', messageHtml);
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
    
    // Add to fullscreen chat
    if (fullscreenChatContainer) {
        fullscreenChatContainer.insertAdjacentHTML('beforeend', messageHtml);
        fullscreenChatContainer.scrollTop = fullscreenChatContainer.scrollHeight;
    }
}

function scrollFullscreenChatToBottom() {
    const chatContainer = document.getElementById('fullscreen-chat-messages');
    if (chatContainer) {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
}
</script>

<style>
/* Ensure fullscreen chat modal covers entire viewport */
#fullscreenChatModal {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    margin: 0 !important;
    padding: 0 !important;
}

/* Ensure no body scroll when fullscreen is active */
body.fullscreen-chat-active {
    overflow: hidden !important;
    margin: 0 !important;
    padding: 0 !important;
}
</style>

@endpush

<!-- Add Note Modal -->
<div id="addNoteModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 max-w-lg w-full shadow-xl">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Add Session Note</h3>
            <button onclick="document.getElementById('addNoteModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>
        
        <form action="{{ route('counselor.sessions.notes.add', $session) }}" method="POST" class="space-y-3">
            @csrf
            
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Note Type *</label>
                    <select name="type" required 
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-1 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                        <option value="general">General Note</option>
                        <option value="progress">Progress Update</option>
                        <option value="observation">Clinical Observation</option>
                        <option value="reminder">Reminder/Follow-up</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Title (Optional)</label>
                    <input type="text" name="title" placeholder="Brief title..." 
                        class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-1 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                </div>
            </div>
            
            <div>
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Note Content *</label>
                <textarea name="content" rows="4" required placeholder="Write your note here..." 
                    class="w-full px-3 py-2 text-sm border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-1 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white resize-none"></textarea>
            </div>

            <div class="flex items-center gap-2 p-2 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <input type="checkbox" name="is_private" id="is_private" value="1" checked 
                    class="w-3 h-3 text-primary border-gray-300 rounded focus:ring-primary">
                <label for="is_private" class="text-xs text-gray-700 dark:text-gray-300 flex items-center gap-1">
                    <span class="material-symbols-outlined text-xs">lock</span>
                    <span>Keep private (counselors only)</span>
                </label>
            </div>
            
            <div class="flex gap-2 pt-2">
                <button type="submit" class="flex-1 bg-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-primary/90 transition-all">
                    Save Note
                </button>
                <button type="button" onclick="document.getElementById('addNoteModal').classList.add('hidden')" 
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium hover:bg-gray-300 dark:hover:bg-gray-600 transition-all">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Fullscreen Chat Modal -->
<div id="fullscreenChatModal" class="hidden fixed inset-0 bg-white dark:bg-gray-900 z-[9999] flex flex-col" style="top: 0; left: 0; right: 0; bottom: 0; margin: 0; padding: 0;">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-xl">chat</span>
                    Chat with {{ $session->student->name }}
                </h2>
                <span class="px-3 py-1 text-xs font-medium rounded-full
                    @if($session->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                    @elseif($session->status === 'active') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                    @elseif($session->status === 'completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                    @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                    @endif">
                    {{ ucfirst($session->status) }}
                </span>
            </div>
            <button onclick="minimizeChat()" 
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">fullscreen_exit</span>
                Minimize
            </button>
        </div>
    </div>

    <!-- Chat Messages -->
    <div id="fullscreen-chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50 dark:bg-gray-900">
        @forelse($session->messages->sortBy('created_at') as $message)
        <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
            <div class="max-w-[70%]">
                <div class="flex items-center gap-2 mb-1 {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $message->sender->name }}
                    </p>
                    <p class="text-sm text-gray-400">
                        {{ $message->created_at->format('h:i A') }}
                    </p>
                </div>
                <div class="rounded-xl p-4 {{ $message->sender_id === auth()->id() ? 'bg-primary text-white' : 'bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm' }}">
                    <div class="text-sm message-content" data-sender="{{ $message->sender_id === auth()->id() ? 'self' : 'other' }}">
                        {!! nl2br(e($message->message)) !!}
                    </div>
                    @if($message->attachment_path)
                    <a href="{{ asset('storage/' . $message->attachment_path) }}" target="_blank" class="text-sm underline mt-2 block">
                        View Attachment
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="flex items-center justify-center h-full">
            <div class="text-center">
                <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-4xl text-gray-400">chat</span>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No messages yet</h3>
                <p class="text-gray-500 dark:text-gray-400">
                    @if($session->status === 'pending')
                        Accept this session to start communicating.
                    @else
                        Start the conversation below.
                    @endif
                </p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Message Input -->
    @if($session->status === 'pending')
    <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-yellow-50 dark:bg-yellow-900/20">
        <div class="flex items-center gap-3 text-yellow-700 dark:text-yellow-300">
            <span class="material-symbols-outlined">info</span>
            <p class="font-medium">Accept this session to start messaging.</p>
        </div>
    </div>
    @elseif($session->status === 'active')
    <div class="p-4 border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
        <form action="{{ route('counselor.sessions.message', $session) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex gap-3">
                <input type="text" name="message" required placeholder="Type your message..." 
                    class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white text-base">
                <button type="submit" class="bg-primary text-white px-6 py-3 rounded-xl hover:bg-primary/90 transition-colors">
                    <span class="material-symbols-outlined">send</span>
                </button>
            </div>
        </form>
    </div>
    @endif
</div>

@endsection
