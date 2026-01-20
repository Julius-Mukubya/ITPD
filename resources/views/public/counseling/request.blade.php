@extends('layouts.public')

@section('title', 'Request Counseling Session')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-br from-emerald-50 via-teal-50 to-cyan-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-900 py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2 bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm text-primary px-4 py-2 rounded-full text-sm font-semibold mb-6">
            <span class="material-symbols-outlined !text-lg">psychology</span>
            Request Session
        </div>
        <h1 class="text-4xl lg:text-5xl font-black text-gray-900 dark:text-white tracking-tight mb-4">Request a Counseling Session</h1>
        <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Complete the steps below to request a counseling session. A professional counselor will review your request and contact you within 24-48 hours.</p>
    </div>
</section>

<!-- Multi-Step Form Section -->
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <!-- Progress Bar -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-2 step-indicator active" data-step="1">
                <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold shadow-lg step-circle">1</div>
                <span class="font-semibold text-gray-900 dark:text-white hidden sm:block">Session Type</span>
            </div>
            <div class="flex-1 h-1 bg-gray-200 dark:bg-gray-700 mx-2 progress-line"></div>
            <div class="flex items-center gap-2 step-indicator" data-step="2">
                <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 flex items-center justify-center font-bold step-circle">2</div>
                <span class="font-semibold text-gray-500 dark:text-gray-400 hidden sm:block">Counselor</span>
            </div>
            <div class="flex-1 h-1 bg-gray-200 dark:bg-gray-700 mx-2 progress-line"></div>
            <div class="flex items-center gap-2 step-indicator" data-step="3">
                <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 flex items-center justify-center font-bold step-circle">3</div>
                <span class="font-semibold text-gray-500 dark:text-gray-400 hidden sm:block">Priority</span>
            </div>
            <div class="flex-1 h-1 bg-gray-200 dark:bg-gray-700 mx-2 progress-line"></div>
            <div class="flex items-center gap-2 step-indicator" data-step="4">
                <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 flex items-center justify-center font-bold step-circle">4</div>
                <span class="font-semibold text-gray-500 dark:text-gray-400 hidden sm:block">Details</span>
            </div>
            <div class="flex-1 h-1 bg-gray-200 dark:bg-gray-700 mx-2 progress-line"></div>
            <div class="flex items-center gap-2 step-indicator" data-step="5">
                <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 text-gray-500 dark:text-gray-400 flex items-center justify-center font-bold step-circle">5</div>
                <span class="font-semibold text-gray-500 dark:text-gray-400 hidden sm:block">Review</span>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl border-2 border-gray-200 dark:border-gray-700 shadow-2xl overflow-hidden">
        <div class="p-8 md:p-12">
            <form action="{{ route('public.counseling.request.store') }}" method="POST" id="counselingForm">
                @csrf

                <!-- Step 1: Session Type -->
                <div class="form-step active" data-step="1">
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/10 rounded-2xl mb-4">
                            <span class="material-symbols-outlined text-4xl text-primary">category</span>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Choose Session Type</h2>
                        <p class="text-gray-600 dark:text-gray-400">Select the type of counseling session you need</p>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
                        <label class="relative flex flex-col p-6 border-2 border-gray-200 dark:border-gray-700 rounded-2xl cursor-pointer hover:border-primary hover:shadow-lg transition-all group">
                            <input type="radio" name="session_type" value="individual" required class="sr-only peer">
                            <div class="text-center">
                                <div class="w-16 h-16 mx-auto mb-3 bg-primary/10 rounded-2xl flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all">
                                    <span class="material-symbols-outlined text-3xl text-primary group-hover:text-white">person</span>
                                </div>
                                <span class="font-bold text-gray-900 dark:text-white block mb-1">Individual</span>
                                <p class="text-sm text-gray-600 dark:text-gray-400">One-on-one session</p>
                            </div>
                            <div class="absolute inset-0 border-2 border-primary rounded-2xl opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                            <div class="absolute top-3 right-3 w-6 h-6 bg-primary rounded-full items-center justify-center hidden peer-checked:flex">
                                <span class="material-symbols-outlined text-white text-sm">check</span>
                            </div>
                        </label>

                        <label class="relative flex flex-col p-6 border-2 border-gray-200 dark:border-gray-700 rounded-2xl cursor-pointer hover:border-primary hover:shadow-lg transition-all group">
                            <input type="radio" name="session_type" value="group" required class="sr-only peer">
                            <div class="text-center">
                                <div class="w-16 h-16 mx-auto mb-3 bg-primary/10 rounded-2xl flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all">
                                    <span class="material-symbols-outlined text-3xl text-primary group-hover:text-white">groups</span>
                                </div>
                                <span class="font-bold text-gray-900 dark:text-white block mb-1">Group</span>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Group therapy</p>
                            </div>
                            <div class="absolute inset-0 border-2 border-primary rounded-2xl opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                            <div class="absolute top-3 right-3 w-6 h-6 bg-primary rounded-full items-center justify-center hidden peer-checked:flex">
                                <span class="material-symbols-outlined text-white text-sm">check</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Step 2: Counselor Selection -->
                <div class="form-step" data-step="2">
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl mb-4">
                            <span class="material-symbols-outlined text-4xl text-emerald-500">person</span>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Choose Your Counselor</h2>
                        <p class="text-gray-600 dark:text-gray-400">Select a specific counselor or let us assign one for you</p>
                    </div>
                    
                    <div class="space-y-4 mb-8">
                        <label class="relative flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-2xl cursor-pointer hover:border-primary hover:shadow-lg transition-all group">
                            <input type="radio" name="counselor_id" value="" class="sr-only peer" checked>
                            <div class="flex items-center gap-4 w-full">
                                <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center group-hover:bg-primary group-hover:scale-110 transition-all">
                                    <span class="material-symbols-outlined text-3xl text-primary group-hover:text-white">shuffle</span>
                                </div>
                                <div class="flex-1">
                                    <span class="font-bold text-gray-900 dark:text-white block mb-1">Any Available Counselor</span>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">We'll assign the best available counselor based on your needs</p>
                                </div>
                            </div>
                            <div class="absolute inset-0 border-2 border-primary rounded-2xl opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                            <div class="absolute top-3 right-3 w-6 h-6 bg-primary rounded-full items-center justify-center hidden peer-checked:flex">
                                <span class="material-symbols-outlined text-white text-sm">check</span>
                            </div>
                        </label>

                        @foreach($counselors as $counselor)
                        <label class="relative flex items-center p-4 border-2 border-gray-200 dark:border-gray-700 rounded-2xl cursor-pointer hover:border-primary hover:shadow-lg transition-all group">
                            <input type="radio" name="counselor_id" value="{{ $counselor->id }}" class="sr-only peer">
                            <div class="flex items-center gap-4 w-full">
                                <div class="w-16 h-16 bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl flex items-center justify-center group-hover:bg-emerald-500 group-hover:scale-110 transition-all">
                                    <span class="material-symbols-outlined text-3xl text-emerald-500 group-hover:text-white">person</span>
                                </div>
                                <div class="flex-1">
                                    <span class="font-bold text-gray-900 dark:text-white block mb-1">{{ $counselor->name }}</span>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $counselor->email }}</p>
                                </div>
                            </div>
                            <div class="absolute inset-0 border-2 border-primary rounded-2xl opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                            <div class="absolute top-3 right-3 w-6 h-6 bg-primary rounded-full items-center justify-center hidden peer-checked:flex">
                                <span class="material-symbols-outlined text-white text-sm">check</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center">You can request a specific counselor, but availability may vary based on their schedule.</p>
                </div>

                <!-- Step 3: Priority -->
                <div class="form-step" data-step="3">
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-orange-50 dark:bg-orange-900/20 rounded-2xl mb-4">
                            <span class="material-symbols-outlined text-4xl text-orange-500">priority_high</span>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Set Priority Level</h2>
                        <p class="text-gray-600 dark:text-gray-400">How urgent is your need for counseling?</p>
                    </div>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                        <label class="relative flex flex-col items-center p-6 border-2 border-gray-200 dark:border-gray-700 rounded-2xl cursor-pointer hover:border-green-500 hover:shadow-lg transition-all group">
                            <input type="radio" name="priority" value="low" required class="sr-only peer">
                            <div class="w-16 h-16 mb-3 bg-green-50 dark:bg-green-900/20 rounded-2xl flex items-center justify-center group-hover:bg-green-500 group-hover:scale-110 transition-all">
                                <span class="material-symbols-outlined text-4xl text-green-500 group-hover:text-white">sentiment_satisfied</span>
                            </div>
                            <span class="font-bold text-gray-900 dark:text-white mb-1">Low</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 text-center">Can wait</span>
                            <div class="absolute inset-0 border-2 border-green-500 rounded-2xl opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                            <div class="absolute top-3 right-3 w-6 h-6 bg-green-500 rounded-full items-center justify-center hidden peer-checked:flex">
                                <span class="material-symbols-outlined text-white text-sm">check</span>
                            </div>
                        </label>

                        <label class="relative flex flex-col items-center p-6 border-2 border-gray-200 dark:border-gray-700 rounded-2xl cursor-pointer hover:border-yellow-500 hover:shadow-lg transition-all group">
                            <input type="radio" name="priority" value="medium" required class="sr-only peer">
                            <div class="w-16 h-16 mb-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-2xl flex items-center justify-center group-hover:bg-yellow-500 group-hover:scale-110 transition-all">
                                <span class="material-symbols-outlined text-4xl text-yellow-500 group-hover:text-white">sentiment_neutral</span>
                            </div>
                            <span class="font-bold text-gray-900 dark:text-white mb-1">Medium</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 text-center">Soon</span>
                            <div class="absolute inset-0 border-2 border-yellow-500 rounded-2xl opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                            <div class="absolute top-3 right-3 w-6 h-6 bg-yellow-500 rounded-full items-center justify-center hidden peer-checked:flex">
                                <span class="material-symbols-outlined text-white text-sm">check</span>
                            </div>
                        </label>

                        <label class="relative flex flex-col items-center p-6 border-2 border-gray-200 dark:border-gray-700 rounded-2xl cursor-pointer hover:border-orange-500 hover:shadow-lg transition-all group">
                            <input type="radio" name="priority" value="high" required class="sr-only peer">
                            <div class="w-16 h-16 mb-3 bg-orange-50 dark:bg-orange-900/20 rounded-2xl flex items-center justify-center group-hover:bg-orange-500 group-hover:scale-110 transition-all">
                                <span class="material-symbols-outlined text-4xl text-orange-500 group-hover:text-white">sentiment_worried</span>
                            </div>
                            <span class="font-bold text-gray-900 dark:text-white mb-1">High</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 text-center">Important</span>
                            <div class="absolute inset-0 border-2 border-orange-500 rounded-2xl opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                            <div class="absolute top-3 right-3 w-6 h-6 bg-orange-500 rounded-full items-center justify-center hidden peer-checked:flex">
                                <span class="material-symbols-outlined text-white text-sm">check</span>
                            </div>
                        </label>

                        <label class="relative flex flex-col items-center p-6 border-2 border-gray-200 dark:border-gray-700 rounded-2xl cursor-pointer hover:border-red-500 hover:shadow-lg transition-all group">
                            <input type="radio" name="priority" value="urgent" required class="sr-only peer">
                            <div class="w-16 h-16 mb-3 bg-red-50 dark:bg-red-900/20 rounded-2xl flex items-center justify-center group-hover:bg-red-500 group-hover:scale-110 transition-all">
                                <span class="material-symbols-outlined text-4xl text-red-500 group-hover:text-white">emergency</span>
                            </div>
                            <span class="font-bold text-gray-900 dark:text-white mb-1">Urgent</span>
                            <span class="text-xs text-gray-500 dark:text-gray-400 text-center">ASAP</span>
                            <div class="absolute inset-0 border-2 border-red-500 rounded-2xl opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                            <div class="absolute top-3 right-3 w-6 h-6 bg-red-500 rounded-full items-center justify-center hidden peer-checked:flex">
                                <span class="material-symbols-outlined text-white text-sm">check</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Step 4: Details -->
                <div class="form-step" data-step="4">
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 dark:bg-blue-900/20 rounded-2xl mb-4">
                            <span class="material-symbols-outlined text-4xl text-blue-500">edit_note</span>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Session Details</h2>
                        <p class="text-gray-600 dark:text-gray-400">Tell us more about your needs</p>
                    </div>

                    <!-- Preferred Method -->
                    <div class="mb-8">
                    <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-4">
                        <span class="material-symbols-outlined text-lg align-middle mr-1">contact_page</span>
                        Preferred Contact Method
                    </label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        <label class="relative flex items-center p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary transition-all">
                            <input type="radio" name="preferred_method" value="zoom" class="text-primary focus:ring-primary">
                            <div class="ml-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">videocam</span>
                                <span class="font-medium text-gray-900 dark:text-white text-sm">Zoom</span>
                            </div>
                        </label>

                        <label class="relative flex items-center p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary transition-all">
                            <input type="radio" name="preferred_method" value="google_meet" class="text-primary focus:ring-primary">
                            <div class="ml-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">video_call</span>
                                <span class="font-medium text-gray-900 dark:text-white text-sm">Google Meet</span>
                            </div>
                        </label>

                        <label class="relative flex items-center p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary transition-all">
                            <input type="radio" name="preferred_method" value="whatsapp" class="text-primary focus:ring-primary">
                            <div class="ml-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">chat</span>
                                <span class="font-medium text-gray-900 dark:text-white text-sm">WhatsApp</span>
                            </div>
                        </label>

                        <label class="relative flex items-center p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary transition-all">
                            <input type="radio" name="preferred_method" value="phone_call" class="text-primary focus:ring-primary">
                            <div class="ml-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">call</span>
                                <span class="font-medium text-gray-900 dark:text-white text-sm">Phone Call</span>
                            </div>
                        </label>

                        <label class="relative flex items-center p-3 border-2 border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:border-primary transition-all">
                            <input type="radio" name="preferred_method" value="physical" class="text-primary focus:ring-primary">
                            <div class="ml-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">location_on</span>
                                <span class="font-medium text-gray-900 dark:text-white text-sm">In-Person</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Reason -->
                <div class="mb-8">
                    <label for="reason" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        <span class="material-symbols-outlined text-lg align-middle mr-1">description</span>
                        Reason for Counseling <span class="text-red-500">*</span>
                    </label>
                    <textarea id="reason" name="reason" rows="6" required minlength="10"
                        class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white resize-none transition-all"
                        placeholder="Please describe what you'd like to discuss in your counseling session. The more details you provide, the better we can assist you.">{{ old('reason') }}</textarea>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Minimum 10 characters. All information is confidential.</p>
                    @error('reason')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preferred Date/Time -->
                <div class="mb-8">
                    <label for="preferred_datetime" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        <span class="material-symbols-outlined text-lg align-middle mr-1">schedule</span>
                        Preferred Date & Time (Optional)
                    </label>
                    <input type="datetime-local" id="preferred_datetime" name="preferred_datetime" value="{{ old('preferred_datetime') }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white transition-all">
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">We'll do our best to accommodate your preferred time.</p>
                </div>

                <!-- Additional Options -->
                <div class="mb-8 space-y-4">
                    <label class="flex items-start p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                        <input type="checkbox" name="anonymous" value="1" class="mt-1 text-primary focus:ring-primary rounded">
                        <div class="ml-3">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="material-symbols-outlined text-gray-600 dark:text-gray-400">visibility_off</span>
                                <span class="font-semibold text-gray-900 dark:text-white">Request Anonymous Session</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Your identity will be kept confidential during the session</p>
                        </div>
                    </label>

                    <label class="flex items-start p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                        <input type="checkbox" name="follow_up" value="1" class="mt-1 text-primary focus:ring-primary rounded">
                        <div class="ml-3">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="material-symbols-outlined text-gray-600 dark:text-gray-400">event_repeat</span>
                                <span class="font-semibold text-gray-900 dark:text-white">Request Follow-up Sessions</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">I'm interested in scheduling regular follow-up sessions</p>
                        </div>
                    </label>

                    <label class="flex items-start p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 transition-all">
                        <input type="checkbox" name="resources" value="1" class="mt-1 text-primary focus:ring-primary rounded">
                        <div class="ml-3">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="material-symbols-outlined text-gray-600 dark:text-gray-400">library_books</span>
                                <span class="font-semibold text-gray-900 dark:text-white">Send Me Resources</span>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Receive helpful mental health resources and materials</p>
                        </div>
                    </label>
                </div>

                </div>

                <!-- Step 5: Review -->
                <div class="form-step" data-step="5">
                    <div class="text-center mb-8">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-50 dark:bg-green-900/20 rounded-2xl mb-4">
                            <span class="material-symbols-outlined text-4xl text-green-500">check_circle</span>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Review Your Request</h2>
                        <p class="text-gray-600 dark:text-gray-400">Please review your information before submitting</p>
                    </div>

                    <div class="space-y-4 mb-8">
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Session Type</p>
                            <p class="font-bold text-gray-900 dark:text-white" id="review-session-type">-</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Preferred Counselor</p>
                            <p class="font-bold text-gray-900 dark:text-white" id="review-counselor">-</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Priority Level</p>
                            <p class="font-bold text-gray-900 dark:text-white" id="review-priority">-</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Preferred Method</p>
                            <p class="font-bold text-gray-900 dark:text-white" id="review-method">-</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Reason</p>
                            <p class="text-gray-900 dark:text-white" id="review-reason">-</p>
                        </div>
                    </div>

                    <!-- Confidentiality Notice -->
                    <div class="mb-8 bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl p-6">
                        <div class="flex gap-3">
                            <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 flex-shrink-0">lock</span>
                            <div>
                                <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Confidentiality & Privacy</h4>
                                <p class="text-sm text-blue-800 dark:text-blue-200 leading-relaxed">
                                    All counseling sessions are completely confidential. Your information will only be shared with your explicit consent or in cases where there's immediate danger to yourself or others.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" id="prevBtn" class="px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-all flex items-center gap-2" style="display: none;">
                        <span class="material-symbols-outlined">arrow_back</span>
                        Previous
                    </button>
                    <a href="{{ route('public.counseling.sessions') }}" class="px-6 py-3 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 font-medium transition-colors">
                        Cancel
                    </a>
                    <button type="button" id="nextBtn" class="px-8 py-3 bg-gradient-to-r from-primary to-emerald-600 text-white rounded-xl font-bold hover:shadow-lg hover:scale-105 transition-all flex items-center gap-2">
                        Next
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                    <button type="submit" id="submitBtn" class="px-8 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl font-bold hover:shadow-lg hover:scale-105 transition-all flex items-center gap-2" style="display: none;">
                        <span class="material-symbols-outlined">send</span>
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Help Section -->
    <div class="mt-8 bg-gradient-to-br from-purple-50 to-indigo-50 dark:from-purple-900/20 dark:to-indigo-900/20 border border-purple-200 dark:border-purple-800 rounded-2xl p-6">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">help</span>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-purple-900 dark:text-purple-100 mb-2">Need Immediate Help?</h3>
                <p class="text-sm text-purple-800 dark:text-purple-200 mb-4">
                    If you're experiencing a mental health emergency, please don't wait for a counseling session.
                </p>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="tel:0800212121" class="inline-flex items-center gap-2 bg-red-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-red-700 transition-all text-sm">
                        <span class="material-symbols-outlined text-base">emergency</span>
                        Call 0800 21 21 21 (Toll Free)
                    </a>
                    <button onclick="document.getElementById('emergencyModal').classList.remove('hidden')" class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 text-purple-900 dark:text-purple-100 border border-purple-300 dark:border-purple-700 px-4 py-2 rounded-lg font-semibold hover:bg-purple-50 dark:hover:bg-purple-900/30 transition-all text-sm">
                        <span class="material-symbols-outlined text-base">info</span>
                        View All Crisis Resources
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Crisis Support Modal -->
@include('components.crisis-support-modal', ['openRequestModal' => false])

@push('scripts')
<script>
// Multi-step form functionality
let currentStep = 1;
const totalSteps = 5;

// Auto-select urgent priority if coming from emergency link
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.get('priority') === 'urgent') {
    setTimeout(() => {
        const priorityInput = document.querySelector('input[name="priority"][value="urgent"]');
        if (priorityInput) priorityInput.checked = true;
    }, 100);
}

function showStep(step) {
    // Hide all steps
    document.querySelectorAll('.form-step').forEach(el => {
        el.classList.remove('active');
        el.style.display = 'none';
    });
    
    // Show current step
    const currentStepEl = document.querySelector(`.form-step[data-step="${step}"]`);
    if (currentStepEl) {
        currentStepEl.style.display = 'block';
        setTimeout(() => currentStepEl.classList.add('active'), 10);
    }
    
    // Update progress indicators
    document.querySelectorAll('.step-indicator').forEach((indicator, index) => {
        const stepNum = index + 1;
        const circle = indicator.querySelector('.step-circle');
        const text = indicator.querySelector('span:last-child');
        
        if (stepNum < step) {
            // Completed steps
            circle.classList.remove('bg-gray-200', 'dark:bg-gray-700', 'text-gray-500', 'dark:text-gray-400', 'bg-primary', 'text-white');
            circle.classList.add('bg-green-500', 'text-white');
            if (text) text.classList.remove('text-gray-500', 'dark:text-gray-400', 'text-gray-900', 'dark:text-white');
            if (text) text.classList.add('text-green-500');
        } else if (stepNum === step) {
            // Current step
            circle.classList.remove('bg-gray-200', 'dark:bg-gray-700', 'text-gray-500', 'dark:text-gray-400', 'bg-green-500');
            circle.classList.add('bg-primary', 'text-white');
            if (text) text.classList.remove('text-gray-500', 'dark:text-gray-400', 'text-green-500');
            if (text) text.classList.add('text-gray-900', 'dark:text-white');
        } else {
            // Future steps
            circle.classList.remove('bg-primary', 'text-white', 'bg-green-500');
            circle.classList.add('bg-gray-200', 'dark:bg-gray-700', 'text-gray-500', 'dark:text-gray-400');
            if (text) text.classList.remove('text-gray-900', 'dark:text-white', 'text-green-500');
            if (text) text.classList.add('text-gray-500', 'dark:text-gray-400');
        }
    });
    
    // Update progress lines
    document.querySelectorAll('.progress-line').forEach((line, index) => {
        if (index < step - 1) {
            line.classList.remove('bg-gray-200', 'dark:bg-gray-700');
            line.classList.add('bg-green-500');
        } else {
            line.classList.remove('bg-green-500');
            line.classList.add('bg-gray-200', 'dark:bg-gray-700');
        }
    });
    
    // Update buttons
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');
    
    if (step === 1) {
        prevBtn.style.display = 'none';
    } else {
        prevBtn.style.display = 'flex';
    }
    
    if (step === totalSteps) {
        nextBtn.style.display = 'none';
        submitBtn.style.display = 'flex';
        updateReview();
    } else {
        nextBtn.style.display = 'flex';
        submitBtn.style.display = 'none';
    }
}

function validateStep(step) {
    if (step === 1) {
        const sessionType = document.querySelector('input[name="session_type"]:checked');
        if (!sessionType) {
            showToast('Please select a session type', 'warning');
            return false;
        }
    } else if (step === 2) {
        // Counselor selection is optional, so no validation needed
        return true;
    } else if (step === 3) {
        const priority = document.querySelector('input[name="priority"]:checked');
        if (!priority) {
            showToast('Please select a priority level', 'warning');
            return false;
        }
    } else if (step === 4) {
        const reason = document.getElementById('reason').value;
        if (reason.length < 10) {
            showToast('Please provide more details about your counseling needs (minimum 10 characters).', 'warning');
            document.getElementById('reason').focus();
            return false;
        }
    }
    return true;
}

function updateReview() {
    // Session Type
    const sessionType = document.querySelector('input[name="session_type"]:checked');
    document.getElementById('review-session-type').textContent = sessionType ? 
        sessionType.value.charAt(0).toUpperCase() + sessionType.value.slice(1) : '-';
    
    // Counselor
    const counselor = document.querySelector('input[name="counselor_id"]:checked');
    if (counselor && counselor.value) {
        // Find the counselor label text
        const counselorLabel = counselor.closest('label').querySelector('.font-bold');
        document.getElementById('review-counselor').textContent = counselorLabel ? counselorLabel.textContent : 'Specific counselor selected';
    } else {
        document.getElementById('review-counselor').textContent = 'Any available counselor';
    }
    
    // Priority
    const priority = document.querySelector('input[name="priority"]:checked');
    document.getElementById('review-priority').textContent = priority ? 
        priority.value.charAt(0).toUpperCase() + priority.value.slice(1) : '-';
    
    // Method
    const method = document.querySelector('input[name="preferred_method"]:checked');
    document.getElementById('review-method').textContent = method ? 
        method.value.replace('_', ' ').split(' ').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ') : 'Not specified';
    
    // Reason
    const reason = document.getElementById('reason').value;
    document.getElementById('review-reason').textContent = reason || '-';
}

// Navigation buttons
document.getElementById('nextBtn').addEventListener('click', function() {
    if (validateStep(currentStep)) {
        if (currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
});

document.getElementById('prevBtn').addEventListener('click', function() {
    if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
});

// Form submission validation
document.getElementById('counselingForm').addEventListener('submit', function(e) {
    if (!validateStep(4)) {
        e.preventDefault();
    }
});

// Initialize
showStep(currentStep);

// Add CSS for smooth transitions
const style = document.createElement('style');
style.textContent = `
    .form-step {
        display: none;
        opacity: 0;
        transform: translateX(20px);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    .form-step.active {
        opacity: 1;
        transform: translateX(0);
    }
`;
document.head.appendChild(style);
</script>
@endpush
@endsection
