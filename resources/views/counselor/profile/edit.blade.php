@extends('layouts.counselor')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<div class="max-w-5xl mx-auto">


    @if($errors->any())
    <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-800 dark:text-red-200 px-6 py-4 rounded-lg mb-6">
        <div class="flex items-start gap-3">
            <span class="material-symbols-outlined text-red-600">error</span>
            <div>
                <p class="font-semibold mb-2">Please fix the following errors:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <!-- Profile Header Card -->
    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-2xl p-8 text-white mb-6">
        <div class="flex items-center gap-6">
            @if(auth()->user()->avatar)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-24 h-24 rounded-full object-cover border-4 border-white/20">
            @else
                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center text-4xl font-bold backdrop-blur-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
            @endif
            <div>
                <h2 class="text-2xl font-bold mb-1">{{ auth()->user()->name }}</h2>
                <p class="text-white/90">{{ auth()->user()->email }}</p>
                <div class="flex items-center gap-2 mt-2">
                    <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-semibold">Counselor</span>
                    <span class="bg-white/20 px-3 py-1 rounded-full text-sm">Member since {{ auth()->user()->created_at->format('M Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
        <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary text-2xl">person</span>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Profile Information</h3>
            </div>
        </div>
        
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PATCH')
            
            <div class="space-y-6">
                <!-- Profile Image -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                        Profile Image
                    </label>
                    <div class="flex items-center gap-6">
                        <div class="relative">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" 
                                     id="avatar-preview" class="w-20 h-20 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600">
                            @else
                                <div id="avatar-preview" class="w-20 h-20 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full flex items-center justify-center text-2xl font-bold text-white">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden" onchange="previewAvatar(event)">
                            <div class="flex gap-3">
                                <button type="button" onclick="document.getElementById('avatar').click()" 
                                        class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-primary/90 transition-colors flex items-center gap-2">
                                    <span class="material-symbols-outlined text-lg">upload</span>
                                    Upload Photo
                                </button>
                                @if(auth()->user()->avatar)
                                    <button type="button" onclick="removeAvatar()" 
                                            class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-700 transition-colors flex items-center gap-2">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                        Remove
                                    </button>
                                @endif
                            </div>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">JPG, PNG or GIF. Max size 1MB.</p>
                        </div>
                    </div>
                    @error('avatar')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Phone Number <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" required
                           placeholder="+256 700 000 000"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Students may contact you via this number</p>
                </div>

                <!-- Specialization -->
                <div>
                    <label for="specialization" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Specialization <span class="text-gray-400 text-xs">(Optional)</span>
                    </label>
                    <input type="text" name="specialization" id="specialization" value="{{ old('specialization', auth()->user()->specialization ?? '') }}"
                           placeholder="e.g., Substance Abuse, Mental Health, Trauma Counseling"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                    @error('specialization')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bio -->
                <div>
                    <label for="bio" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Professional Bio <span class="text-gray-400 text-xs">(Optional)</span>
                    </label>
                    <textarea name="bio" id="bio" rows="4"
                              placeholder="Share your experience, qualifications, and approach to counseling..."
                              class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary resize-none">{{ old('bio', auth()->user()->bio ?? '') }}</textarea>
                    @error('bio')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Availability -->
                <div>
                    <label for="availability" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Availability <span class="text-gray-400 text-xs">(Optional)</span>
                    </label>
                    <input type="text" name="availability" id="availability" value="{{ old('availability', auth()->user()->availability ?? '') }}"
                           placeholder="e.g., Mon-Fri 9AM-5PM"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                    @error('availability')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary/90 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Change Password -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
        <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary text-2xl">lock</span>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Change Password</h3>
            </div>
        </div>
        
        <form action="{{ route('profile.password.update') }}" method="POST" class="p-6">
            @csrf
            @method('PATCH')
            
            <div class="space-y-6">
                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Current Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="current_password" id="current_password" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        New Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Must be at least 8 characters long</p>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Confirm New Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary/90 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined">lock_reset</span>
                    Update Password
                </button>
            </div>
        </form>
    </div>

    <!-- Professional Settings -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
        <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary text-2xl">settings</span>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Professional Settings</h3>
            </div>
        </div>
        
        <div class="p-6 space-y-4">
            <!-- Accept New Sessions -->
            <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white">Accept New Sessions</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Allow students to request counseling sessions</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 dark:peer-focus:ring-primary/40 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                </label>
            </div>

            <!-- Email Notifications -->
            <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white">Email Notifications</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Receive email alerts for new sessions</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 dark:peer-focus:ring-primary/40 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                </label>
            </div>

            <!-- Show Profile Publicly -->
            <div class="flex items-center justify-between py-3">
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white">Public Profile</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Display your profile in the counselors directory</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 dark:peer-focus:ring-primary/40 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                </label>
            </div>
        </div>
    </div>

    <!-- Video Call Preferences -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
        <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary text-2xl">videocam</span>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Video Call Preferences</h3>
            </div>
        </div>
        
        <form action="{{ route('profile.video-preferences.update') }}" method="POST" class="p-6">
            @csrf
            @method('PATCH')
            
            <div class="space-y-6">
                <!-- Default Video Service -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                        Preferred Video Call Service
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="preferred_video_service" value="jitsi" class="sr-only peer" 
                                   {{ (auth()->user()->preferred_video_service ?? 'jitsi') === 'jitsi' ? 'checked' : '' }}>
                            <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl p-4 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/20 transition-all hover:border-gray-300 dark:hover:border-gray-500">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                                        <span class="material-symbols-outlined text-indigo-600 dark:text-indigo-400">videocam</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Jitsi Meet</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Embedded, no downloads needed</p>
                                    </div>
                                </div>
                                <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                    ✅ Works directly in browser<br>
                                    ✅ No account required<br>
                                    ✅ Best for embedded experience
                                </div>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" name="preferred_video_service" value="google_meet" class="sr-only peer"
                                   {{ (auth()->user()->preferred_video_service ?? '') === 'google_meet' ? 'checked' : '' }}>
                            <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl p-4 peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20 transition-all hover:border-gray-300 dark:hover:border-gray-500">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                        <span class="material-symbols-outlined text-green-600 dark:text-green-400">video_call</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Google Meet</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Professional video conferencing</p>
                                    </div>
                                </div>
                                <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                    ✅ High quality video<br>
                                    ✅ Google integration<br>
                                    ⚠️ May open in new tab
                                </div>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" name="preferred_video_service" value="zoom" class="sr-only peer"
                                   {{ (auth()->user()->preferred_video_service ?? '') === 'zoom' ? 'checked' : '' }}>
                            <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl p-4 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition-all hover:border-gray-300 dark:hover:border-gray-500">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">videocam</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Zoom</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Industry standard video calls</p>
                                    </div>
                                </div>
                                <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                    ✅ Reliable and stable<br>
                                    ✅ Advanced features<br>
                                    ⚠️ May require app download
                                </div>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" name="preferred_video_service" value="phone_call" class="sr-only peer"
                                   {{ (auth()->user()->preferred_video_service ?? '') === 'phone_call' ? 'checked' : '' }}>
                            <div class="bg-gray-50 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 rounded-xl p-4 peer-checked:border-purple-500 peer-checked:bg-purple-50 dark:peer-checked:bg-purple-900/20 transition-all hover:border-gray-300 dark:hover:border-gray-500">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                                        <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">call</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Phone Call</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Traditional voice calls</p>
                                    </div>
                                </div>
                                <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                    ✅ Works on any phone<br>
                                    ✅ No internet required<br>
                                    ✅ Most accessible option
                                </div>
                            </div>
                        </label>
                    </div>
                    <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                        This will be your default video service for new sessions. You can still change it for individual sessions.
                    </p>
                </div>

                <!-- Auto-start Video Calls -->
                <div class="flex items-center justify-between py-4 border-t border-gray-200 dark:border-gray-700">
                    <div>
                        <h4 class="font-semibold text-gray-900 dark:text-white">Auto-start Video Calls</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Automatically create video call rooms when accepting sessions</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="auto_start_video" value="1" class="sr-only peer" 
                               {{ (auth()->user()->auto_start_video ?? true) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 dark:peer-focus:ring-primary/40 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                    </label>
                </div>

                <!-- Camera and Microphone Defaults -->
                <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Default Camera & Microphone Settings</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Camera</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Start with camera on</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="default_camera_on" value="1" class="sr-only peer"
                                       {{ (auth()->user()->default_camera_on ?? false) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 dark:peer-focus:ring-primary/40 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Microphone</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Start with microphone on</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="default_microphone_on" value="1" class="sr-only peer"
                                       {{ (auth()->user()->default_microphone_on ?? false) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 dark:peer-focus:ring-primary/40 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                            </label>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                        Note: For privacy, camera and microphone are currently set to start muted by default. These settings will override that behavior.
                    </p>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary/90 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    Save Video Preferences
                </button>
            </div>
        </form>
    </div>

    <!-- Danger Zone -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-red-200 dark:border-red-900 overflow-hidden">
        <div class="bg-red-50 dark:bg-red-900/20 px-6 py-4 border-b border-red-200 dark:border-red-900">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-2xl">warning</span>
                <h3 class="text-xl font-semibold text-red-900 dark:text-red-100">Danger Zone</h3>
            </div>
        </div>
        
        <div class="p-6">
            <div class="flex items-start justify-between">
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Delete Account</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Permanently delete your account and all associated data. This action cannot be undone.</p>
                </div>
                <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-red-700 transition-colors whitespace-nowrap">
                        Delete Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewAvatar(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatar-preview');
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-20 h-20 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600">`;
        }
        reader.readAsDataURL(file);
    }
}

function removeAvatar() {
    if (confirm('Are you sure you want to remove your profile image?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('profile.avatar.remove') }}';
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
