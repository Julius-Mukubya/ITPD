@extends('layouts.admin')

@section('title', 'System Settings - Admin')

@section('content')
<div class="space-y-8">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">System Settings</h2>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Configure application settings and preferences</p>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="exportSettings()" class="inline-flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/90 transition-colors">
                <span class="material-symbols-outlined text-sm">download</span>
                Export Settings
            </button>
        </div>
    </div>


    <!-- Settings Cards Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- General Settings -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-xl">settings</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">General Settings</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Basic application configuration</p>
                </div>
            </div>

            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Application Name</label>
                        <input type="text" name="app_name" value="{{ config('app.name') }}" 
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Timezone</label>
                        <select name="timezone" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary dark:bg-gray-700 dark:text-white">
                            <option value="UTC">UTC</option>
                            <option value="Africa/Kampala" selected>Africa/Kampala (EAT)</option>
                            <option value="Africa/Nairobi">Africa/Nairobi (EAT)</option>
                        </select>
                    </div>

                    <div>
                        <label class="flex items-center gap-3 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700 cursor-pointer hover:border-primary/30 transition-colors">
                            <input type="checkbox" name="maintenance_mode" value="1" class="w-5 h-5 rounded text-primary focus:ring-primary/20">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">Maintenance Mode</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Temporarily disable public access</p>
                            </div>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary/90 font-medium transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-sm">save</span>
                        Save General Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Email Settings -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-xl">mail</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Email Settings</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Configure email notifications</p>
                </div>
            </div>

            <form action="{{ route('admin.settings.email.update') }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">From Email</label>
                        <input type="email" name="mail_from" value="{{ config('mail.from.address') }}" 
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">From Name</label>
                        <input type="text" name="mail_from_name" value="{{ config('mail.from.name') }}" 
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary dark:bg-gray-700 dark:text-white">
                    </div>

                    <div class="space-y-3">
                        <label class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                            <input type="checkbox" name="notify_new_user" value="1" checked class="w-4 h-4 rounded text-primary focus:ring-primary/20">
                            <span class="text-sm text-gray-700 dark:text-gray-300">New user registration</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                            <input type="checkbox" name="notify_counseling" value="1" checked class="w-4 h-4 rounded text-primary focus:ring-primary/20">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Counseling requests</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary/90 font-medium transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-sm">save</span>
                        Save Email Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Security Settings -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-purple-600 dark:text-purple-400 text-xl">shield</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Security Settings</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Manage security options</p>
                </div>
            </div>

            <form action="{{ route('admin.settings.security.update') }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Session Timeout (minutes)</label>
                        <input type="number" name="session_timeout" value="120" min="15" max="1440"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary dark:bg-gray-700 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max Login Attempts</label>
                        <input type="number" name="max_login_attempts" value="5" min="3" max="10"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary dark:bg-gray-700 dark:text-white">
                    </div>

                    <div class="space-y-3">
                        <label class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                            <input type="checkbox" name="require_email_verification" value="1" checked class="w-4 h-4 rounded text-primary focus:ring-primary/20">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Require email verification</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                            <input type="checkbox" name="force_password_change" value="1" class="w-4 h-4 rounded text-primary focus:ring-primary/20">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Force password change (90 days)</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary/90 font-medium transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-sm">save</span>
                        Save Security Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Content Settings -->
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/30 rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-orange-600 dark:text-orange-400 text-xl">article</span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Content Settings</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Configure content options</p>
                </div>
            </div>

            <form action="{{ route('admin.settings.content.update') }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Items Per Page</label>
                        <select name="items_per_page" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary dark:bg-gray-700 dark:text-white">
                            <option value="10">10</option>
                            <option value="20" selected>20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max Upload Size (MB)</label>
                        <input type="number" name="max_upload_size" value="10" min="1" max="100"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary dark:bg-gray-700 dark:text-white">
                    </div>

                    <div class="space-y-3">
                        <label class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                            <input type="checkbox" name="allow_comments" value="1" checked class="w-4 h-4 rounded text-primary focus:ring-primary/20">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Allow comments on content</span>
                        </label>
                        <label class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                            <input type="checkbox" name="moderate_comments" value="1" class="w-4 h-4 rounded text-primary focus:ring-primary/20">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Moderate comments before publishing</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full bg-primary text-white px-6 py-3 rounded-lg hover:bg-primary/90 font-medium transition-colors flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-sm">save</span>
                        Save Content Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- System Information -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 bg-gray-100 dark:bg-gray-900/30 rounded-lg flex items-center justify-center">
                <span class="material-symbols-outlined text-gray-600 dark:text-gray-400 text-xl">info</span>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">System Information</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Current system status and version details</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Laravel Version</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ app()->version() }}</p>
            </div>
            <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">PHP Version</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ PHP_VERSION }}</p>
            </div>
            <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Environment</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ config('app.env') }}</p>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Notifications -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4 sm:mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-lg sm:text-xl">notifications_active</span>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">Recent System Activity</h3>
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Latest system events and notifications</p>
                </div>
            </div>
            <a href="{{ route('notifications.index') }}" class="inline-flex items-center gap-2 text-primary hover:text-primary/80 font-medium text-sm">
                <span class="hidden sm:inline">View All</span>
                <span class="sm:hidden">View All</span>
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>
        
        <div id="recentActivity" class="space-y-3 sm:space-y-4">
            <!-- Activity items will be loaded here -->
            <div class="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-sm">person_add</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white">New user registered</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ now()->subMinutes(5)->diffForHumans() }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-sm">campaign</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white">New campaign created</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ now()->subHour()->diffForHumans() }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3 sm:gap-4 p-3 sm:p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="material-symbols-outlined text-purple-600 dark:text-purple-400 text-sm">support_agent</span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white">Counseling session completed</p>
                    <p class="text-xs text-gray-600 dark:text-gray-400">{{ now()->subHours(2)->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function exportSettings() {
    // Create a simple settings export
    const settings = {
        exported_at: new Date().toISOString(),
        app_name: '{{ config("app.name") }}',
        environment: '{{ config("app.env") }}',
        laravel_version: '{{ app()->version() }}',
        php_version: '{{ PHP_VERSION }}',
        export_note: 'Settings exported from admin panel'
    };
    
    const dataStr = JSON.stringify(settings, null, 2);
    const dataBlob = new Blob([dataStr], {type: 'application/json'});
    
    const link = document.createElement('a');
    link.href = URL.createObjectURL(dataBlob);
    link.download = 'system_settings_' + new Date().toISOString().split('T')[0] + '.json';
    link.click();
}

// Load recent activity dynamically
document.addEventListener('DOMContentLoaded', function() {
    // This would typically fetch from an API endpoint
    // For now, we'll show static content as implemented above
    console.log('Settings page loaded');
});
</script>
@endsection
