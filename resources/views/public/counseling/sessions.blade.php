@extends('layouts.public')

@section('title', 'My Counseling Sessions')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden h-screen">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2087&q=80" 
             alt="Counseling sessions" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>
    
    <!-- Content -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center justify-center">
        <div class="text-center">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-semibold mb-6">
                <span class="material-symbols-outlined !text-lg">psychology</span>
                My Sessions
            </div>
            <h1 class="text-4xl lg:text-6xl font-black text-white tracking-tight mb-6">Your Counseling Journey</h1>
            <p class="text-xl lg:text-2xl text-white/90 max-w-4xl mx-auto leading-relaxed mb-8">Track your sessions, connect with counselors, and continue your path to better mental health.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="openRequestModal()" class="inline-flex items-center gap-2 bg-white text-primary px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <span class="material-symbols-outlined !text-xl">add_circle</span>
                    Request New Session
                </button>
                <a href="#sessions" class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm border-2 border-white/30 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/30 transition-all duration-200 transform hover:scale-105">
                    <span class="material-symbols-outlined !text-xl">visibility</span>
                    View Sessions
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Statistics & Info Section -->
<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="space-y-8">
        <!-- Info Banner -->
        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 border-2 border-emerald-200 dark:border-emerald-800 rounded-2xl p-6 shadow-sm">
            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center">
                        <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-2xl">info</span>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Confidential Support Available</h3>
                    <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">Our trained counselors provide confidential support for academic, personal, and mental health concerns. For emergencies, <button onclick="document.getElementById('emergencyModal').classList.remove('hidden')" class="text-red-600 dark:text-red-400 underline font-semibold hover:text-red-700 dark:hover:text-red-300 transition-colors">click here for crisis support</button>.</p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600">analytics</span>
                Your Session Statistics
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Pending Requests -->
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
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $pendingSessions ?? 0 }}</p>
                        <div class="flex items-center">
                            <div class="flex items-center bg-yellow-50 dark:bg-yellow-900/20 px-2 py-1 rounded-full">
                                <span class="material-symbols-outlined text-xs mr-1 text-yellow-600">schedule</span>
                                <span class="text-xs font-medium text-yellow-600">Awaiting Response</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Sessions -->
                <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-emerald-600"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Active Sessions</p>
                        </div>
                        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined text-xl text-emerald-600 dark:text-emerald-400">psychology</span>
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

                <!-- Completed -->
                <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-teal-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-teal-500 to-teal-600"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-teal-500 rounded-full"></div>
                            <p class="text-gray-600 dark:text-gray-400 text-sm font-semibold uppercase tracking-wide">Completed</p>
                        </div>
                        <div class="bg-gradient-to-br from-teal-50 to-teal-100 dark:from-teal-900/20 dark:to-teal-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined text-xl text-teal-600 dark:text-teal-400">check_circle</span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $completedSessions ?? 0 }}</p>
                        <div class="flex items-center">
                            <div class="flex items-center bg-teal-50 dark:bg-teal-900/20 px-2 py-1 rounded-full">
                                <span class="material-symbols-outlined text-xs mr-1 text-teal-600">done_all</span>
                                <span class="text-xs font-medium text-teal-600">Finished</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600">bolt</span>
                Quick Actions
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden cursor-pointer" onclick="openRequestModal()">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-emerald-600"></div>
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                                <p class="text-gray-600 dark:text-gray-400 text-xs font-semibold uppercase tracking-wide">New Session</p>
                            </div>
                            <p class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-emerald-600 transition-colors">Request Counseling</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Get professional support</p>
                        </div>
                        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 rounded-xl p-3 group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-2xl">add_circle</span>
                        </div>
                    </div>
                </div>

                <div class="group bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg hover:shadow-red-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden cursor-pointer" onclick="document.getElementById('emergencyModal').classList.remove('hidden')">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-red-600"></div>
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                <p class="text-gray-600 dark:text-gray-400 text-xs font-semibold uppercase tracking-wide">Emergency</p>
                            </div>
                            <p class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-red-600 transition-colors">Crisis Support</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Immediate assistance</p>
                        </div>
                        <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-xl p-3 group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-2xl">emergency</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sessions List -->
<div id="sessions" class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600">history</span>
                Your Sessions
            </h2>
            
            <!-- Filter Buttons -->
            <div class="flex items-center gap-2 flex-wrap">
                <button onclick="filterSessions('all')" class="filter-btn active bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-4 py-2 rounded-xl font-semibold text-sm transition-all hover:shadow-lg hover:shadow-emerald-500/30 duration-200" data-filter="all">
                    All Sessions
                </button>
                <button onclick="filterSessions('pending')" class="filter-btn bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-xl font-medium text-sm transition-all hover:border-yellow-500 hover:text-yellow-600 hover:shadow-md" data-filter="pending">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">pending</span>
                        Pending
                    </span>
                </button>
                <button onclick="filterSessions('active')" class="filter-btn bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-xl font-medium text-sm transition-all hover:border-emerald-500 hover:text-emerald-600 hover:shadow-md" data-filter="active">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">psychology</span>
                        Active
                    </span>
                </button>
                <button onclick="filterSessions('completed')" class="filter-btn bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-xl font-medium text-sm transition-all hover:border-teal-500 hover:text-teal-600 hover:shadow-md" data-filter="completed">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">check_circle</span>
                        Completed
                    </span>
                </button>
            </div>
        </div>
        
        @if(isset($sessions) && $sessions->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($sessions as $session)
                <div class="session-item p-6 hover:bg-gradient-to-r hover:from-gray-50 hover:to-transparent dark:hover:from-gray-700/30 dark:hover:to-transparent transition-all duration-300 group" data-status="{{ $session->status }}" data-type="{{ $session->session_type }}" data-date="{{ $session->created_at->format('Y-m-d') }}">
                    @php
                        // Check if this is a group session where the user is a participant (not the primary student)
                        $isGroupParticipant = $session->session_type === 'group' && $session->student_id !== auth()->id();
                        $participantRecord = null;
                        
                        if ($isGroupParticipant) {
                            $participantRecord = $session->participants()
                                ->where('email', auth()->user()->email)
                                ->first();
                        }
                    @endphp
                    
                    @if($isGroupParticipant && $participantRecord && $participantRecord->status === 'invited')
                        <!-- Group Session Invitation -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl p-4 mb-4">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-xl">group</span>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-blue-900 dark:text-blue-100">Group Session Invitation</h4>
                                    <p class="text-sm text-blue-700 dark:text-blue-300">You've been invited to join this group counseling session</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('public.counseling.session.accept-invitation', $session) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">check</span>
                                        Accept
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('public.counseling.session.decline-invitation', $session) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">close</span>
                                        Decline
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-5">
                            <div class="relative">
                                <div class="w-16 h-16 rounded-2xl border-2 
                                    @if($session->status === 'pending') border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-900/20
                                    @elseif($session->status === 'active') border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-900/20
                                    @else border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/20
                                    @endif
                                    flex items-center justify-center shadow-sm group-hover:shadow-md group-hover:scale-105 transition-all duration-300">
                                    <span class="material-symbols-outlined text-3xl
                                        @if($session->status === 'pending') text-amber-600 dark:text-amber-400
                                        @elseif($session->status === 'active') text-emerald-600 dark:text-emerald-400
                                        @else text-blue-600 dark:text-blue-400
                                        @endif">
                                        @if($session->status === 'pending') pending
                                        @elseif($session->status === 'active') psychology
                                        @else check_circle
                                        @endif
                                    </span>
                                </div>
                                @if($session->status === 'active')
                                <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white dark:border-gray-800 animate-pulse"></div>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">
                                    {{ ucfirst(str_replace('_', ' ', $session->session_type)) }}
                                    @if($isGroupParticipant)
                                        <span class="text-sm font-normal text-blue-600 dark:text-blue-400">(Participant)</span>
                                    @endif
                                </h3>
                                <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">calendar_today</span>
                                        {{ $session->created_at->format('M d, Y') }}
                                    </span>
                                    @if($session->counselor)
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">person</span>
                                        {{ $session->counselor->name }}
                                    </span>
                                    @endif
                                    @if($isGroupParticipant && $participantRecord)
                                    <span class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">info</span>
                                        Status: {{ ucfirst($participantRecord->status) }}
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="px-4 py-2 rounded-xl text-sm font-bold
                                @if($session->status === 'pending') bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300
                                @elseif($session->status === 'active') bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300
                                @else bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300
                                @endif">
                                {{ ucfirst($session->status) }}
                            </span>
                            @if($session->status === 'active' && (!$isGroupParticipant || ($participantRecord && $participantRecord->status === 'joined')))
                            <button onclick="toggleContactInfo({{ $session->id }})" class="bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-300 px-4 py-2 rounded-xl hover:bg-blue-100 dark:hover:bg-blue-900/30 text-sm font-medium transition-all duration-300 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">contact_phone</span>
                                <span>Share Contact</span>
                            </button>
                            <a href="{{ route('public.counseling.session.show', $session) }}" class="bg-white/20 backdrop-blur-sm border-2 border-primary/30 text-primary px-6 py-2.5 rounded-xl hover:bg-primary/10 hover:scale-105 text-sm font-bold transition-all duration-300 flex items-center gap-2">
                                <span>Continue</span>
                                <span class="material-symbols-outlined text-lg">arrow_forward</span>
                            </a>
                            @elseif($isGroupParticipant && $participantRecord && $participantRecord->status === 'invited')
                            <span class="text-blue-600 dark:text-blue-400 font-semibold text-sm">Invitation Pending</span>
                            @else
                            <a href="{{ route('public.counseling.session.show', $session) }}" class="text-primary hover:text-primary/80 font-semibold text-sm flex items-center gap-1 transition-colors">
                                <span>View Details</span>
                                <span class="material-symbols-outlined text-lg">arrow_forward</span>
                            </a>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Contact Information Panel (Hidden by default) -->
                    <div id="contact-info-{{ $session->id }}" class="hidden mt-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl p-4">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-xl">contact_phone</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-blue-900 dark:text-blue-100">Share Your Contact Information</h4>
                                <p class="text-sm text-blue-700 dark:text-blue-300">Your counselor can use this information to reach you if needed</p>
                            </div>
                        </div>
                        
                        <form id="contact-form-{{ $session->id }}" class="space-y-4">
                            @csrf
                            <input type="hidden" name="session_id" value="{{ $session->id }}">
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <!-- Phone Number -->
                                <div class="space-y-2">
                                    <label class="flex items-center gap-2 text-sm font-medium text-blue-900 dark:text-blue-100">
                                        <span class="material-symbols-outlined text-sm">phone</span>
                                        Phone Number
                                    </label>
                                    <div class="relative">
                                        <input type="tel" name="phone" value="{{ auth()->user()->phone ?? '' }}" 
                                               placeholder="Enter your phone number"
                                               class="w-full px-3 py-2 pl-10 border border-blue-200 dark:border-blue-700 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-blue-900/20 dark:text-white text-sm">
                                        <span class="material-symbols-outlined absolute left-3 top-2.5 text-blue-500 text-sm">phone</span>
                                    </div>
                                </div>
                                
                                <!-- WhatsApp -->
                                <div class="space-y-2">
                                    <label class="flex items-center gap-2 text-sm font-medium text-blue-900 dark:text-blue-100">
                                        <span class="material-symbols-outlined text-sm">chat</span>
                                        WhatsApp
                                    </label>
                                    <div class="relative">
                                        <input type="tel" name="whatsapp" value="{{ auth()->user()->phone ?? '' }}" 
                                               placeholder="WhatsApp number"
                                               class="w-full px-3 py-2 pl-10 border border-blue-200 dark:border-blue-700 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-blue-900/20 dark:text-white text-sm">
                                        <span class="material-symbols-outlined absolute left-3 top-2.5 text-green-500 text-sm">chat</span>
                                    </div>
                                </div>
                                
                                <!-- Email -->
                                <div class="space-y-2">
                                    <label class="flex items-center gap-2 text-sm font-medium text-blue-900 dark:text-blue-100">
                                        <span class="material-symbols-outlined text-sm">email</span>
                                        Email
                                    </label>
                                    <div class="relative">
                                        <input type="email" name="email" value="{{ auth()->user()->email }}" readonly
                                               class="w-full px-3 py-2 pl-10 border border-blue-200 dark:border-blue-700 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-white text-sm">
                                        <span class="material-symbols-outlined absolute left-3 top-2.5 text-blue-500 text-sm">email</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Preferred Contact Method -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-blue-900 dark:text-blue-100">Preferred Contact Method</label>
                                <div class="flex flex-wrap gap-2">
                                    <label class="flex items-center gap-2 bg-white dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg px-3 py-2 cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/40 transition-colors">
                                        <input type="radio" name="preferred_contact" value="phone" class="text-blue-600 focus:ring-blue-500">
                                        <span class="material-symbols-outlined text-sm text-blue-600">phone</span>
                                        <span class="text-sm text-blue-900 dark:text-blue-100">Phone Call</span>
                                    </label>
                                    <label class="flex items-center gap-2 bg-white dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg px-3 py-2 cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/40 transition-colors">
                                        <input type="radio" name="preferred_contact" value="whatsapp" class="text-blue-600 focus:ring-blue-500">
                                        <span class="material-symbols-outlined text-sm text-green-600">chat</span>
                                        <span class="text-sm text-blue-900 dark:text-blue-100">WhatsApp</span>
                                    </label>
                                    <label class="flex items-center gap-2 bg-white dark:bg-blue-900/30 border border-blue-200 dark:border-blue-700 rounded-lg px-3 py-2 cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/40 transition-colors">
                                        <input type="radio" name="preferred_contact" value="email" class="text-blue-600 focus:ring-blue-500">
                                        <span class="material-symbols-outlined text-sm text-blue-600">email</span>
                                        <span class="text-sm text-blue-900 dark:text-blue-100">Email</span>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Notes -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-blue-900 dark:text-blue-100">Additional Notes (Optional)</label>
                                <textarea name="contact_notes" rows="2" 
                                          placeholder="Any specific instructions for contacting you..."
                                          class="w-full px-3 py-2 border border-blue-200 dark:border-blue-700 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-blue-900/20 dark:text-white text-sm resize-none"></textarea>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex gap-3 pt-2">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">share</span>
                                    Share Contact Info
                                </button>
                                <button type="button" onclick="toggleContactInfo({{ $session->id }})" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">close</span>
                                    Cancel
                                </button>
                            </div>
                            
                            <!-- Success Message (Hidden by default) -->
                            <div id="contact-success-{{ $session->id }}" class="hidden mt-3 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                <div class="flex items-center gap-2 text-green-700 dark:text-green-300">
                                    <span class="material-symbols-outlined text-sm">check_circle</span>
                                    <span class="text-sm font-medium">Contact information shared successfully!</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @else
        <!-- Empty State -->
        <div class="group bg-white dark:bg-gray-800 rounded-2xl p-16 text-center shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-teal-600"></div>
            <div class="relative inline-block mb-8">
                <div class="w-32 h-32 mx-auto rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 border border-emerald-200 dark:border-emerald-800 flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform duration-300">
                    <span class="material-symbols-outlined text-6xl text-emerald-600 dark:text-emerald-400">support_agent</span>
                </div>
                <div class="absolute -top-2 -right-2 w-12 h-12 bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 border border-yellow-200 dark:border-yellow-800 rounded-full flex items-center justify-center shadow-sm animate-bounce">
                    <span class="material-symbols-outlined text-yellow-600 dark:text-yellow-400 text-2xl">star</span>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Ready to Start Your Journey?</h3>
            <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 max-w-2xl mx-auto leading-relaxed">
                You haven't requested any counseling sessions yet. Our professional counselors are here to support you through any challenges you're facing. Take the first step towards better mental health today.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button onclick="openRequestModal()" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-10 py-4 rounded-xl font-bold text-lg hover:shadow-lg hover:shadow-emerald-500/30 hover:scale-105 transition-all duration-200 flex items-center gap-2 justify-center">
                    <span class="material-symbols-outlined text-2xl">add_circle</span>
                    Request Your First Session
                </button>
                <button onclick="document.getElementById('infoModal').classList.remove('hidden')" class="bg-white dark:bg-gray-700 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 px-10 py-4 rounded-xl font-bold text-lg hover:bg-gray-50 dark:hover:bg-gray-600 hover:shadow-lg transition-all flex items-center gap-2 justify-center">
                    <span class="material-symbols-outlined text-2xl">info</span>
                    Learn More
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- CTA Section -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-gradient-to-r from-primary/10 to-green-50 dark:from-gray-800 dark:to-gray-800/50 rounded-2xl p-8 border border-primary/20 dark:border-gray-700 overflow-hidden">
            <!-- Decorative Icons -->
            <div class="absolute top-4 left-4 opacity-10">
                <span class="material-symbols-outlined text-6xl text-primary">support_agent</span>
            </div>
            <div class="absolute bottom-4 right-4 opacity-10">
                <span class="material-symbols-outlined text-6xl text-primary">psychology</span>
            </div>
            
            <div class="relative text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/20 rounded-full mb-4">
                    <span class="material-symbols-outlined text-3xl text-primary">favorite</span>
                </div>
                <h3 class="text-xl font-bold text-[#111816] dark:text-white mb-2">Need Additional Support?</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-2xl mx-auto">Our counselors are here to help. Request a new session or explore our mental health resources.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <button onclick="openRequestModal()" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition-colors text-sm">
                        <span class="material-symbols-outlined text-base">add_circle</span>
                        <span>Request Session</span>
                    </button>
                    <a href="{{ route('content.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white dark:bg-gray-700 text-[#111816] dark:text-white border border-gray-300 dark:border-gray-600 rounded-lg font-semibold hover:border-primary hover:text-primary transition-colors text-sm">
                        <span class="material-symbols-outlined text-base">library_books</span>
                        <span>Browse Resources</span>
                    </a>
                    <a href="{{ route('public.counseling.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white dark:bg-gray-700 text-[#111816] dark:text-white border border-gray-300 dark:border-gray-600 rounded-lg font-semibold hover:border-primary hover:text-primary transition-colors text-sm">
                        <span class="material-symbols-outlined text-base">arrow_back</span>
                        <span>Back to Services</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

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
@include('components.request-counseling-modal')

@push('scripts')
<script>
// Session filtering functionality
function filterSessions(status) {
    const sessionItems = document.querySelectorAll('.session-item');
    const filterBtns = document.querySelectorAll('.filter-btn');
    let visibleCount = 0;
    
    // Update button styles
    filterBtns.forEach(btn => {
        if (btn.dataset.filter === status) {
            btn.classList.remove('bg-white', 'dark:bg-gray-800', 'border', 'border-gray-200', 'dark:border-gray-700', 'text-gray-700', 'dark:text-gray-300');
            btn.classList.add('bg-gradient-to-r', 'from-emerald-500', 'to-teal-600', 'text-white', 'active');
        } else {
            btn.classList.remove('bg-gradient-to-r', 'from-emerald-500', 'to-teal-600', 'text-white', 'active');
            btn.classList.add('bg-white', 'dark:bg-gray-800', 'border', 'border-gray-200', 'dark:border-gray-700', 'text-gray-700', 'dark:text-gray-300');
        }
    });
    
    // Filter sessions
    sessionItems.forEach(item => {
        const itemStatus = item.dataset.status;
        
        if (status === 'all' || itemStatus === status) {
            item.style.display = 'block';
            setTimeout(() => {
                item.style.opacity = '1';
                item.style.transform = 'translateX(0)';
            }, 10);
            visibleCount++;
        } else {
            item.style.opacity = '0';
            item.style.transform = 'translateX(-20px)';
            setTimeout(() => {
                item.style.display = 'none';
            }, 300);
        }
    });
    
    // Show/hide empty state
    showEmptyState(visibleCount === 0, status);
}

function showEmptyState(show, filter) {
    let emptyState = document.querySelector('.filter-empty-state');
    const sessionsList = document.querySelector('.session-item')?.parentElement;
    
    if (show && !emptyState && sessionsList) {
        emptyState = document.createElement('div');
        emptyState.className = 'filter-empty-state p-12 text-center';
        emptyState.innerHTML = `
            <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                <span class="material-symbols-outlined text-4xl text-gray-400">filter_list_off</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No ${filter === 'all' ? '' : filter.charAt(0).toUpperCase() + filter.slice(1)} Sessions</h3>
            <p class="text-gray-600 dark:text-gray-400">You don't have any ${filter === 'all' ? '' : filter} sessions yet.</p>
        `;
        sessionsList.appendChild(emptyState);
    } else if (!show && emptyState) {
        emptyState.remove();
    }
}

// Contact information functionality
function toggleContactInfo(sessionId) {
    const contactPanel = document.getElementById(`contact-info-${sessionId}`);
    if (contactPanel) {
        contactPanel.classList.toggle('hidden');
        
        // If showing the panel, scroll it into view
        if (!contactPanel.classList.contains('hidden')) {
            setTimeout(() => {
                contactPanel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }, 100);
        }
    }
}

// Handle contact form submission
document.addEventListener('DOMContentLoaded', function() {
    // Auto-fill WhatsApp when phone number is entered
    document.querySelectorAll('input[name="phone"]').forEach(phoneInput => {
        phoneInput.addEventListener('input', function() {
            const whatsappInput = this.closest('form').querySelector('input[name="whatsapp"]');
            if (whatsappInput && !whatsappInput.value) {
                whatsappInput.value = this.value;
            }
        });
    });
    
    // Add event listeners to all contact forms
    document.querySelectorAll('[id^="contact-form-"]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const sessionId = formData.get('session_id');
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">refresh</span> Sharing...';
            submitBtn.disabled = true;
            
            // Simulate API call (replace with actual endpoint)
            fetch('/api/sessions/share-contact', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    session_id: sessionId,
                    phone: formData.get('phone'),
                    whatsapp: formData.get('whatsapp'),
                    email: formData.get('email'),
                    preferred_contact: formData.get('preferred_contact'),
                    contact_notes: formData.get('contact_notes')
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message in the contact panel
                    const successDiv = document.getElementById(`contact-success-${sessionId}`);
                    if (successDiv) {
                        successDiv.classList.remove('hidden');
                    }
                    
                    // Show global notification
                    showNotification('Contact information shared successfully!', 'success');
                    
                    // Hide the contact panel after 2 seconds
                    setTimeout(() => {
                        toggleContactInfo(sessionId);
                        // Hide success message when panel is closed
                        if (successDiv) {
                            successDiv.classList.add('hidden');
                        }
                    }, 2000);
                    
                    // Reset form
                    this.reset();
                } else {
                    showNotification(data.message || 'Failed to share contact information.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Failed to share contact information. Please try again.', 'error');
            })
            .finally(() => {
                // Restore button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    });
});

// Notification function
function showNotification(message, type = 'info') {
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
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 5000);
}

// Add transition styles
const style = document.createElement('style');
style.textContent = `
    .session-item {
        opacity: 1;
        transform: translateX(0);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
`;
document.head.appendChild(style);
</script>
@endpush
@endsection
