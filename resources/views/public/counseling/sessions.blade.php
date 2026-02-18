@extends('layouts.public')

@section('title', 'My Counseling Sessions')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden h-screen">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="{{ asset('images/counselling-mysessions-hero.avif') }}" 
             alt="Counseling sessions" 
             class="w-full h-full object-cover animate-hero-zoom">
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

<!-- Sessions List -->
<div id="sessions" class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 scroll-mt-16">
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600">history</span>
                Your Sessions
            </h2>
        </div>
        
        <!-- Filters Section -->
        <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-md rounded-2xl p-4 sm:p-6 shadow-lg border border-[#f0f4f3] dark:border-gray-800">
            <!-- Mobile Filter Header with Toggle -->
            <div class="flex items-center justify-between mb-4 lg:hidden">
                <h3 class="text-lg font-semibold text-[#111816] dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">tune</span>
                    Filters
                </h3>
                <button id="mobile-filter-toggle" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                    <span>Show Filters</span>
                    <span id="mobile-filter-icon" class="material-symbols-outlined text-sm transition-transform">expand_more</span>
                </button>
            </div>
            
            <!-- Filter Buttons (Hidden on mobile by default) -->
            <div id="mobile-filters" class="hidden lg:flex flex-col sm:flex-row items-start sm:items-center gap-3">
                <label class="text-sm font-semibold text-[#111816] dark:text-gray-300 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">filter_list</span>
                    <span>Status:</span>
                </label>
                <div class="flex flex-wrap items-center gap-2">
                    <button onclick="filterSessions('all')" class="filter-btn flex h-10 items-center justify-center gap-1.5 rounded-xl bg-primary text-white px-4 text-sm font-semibold shadow-sm hover:shadow-md transition-all duration-200" data-filter="all">
                        <span class="material-symbols-outlined !text-base">select_all</span>
                        <span>All Sessions</span>
                    </button>
                    <button onclick="filterSessions('pending')" class="filter-btn flex h-10 items-center justify-center gap-1.5 rounded-xl bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-[#111816] dark:text-gray-300 px-4 text-sm font-medium hover:border-primary transition-all duration-200" data-filter="pending">
                        <span class="material-symbols-outlined !text-base">schedule</span>
                        <span>Pending</span>
                    </button>
                    <button onclick="filterSessions('active')" class="filter-btn flex h-10 items-center justify-center gap-1.5 rounded-xl bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-[#111816] dark:text-gray-300 px-4 text-sm font-medium hover:border-primary transition-all duration-200" data-filter="active">
                        <span class="material-symbols-outlined !text-base">check_circle</span>
                        <span>Active</span>
                    </button>
                    <button onclick="filterSessions('completed')" class="filter-btn flex h-10 items-center justify-center gap-1.5 rounded-xl bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-[#111816] dark:text-gray-300 px-4 text-sm font-medium hover:border-primary transition-all duration-200" data-filter="completed">
                        <span class="material-symbols-outlined !text-base">task_alt</span>
                        <span>Completed</span>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Mobile: Request Session Button (Below filters) -->
        <div class="lg:hidden">
            <button onclick="openRequestModal()" class="w-full bg-gradient-to-r from-primary to-green-500 text-white px-6 py-3 rounded-xl font-semibold text-sm hover:shadow-lg hover:shadow-primary/30 transition-all duration-200 transform hover:scale-105 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined !text-lg">add_circle</span>
                Request Session
            </button>
        </div>
        
        <!-- Sessions Content with Fixed Sidebar -->
        <div class="flex gap-6">
            <!-- Fixed Sidebar -->
            <div class="hidden lg:block w-64 flex-shrink-0">
                <div class="sticky top-24 space-y-4">
                    <!-- Request Session Button -->
                    <button onclick="openRequestModal()" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-primary to-green-500 text-white px-6 py-4 rounded-xl font-semibold text-sm hover:shadow-lg hover:shadow-primary/30 transition-all duration-200 transform hover:scale-105">
                        <span class="material-symbols-outlined !text-lg">add_circle</span>
                        <span>Request Session</span>
                    </button>
                    
                    <!-- Quick Stats Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-3 text-sm">Session Overview</h3>
                        <div class="space-y-2 text-sm">
                            @if(isset($sessions) && $sessions->count() > 0)
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Total Sessions</span>
                                <span class="font-semibold text-gray-900 dark:text-white">{{ $sessions->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Pending</span>
                                <span class="font-semibold text-amber-600">{{ $sessions->where('status', 'pending')->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Active</span>
                                <span class="font-semibold text-emerald-600">{{ $sessions->where('status', 'active')->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Completed</span>
                                <span class="font-semibold text-green-600">{{ $sessions->where('status', 'completed')->count() }}</span>
                            </div>
                            @else
                            <div class="text-center text-gray-500 dark:text-gray-400 py-4">
                                <span class="material-symbols-outlined text-2xl mb-2 block">support_agent</span>
                                <p class="text-xs">No sessions yet</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Quick Actions Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700 shadow-sm">
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-3 text-sm">Quick Actions</h3>
                        <div class="space-y-2">
                            <button onclick="document.getElementById('emergencyModal').classList.remove('hidden')" class="w-full text-left flex items-center gap-2 p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors text-sm text-red-600 dark:text-red-400">
                                <span class="material-symbols-outlined text-sm">emergency</span>
                                <span>Crisis Support</span>
                            </button>
                            <a href="{{ route('content.index') }}" class="w-full text-left flex items-center gap-2 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm text-gray-700 dark:text-gray-300">
                                <span class="material-symbols-outlined text-sm">library_books</span>
                                <span>Browse Resources</span>
                            </a>
                            <a href="{{ route('public.counseling.index') }}" class="w-full text-left flex items-center gap-2 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm text-gray-700 dark:text-gray-300">
                                <span class="material-symbols-outlined text-sm">arrow_back</span>
                                <span>Back to Services</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Sessions Content -->
            <div class="flex-1 min-w-0">
                @if(isset($sessions) && $sessions->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($sessions as $session)
            <div class="session-item bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 overflow-hidden group" data-status="{{ $session->status }}" data-type="{{ $session->session_type }}" data-date="{{ $session->created_at->format('Y-m-d') }}">
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
                
                <!-- Card Header with Status -->
                <div class="relative h-48 overflow-hidden">
                    <!-- Background Image -->
                    @php
                        $sessionImages = [
                            'individual' => [
                                'pending' => asset('images/pending-individual-session.avif'),
                                'active' => asset('images/active-individual-session.avif'),
                                'completed' => asset('images/completed-individual-session.avif')
                            ],
                            'group' => [
                                'pending' => asset('images/pending-group-session.avif'),
                                'active' => asset('images/active-group-session.avif'),
                                'completed' => asset('images/completed-group-session.avif')
                            ]
                        ];
                        
                        $sessionType = $session->session_type === 'group' ? 'group' : 'individual';
                        $sessionStatus = $session->status;
                        $imageUrl = $sessionImages[$sessionType][$sessionStatus] ?? $sessionImages['individual']['active'];
                        
                        $imageAlts = [
                            'individual' => [
                                'pending' => 'Scheduled individual counseling session',
                                'active' => 'Active individual counseling session',
                                'completed' => 'Completed individual counseling session'
                            ],
                            'group' => [
                                'pending' => 'Scheduled group therapy session',
                                'active' => 'Active group counseling session',
                                'completed' => 'Completed group therapy session'
                            ]
                        ];
                        
                        $imageAlt = $imageAlts[$sessionType][$sessionStatus] ?? 'Counseling session';
                    @endphp
                    
                    <img src="{{ $imageUrl }}" 
                         alt="{{ $imageAlt }}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 
                        @if($session->status === 'pending') bg-gradient-to-t from-amber-900/80 via-amber-900/40 to-transparent
                        @elseif($session->status === 'active') bg-gradient-to-t from-emerald-900/80 via-emerald-900/40 to-transparent
                        @else bg-gradient-to-t from-green-900/80 via-blue-900/40 to-transparent
                        @endif"></div>
                    
                    <!-- Status Badge -->
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold backdrop-blur-sm
                            @if($session->status === 'pending') bg-amber-100/90 text-amber-700 dark:bg-amber-900/60 dark:text-amber-300
                            @elseif($session->status === 'active') bg-emerald-100/90 text-emerald-700 dark:bg-emerald-900/60 dark:text-emerald-300
                            @else bg-green-100/90 text-green-700 dark:bg-green-900/60 dark:text-green-300
                            @endif">
                            {{ ucfirst($session->status) }}
                        </span>
                    </div>
                    
                    <!-- Session Type Badge -->
                    <div class="absolute top-4 left-4">
                        <div class="flex items-center gap-1 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-full text-xs font-semibold text-gray-700">
                            <span class="material-symbols-outlined text-sm">
                                @if($session->session_type === 'group') group @else person @endif
                            </span>
                            <span>{{ ucfirst(str_replace('_', ' ', $session->session_type)) }}</span>
                        </div>
                    </div>
                    
                    <!-- Session Icon -->
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2">
                        <div class="w-16 h-16 rounded-2xl border-2 border-white/30 bg-white/20 backdrop-blur-sm flex items-center justify-center shadow-lg group-hover:scale-105 transition-all duration-300">
                            <span class="material-symbols-outlined text-3xl text-white">
                                @if($session->status === 'pending') schedule
                                @elseif($session->status === 'active') psychology
                                @else check_circle
                                @endif
                            </span>
                        </div>
                        @if($session->status === 'active')
                        <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white animate-pulse"></div>
                        @endif
                    </div>
                </div>
                
                <!-- Card Content -->
                <div class="p-6">
                    @if($isGroupParticipant && $participantRecord && $participantRecord->status === 'invited')
                        <!-- Group Session Invitation -->
                        <div class="bg-gradient-to-r from-green-50 to-indigo-50 dark:from-green-900/20 dark:to-indigo-900/20 border border-green-200 dark:border-green-800 rounded-xl p-3 mb-4">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-sm">group</span>
                                <span class="text-xs font-semibold text-green-900 dark:text-green-100">Group Invitation</span>
                            </div>
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('public.counseling.session.accept-invitation', $session) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition-colors flex items-center gap-1">
                                        <span class="material-symbols-outlined text-xs">check</span>
                                        Accept
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('public.counseling.session.decline-invitation', $session) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition-colors flex items-center gap-1">
                                        <span class="material-symbols-outlined text-xs">close</span>
                                        Decline
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Session Title -->
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">
                        {{ ucfirst(str_replace('_', ' ', $session->session_type)) }}
                        @if($isGroupParticipant)
                            <span class="text-sm font-normal text-green-600 dark:text-green-400">(Participant)</span>
                        @endif
                    </h3>
                    
                    <!-- Session Details -->
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                            <span class="material-symbols-outlined text-sm">calendar_today</span>
                            <span>{{ $session->created_at->format('M d, Y') }}</span>
                        </div>
                        @if($session->counselor)
                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                            <span class="material-symbols-outlined text-sm">person</span>
                            <span>{{ $session->counselor->name }}</span>
                        </div>
                        @endif
                        @if($isGroupParticipant && $participantRecord)
                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                            <span class="material-symbols-outlined text-sm">info</span>
                            <span>Status: {{ ucfirst($participantRecord->status) }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex flex-col gap-2">
                        @if($session->status === 'active' && (!$isGroupParticipant || ($participantRecord && $participantRecord->status === 'joined')))
                            <button onclick="toggleContactInfo({{ $session->id }})" class="w-full bg-green-50 dark:bg-blue-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-2 rounded-lg hover:bg-green-100 dark:hover:bg-blue-900/30 text-sm font-medium transition-all duration-300 flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined text-sm">contact_phone</span>
                                <span>Share Contact</span>
                            </button>
                            <a href="{{ route('public.counseling.session.show', $session) }}" class="w-full bg-primary text-white px-4 py-2.5 rounded-lg hover:bg-primary/90 hover:scale-105 text-sm font-bold transition-all duration-300 flex items-center justify-center gap-2">
                                <span>Continue</span>
                                <span class="material-symbols-outlined text-lg">arrow_forward</span>
                            </a>
                        @elseif($isGroupParticipant && $participantRecord && $participantRecord->status === 'invited')
                            <div class="text-center text-green-600 dark:text-green-400 font-semibold text-sm py-2">
                                Invitation Pending
                            </div>
                        @else
                            <a href="{{ route('public.counseling.session.show', $session) }}" class="w-full text-primary hover:text-primary/80 font-semibold text-sm flex items-center justify-center gap-1 transition-colors py-2">
                                <span>View Details</span>
                                <span class="material-symbols-outlined text-lg">arrow_forward</span>
                            </a>
                        @endif
                    </div>
                </div>
                
                <!-- Contact Information Panel (Hidden by default) -->
                <div id="contact-info-{{ $session->id }}" class="hidden border-t border-gray-200 dark:border-gray-700 bg-gradient-to-r from-green-50 to-indigo-50 dark:from-green-900/20 dark:to-indigo-900/20 p-4">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-lg">contact_phone</span>
                        <h4 class="font-semibold text-green-900 dark:text-green-100 text-sm">Share Contact Info</h4>
                    </div>
                    
                    <form id="contact-form-{{ $session->id }}" class="space-y-3">
                        @csrf
                        <input type="hidden" name="session_id" value="{{ $session->id }}">
                        
                        <!-- Phone Number -->
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-green-900 dark:text-green-100">Phone Number</label>
                            <input type="tel" name="phone" value="{{ auth()->user()->phone ?? '' }}" 
                                   placeholder="Enter your phone number"
                                   class="w-full px-3 py-2 border border-green-200 dark:border-blue-700 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-blue-900/20 dark:text-white text-sm">
                        </div>
                        
                        <!-- WhatsApp -->
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-green-900 dark:text-green-100">WhatsApp</label>
                            <input type="tel" name="whatsapp" value="{{ auth()->user()->phone ?? '' }}" 
                                   placeholder="WhatsApp number"
                                   class="w-full px-3 py-2 border border-green-200 dark:border-blue-700 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-blue-900/20 dark:text-white text-sm">
                        </div>
                        
                        <!-- Preferred Contact Method -->
                        <div class="space-y-1">
                            <label class="text-xs font-medium text-green-900 dark:text-green-100">Preferred Method</label>
                            <div class="flex gap-2">
                                <label class="flex items-center gap-1 bg-white dark:bg-blue-900/30 border border-green-200 dark:border-blue-700 rounded-lg px-2 py-1 cursor-pointer hover:bg-green-50 dark:hover:bg-blue-900/40 transition-colors text-xs">
                                    <input type="radio" name="preferred_contact" value="phone" class="text-green-600 focus:ring-blue-500">
                                    <span>Phone</span>
                                </label>
                                <label class="flex items-center gap-1 bg-white dark:bg-blue-900/30 border border-green-200 dark:border-blue-700 rounded-lg px-2 py-1 cursor-pointer hover:bg-green-50 dark:hover:bg-blue-900/40 transition-colors text-xs">
                                    <input type="radio" name="preferred_contact" value="whatsapp" class="text-green-600 focus:ring-blue-500">
                                    <span>WhatsApp</span>
                                </label>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="flex gap-2 pt-2">
                            <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-xs font-medium transition-colors flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-xs">share</span>
                                Share
                            </button>
                            <button type="button" onclick="toggleContactInfo({{ $session->id }})" class="px-3 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-xs font-medium transition-colors">
                                Cancel
                            </button>
                        </div>
                        
                        <!-- Success Message -->
                        <div id="contact-success-{{ $session->id }}" class="hidden mt-2 p-2 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                            <div class="flex items-center gap-1 text-green-700 dark:text-green-300">
                                <span class="material-symbols-outlined text-xs">check_circle</span>
                                <span class="text-xs font-medium">Contact info shared!</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
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
    </div>
</div>

<!-- Confidential Support Banner -->
<section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
    </div>
</section>

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

<!-- Floating Action Button (Mobile Only) -->
<button onclick="openRequestModal()" 
        class="md:hidden fixed bottom-6 right-6 w-16 h-16 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-full shadow-2xl hover:shadow-emerald-500/50 transition-all duration-300 transform hover:scale-110 flex items-center justify-center group" 
        style="z-index: 9999;"
        title="Request Counseling Session">
    <span class="material-symbols-outlined text-3xl group-hover:rotate-90 transition-transform duration-300">add</span>
</button>

@include('components.request-counseling-modal')

@push('scripts')
<script>
// Mobile filter toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const mobileFilterToggle = document.getElementById('mobile-filter-toggle');
    const mobileFilters = document.getElementById('mobile-filters');
    const mobileFilterIcon = document.getElementById('mobile-filter-icon');
    
    if (mobileFilterToggle && mobileFilters) {
        mobileFilterToggle.addEventListener('click', function() {
            const isHidden = mobileFilters.classList.contains('hidden');
            
            if (isHidden) {
                mobileFilters.classList.remove('hidden');
                mobileFilterIcon.style.transform = 'rotate(180deg)';
                mobileFilterToggle.querySelector('span:first-child').textContent = 'Hide Filters';
            } else {
                mobileFilters.classList.add('hidden');
                mobileFilterIcon.style.transform = 'rotate(0deg)';
                mobileFilterToggle.querySelector('span:first-child').textContent = 'Show Filters';
            }
        });
    }
});

// Session filtering functionality
function filterSessions(status) {
    const sessionItems = document.querySelectorAll('.session-item');
    const filterBtns = document.querySelectorAll('.filter-btn');
    let visibleCount = 0;
    
    // Update button styles
    filterBtns.forEach(btn => {
        if (btn.dataset.filter === status) {
            btn.classList.remove('bg-white', 'dark:bg-gray-800', 'border-2', 'border-gray-200', 'dark:border-gray-700', 'text-[#111816]', 'dark:text-gray-300', 'font-medium', 'hover:border-primary');
            btn.classList.add('bg-primary', 'text-white', 'font-semibold', 'shadow-sm', 'hover:shadow-md');
        } else {
            btn.classList.remove('bg-primary', 'text-white', 'font-semibold', 'shadow-sm', 'hover:shadow-md');
            btn.classList.add('bg-white', 'dark:bg-gray-800', 'border-2', 'border-gray-200', 'dark:border-gray-700', 'text-[#111816]', 'dark:text-gray-300', 'font-medium', 'hover:border-primary');
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
        'bg-green-500 text-white'
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
    
    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }
`;
document.head.appendChild(style);

// Handle scroll to sessions section - ensure hero is completely hidden
document.addEventListener('DOMContentLoaded', function() {
    // Check if we should scroll to sessions (from profile dropdown)
    if (sessionStorage.getItem('scrollToSessions') === 'true') {
        sessionStorage.removeItem('scrollToSessions');
        setTimeout(() => {
            scrollToSessions();
        }, 100);
    }
    // Check if URL has #sessions hash
    else if (window.location.hash === '#sessions') {
        // Prevent default browser scroll by scrolling to top first
        window.scrollTo(0, 0);
        
        // Then use our custom scroll after a short delay
        setTimeout(() => {
            scrollToSessions();
        }, 100);
    }
    
    // Handle clicks on links to #sessions
    document.querySelectorAll('a[href="#sessions"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            scrollToSessions();
        });
    });
});

function scrollToSessions() {
    const sessionsSection = document.getElementById('sessions');
    if (sessionsSection) {
        const headerHeight = 65; // Fixed header height + extra padding to ensure title is visible
        const elementPosition = sessionsSection.getBoundingClientRect().top + window.pageYOffset;
        const offsetPosition = elementPosition - headerHeight;
        
        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
        });
    }
}
</script>
@endpush
@endsection

@push('styles')
<style>
    @keyframes hero-zoom {
        0% {
            transform: scale(1);
        }
        100% {
            transform: scale(1.05);
        }
    }
    
    .animate-hero-zoom {
        animation: hero-zoom 8s ease-out infinite alternate;
    }
</style>
@endpush

