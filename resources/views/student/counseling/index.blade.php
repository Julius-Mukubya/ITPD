@extends('layouts.student')

@section('title', 'Counseling - Student')
@section('page-title', 'Counseling Sessions')

@section('content')
<!-- PageHeading -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-2xl sm:text-3xl font-bold tracking-tight">Counseling Support</p>
        <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">Professional guidance when you need it most</p>
    </div>
    <div class="flex flex-col sm:flex-row gap-3">
        <a href="{{ route('public.counseling.sessions') }}" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-semibold px-6 py-3 rounded-xl flex items-center justify-center gap-2 hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-200 w-full sm:w-auto">
            <span class="material-symbols-outlined text-lg">add</span>
            Request Session
        </a>
    </div>
</div>

<!-- Info Banner -->
<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 mb-8 shadow-sm">
    <div class="flex gap-3">
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-2">
            <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">info</span>
        </div>
        <div class="flex-1">
            <h3 class="font-semibold text-gray-900 dark:text-white mb-1">Confidential Support Available</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Our trained counselors provide confidential support for academic, personal, and mental health concerns. For emergencies, <button onclick="document.getElementById('emergencyModal').classList.remove('hidden')" class="text-red-600 dark:text-red-400 underline font-medium">click here for crisis support</button>.</p>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
    <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-orange-100 text-sm font-medium">Pending Requests</p>
                <p class="text-3xl font-bold">{{ $pendingSessions ?? 0 }}</p>
                <div class="flex items-center mt-2">
                    <span class="material-symbols-outlined text-sm mr-1">pending</span>
                    <span class="text-sm">Awaiting response</span>
                </div>
            </div>
            <div class="bg-white/20 rounded-lg p-3">
                <span class="material-symbols-outlined text-2xl">pending</span>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium">Active Sessions</p>
                <p class="text-3xl font-bold">{{ $activeSessions ?? 0 }}</p>
                <div class="flex items-center mt-2">
                    <span class="material-symbols-outlined text-sm mr-1">psychology</span>
                    <span class="text-sm">In progress</span>
                </div>
            </div>
            <div class="bg-white/20 rounded-lg p-3">
                <span class="material-symbols-outlined text-2xl">psychology</span>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Completed</p>
                <p class="text-3xl font-bold">{{ $completedSessions ?? 0 }}</p>
                <div class="flex items-center mt-2">
                    <span class="material-symbols-outlined text-sm mr-1">check_circle</span>
                    <span class="text-sm">Total completed</span>
                </div>
            </div>
            <div class="bg-white/20 rounded-lg p-3">
                <span class="material-symbols-outlined text-2xl">check_circle</span>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Stats -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">New Session</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">Request</p>
            </div>
            <a href="{{ route('public.counseling.sessions') }}" class="text-primary hover:text-primary/80">
                <span class="material-symbols-outlined">add_circle</span>
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">Schedule</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">View</p>
            </div>
            <span class="material-symbols-outlined text-blue-500">schedule</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">Resources</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">Browse</p>
            </div>
            <span class="material-symbols-outlined text-purple-500">library_books</span>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-600 dark:text-gray-400 text-xs font-medium">Crisis</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">Support</p>
            </div>
            <button onclick="document.getElementById('emergencyModal').classList.remove('hidden')" class="text-red-500 hover:text-red-600">
                <span class="material-symbols-outlined">emergency</span>
            </button>
        </div>
    </div>
</div>

<!-- Sessions List -->
@if(isset($sessions) && $sessions->count() > 0)
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg overflow-hidden">
    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
            <span class="material-symbols-outlined text-emerald-600">history</span>
            Your Sessions
        </h2>
    </div>
    <div class="divide-y divide-gray-200 dark:divide-gray-700">
        @foreach($sessions as $session)
        <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
            <!-- Check if this is a group session invitation that needs response -->
            @php
                $isGroupParticipant = false;
                $participantStatus = null;
                if ($session->session_type === 'group' && $session->student_id !== auth()->id()) {
                    $participant = $session->participants->where('email', auth()->user()->email)->first();
                    if ($participant) {
                        $isGroupParticipant = true;
                        $participantStatus = $participant->status;
                    }
                }
            @endphp
            
            @if($isGroupParticipant && $participantStatus === 'invited')
            <!-- Group Session Invitation -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white">
                        <span class="material-symbols-outlined text-lg">group</span>
                    </div>
                    <div>
                        <h4 class="font-semibold text-blue-900 dark:text-blue-100">Group Session Invitation</h4>
                        <p class="text-sm text-blue-700 dark:text-blue-300">You've been invited to join a group counseling session</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <form method="POST" action="{{ route('student.counseling.accept-invitation', $session) }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 text-sm font-medium flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">check</span>
                            Accept Invitation
                        </button>
                    </form>
                    <form method="POST" action="{{ route('student.counseling.decline-invitation', $session) }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 text-sm font-medium flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">close</span>
                            Decline
                        </button>
                    </form>
                </div>
            </div>
            @endif
            
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br 
                        @if($session->status === 'pending') from-amber-500 to-orange-600
                        @elseif($session->status === 'active') from-emerald-500 to-teal-600
                        @else from-blue-500 to-indigo-600
                        @endif
                        flex items-center justify-center text-white font-bold shadow-lg">
                        <span class="material-symbols-outlined">
                            @if($session->status === 'pending') pending
                            @elseif($session->status === 'active') psychology
                            @else check_circle
                            @endif
                        </span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">
                            {{ ucfirst(str_replace('_', ' ', $session->session_type)) }}
                            @if($isGroupParticipant)
                                <span class="text-sm text-blue-600 dark:text-blue-400">(Group Participant)</span>
                            @endif
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ $session->created_at->format('M d, Y') }}</p>
                        @if($session->counselor)
                            <p class="text-xs text-gray-500 dark:text-gray-500">Counselor: {{ $session->counselor->name }}</p>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @if($isGroupParticipant)
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            @if($participantStatus === 'invited') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300
                            @elseif($participantStatus === 'joined') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300
                            @else bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-300
                            @endif">
                            {{ ucfirst($participantStatus) }}
                        </span>
                    @endif
                    
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        @if($session->status === 'pending') bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300
                        @elseif($session->status === 'active') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300
                        @else bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300
                        @endif">
                        {{ ucfirst($session->status) }}
                    </span>
                    
                    @if($session->status === 'active' && (!$isGroupParticipant || $participantStatus === 'joined'))
                    <a href="{{ route('student.counseling.show', $session) }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:opacity-90 text-sm font-medium">
                        Continue
                    </a>
                    @elseif($session->status === 'pending' && !$isGroupParticipant)
                    <a href="{{ route('student.counseling.show', $session) }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:opacity-90 text-sm font-medium">
                        View
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@else
<!-- Empty State -->
<div class="bg-gradient-to-br from-white to-gray-50/30 dark:from-gray-800 dark:to-gray-950/20 rounded-2xl border border-gray-200 dark:border-gray-700 p-12 text-center shadow-lg">
    <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-br from-emerald-100 to-teal-100 dark:from-emerald-900/30 dark:to-teal-900/30 flex items-center justify-center">
        <span class="material-symbols-outlined text-5xl text-emerald-600 dark:text-emerald-400">support_agent</span>
    </div>
    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Ready to Start Your Journey?</h3>
    <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
        You haven't requested any counseling sessions yet. Our professional counselors are here to support you through any challenges you're facing.
    </p>
    <div class="flex flex-col sm:flex-row gap-3 justify-center">
        <a href="{{ route('public.counseling.sessions') }}" class="bg-primary text-white px-8 py-3 rounded-xl font-semibold hover:opacity-90 transition-all flex items-center gap-2 shadow-lg">
            <span class="material-symbols-outlined">add</span>
            Request Your First Session
        </a>
        <button onclick="document.getElementById('infoModal').classList.remove('hidden')" class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-8 py-3 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined">info</span>
            Learn More
        </button>
    </div>
</div>
@endif

<!-- Emergency Support Modal -->
@include('components.crisis-support-modal')

<!-- Info Modal -->
<div id="infoModal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 max-w-2xl w-full shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-3xl text-emerald-600 dark:text-emerald-400">psychology</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">About Counseling Services</h3>
        </div>
        
        <div class="space-y-6 text-left">
            <div>
                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">What We Offer</h4>
                <ul class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                    <li>• Individual counseling sessions</li>
                    <li>• Group therapy sessions</li>
                    <li>• Crisis intervention support</li>
                    <li>• Academic counseling and guidance</li>
                    <li>• Mental health assessments</li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Confidentiality</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    All counseling sessions are completely confidential. Information is only shared with your explicit consent or in cases where there's immediate danger.
                </p>
            </div>
            
            <div>
                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">How It Works</h4>
                <ol class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                    <li>1. Submit a counseling request</li>
                    <li>2. A counselor reviews your request within 24-48 hours</li>
                    <li>3. You'll be contacted to schedule your session</li>
                    <li>4. Attend your session via video call or in-person</li>
                </ol>
            </div>
        </div>
        
        <div class="flex gap-3 mt-8">
            <a href="{{ route('public.counseling.sessions') }}" class="flex-1 bg-primary text-white px-4 py-3 rounded-xl font-semibold hover:opacity-90 transition-all text-center">
                Get Started
            </a>
            <button onclick="document.getElementById('infoModal').classList.add('hidden')" class="px-6 py-3 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-300 dark:hover:bg-gray-600 transition-all">
                Close
            </button>
        </div>
    </div>
</div>
@endsection
