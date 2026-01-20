@extends('layouts.student')

@section('title', 'Request Counseling - Student')
@section('page-title', 'Request Counseling Session')

@section('content')
<!-- Breadcrumb -->
<div class="mb-8">
    <nav class="flex items-center gap-2 text-sm">
        <a href="{{ route('student.counseling.index') }}" class="text-gray-500 dark:text-gray-400 hover:text-primary transition-colors">Counseling</a>
        <span class="material-symbols-outlined text-gray-400 text-sm">chevron_right</span>
        <span class="text-gray-900 dark:text-white font-medium">Request Session</span>
    </nav>
</div>

<!-- Header -->
<div class="bg-gradient-to-br from-teal-50 to-cyan-50 dark:from-teal-900/20 dark:to-cyan-900/20 rounded-3xl p-8 mb-8 border border-teal-100 dark:border-teal-800 relative overflow-hidden">
    <div class="relative z-10">
        <div class="flex items-center gap-4 mb-4">
            <div class="w-16 h-16 bg-teal-100 dark:bg-teal-900/30 rounded-2xl flex items-center justify-center">
                <span class="material-symbols-outlined text-3xl text-teal-600 dark:text-teal-400">support_agent</span>
            </div>
            <div>
                <h1 class="text-3xl font-bold mb-2 text-gray-900 dark:text-white">Request Counseling Session</h1>
                <p class="text-teal-700 dark:text-teal-300 text-lg">Take the first step towards getting the support you need</p>
            </div>
        </div>
        <p class="text-gray-700 dark:text-gray-300 max-w-2xl">
            Our professional counselors are here to provide confidential, personalized support. 
            Please fill out this form with as much detail as you're comfortable sharing.
        </p>
    </div>
</div>

<div class="max-w-4xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-lg overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('student.counseling.store') }}" method="POST" id="counselingForm">
                        @csrf

                        <div class="space-y-8">
                            <!-- Session Type -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-4">Session Type *</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="session_type" value="individual" required class="sr-only peer">
                                        <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl p-4 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20 transition-all hover:border-gray-300 dark:hover:border-gray-500">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400">person</span>
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-900 dark:text-white">Individual</h3>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">One-on-one session</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="session_type" value="group" required class="sr-only peer">
                                        <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl p-4 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20 transition-all hover:border-gray-300 dark:hover:border-gray-500">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">groups</span>
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-900 dark:text-white">Group</h3>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">Group therapy session</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Preferred Counselor -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-4">Preferred Counselor (Optional)</label>
                                <div class="space-y-3">
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="counselor_id" value="" class="sr-only peer" checked>
                                        <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl p-4 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20 transition-all hover:border-gray-300 dark:hover:border-gray-500">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-gray-100 dark:bg-gray-600 rounded-lg flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-gray-600 dark:text-gray-400">shuffle</span>
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-900 dark:text-white">Any Available Counselor</h3>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">We'll assign the best available counselor</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>

                                    @foreach($counselors as $counselor)
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="counselor_id" value="{{ $counselor->id }}" class="sr-only peer">
                                        <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl p-4 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20 transition-all hover:border-gray-300 dark:hover:border-gray-500">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400">person</span>
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $counselor->name }}</h3>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $counselor->email }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">You can request a specific counselor, but availability may vary.</p>
                            </div>

                            <!-- Priority -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-4">Priority Level *</label>
                                <div class="space-y-3">
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="priority" value="low" required class="sr-only peer">
                                        <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl p-4 peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20 transition-all hover:border-gray-300 dark:hover:border-gray-500">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                                    <div>
                                                        <h3 class="font-semibold text-gray-900 dark:text-white">Low Priority</h3>
                                                        <p class="text-sm text-gray-600 dark:text-gray-400">Can wait a few days</p>
                                                    </div>
                                                </div>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">3-5 days</span>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="priority" value="medium" required class="sr-only peer" {{ request('priority') !== 'urgent' ? 'checked' : '' }}>
                                        <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl p-4 peer-checked:border-yellow-500 peer-checked:bg-yellow-50 dark:peer-checked:bg-yellow-900/20 transition-all hover:border-gray-300 dark:hover:border-gray-500">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                                    <div>
                                                        <h3 class="font-semibold text-gray-900 dark:text-white">Medium Priority</h3>
                                                        <p class="text-sm text-gray-600 dark:text-gray-400">Within this week</p>
                                                    </div>
                                                </div>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">1-2 days</span>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="priority" value="high" required class="sr-only peer">
                                        <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl p-4 peer-checked:border-orange-500 peer-checked:bg-orange-50 dark:peer-checked:bg-orange-900/20 transition-all hover:border-gray-300 dark:hover:border-gray-500">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
                                                    <div>
                                                        <h3 class="font-semibold text-gray-900 dark:text-white">High Priority</h3>
                                                        <p class="text-sm text-gray-600 dark:text-gray-400">Within 24 hours</p>
                                                    </div>
                                                </div>
                                                <span class="text-sm text-gray-500 dark:text-gray-400">Same day</span>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="priority" value="urgent" required class="sr-only peer" {{ request('priority') === 'urgent' ? 'checked' : '' }}>
                                        <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl p-4 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/20 transition-all hover:border-gray-300 dark:hover:border-gray-500">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                                                    <div>
                                                        <h3 class="font-semibold text-gray-900 dark:text-white">Urgent</h3>
                                                        <p class="text-sm text-gray-600 dark:text-gray-400">Immediate attention needed</p>
                                                    </div>
                                                </div>
                                                <span class="text-sm text-red-600 dark:text-red-400 font-semibold">ASAP</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Preferred Method -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-4">Preferred Method (Optional)</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="preferred_method" value="zoom" class="sr-only peer">
                                        <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl p-4 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all hover:border-gray-300 dark:hover:border-gray-500">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">videocam</span>
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-900 dark:text-white">Zoom</h3>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">Video call</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="preferred_method" value="google_meet" class="sr-only peer">
                                        <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl p-4 peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20 transition-all hover:border-gray-300 dark:hover:border-gray-500">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">video_call</span>
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-900 dark:text-white">Google Meet</h3>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">Video call</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="preferred_method" value="whatsapp" class="sr-only peer">
                                        <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl p-4 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20 transition-all hover:border-gray-300 dark:hover:border-gray-500">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400">chat</span>
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-900 dark:text-white">WhatsApp</h3>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">Voice/Video call</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>

                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="preferred_method" value="phone_call" class="sr-only peer">
                                        <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl p-4 peer-checked:border-purple-500 peer-checked:bg-purple-50 dark:peer-checked:bg-purple-900/20 transition-all hover:border-gray-300 dark:hover:border-gray-500">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">call</span>
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-900 dark:text-white">Phone Call</h3>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">Voice only</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>

                                    {{-- Jitsi option removed - embedded video calls no longer supported --}}

                                    <label class="relative cursor-pointer md:col-span-2">
                                        <input type="radio" name="preferred_method" value="physical" class="sr-only peer">
                                        <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl p-4 peer-checked:border-orange-500 peer-checked:bg-orange-50 dark:peer-checked:bg-orange-900/20 transition-all hover:border-gray-300 dark:hover:border-gray-500">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                                                    <span class="material-symbols-outlined text-orange-600 dark:text-orange-400">location_on</span>
                                                </div>
                                                <div>
                                                    <h3 class="font-semibold text-gray-900 dark:text-white">Physical (In-Person)</h3>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">Face-to-face meeting at campus</p>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Select your preferred method for the counseling session. We'll do our best to accommodate your choice.</p>
                            </div>

                            <!-- Reason -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-3">What would you like to discuss? *</label>
                                <textarea name="reason" rows="6" required 
                                    placeholder="Please share what's on your mind. The more details you provide, the better we can prepare to support you. Remember, everything you share is confidential."
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white resize-none transition-all"></textarea>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Your information is completely confidential and secure.</p>
                            </div>

                            <!-- Preferred Time -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-3">Preferred Date & Time (Optional)</label>
                                <input type="datetime-local" name="preferred_datetime" 
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white transition-all">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">We'll do our best to accommodate your preferred time, but availability may vary.</p>
                            </div>

                            <!-- Additional Options -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-3">Additional Preferences</label>
                                <div class="space-y-3">
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" name="anonymous" value="1" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">I prefer to remain anonymous initially</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" name="follow_up" value="1" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">I'm interested in follow-up sessions</span>
                                    </label>
                                    <label class="flex items-center gap-3 cursor-pointer">
                                        <input type="checkbox" name="resources" value="1" class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                                        <span class="text-sm text-gray-700 dark:text-gray-300">Send me relevant self-help resources</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <button type="submit" class="flex-1 bg-teal-600 dark:bg-teal-700 text-white px-8 py-4 rounded-xl font-semibold hover:bg-teal-700 dark:hover:bg-teal-600 transition-all flex items-center justify-center gap-2">
                                <span class="material-symbols-outlined">send</span>
                                Submit Request
                            </button>
                            <a href="{{ route('student.counseling.index') }}" class="flex-1 sm:flex-none bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-8 py-4 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-all text-center">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Confidentiality Notice -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">security</span>
                    </div>
                    <h3 class="font-semibold text-blue-900 dark:text-blue-100">Confidentiality</h3>
                </div>
                <p class="text-sm text-blue-800 dark:text-blue-200 mb-3">
                    All counseling sessions are completely confidential. Your information is protected and will only be shared with your explicit consent.
                </p>
                <p class="text-xs text-blue-700 dark:text-blue-300">
                    A counselor will review your request and contact you within 24-48 hours.
                </p>
            </div>

            <!-- Emergency Support -->
            <div class="bg-gradient-to-br from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-red-600 dark:text-red-400">emergency</span>
                    </div>
                    <h3 class="font-semibold text-red-900 dark:text-red-100">Crisis Support</h3>
                </div>
                <p class="text-sm text-red-800 dark:text-red-200 mb-4">
                    If you're experiencing a mental health emergency, please reach out immediately:
                </p>
                <div class="space-y-3">
                    <a href="tel:0800212121" class="flex items-center gap-2 text-sm font-bold text-red-700 dark:text-red-300 hover:text-red-900 dark:hover:text-red-100 transition-colors">
                        <span class="material-symbols-outlined">call</span>
                        <div>
                            <p>Mental Health Uganda</p>
                            <p class="text-xs font-normal">0800 21 21 21 (Toll Free)</p>
                        </div>
                    </a>
                    <button onclick="document.getElementById('emergencyModal').classList.remove('hidden')" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-all text-sm font-semibold">
                        View All Crisis Resources
                    </button>
                </div>
            </div>

            <!-- What to Expect -->
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400">info</span>
                    </div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">What to Expect</h3>
                </div>
                <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">1</span>
                        </div>
                        <p>Submit your request with as much detail as you're comfortable sharing</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">2</span>
                        </div>
                        <p>A qualified counselor will review your request</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">3</span>
                        </div>
                        <p>You'll be contacted to schedule your session</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-6 h-6 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">4</span>
                        </div>
                        <p>Attend your session via secure video call or in-person</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Crisis Support Modal -->
@include('components.crisis-support-modal')
@endsection
