@extends('layouts.public')

@section('title', 'Dr. Sarah Rodriguez - Counselor Profile - WellPath')

@section('content')
<!-- Breadcrumb -->
<div class="bg-gradient-to-br from-teal-50 via-green-50 to-emerald-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center gap-2 text-sm">
            <a href="{{ route('public.home') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary transition-colors">Home</a>
            <span class="material-symbols-outlined text-gray-400 text-sm">chevron_right</span>
            <a href="{{ route('public.counseling.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary transition-colors">Counseling</a>
            <span class="material-symbols-outlined text-gray-400 text-sm">chevron_right</span>
            <span class="text-[#111816] dark:text-white font-medium">Dr. Sarah Rodriguez</span>
        </nav>
    </div>
</div>

<!-- Counselor Profile Header -->
<section class="py-20 bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-700 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-black/10"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-center">
            <div class="lg:col-span-1 text-center lg:text-left">
                <div class="w-48 h-48 bg-white/20 rounded-full flex items-center justify-center mx-auto lg:mx-0 mb-8 backdrop-blur-sm shadow-2xl">
                    <span class="text-8xl font-bold text-white">DR</span>
                </div>
            </div>
            
            <div class="lg:col-span-2">
                <div class="text-center lg:text-left">
                    <h1 class="text-5xl font-bold mb-4">Dr. Sarah Rodriguez</h1>
                    <p class="text-2xl text-blue-100 mb-6">Licensed Clinical Psychologist</p>
                    <p class="text-xl text-white/90 mb-8 max-w-2xl">
                        Specializing in anxiety disorders, depression, and trauma therapy with over 8 years of experience in student mental health support.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        @auth
                            @if(auth()->user()->role === 'user')
                                <a href="{{ route('public.counseling.sessions') }}" class="bg-white text-blue-600 px-8 py-4 rounded-2xl font-bold text-lg hover:bg-white/90 transition-all shadow-xl">
                                    Book Session with Dr. Rodriguez
                                </a>
                            @else
                                <button onclick="document.getElementById('loginModal').classList.remove('hidden')" class="bg-white text-blue-600 px-8 py-4 rounded-2xl font-bold text-lg hover:bg-white/90 transition-all shadow-xl">
                                    Student Login Required
                                </button>
                            @endif
                        @else
                            <button onclick="document.getElementById('loginModal').classList.remove('hidden')" class="bg-white text-blue-600 px-8 py-4 rounded-2xl font-bold text-lg hover:bg-white/90 transition-all shadow-xl">
                                Login to Book Session
                            </button>
                        @endauth
                        
                        <a href="#availability" class="bg-blue-600 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-blue-700 transition-all border-2 border-white/20">
                            View Availability
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute -top-20 -right-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-20 -left-20 w-64 h-64 bg-white/10 rounded-full blur-2xl"></div>
</section>

<!-- Specializations & Expertise -->
<section class="py-20 bg-white dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Specializations -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Areas of Specialization</h2>
                
                <div class="space-y-6">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 rounded-2xl p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">psychology</span>
                            </div>
                            <h3 class="text-xl font-bold text-blue-900 dark:text-blue-100">Anxiety Disorders</h3>
                        </div>
                        <p class="text-blue-800 dark:text-blue-200 mb-4">
                            Specialized treatment for generalized anxiety, social anxiety, panic disorders, and phobias using evidence-based approaches.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-sm rounded-full">Panic Attacks</span>
                            <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-sm rounded-full">Social Anxiety</span>
                            <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-sm rounded-full">Test Anxiety</span>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 border border-emerald-200 dark:border-emerald-800 rounded-2xl p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center">
                                <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400">healing</span>
                            </div>
                            <h3 class="text-xl font-bold text-emerald-900 dark:text-emerald-100">Depression Treatment</h3>
                        </div>
                        <p class="text-emerald-800 dark:text-emerald-200 mb-4">
                            Comprehensive support for major depression, seasonal affective disorder, and mood-related challenges.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-sm rounded-full">Major Depression</span>
                            <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-sm rounded-full">Seasonal Depression</span>
                            <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-sm rounded-full">Mood Disorders</span>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 border border-purple-200 dark:border-purple-800 rounded-2xl p-6">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                                <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">shield</span>
                            </div>
                            <h3 class="text-xl font-bold text-purple-900 dark:text-purple-100">Trauma Therapy</h3>
                        </div>
                        <p class="text-purple-800 dark:text-purple-200 mb-4">
                            Trauma-informed care for PTSD, complex trauma, and recovery from traumatic experiences.
                        </p>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-sm rounded-full">PTSD</span>
                            <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-sm rounded-full">Complex Trauma</span>
                            <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-sm rounded-full">Recovery Support</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Approach & Methods -->
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Therapeutic Approach</h2>
                
                <div class="bg-gradient-to-br from-gray-50 to-white dark:from-gray-700 dark:to-gray-800 rounded-2xl p-8 border border-gray-200 dark:border-gray-600 mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Treatment Philosophy</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6 leading-relaxed">
                        "I believe in creating a safe, non-judgmental space where students can explore their thoughts and feelings. 
                        My approach is collaborative, focusing on building your strengths while addressing challenges with evidence-based techniques."
                    </p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-white dark:bg-gray-900 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Cognitive Behavioral Therapy (CBT)</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Evidence-based approach for anxiety and depression</p>
                        </div>
                        <div class="bg-white dark:bg-gray-900 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Mindfulness-Based Interventions</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Present-moment awareness and stress reduction</p>
                        </div>
                        <div class="bg-white dark:bg-gray-900 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Trauma-Informed Care</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Safe, supportive approach to trauma recovery</p>
                        </div>
                        <div class="bg-white dark:bg-gray-900 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Solution-Focused Therapy</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Goal-oriented approach to positive change</p>
                        </div>
                    </div>
                </div>

                <!-- Credentials -->
                <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 border border-indigo-200 dark:border-indigo-800 rounded-2xl p-8">
                    <h3 class="text-2xl font-bold text-indigo-900 dark:text-indigo-100 mb-6">Education & Credentials</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <span class="material-symbols-outlined text-indigo-600 dark:text-indigo-400 text-sm">school</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-indigo-900 dark:text-indigo-100">Ph.D. in Clinical Psychology</h4>
                                <p class="text-sm text-indigo-700 dark:text-indigo-300">University of California, Los Angeles (UCLA)</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <span class="material-symbols-outlined text-indigo-600 dark:text-indigo-400 text-sm">verified</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-indigo-900 dark:text-indigo-100">Licensed Clinical Psychologist</h4>
                                <p class="text-sm text-indigo-700 dark:text-indigo-300">State of California License #PSY12345</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-4">
                            <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                <span class="material-symbols-outlined text-indigo-600 dark:text-indigo-400 text-sm">workspace_premium</span>
                            </div>
                            <div>
                                <h4 class="font-semibold text-indigo-900 dark:text-indigo-100">Certified Trauma Specialist</h4>
                                <p class="text-sm text-indigo-700 dark:text-indigo-300">International Society for Traumatic Stress Studies</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Experience & Background -->
<section class="py-20 bg-gradient-to-br from-teal-50 via-green-50 to-emerald-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Professional Experience</h2>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                Over 8 years of dedicated service in student mental health and clinical psychology.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg border border-gray-200 dark:border-gray-700">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">school</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">University Counseling</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    5+ years providing counseling services at university counseling centers, specializing in student mental health.
                </p>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <p>• Individual and group therapy</p>
                    <p>• Crisis intervention</p>
                    <p>• Academic stress management</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg border border-gray-200 dark:border-gray-700">
                <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400">local_hospital</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Clinical Practice</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    3+ years in private practice and clinical settings, treating anxiety, depression, and trauma disorders.
                </p>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <p>• Anxiety disorder treatment</p>
                    <p>• Depression therapy</p>
                    <p>• Trauma recovery support</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg border border-gray-200 dark:border-gray-700">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center mb-6">
                    <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">groups</span>
                </div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Research & Training</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Active in research on student mental health and training the next generation of counselors.
                </p>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    <p>• Published research papers</p>
                    <p>• Conference presentations</p>
                    <p>• Supervision of interns</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Availability & Booking -->
<section id="availability" class="py-20 bg-white dark:bg-gray-800/50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Schedule a Session</h2>
            <p class="text-xl text-gray-600 dark:text-gray-400">
                Dr. Rodriguez is currently accepting new clients. Sessions are available both in-person and via secure video call.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Session Types -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 rounded-2xl p-8">
                <h3 class="text-2xl font-bold text-blue-900 dark:text-blue-100 mb-6">Available Session Types</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-sm">person</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-blue-900 dark:text-blue-100">Individual Counseling</h4>
                            <p class="text-sm text-blue-700 dark:text-blue-300">50-minute one-on-one sessions</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-sm">video_call</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-blue-900 dark:text-blue-100">Telehealth Sessions</h4>
                            <p class="text-sm text-blue-700 dark:text-blue-300">Secure video counseling</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-4">
                        <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                            <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-sm">emergency</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-blue-900 dark:text-blue-100">Crisis Consultation</h4>
                            <p class="text-sm text-blue-700 dark:text-blue-300">Same-day emergency support</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Typical Schedule -->
            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 border border-emerald-200 dark:border-emerald-800 rounded-2xl p-8">
                <h3 class="text-2xl font-bold text-emerald-900 dark:text-emerald-100 mb-6">Typical Availability</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="font-medium text-emerald-900 dark:text-emerald-100">Monday</span>
                        <span class="text-sm text-emerald-700 dark:text-emerald-300">9:00 AM - 5:00 PM</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-medium text-emerald-900 dark:text-emerald-100">Tuesday</span>
                        <span class="text-sm text-emerald-700 dark:text-emerald-300">10:00 AM - 6:00 PM</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-medium text-emerald-900 dark:text-emerald-100">Wednesday</span>
                        <span class="text-sm text-emerald-700 dark:text-emerald-300">9:00 AM - 5:00 PM</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-medium text-emerald-900 dark:text-emerald-100">Thursday</span>
                        <span class="text-sm text-emerald-700 dark:text-emerald-300">11:00 AM - 7:00 PM</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="font-medium text-emerald-900 dark:text-emerald-100">Friday</span>
                        <span class="text-sm text-emerald-700 dark:text-emerald-300">9:00 AM - 3:00 PM</span>
                    </div>
                </div>
                
                <div class="mt-6 p-4 bg-white dark:bg-gray-800 rounded-xl border border-emerald-200 dark:border-emerald-700">
                    <p class="text-sm text-emerald-700 dark:text-emerald-300">
                        <strong>Note:</strong> Emergency consultations available outside regular hours for crisis situations.
                    </p>
                </div>
            </div>
        </div>

        <!-- Booking CTA -->
        <div class="text-center">
            <div class="bg-gradient-to-br from-blue-500 via-indigo-600 to-purple-700 rounded-3xl p-8 text-white">
                <h3 class="text-2xl font-bold mb-4">Ready to Begin Your Journey?</h3>
                <p class="text-blue-100 mb-6 max-w-2xl mx-auto">
                    Take the first step towards better mental health. Dr. Rodriguez is here to support you with compassionate, professional care.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        @if(auth()->user()->role === 'user')
                            <a href="{{ route('public.counseling.sessions') }}" class="bg-white text-blue-600 px-8 py-4 rounded-2xl font-bold text-lg hover:bg-white/90 transition-all shadow-xl">
                                Book Session with Dr. Rodriguez
                            </a>
                        @else
                            <button onclick="document.getElementById('loginModal').classList.remove('hidden')" class="bg-white text-blue-600 px-8 py-4 rounded-2xl font-bold text-lg hover:bg-white/90 transition-all shadow-xl">
                                Student Login Required
                            </button>
                        @endif
                    @else
                        <button onclick="document.getElementById('loginModal').classList.remove('hidden')" class="bg-white text-blue-600 px-8 py-4 rounded-2xl font-bold text-lg hover:bg-white/90 transition-all shadow-xl">
                            Login to Book Session
                        </button>
                    @endauth
                    
                    <a href="{{ route('public.counseling.index') }}" class="bg-blue-600 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-blue-700 transition-all border-2 border-white/20">
                        View All Counselors
                    </a>
                </div>
                
                <p class="text-blue-100 text-sm mt-4">
                    All counseling services are free for students
                </p>
            </div>
        </div>
    </div>
</section>

@include('components.login-modal')
@endsection