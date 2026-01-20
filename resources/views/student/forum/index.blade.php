@extends('layouts.student')

@section('title', 'Forum - Student')

@section('content')
<!-- PageHeading -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-2xl sm:text-3xl font-bold tracking-tight">Community Forum</p>
        <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">Connect with peers and share experiences</p>
    </div>
    <a href="{{ route('student.forum.create') }}" class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white text-sm font-semibold px-6 py-3 rounded-xl flex items-center justify-center gap-2 hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-200 w-full sm:w-auto">
        <span class="material-symbols-outlined text-lg">add</span>
        New Post
    </a>
</div>

<!-- Categories -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Mental Health</p>
                <p class="text-3xl font-bold">0</p>
                <div class="flex items-center mt-2">
                    <span class="material-symbols-outlined text-sm mr-1">forum</span>
                    <span class="text-sm">Posts</span>
                </div>
            </div>
            <div class="bg-white/20 rounded-lg p-3">
                <span class="material-symbols-outlined text-2xl">psychology</span>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium">Academic Support</p>
                <p class="text-3xl font-bold">0</p>
                <div class="flex items-center mt-2">
                    <span class="material-symbols-outlined text-sm mr-1">forum</span>
                    <span class="text-sm">Posts</span>
                </div>
            </div>
            <div class="bg-white/20 rounded-lg p-3">
                <span class="material-symbols-outlined text-2xl">school</span>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-purple-100 text-sm font-medium">Peer Support</p>
                <p class="text-3xl font-bold">0</p>
                <div class="flex items-center mt-2">
                    <span class="material-symbols-outlined text-sm mr-1">forum</span>
                    <span class="text-sm">Posts</span>
                </div>
            </div>
            <div class="bg-white/20 rounded-lg p-3">
                <span class="material-symbols-outlined text-2xl">groups</span>
            </div>
        </div>
    </div>
</div>

<!-- Empty State -->
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center shadow-sm">
    <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
        <span class="material-symbols-outlined text-5xl text-gray-400">forum</span>
    </div>
    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Start a Conversation</h3>
    <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
        No posts yet. Be the first to start a discussion and connect with your peers!
    </p>
    <a href="{{ route('student.forum.create') }}" class="inline-flex items-center gap-2 bg-primary text-white px-8 py-3 rounded-xl font-semibold hover:opacity-90 transition-all">
        <span class="material-symbols-outlined">add</span>
        Create First Post
    </a>
</div>
@endsection
