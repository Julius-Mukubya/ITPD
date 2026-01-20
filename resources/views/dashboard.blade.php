@extends('layouts.app')

@section('title', 'Dashboard - WellPath')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Welcome Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
            Welcome back, {{ auth()->user()->name }}! 👋
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-400">
            Your account is ready. Contact an administrator to unlock full platform access.
        </p>
    </div>

    <!-- Role Assignment Notice -->
    <div class="relative overflow-hidden bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 border-2 border-yellow-300 dark:border-yellow-700 rounded-2xl p-6 mb-8 shadow-sm">
        <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-200 dark:bg-yellow-800 rounded-full -mr-16 -mt-16 opacity-20"></div>
        <div class="absolute bottom-0 left-0 w-24 h-24 bg-orange-200 dark:bg-orange-800 rounded-full -ml-12 -mb-12 opacity-20"></div>
        <div class="relative flex items-start gap-4">
            <div class="flex-shrink-0 w-12 h-12 bg-yellow-100 dark:bg-yellow-800/50 rounded-xl flex items-center justify-center">
                <span class="material-symbols-outlined text-yellow-600 dark:text-yellow-400 text-2xl">info</span>
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold text-yellow-900 dark:text-yellow-100 mb-2">Role Assignment Pending</h3>
                <p class="text-yellow-800 dark:text-yellow-200 mb-4">
                    Your account needs to be assigned a role (User, Counselor, or Admin) to access the full platform features.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="#contact" class="inline-flex items-center gap-2 bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        <span class="material-symbols-outlined text-sm">mail</span>
                        Contact Admin
                    </a>
                    <a href="{{ route('profile.show') }}" class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 text-yellow-900 dark:text-yellow-100 px-4 py-2 rounded-lg font-medium border border-yellow-300 dark:border-yellow-700 transition-colors">
                        <span class="material-symbols-outlined text-sm">person</span>
                        Complete Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Available Actions -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">What You Can Do</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Explore these features while your role is being assigned</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        <a href="{{ route('content.index') }}" class="group bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:shadow-primary/10 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-primary to-blue-600"></div>
            <div class="flex items-start justify-between mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-primary/10 to-blue-100 dark:from-primary/20 dark:to-blue-900/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <span class="material-symbols-outlined text-primary text-2xl">library_books</span>
                </div>
                <span class="material-symbols-outlined text-gray-400 group-hover:text-primary group-hover:translate-x-1 transition-all duration-300">arrow_forward</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 group-hover:text-primary transition-colors">Browse Resources</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                Explore educational content, articles, and mental health resources available to everyone.
            </p>
        </a>

        <a href="{{ route('profile.show') }}" class="group bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:shadow-green-500/10 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-green-600"></div>
            <div class="flex items-start justify-between mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <span class="material-symbols-outlined text-green-600 text-2xl">person</span>
                </div>
                <span class="material-symbols-outlined text-gray-400 group-hover:text-green-600 group-hover:translate-x-1 transition-all duration-300">arrow_forward</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 group-hover:text-green-600 transition-colors">Update Profile</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                Complete your profile information, preferences, and personal details.
            </p>
        </a>

        <a href="{{ route('campaigns.index') }}" class="group bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-6 hover:shadow-lg hover:shadow-blue-500/10 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-blue-600"></div>
            <div class="flex items-start justify-between mb-4">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <span class="material-symbols-outlined text-blue-600 text-2xl">campaign</span>
                </div>
                <span class="material-symbols-outlined text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all duration-300">arrow_forward</span>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2 group-hover:text-blue-600 transition-colors">View Campaigns</h3>
            <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed">
                Check out active awareness campaigns, events, and community initiatives.
            </p>
        </a>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-12">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 text-center">
            <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center mx-auto mb-2">
                <span class="material-symbols-outlined text-primary">groups</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($total_users ?? 0) }}{{ ($total_users ?? 0) > 0 ? '+' : '' }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">Platform Users</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 text-center">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                <span class="material-symbols-outlined text-green-600">library_books</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $total_resources ?? 0 }}{{ ($total_resources ?? 0) > 0 ? '+' : '' }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">Resources Available</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 text-center">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                <span class="material-symbols-outlined text-blue-600">psychology</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $total_counselors ?? 0 }}{{ ($total_counselors ?? 0) > 0 ? '+' : '' }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">Professional Counselors</p>
        </div>
    </div>

    <!-- Contact Information -->
    <div id="contact" class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-8 border border-gray-200 dark:border-gray-700">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-primary text-3xl">support_agent</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Need Help?</h3>
            <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">
                Our support team is here to help with your account setup and role assignment.
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl mx-auto">
            <a href="mailto:{{ $support_email ?? 'admin@wellpath.com' }}" class="flex items-center gap-4 bg-white dark:bg-gray-800 rounded-xl p-4 hover:shadow-md transition-shadow border border-gray-200 dark:border-gray-700">
                <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary">email</span>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white">Email Support</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $support_email ?? 'admin@wellpath.com' }}</p>
                </div>
            </a>
            
            <a href="tel:{{ str_replace(' ', '', $support_phone ?? '+256XXXXXXX') }}" class="flex items-center gap-4 bg-white dark:bg-gray-800 rounded-xl p-4 hover:shadow-md transition-shadow border border-gray-200 dark:border-gray-700">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-green-600">phone</span>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white">Phone Support</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $support_phone ?? '+256 XXX XXX XXX' }}</p>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-6">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                Response time: Usually within 24 hours
            </p>
        </div>
    </div>
</div>
@endsection
