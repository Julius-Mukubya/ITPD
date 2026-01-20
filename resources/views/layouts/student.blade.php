<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'WellPath - Student Portal')</title>
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
    <div class="relative flex min-h-screen w-full">
        <!-- Student Navigation -->
        <aside class="sticky top-0 h-screen flex-col bg-white dark:bg-background-dark dark:border-r dark:border-gray-700 w-64 hidden lg:flex">
            <div class="flex h-full flex-col justify-between p-4">
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-3 px-3">
                        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDOlqqrnn7gUspf7G--ZfEAHfhFEmJb11poCmQ-Z4Zft45BLCVKpHj8Z31-CHMgkQcNe9ElWNbPm3X-593kkxtwcTHNIgMBzkAF6g-sEoJSy8Nv-8hIrnQthnN73ECoGjM7NBMhiQsRAHWYZzbtxEHIGfyIxZQHtYhjUOR4H8CASI3M-pOsBMKeP72jZ7Ude7mhcX7OfYRh8kMKavkZjjkB_vWiM2JmewfBrRt3-AZ-JKAlmx8crQT3_lUiarlATmnRdGR-OXMGXA");'></div>
                        <div class="flex flex-col">
                            <h1 class="text-gray-900 dark:text-white text-base font-medium leading-normal">WellPath</h1>
                            <p class="text-gray-500 dark:text-gray-400 text-sm font-normal leading-normal">Student Portal</p>
                        </div>
                    </div>
                    <nav class="flex flex-col gap-2 mt-4">
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('student.dashboard') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('student.dashboard') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('student.dashboard') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">dashboard</span>
                            <p class="{{ request()->routeIs('student.dashboard') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Dashboard</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('student.content.*') || request()->routeIs('content.*') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('student.content.library') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('student.content.*') || request()->routeIs('content.*') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">auto_stories</span>
                            <p class="{{ request()->routeIs('student.content.*') || request()->routeIs('content.*') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Learning Library</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('student.assessments.*') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('student.assessments.index') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('student.assessments.*') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">psychology</span>
                            <p class="{{ request()->routeIs('student.assessments.*') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Assessments</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('student.forum.*') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('student.forum.index') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('student.forum.*') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">forum</span>
                            <p class="{{ request()->routeIs('student.forum.*') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Forum</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('student.counseling.*') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('student.counseling.index') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('student.counseling.*') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">support_agent</span>
                            <p class="{{ request()->routeIs('student.counseling.*') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Counseling</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('student.campaigns.*') || request()->routeIs('campaigns.*') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('student.campaigns.index') }}">
                            <span class="material-symbols-outlined {{ request()->routeIs('student.campaigns.*') || request()->routeIs('campaigns.*') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">campaign</span>
                            <p class="{{ request()->routeIs('student.campaigns.*') || request()->routeIs('campaigns.*') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Campaigns</p>
                        </a>
                    </nav>
                </div>
                <div class="flex flex-col gap-2 border-t border-gray-200 dark:border-gray-700 pt-4">
                    <!-- Dark Mode Toggle -->
                    <button id="darkModeToggle" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-white/10 transition-all duration-200">
                        <span class="material-symbols-outlined text-primary" id="darkModeIcon">dark_mode</span>
                        <p class="text-gray-700 dark:text-gray-300 text-sm font-medium leading-normal">Dark Mode</p>
                        <div class="ml-auto">
                            <div class="relative inline-block w-10 h-6 transition duration-200 ease-in-out bg-gray-300 dark:bg-primary rounded-full">
                                <span class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform duration-200 dark:translate-x-4"></span>
                            </div>
                        </div>
                    </button>
                    
                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-white/10" href="{{ route('home') }}">
                        <span class="material-symbols-outlined text-gray-700 dark:text-gray-300">public</span>
                        <p class="text-gray-700 dark:text-gray-300 text-sm font-medium leading-normal">View Main Site</p>
                    </a>
                    
                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-white/10" href="{{ route('student.profile.edit') }}">
                        <span class="material-symbols-outlined text-gray-700 dark:text-gray-300">settings</span>
                        <p class="text-gray-700 dark:text-gray-300 text-sm font-medium leading-normal">Profile</p>
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-white/10">
                            <span class="material-symbols-outlined text-gray-700 dark:text-gray-300">logout</span>
                            <p class="text-gray-700 dark:text-gray-300 text-sm font-medium leading-normal">Logout</p>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="sticky top-0 z-10 flex justify-between items-center gap-2 px-4 md:px-8 py-3 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-sm border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-4">
                    <button class="p-2 text-gray-700 dark:text-gray-300 lg:hidden" onclick="toggleSidebar()">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <h1 class="text-xl font-semibold text-gray-900 dark:text-white">@yield('page-title', 'Student Portal')</h1>
                </div>
                <div class="flex items-center gap-2">
                    <!-- Dark Mode Toggle (Mobile) -->
                    <button id="mobileDarkModeToggle" class="p-2 text-gray-700 dark:text-gray-300 rounded-full hover:bg-gray-200 dark:hover:bg-white/10 lg:hidden">
                        <span class="material-symbols-outlined" id="mobileDarkModeIcon">dark_mode</span>
                    </button>
                    
                    <a href="{{ route('notifications.index') }}" class="p-2 text-gray-700 dark:text-gray-300 rounded-full hover:bg-gray-200 dark:hover:bg-white/10 relative">
                        <span class="material-symbols-outlined">notifications</span>
                        @if(auth()->user()->unreadNotificationsCount() > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                {{ auth()->user()->unreadNotificationsCount() }}
                            </span>
                        @endif
                    </a>
                    
                    <div class="relative group">
                        <button class="rounded-full hover:ring-2 hover:ring-primary/50 transition-all">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600">
                            @else
                                <div class="w-10 h-10 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-sm font-bold text-white border-2 border-gray-300 dark:border-gray-600">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </div>
                            @endif
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="p-3 border-b border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('home') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span class="material-symbols-outlined text-lg">public</span>
                                View Main Site
                            </a>
                            <a href="{{ route('student.profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <span class="material-symbols-outlined text-lg">person</span>
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}" id="logoutFormDropdown">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center gap-2 px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20">
                                    <span class="material-symbols-outlined text-lg">logout</span>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <div class="flex-1 p-4 md:p-8 space-y-8 overflow-y-auto">
                @yield('content')
            </div>
            
            <!-- Toast Notifications -->
            @include('components.toast-notifications')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('aside');
            sidebar.classList.toggle('hidden');
        }

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
        mobileDarkModeToggle?.addEventListener('click', toggleDarkMode);

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
    </script>
    @stack('scripts')
</body>
</html>