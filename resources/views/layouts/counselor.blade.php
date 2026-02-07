<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'WellPath - Counselor Portal')</title>
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
        <!-- Mobile Sidebar Backdrop -->
        <div id="sidebarBackdrop" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 lg:hidden hidden" onclick="closeSidebar()"></div>
        
        <!-- Counselor Navigation -->
        <aside id="sidebar" class="fixed lg:sticky top-0 left-0 h-screen flex-col bg-white dark:bg-background-dark dark:border-r dark:border-gray-700 w-64 z-50 lg:z-auto transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out lg:flex">
            <div class="flex h-full flex-col justify-between p-4">
                <div class="flex flex-col gap-4">
                    <!-- Mobile Close Button -->
                    <div class="flex items-center justify-between lg:hidden mb-2">
                        <div class="flex items-center gap-3">
                            <div class="size-8 flex-shrink-0">
                                <img src="{{ asset('images/leaf-logo.svg') }}" alt="WellPath Logo" class="w-full h-full">
                            </div>
                            <h1 class="text-gray-900 dark:text-white text-sm font-medium">WellPath</h1>
                        </div>
                        <button onclick="closeSidebar()" class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                    
                    <!-- Desktop Header -->
                    <div class="hidden lg:flex items-center gap-3 px-3">
                        <div class="size-10 flex-shrink-0">
                            <img src="{{ asset('images/leaf-logo.svg') }}" alt="WellPath Logo" class="w-full h-full">
                        </div>
                        <div class="flex flex-col">
                            <h1 class="text-gray-900 dark:text-white text-base font-medium leading-normal">WellPath</h1>
                            <p class="text-gray-500 dark:text-gray-400 text-sm font-normal leading-normal">Counselor Portal</p>
                        </div>
                    </div>
                    
                    <nav class="flex flex-col gap-2 mt-4">
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('counselor.dashboard') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('counselor.dashboard') }}" onclick="closeSidebarOnMobile()">
                            <span class="material-symbols-outlined {{ request()->routeIs('counselor.dashboard') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">dashboard</span>
                            <p class="{{ request()->routeIs('counselor.dashboard') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Dashboard</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('counselor.sessions.*') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('counselor.sessions.index') }}" onclick="closeSidebarOnMobile()">
                            <span class="material-symbols-outlined {{ request()->routeIs('counselor.sessions.*') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">support_agent</span>
                            <p class="{{ request()->routeIs('counselor.sessions.*') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Sessions</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('counselor.notes.*') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('counselor.notes.index') }}" onclick="closeSidebarOnMobile()">
                            <span class="material-symbols-outlined {{ request()->routeIs('counselor.notes.*') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">note_alt</span>
                            <p class="{{ request()->routeIs('counselor.notes.*') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Session Notes</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('counselor.clients') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('counselor.clients') }}" onclick="closeSidebarOnMobile()">
                            <span class="material-symbols-outlined {{ request()->routeIs('counselor.clients') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">school</span>
                            <p class="{{ request()->routeIs('counselor.clients') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">My Clients</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('counselor.schedule') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('counselor.schedule') }}" onclick="closeSidebarOnMobile()">
                            <span class="material-symbols-outlined {{ request()->routeIs('counselor.schedule') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">schedule</span>
                            <p class="{{ request()->routeIs('counselor.schedule') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Schedule</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('counselor.reports') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('counselor.reports') }}" onclick="closeSidebarOnMobile()">
                            <span class="material-symbols-outlined {{ request()->routeIs('counselor.reports') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">assessment</span>
                            <p class="{{ request()->routeIs('counselor.reports') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Reports</p>
                        </a>
                        <a class="flex items-center gap-3 px-3 py-2 rounded-lg {{ request()->routeIs('counselor.contact-setup') ? 'bg-primary/20 dark:bg-primary/30' : 'hover:bg-gray-100 dark:hover:bg-white/10' }}" href="{{ route('counselor.contact-setup') }}" onclick="closeSidebarOnMobile()">
                            <span class="material-symbols-outlined {{ request()->routeIs('counselor.contact-setup') ? 'text-primary' : 'text-gray-700 dark:text-gray-300' }}">contact_phone</span>
                            <p class="{{ request()->routeIs('counselor.contact-setup') ? 'text-gray-900 dark:text-white' : 'text-gray-700 dark:text-gray-300' }} text-sm font-medium leading-normal">Contact Setup</p>
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
                    
                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-white/10" href="{{ route('home') }}" onclick="closeSidebarOnMobile()">
                        <span class="material-symbols-outlined text-gray-700 dark:text-gray-300">public</span>
                        <p class="text-gray-700 dark:text-gray-300 text-sm font-medium leading-normal">View Main Site</p>
                    </a>
                    
                    <a class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-white/10" href="{{ route('counselor.profile.edit') }}" onclick="closeSidebarOnMobile()">
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
        <main class="flex-1 flex flex-col lg:ml-0 relative">
            <!-- Header -->
            <header class="fixed lg:sticky top-0 left-0 right-0 z-30 flex justify-between items-center gap-2 px-4 md:px-8 py-3 bg-background-light/95 dark:bg-background-dark/95 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 lg:left-auto">
                <div class="flex items-center gap-3 sm:gap-4">
                    <button class="p-2 text-gray-700 dark:text-gray-300 lg:hidden hover:bg-gray-200 dark:hover:bg-white/10 rounded-lg transition-colors" onclick="openSidebar()">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <h1 class="text-base sm:text-xl font-semibold text-gray-900 dark:text-white truncate">@yield('page-title', 'Counselor Portal')</h1>
                </div>
                <div class="flex items-center gap-1 sm:gap-2">
                    <!-- Dark Mode Toggle (Mobile) -->
                    <button id="mobileDarkModeToggle" class="p-2 text-gray-700 dark:text-gray-300 rounded-full hover:bg-gray-200 dark:hover:bg-white/10 lg:hidden">
                        <span class="material-symbols-outlined" id="mobileDarkModeIcon">dark_mode</span>
                    </button>
                    
                    <!-- Notifications Dropdown -->
                    <div class="relative group">
                        <button class="p-2 text-gray-700 dark:text-gray-300 rounded-full hover:bg-gray-200 dark:hover:bg-white/10 relative">
                            <span class="material-symbols-outlined">notifications</span>
                            @if(auth()->user()->unreadNotificationsCount() > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                    {{ auth()->user()->unreadNotificationsCount() }}
                                </span>
                            @endif
                        </button>
                        
                        <!-- Notifications Dropdown -->
                        <div class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notifications</h3>
                                    <a href="{{ route('notifications.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                                        View All
                                    </a>
                                </div>
                            </div>
                            
                            <div class="max-h-96 overflow-y-auto">
                                @if(auth()->user()->isCounselor())
                                    @php $notifications = auth()->user()->getCounselorNotifications(); @endphp
                                    @if($notifications->count() > 0)
                                        @foreach($notifications as $notification)
                                            <a href="{{ $notification['url'] }}" class="block p-4 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-600 last:border-b-0 transition-colors">
                                                <div class="flex items-start gap-3">
                                                    <div class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center
                                                        @if($notification['color'] === 'yellow') bg-yellow-100 dark:bg-yellow-900/20
                                                        @elseif($notification['color'] === 'blue') bg-blue-100 dark:bg-blue-900/20
                                                        @elseif($notification['color'] === 'green') bg-green-100 dark:bg-green-900/20
                                                        @else bg-gray-100 dark:bg-gray-900/20 @endif">
                                                        <span class="material-symbols-outlined text-sm
                                                            @if($notification['color'] === 'yellow') text-yellow-600 dark:text-yellow-400
                                                            @elseif($notification['color'] === 'blue') text-blue-600 dark:text-blue-400
                                                            @elseif($notification['color'] === 'green') text-green-600 dark:text-green-400
                                                            @else text-gray-600 dark:text-gray-400 @endif">
                                                            {{ $notification['icon'] }}
                                                        </span>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ $notification['title'] }}
                                                        </p>
                                                        <p class="text-sm text-gray-600 dark:text-gray-400 truncate">
                                                            {{ $notification['message'] }}
                                                        </p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                                            {{ $notification['time']->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                    @if($notification['priority'] === 'urgent' || $notification['priority'] === 'high')
                                                        <div class="flex-shrink-0">
                                                            <span class="w-2 h-2 bg-red-500 rounded-full"></span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </a>
                                        @endforeach
                                    @else
                                        <div class="p-6 text-center">
                                            <span class="material-symbols-outlined text-4xl text-gray-400 dark:text-gray-600 mb-2">notifications_none</span>
                                            <p class="text-gray-500 dark:text-gray-400">No new notifications</p>
                                        </div>
                                    @endif
                                @else
                                    @if(auth()->user()->unreadNotifications()->count() > 0)
                                        @foreach(auth()->user()->unreadNotifications()->take(5)->get() as $notification)
                                            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 border-b border-gray-100 dark:border-gray-600 last:border-b-0">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $notification->title }}</p>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $notification->message }}</p>
                                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="p-6 text-center">
                                            <span class="material-symbols-outlined text-4xl text-gray-400 dark:text-gray-600 mb-2">notifications_none</span>
                                            <p class="text-gray-500 dark:text-gray-400">No new notifications</p>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative group">
                        <button class="rounded-full hover:ring-2 hover:ring-primary/50 transition-all">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600">
                            @else
                                <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-full flex items-center justify-center text-xs sm:text-sm font-bold text-white border-2 border-gray-300 dark:border-gray-600">
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
                            <a href="{{ route('counselor.profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
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

            <div class="flex-1 p-4 md:p-8 space-y-8 overflow-y-auto pt-20 lg:pt-0">
                @yield('content')
            </div>
            
            <!-- Toast Notifications -->
            @include('components.toast-notifications')
        </main>
    </div>

    <script>
        // Sidebar functionality
        function openSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            backdrop.classList.remove('hidden');
            
            // Prevent body scroll when sidebar is open on mobile
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
            
            // Restore body scroll
            document.body.style.overflow = '';
        }

        function closeSidebarOnMobile() {
            // Only close sidebar on mobile screens
            if (window.innerWidth < 1024) {
                closeSidebar();
            }
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuButton = event.target.closest('button[onclick="openSidebar()"]');
            
            if (window.innerWidth < 1024 && 
                !sidebar.contains(event.target) && 
                !menuButton && 
                !sidebar.classList.contains('-translate-x-full')) {
                closeSidebar();
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                // Desktop: ensure sidebar is visible and backdrop is hidden
                const sidebar = document.getElementById('sidebar');
                const backdrop = document.getElementById('sidebarBackdrop');
                
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                backdrop.classList.add('hidden');
                document.body.style.overflow = '';
            } else {
                // Mobile: ensure sidebar is hidden by default
                const sidebar = document.getElementById('sidebar');
                if (!sidebar.classList.contains('-translate-x-full')) {
                    closeSidebar();
                }
            }
        });

        // Initialize sidebar state on page load
        document.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth >= 1024) {
                // Desktop: show sidebar
                const sidebar = document.getElementById('sidebar');
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
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

        // Auto-refresh notifications every 30 seconds for counselors
        if (document.querySelector('.group:has(.material-symbols-outlined:contains("notifications"))')) {
            setInterval(function() {
                // Only refresh if user is a counselor and on the notifications page
                if (window.location.pathname.includes('/notifications')) {
                    // Refresh the page to get updated notifications
                    window.location.reload();
                }
            }, 30000); // 30 seconds
        }
    </script>
    @stack('scripts')
</body>
</html>