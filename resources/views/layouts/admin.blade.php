<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'WellPath - Admin Dashboard')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#10b77f",
                        "background-light": "#f6f8f7",
                        "background-dark": "#10221c",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            font-size: 24px;
        }
    </style>
    @stack('styles')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-background-light dark:bg-background-dark font-display">
    <!-- Mobile Overlay -->
    <div id="mobileOverlay" class="lg:hidden fixed inset-0 bg-black/60 z-40 hidden transition-opacity duration-300"></div>

    <!-- Mobile Header -->
    <div class="lg:hidden sticky top-0 z-30 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-b border-emerald-100 dark:border-emerald-900/30 px-4 py-3 shadow-sm">
        <div class="flex items-center gap-3">
            <button id="mobileMenuBtn" class="text-gray-700 dark:text-gray-300 p-2.5 rounded-xl border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-800 transition-all duration-200">
                <span class="material-symbols-outlined text-xl">menu</span>
            </button>
            
            <!-- Search Bar -->
            <div class="flex-1 relative" id="mobileSearchContainer">
                <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 text-lg">search</span>
                <input 
                    id="mobileSearchInput"
                    class="w-full pl-9 pr-3 py-2 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-primary focus:border-primary" 
                    placeholder="Search..." 
                    type="text"
                    autocomplete="off"
                />
                
                <!-- Mobile Search Results -->
                <div id="mobileSearchResults" class="absolute top-full left-0 right-0 mt-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg max-h-96 overflow-y-auto z-50 hidden">
                    <div id="mobileSearchResultsContent" class="p-2">
                        <!-- Results will be populated here -->
                    </div>
                </div>
            </div>

            <!-- Notifications Icon -->
            <div class="relative" id="mobileNotificationContainer">
                <button 
                    id="mobileNotificationBtn"
                    class="p-2 text-gray-700 dark:text-gray-300 rounded-full hover:bg-emerald-50 dark:hover:bg-emerald-900/20 relative transition-colors"
                >
                    <span class="material-symbols-outlined">notifications</span>
                    @if(auth()->user()->unreadNotificationsCount() > 0)
                        <span id="mobileNotificationBadge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {{ auth()->user()->unreadNotificationsCount() }}
                        </span>
                    @endif
                </button>
                
                <!-- Mobile Notification Dropdown -->
                <div id="mobileNotificationDropdown" class="absolute right-0 top-full mt-2 w-80 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 opacity-0 invisible transition-all duration-200 z-50">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Notifications</h3>
                            <a href="{{ route('notifications.mark-all-read') }}" 
                               class="text-xs text-primary hover:underline"
                               onclick="event.preventDefault(); markAllAsRead();">
                                Mark all read
                            </a>
                        </div>
                    </div>
                    <div id="mobileNotificationList" class="max-h-64 overflow-y-auto">
                        <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                            <div class="animate-spin w-5 h-5 border-2 border-primary border-t-transparent rounded-full mx-auto mb-2"></div>
                            Loading notifications...
                        </div>
                    </div>
                    <div class="p-3 border-t border-gray-200 dark:border-gray-700">
                        <a href="{{ route('notifications.index') }}" 
                           class="block text-center text-sm text-primary hover:underline">
                            View all notifications
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile Icon -->
            <div class="relative group">
                <button class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="size-9 sm:size-10 rounded-full object-cover border-2 border-primary">
                    @else
                        <div class="size-9 sm:size-10 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-sm font-bold text-white border-2 border-primary">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                    @endif
                    <span class="material-symbols-outlined text-sm text-gray-700 dark:text-gray-300">expand_more</span>
                </button>
                <div class="absolute right-0 top-full mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                    <div class="p-3 border-b border-gray-200 dark:border-gray-700">
                        <p class="text-sm font-semibold text-[#111816] dark:text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="p-2">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <span class="material-symbols-outlined text-blue-600">public</span>
                            <span>View Site</span>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <span class="material-symbols-outlined text-blue-600">person</span>
                            <span>Profile Settings</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" id="logoutFormDropdown">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                <span class="material-symbols-outlined">logout</span>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="relative flex min-h-screen w-full">
        <!-- Enhanced Sidebar -->
        <aside id="sidebar" class="fixed lg:sticky top-0 h-screen flex-col bg-white dark:bg-gray-900 border-r border-emerald-100 dark:border-emerald-900/30 w-64 flex transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40 shadow-xl shadow-emerald-500/5">
            <div class="flex h-full flex-col justify-between p-4">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-3 px-3">
                        <div class="size-10 flex-shrink-0">
                            <img src="{{ asset('images/leaf-logo.svg') }}" alt="WellPath Logo" class="w-full h-full">
                        </div>
                        <div class="flex flex-col">
                            <h1 class="text-gray-900 dark:text-white text-base font-medium leading-normal">WellPath</h1>
                            <p class="text-gray-500 dark:text-gray-400 text-sm font-normal leading-normal">Admin Panel</p>
                        </div>
                    </div>
                    <nav class="flex flex-col gap-2 mt-4">
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('admin.dashboard') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('admin.dashboard') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">dashboard</span>
                            <p class="{{ request()->routeIs('admin.dashboard') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Dashboard</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.contents.*') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('admin.contents.index') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('admin.contents.*') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">article</span>
                            <p class="{{ request()->routeIs('admin.contents.*') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Content</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.assessments.*') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('admin.assessments.index') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('admin.assessments.*') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">psychology</span>
                            <p class="{{ request()->routeIs('admin.assessments.*') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Assessments</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('admin.users.index') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('admin.users.*') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">group</span>
                            <p class="{{ request()->routeIs('admin.users.*') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Users</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.counseling.*') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('admin.counseling.index') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('admin.counseling.*') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">support_agent</span>
                            <p class="{{ request()->routeIs('admin.counseling.*') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Counseling</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.campaigns.*') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('admin.campaigns.index') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('admin.campaigns.*') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">campaign</span>
                            <p class="{{ request()->routeIs('admin.campaigns.*') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Campaigns</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.content-flags.*') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('admin.content-flags.index') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('admin.content-flags.*') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">flag</span>
                            <p class="{{ request()->routeIs('admin.content-flags.*') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Content Flags</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('admin.reports.*') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('admin.reports.index') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('admin.reports.*') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">summarize</span>
                            <p class="{{ request()->routeIs('admin.reports.*') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Reports</p>
                        </a>
                    </nav>
                </div>
                <div class="flex flex-col gap-2 border-t border-emerald-100 dark:border-emerald-900/30 pt-4">
                    <!-- Dark Mode Toggle -->
                    <button id="darkModeToggle" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all duration-200">
                        <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400" id="darkModeIcon">dark_mode</span>
                        <p class="text-gray-700 dark:text-gray-300 text-sm font-medium">Dark Mode</p>
                        <div class="ml-auto">
                            <div class="relative inline-block w-10 h-6 transition duration-200 ease-in-out bg-gray-300 dark:bg-emerald-600 rounded-full">
                                <span class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform duration-200 dark:translate-x-4"></span>
                            </div>
                        </div>
                    </button>

                    <a class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all duration-200" href="{{ route('home') }}">
                        <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">public</span>
                        <p class="text-gray-700 dark:text-gray-300 text-sm font-medium">View Site</p>
                    </a>

                    <a class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all duration-200" href="{{ route('admin.settings.index') }}">
                        <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400">settings</span>
                        <p class="text-gray-700 dark:text-gray-300 text-sm font-medium">Settings</p>
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-red-50 dark:hover:bg-red-900/20 transition-all duration-200">
                            <span class="material-symbols-outlined text-red-600 dark:text-red-400">logout</span>
                            <p class="text-gray-700 dark:text-gray-300 text-sm font-medium">Logout</p>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col">
            <!-- ToolBar -->
            <header class="sticky top-0 z-10 flex justify-between items-center gap-2 px-4 md:px-8 py-3 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-sm border-b border-gray-200 dark:border-gray-700 hidden lg:flex">
                <div class="flex items-center gap-4">
                    <div class="relative" id="searchContainer">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                        <input 
                            id="searchInput"
                            class="w-full max-w-xs pl-10 pr-4 py-2 text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-primary focus:border-primary" 
                            placeholder="Search users, content, sessions..." 
                            type="text"
                            autocomplete="off"
                        />
                        
                        <!-- Search Results Dropdown -->
                        <div id="searchResults" class="absolute top-full left-0 right-0 mt-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg max-h-96 overflow-y-auto z-50 hidden">
                            <div id="searchResultsContent" class="p-2">
                                <!-- Results will be populated here -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <!-- Notification Dropdown -->
                    <div class="relative" id="notificationContainer">
                        <button 
                            id="notificationBtn"
                            class="p-2 text-gray-700 dark:text-gray-300 rounded-full hover:bg-gray-200 dark:hover:bg-white/10 relative transition-colors"
                        >
                            <span class="material-symbols-outlined">notifications</span>
                            @if(auth()->user()->unreadNotificationsCount() > 0)
                                <span id="notificationBadge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ auth()->user()->unreadNotificationsCount() }}
                                </span>
                            @endif
                        </button>
                        
                        <!-- Notification Dropdown -->
                        <div id="notificationDropdown" class="absolute right-0 top-full mt-2 w-80 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 opacity-0 invisible transition-all duration-200 z-50">
                            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white">Notifications</h3>
                                    <a href="{{ route('notifications.mark-all-read') }}" 
                                       class="text-xs text-primary hover:underline"
                                       onclick="event.preventDefault(); markAllAsRead();">
                                        Mark all read
                                    </a>
                                </div>
                            </div>
                            <div id="notificationList" class="max-h-64 overflow-y-auto">
                                <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                                    <div class="animate-spin w-5 h-5 border-2 border-primary border-t-transparent rounded-full mx-auto mb-2"></div>
                                    Loading notifications...
                                </div>
                            </div>
                            <div class="p-3 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('notifications.index') }}" 
                                   class="block text-center text-sm text-primary hover:underline">
                                    View all notifications
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative group">
                        <button class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="size-9 sm:size-10 rounded-full object-cover border-2 border-primary">
                            @else
                                <div class="size-9 sm:size-10 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-sm font-bold text-white border-2 border-primary">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </div>
                            @endif
                            <span class="material-symbols-outlined text-sm text-gray-700 dark:text-gray-300">expand_more</span>
                        </button>
                        <div class="absolute right-0 top-full mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="p-3 border-b border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-semibold text-[#111816] dark:text-white truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="p-2">
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-blue-600">person</span>
                                    <span>Profile Settings</span>
                                </a>
                                <form method="POST" action="{{ route('logout') }}" id="logoutFormMobile">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined">logout</span>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex-1 p-4 md:p-6 lg:p-8 space-y-6 md:space-y-8 overflow-y-auto">
                @yield('content')
            </div>
            
            <!-- Toast Notifications -->
            @include('components.toast-notifications')
        </main>
    </div>

    <!-- Delete Confirmation Modal -->
    @include('components.delete-confirmation-modal')

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('sidebar');
        const mobileOverlay = document.getElementById('mobileOverlay');

        function toggleMobileMenu() {
            sidebar?.classList.toggle('-translate-x-full');
            mobileOverlay?.classList.toggle('hidden');
        }

        mobileMenuBtn?.addEventListener('click', toggleMobileMenu);
        mobileOverlay?.addEventListener('click', toggleMobileMenu);

        // Handle sidebar on window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                // Desktop: show sidebar and hide overlay
                sidebar?.classList.remove('-translate-x-full');
                mobileOverlay?.classList.add('hidden');
            } else {
                // Mobile: hide sidebar
                sidebar?.classList.add('-translate-x-full');
                mobileOverlay?.classList.add('hidden');
            }
        });

        // Dark Mode Toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const mobileDarkModeToggle = document.getElementById('mobileDarkModeToggle');
        const darkModeIcon = document.getElementById('darkModeIcon');
        const mobileDarkModeIcon = document.getElementById('mobileDarkModeIcon');
        const html = document.documentElement;

        // Check for saved theme preference or default to light mode
        const currentTheme = localStorage.getItem('theme') || 'light';
        if (currentTheme === 'dark') {
            html.classList.add('dark');
            if (darkModeIcon) darkModeIcon.textContent = 'light_mode';
            if (mobileDarkModeIcon) mobileDarkModeIcon.textContent = 'light_mode';
        }

        function toggleDarkMode() {
            html.classList.toggle('dark');
            
            if (html.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
                if (darkModeIcon) darkModeIcon.textContent = 'light_mode';
                if (mobileDarkModeIcon) mobileDarkModeIcon.textContent = 'light_mode';
            } else {
                localStorage.setItem('theme', 'light');
                if (darkModeIcon) darkModeIcon.textContent = 'dark_mode';
                if (mobileDarkModeIcon) mobileDarkModeIcon.textContent = 'dark_mode';
            }
        }

        darkModeToggle?.addEventListener('click', toggleDarkMode);

        // Handle logout with fresh CSRF token
        function handleLogout(formId) {
            const form = document.getElementById(formId);
            if (form) {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    
                    try {
                        // Get fresh CSRF token
                        const response = await fetch('/csrf-token', {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                            }
                        });
                        
                        if (response.ok) {
                            const data = await response.json();
                            // Update CSRF token in form
                            const csrfInput = form.querySelector('input[name="_token"]');
                            if (csrfInput) {
                                csrfInput.value = data.csrf_token;
                            }
                        }
                    } catch (error) {
                        console.log('Could not refresh CSRF token, proceeding with existing token');
                    }
                    
                    // Submit the form
                    form.submit();
                });
            }
        }

        // Initialize logout handlers
        handleLogout('logoutForm');
        handleLogout('logoutFormDropdown');
        handleLogout('logoutFormMobile');

        // Search functionality
        let searchTimeout;
        const searchInput = document.getElementById('searchInput');
        const mobileSearchInput = document.getElementById('mobileSearchInput');
        const searchResults = document.getElementById('searchResults');
        const mobileSearchResults = document.getElementById('mobileSearchResults');
        const searchResultsContent = document.getElementById('searchResultsContent');
        const mobileSearchResultsContent = document.getElementById('mobileSearchResultsContent');

        function performSearch(query, resultsContainer, contentContainer) {
            if (query.length < 2) {
                resultsContainer.classList.add('hidden');
                return;
            }

            // Show loading
            contentContainer.innerHTML = `
                <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                    <div class="animate-spin w-5 h-5 border-2 border-primary border-t-transparent rounded-full mx-auto mb-2"></div>
                    Searching...
                </div>
            `;
            resultsContainer.classList.remove('hidden');

            fetch(`{{ route('admin.search') }}?q=${encodeURIComponent(query)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        contentContainer.innerHTML = `
                            <div class="p-4 text-center text-red-500">
                                <span class="material-symbols-outlined text-2xl mb-2 block">error</span>
                                ${data.error}
                            </div>
                        `;
                    } else if (data.results.length === 0) {
                        contentContainer.innerHTML = `
                            <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                                <span class="material-symbols-outlined text-2xl mb-2 block">search_off</span>
                                No results found for "${query}"
                            </div>
                        `;
                    } else {
                        contentContainer.innerHTML = data.results.map(result => {
                            const getTypeColor = (type) => {
                                const colors = {
                                    'user': 'blue',
                                    'content': 'purple', 
                                    'assessment': 'emerald',
                                    'campaign': 'teal',
                                    'session': 'indigo',
                                    'no-results': 'gray',
                                    'error': 'red'
                                };
                                return colors[type] || 'gray';
                            };
                            
                            const color = getTypeColor(result.type);
                            const isClickable = result.url !== '#';
                            
                            return `
                                <${isClickable ? 'a href="' + result.url + '"' : 'div'} class="flex items-center gap-3 p-3 ${isClickable ? 'hover:bg-gray-50 dark:hover:bg-gray-700' : ''} rounded-lg transition-colors">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-${color}-100 dark:bg-${color}-900/20">
                                        <span class="material-symbols-outlined text-sm text-${color}-600 dark:text-${color}-400">${result.icon}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">${result.title}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">${result.subtitle}</p>
                                    </div>
                                    <span class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded-full">${result.badge}</span>
                                </${isClickable ? 'a' : 'div'}>
                            `;
                        }).join('');
                    }
                })
                .catch(error => {
                    console.error('Search error:', error);
                    contentContainer.innerHTML = `
                        <div class="p-4 text-center text-red-500">
                            <span class="material-symbols-outlined text-2xl mb-2 block">error</span>
                            Search failed: ${error.message}
                        </div>
                    `;
                });
        }

        // Desktop search
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();
                
                searchTimeout = setTimeout(() => {
                    performSearch(query, searchResults, searchResultsContent);
                }, 300);
            });

            searchInput.addEventListener('focus', function() {
                if (this.value.trim().length >= 2) {
                    searchResults.classList.remove('hidden');
                }
            });
        }

        // Mobile search
        if (mobileSearchInput) {
            mobileSearchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const query = this.value.trim();
                
                searchTimeout = setTimeout(() => {
                    performSearch(query, mobileSearchResults, mobileSearchResultsContent);
                }, 300);
            });

            mobileSearchInput.addEventListener('focus', function() {
                if (this.value.trim().length >= 2) {
                    mobileSearchResults.classList.remove('hidden');
                }
            });
        }

        // Hide search results when clicking outside
        document.addEventListener('click', function(e) {
            if (!document.getElementById('searchContainer')?.contains(e.target)) {
                searchResults?.classList.add('hidden');
            }
            if (!document.getElementById('mobileSearchContainer')?.contains(e.target)) {
                mobileSearchResults?.classList.add('hidden');
            }
        });

        // Notification dropdown functionality
        const notificationBtn = document.getElementById('notificationBtn');
        const mobileNotificationBtn = document.getElementById('mobileNotificationBtn');
        const notificationDropdown = document.getElementById('notificationDropdown');
        const mobileNotificationDropdown = document.getElementById('mobileNotificationDropdown');
        const notificationList = document.getElementById('notificationList');
        const mobileNotificationList = document.getElementById('mobileNotificationList');

        function loadNotifications(listContainer) {
            fetch('{{ route('notifications.dropdown') }}')
                .then(response => response.json())
                .then(data => {
                    if (data.notifications.length === 0) {
                        listContainer.innerHTML = `
                            <div class="p-4 text-center text-gray-500 dark:text-gray-400">
                                <span class="material-symbols-outlined text-2xl mb-2 block">notifications_off</span>
                                No new notifications
                            </div>
                        `;
                    } else {
                        listContainer.innerHTML = data.notifications.map(notification => `
                            <a href="${notification.url}" class="flex items-center gap-3 p-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-${notification.color}-100 dark:bg-${notification.color}-900/20">
                                    <span class="material-symbols-outlined text-sm text-${notification.color}-600 dark:text-${notification.color}-400">${notification.icon}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white truncate">${notification.title}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">${notification.message}</p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">${timeAgo(notification.created_at)}</p>
                                </div>
                            </a>
                        `).join('');
                    }
                })
                .catch(error => {
                    console.error('Notification loading error:', error);
                    listContainer.innerHTML = `
                        <div class="p-4 text-center text-red-500">
                            <span class="material-symbols-outlined text-2xl mb-2 block">error</span>
                            Failed to load notifications
                        </div>
                    `;
                });
        }

        function toggleNotificationDropdown(dropdown, listContainer) {
            const isVisible = !dropdown.classList.contains('opacity-0');
            
            if (isVisible) {
                dropdown.classList.add('opacity-0', 'invisible');
            } else {
                dropdown.classList.remove('opacity-0', 'invisible');
                loadNotifications(listContainer);
            }
        }

        // Desktop notification dropdown
        if (notificationBtn) {
            notificationBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleNotificationDropdown(notificationDropdown, notificationList);
            });
        }

        // Mobile notification dropdown
        if (mobileNotificationBtn) {
            mobileNotificationBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleNotificationDropdown(mobileNotificationDropdown, mobileNotificationList);
            });
        }

        // Hide notification dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!document.getElementById('notificationContainer')?.contains(e.target)) {
                notificationDropdown?.classList.add('opacity-0', 'invisible');
            }
            if (!document.getElementById('mobileNotificationContainer')?.contains(e.target)) {
                mobileNotificationDropdown?.classList.add('opacity-0', 'invisible');
            }
        });

        // Helper function for time ago
        function timeAgo(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffInSeconds = Math.floor((now - date) / 1000);
            
            if (diffInSeconds < 60) return 'Just now';
            if (diffInSeconds < 3600) return `${Math.floor(diffInSeconds / 60)}m ago`;
            if (diffInSeconds < 86400) return `${Math.floor(diffInSeconds / 3600)}h ago`;
            return `${Math.floor(diffInSeconds / 86400)}d ago`;
        }

        // Mark all notifications as read
        window.markAllAsRead = function() {
            fetch('{{ route('notifications.mark-all-read') }}', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (response.ok) {
                    // Update badge counts
                    const badges = document.querySelectorAll('#notificationBadge, #mobileNotificationBadge');
                    badges.forEach(badge => badge.style.display = 'none');
                    
                    // Reload notifications
                    loadNotifications(notificationList);
                    loadNotifications(mobileNotificationList);
                }
            })
            .catch(error => console.error('Error marking notifications as read:', error));
        };
    </script>
    @stack('scripts')
</body>
</html>