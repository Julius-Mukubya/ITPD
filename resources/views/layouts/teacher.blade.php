<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Teacher Dashboard') - WellPath</title>
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
            
            <div class="flex-1">
                <h1 class="text-lg font-semibold text-gray-900 dark:text-white">@yield('header', 'Dashboard')</h1>
            </div>

            <!-- Profile Icon -->
            <div class="relative group">
                <button class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="size-9 rounded-full object-cover border-2 border-primary">
                    @else
                        <div class="size-9 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-sm font-bold text-white border-2 border-primary">
                            {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                        </div>
                    @endif
                </button>
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
                            <p class="text-gray-500 dark:text-gray-400 text-sm font-normal leading-normal">Teacher Portal</p>
                        </div>
                    </div>
                    <nav class="flex flex-col gap-2 mt-4">
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('dashboard') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">dashboard</span>
                            <p class="{{ request()->routeIs('dashboard') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Dashboard</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('teacher.campaigns.*') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('teacher.campaigns.index') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('teacher.campaigns.*') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">campaign</span>
                            <p class="{{ request()->routeIs('teacher.campaigns.*') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">My Campaigns</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('teacher.content') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('teacher.content') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('teacher.content') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">article</span>
                            <p class="{{ request()->routeIs('teacher.content') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Content Engagement</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('teacher.assessments') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('teacher.assessments') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('teacher.assessments') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">psychology</span>
                            <p class="{{ request()->routeIs('teacher.assessments') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Assessments</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('teacher.forum') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('teacher.forum') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('teacher.forum') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">forum</span>
                            <p class="{{ request()->routeIs('teacher.forum') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Forum Activity</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('teacher.reports') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('teacher.reports') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('teacher.reports') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">analytics</span>
                            <p class="{{ request()->routeIs('teacher.reports') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Reports</p>
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

                    <a class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all duration-200" href="{{ route('profile.edit') }}">
                        <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400">person</span>
                        <p class="text-gray-700 dark:text-gray-300 text-sm font-medium">Profile</p>
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
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">@yield('header', 'Dashboard')</h2>
                </div>
                <div class="flex items-center gap-2">
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
            </header>

            <div class="flex-1 p-4 md:p-6 lg:p-8 space-y-6 md:space-y-8 overflow-y-auto">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </div>
            
            <!-- Toast Notifications -->
            @include('components.toast-notifications')
        </main>
    </div>

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
                sidebar?.classList.remove('-translate-x-full');
                mobileOverlay?.classList.add('hidden');
            } else {
                sidebar?.classList.add('-translate-x-full');
                mobileOverlay?.classList.add('hidden');
            }
        });

        // Dark Mode Toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const darkModeIcon = document.getElementById('darkModeIcon');
        const html = document.documentElement;

        const currentTheme = localStorage.getItem('theme') || 'light';
        if (currentTheme === 'dark') {
            html.classList.add('dark');
            if (darkModeIcon) darkModeIcon.textContent = 'light_mode';
        }

        function toggleDarkMode() {
            html.classList.toggle('dark');
            
            if (html.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
                if (darkModeIcon) darkModeIcon.textContent = 'light_mode';
            } else {
                localStorage.setItem('theme', 'light');
                if (darkModeIcon) darkModeIcon.textContent = 'dark_mode';
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
                        const response = await fetch('/csrf-token', {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                            }
                        });
                        
                        if (response.ok) {
                            const data = await response.json();
                            const csrfInput = form.querySelector('input[name="_token"]');
                            if (csrfInput) {
                                csrfInput.value = data.csrf_token;
                            }
                        }
                    } catch (error) {
                        console.log('Could not refresh CSRF token, proceeding with existing token');
                    }
                    
                    form.submit();
                });
            }
        }

        handleLogout('logoutForm');
        handleLogout('logoutFormDropdown');
    </script>
    @stack('scripts')
</body>
</html>
