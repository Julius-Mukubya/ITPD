@extends('layouts.admin')

@section('title', 'System Settings')

@section('content')
<!-- Header -->
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">System Settings</h1>
    <p class="text-gray-500 dark:text-gray-400 mt-1">Configure application settings and preferences</p>
</div>



<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- General Settings -->
    <div class="bg-gradient-to-br from-white to-emerald-50/30 dark:from-gray-800 dark:to-emerald-950/20 rounded-2xl border border-emerald-100 dark:border-emerald-900/30 p-6 shadow-lg shadow-emerald-500/5">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg">
                <span class="material-symbols-outlined text-white text-2xl">settings</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">General Settings</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Basic application configuration</p>
            </div>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST">
            @csrf
            @method('PATCH')
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Application Name</label>
                    <input type="text" name="app_name" value="{{ config('app.name') }}" 
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Timezone</label>
                    <select name="timezone" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white">
                        <option value="UTC">UTC</option>
                        <option value="Africa/Kampala" selected>Africa/Kampala (EAT)</option>
                        <option value="Africa/Nairobi">Africa/Nairobi (EAT)</option>
                    </select>
                </div>

                <div>
                    <label class="flex items-center gap-3 p-4 bg-white dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700 cursor-pointer hover:border-primary transition-colors">
                        <input type="checkbox" name="maintenance_mode" value="1" class="w-5 h-5 rounded text-primary focus:ring-primary">
                        <div>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">Maintenance Mode</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Temporarily disable public access</p>
                        </div>
                    </label>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-6 py-3 rounded-lg hover:shadow-lg hover:shadow-emerald-500/30 font-semibold transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    Save General Settings
                </button>
            </div>
        </form>
    </div>

    <!-- Email Settings -->
    <div class="bg-gradient-to-br from-white to-blue-50/30 dark:from-gray-800 dark:to-blue-950/20 rounded-2xl border border-blue-100 dark:border-blue-900/30 p-6 shadow-lg shadow-blue-500/5">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg">
                <span class="material-symbols-outlined text-white text-2xl">mail</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Email Settings</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Configure email notifications</p>
            </div>
        </div>

        <form action="{{ route('admin.settings.email.update') }}" method="POST">
            @csrf
            @method('PATCH')
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">From Email</label>
                    <input type="email" name="mail_from" value="{{ config('mail.from.address') }}" 
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">From Name</label>
                    <input type="text" name="mail_from_name" value="{{ config('mail.from.name') }}" 
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                </div>

                <div class="space-y-3">
                    <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                        <input type="checkbox" name="notify_new_user" value="1" checked class="w-4 h-4 rounded text-blue-500">
                        <span class="text-sm text-gray-700 dark:text-gray-300">New user registration</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                        <input type="checkbox" name="notify_counseling" value="1" checked class="w-4 h-4 rounded text-blue-500">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Counseling requests</span>
                    </label>

                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-3 rounded-lg hover:shadow-lg hover:shadow-blue-500/30 font-semibold transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    Save Email Settings
                </button>
            </div>
        </form>
    </div>

    <!-- Security Settings -->
    <div class="bg-gradient-to-br from-white to-purple-50/30 dark:from-gray-800 dark:to-purple-950/20 rounded-2xl border border-purple-100 dark:border-purple-900/30 p-6 shadow-lg shadow-purple-500/5">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center shadow-lg">
                <span class="material-symbols-outlined text-white text-2xl">shield</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Security Settings</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Manage security options</p>
            </div>
        </div>

        <form action="{{ route('admin.settings.security.update') }}" method="POST">
            @csrf
            @method('PATCH')
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Session Timeout (minutes)</label>
                    <input type="number" name="session_timeout" value="120" min="15" max="1440"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Max Login Attempts</label>
                    <input type="number" name="max_login_attempts" value="5" min="3" max="10"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white">
                </div>

                <div class="space-y-3">
                    <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                        <input type="checkbox" name="require_email_verification" value="1" checked class="w-4 h-4 rounded text-purple-500">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Require email verification</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                        <input type="checkbox" name="force_password_change" value="1" class="w-4 h-4 rounded text-purple-500">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Force password change (90 days)</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-pink-600 text-white px-6 py-3 rounded-lg hover:shadow-lg hover:shadow-purple-500/30 font-semibold transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    Save Security Settings
                </button>
            </div>
        </form>
    </div>

    <!-- Content Settings -->
    <div class="bg-gradient-to-br from-white to-orange-50/30 dark:from-gray-800 dark:to-orange-950/20 rounded-2xl border border-orange-100 dark:border-orange-900/30 p-6 shadow-lg shadow-orange-500/5">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-red-600 flex items-center justify-center shadow-lg">
                <span class="material-symbols-outlined text-white text-2xl">article</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Content Settings</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Configure content options</p>
            </div>
        </div>

        <form action="{{ route('admin.settings.content.update') }}" method="POST">
            @csrf
            @method('PATCH')
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Items Per Page</label>
                    <select name="items_per_page" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white">
                        <option value="10">10</option>
                        <option value="20" selected>20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Max Upload Size (MB)</label>
                    <input type="number" name="max_upload_size" value="10" min="1" max="100"
                        class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white">
                </div>

                <div class="space-y-3">
                    <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                        <input type="checkbox" name="allow_comments" value="1" checked class="w-4 h-4 rounded text-orange-500">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Allow comments on content</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                        <input type="checkbox" name="moderate_comments" value="1" class="w-4 h-4 rounded text-orange-500">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Moderate comments before publishing</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-red-600 text-white px-6 py-3 rounded-lg hover:shadow-lg hover:shadow-orange-500/30 font-semibold transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    Save Content Settings
                </button>
            </div>
        </form>
    </div>

    <!-- Video Call Settings -->
    <div class="bg-gradient-to-br from-white to-indigo-50/30 dark:from-gray-800 dark:to-indigo-950/20 rounded-2xl border border-indigo-100 dark:border-indigo-900/30 p-6 shadow-lg shadow-indigo-500/5">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg">
                <span class="material-symbols-outlined text-white text-2xl">videocam</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Video Call Settings</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Configure video calling services</p>
            </div>
        </div>

        <form action="{{ route('admin.settings.video.update') }}" method="POST">
            @csrf
            @method('PATCH')
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Default Video Service</label>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 p-4 bg-white dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700 cursor-pointer hover:border-indigo-300 transition-colors">
                            <input type="radio" name="default_video_provider" value="jitsi" 
                                {{ config('video_calls.default_provider', 'jitsi') === 'jitsi' ? 'checked' : '' }}
                                class="w-4 h-4 text-indigo-500 focus:ring-indigo-500">
                            <div class="flex items-center gap-3 flex-1">
                                <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-indigo-600 dark:text-indigo-400 text-sm">videocam</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Jitsi Meet</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Open source, fully embeddable, no API keys required</p>
                                </div>
                                <span class="text-xs bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300 px-2 py-1 rounded-full font-medium">Recommended</span>
                            </div>
                        </label>
                        
                        <label class="flex items-center gap-3 p-4 bg-white dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700 cursor-pointer hover:border-indigo-300 transition-colors">
                            <input type="radio" name="default_video_provider" value="google_meet" 
                                {{ config('video_calls.default_provider') === 'google_meet' ? 'checked' : '' }}
                                class="w-4 h-4 text-indigo-500 focus:ring-indigo-500">
                            <div class="flex items-center gap-3 flex-1">
                                <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-sm">video_call</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Google Meet</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Professional video conferencing, requires Google account</p>
                                </div>
                            </div>
                        </label>
                        
                        <label class="flex items-center gap-3 p-4 bg-white dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700 cursor-pointer hover:border-indigo-300 transition-colors">
                            <input type="radio" name="default_video_provider" value="zoom" 
                                {{ config('video_calls.default_provider') === 'zoom' ? 'checked' : '' }}
                                class="w-4 h-4 text-indigo-500 focus:ring-indigo-500">
                            <div class="flex items-center gap-3 flex-1">
                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-sm">videocam</span>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">Zoom</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Enterprise video conferencing, requires API keys</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                        <input type="checkbox" name="auto_embed_video" value="1" 
                            {{ config('video_calls.auto_embed', true) ? 'checked' : '' }}
                            class="w-4 h-4 rounded text-indigo-500">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Auto-embed video calls in sessions</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                        <input type="checkbox" name="fallback_to_external" value="1" 
                            {{ config('video_calls.fallback_to_external', true) ? 'checked' : '' }}
                            class="w-4 h-4 rounded text-indigo-500">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Fallback to external links if embedding fails</span>
                    </label>
                    <label class="flex items-center gap-3 p-3 bg-white dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                        <input type="checkbox" name="enable_session_recording" value="1" 
                            {{ config('video_calls.session_recording', false) ? 'checked' : '' }}
                            class="w-4 h-4 rounded text-indigo-500">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Enable session recording (where supported)</span>
                    </label>
                </div>

                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-lg mt-0.5">info</span>
                        <div>
                            <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-100 mb-1">Service Configuration</h4>
                            <p class="text-xs text-blue-800 dark:text-blue-200 mb-2">
                                To use Google Meet or Zoom, you'll need to configure API keys in your environment file (.env).
                            </p>
                            <div class="text-xs text-blue-700 dark:text-blue-300 space-y-1">
                                <p><strong>Jitsi:</strong> No configuration needed - works out of the box</p>
                                <p><strong>Google Meet:</strong> Requires GOOGLE_MEET_API_KEY and GOOGLE_MEET_CLIENT_ID</p>
                                <p><strong>Zoom:</strong> Requires ZOOM_SDK_KEY and ZOOM_SDK_SECRET</p>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-3 rounded-lg hover:shadow-lg hover:shadow-indigo-500/30 font-semibold transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    Save Video Call Settings
                </button>
            </div>
        </form>
    </div>
</div>

<!-- System Information -->
<div class="mt-6 bg-gradient-to-br from-white to-gray-50/30 dark:from-gray-800 dark:to-gray-950/20 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 shadow-lg">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-gray-600 dark:text-gray-400">info</span>
        System Information
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="p-4 bg-white dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Laravel Version</p>
            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ app()->version() }}</p>
        </div>
        <div class="p-4 bg-white dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">PHP Version</p>
            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ PHP_VERSION }}</p>
        </div>
        <div class="p-4 bg-white dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">Environment</p>
            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ config('app.env') }}</p>
        </div>
    </div>
</div>
@endsection
