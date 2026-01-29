<header class="fixed top-0 left-0 right-0 z-50 w-full glass-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between py-3">
            <div class="flex items-center gap-3">
                <div class="size-6 flex-shrink-0 header-logo">
                    <img src="{{ asset('images/leaf-logo.svg') }}" alt="WellPath Logo" class="w-full h-full">
                </div>
                <h2 class="header-text text-base sm:text-lg font-bold leading-tight tracking-[-0.015em] hidden xs:block">WellPath</h2>
                <h2 class="header-text text-base font-bold leading-tight tracking-[-0.015em] xs:hidden">WellPath</h2>
            </div>
            
            <nav class="hidden lg:flex items-center gap-4 xl:gap-6">
                <a class="header-text hover:opacity-80 text-sm font-medium leading-normal flex items-center gap-1.5" href="{{ route('home') }}">
                    <span class="material-symbols-outlined text-base">home</span>
                    <span>Home</span>
                </a>
                <a class="header-text hover:opacity-80 text-sm font-medium leading-normal flex items-center gap-1.5 {{ request()->routeIs('content.*') ? 'font-bold' : '' }}" href="{{ route('content.index') }}">
                    <span class="material-symbols-outlined text-base">library_books</span>
                    <span>Resources</span>
                </a>
                
                <!-- Counseling Dropdown -->
                <div class="relative group">
                    <button class="header-text hover:opacity-80 text-sm font-medium leading-normal flex items-center gap-1.5 {{ request()->routeIs('public.counseling.*') || request()->routeIs('student.counseling.*') ? 'font-bold' : '' }}">
                        <span class="material-symbols-outlined text-base">psychology</span>
                        <span>Counseling</span>
                        <span class="material-symbols-outlined text-sm">expand_more</span>
                    </button>
                    <div class="absolute top-full left-0 mt-2 w-64 glass-dropdown rounded-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="p-2">
                            <a href="{{ route('public.counseling.index') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-emerald-600">support_agent</span>
                                    <div>
                                        <div class="font-medium">Our Services</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Professional counseling support</div>
                                    </div>
                                </div>
                            </a>
                            <a href="{{ route('public.counseling.counselors') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-blue-600">group</span>
                                    <div>
                                        <div class="font-medium">Our Counselors</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">Meet our professional team</div>
                                    </div>
                                </div>
                            </a>
                            @auth
                                <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                                <a href="{{ route('public.counseling.sessions') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-blue-600">psychology</span>
                                        <div>
                                            <div class="font-medium">My Sessions</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">View your counseling sessions</div>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('public.counseling.sessions') }}" class="block px-4 py-3 text-sm text-white bg-primary hover:bg-primary/90 rounded-lg transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined">add</span>
                                        <div class="font-medium">Request Session</div>
                                    </div>
                                </a>
                            @else
                                <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                                <button onclick="openLoginModal()" class="block w-full px-4 py-3 text-sm text-white bg-primary hover:bg-primary/90 rounded-lg transition-colors">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined">login</span>
                                        <div class="font-medium">Login to Request Session</div>
                                    </div>
                                </button>
                            @endauth
                        </div>
                    </div>
                </div>
                
                <a class="header-text hover:opacity-80 text-sm font-medium leading-normal flex items-center gap-1.5 {{ request()->routeIs('public.assessments.*') ? 'font-bold' : '' }}" href="{{ route('public.assessments.index') }}">
                    <span class="material-symbols-outlined text-base">quiz</span>
                    <span>Assessments</span>
                </a>
                <a class="header-text hover:opacity-80 text-sm font-medium leading-normal flex items-center gap-1.5 {{ request()->routeIs('public.forum.*') || request()->routeIs('student.forum.*') ? 'font-bold' : '' }}" href="{{ route('public.forum.index') }}">
                    <span class="material-symbols-outlined text-base">forum</span>
                    <span>Community</span>
                </a>
                <a class="header-text hover:opacity-80 text-sm font-medium leading-normal flex items-center gap-1.5" href="{{ route('campaigns.index') }}">
                    <span class="material-symbols-outlined text-base">campaign</span>
                    <span>Events</span>
                </a>
                
                <!-- More Dropdown -->
                <div class="relative group">
                    <button class="header-text hover:opacity-80 text-sm font-medium leading-normal flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-base">more_horiz</span>
                        <span>More</span>
                        <span class="material-symbols-outlined text-sm">expand_more</span>
                    </button>
                    <div class="absolute top-full left-0 mt-2 w-48 glass-dropdown rounded-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="p-2">
                            <a href="{{ route('public.about') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-blue-600">info</span>
                                    <span class="font-medium">About Us</span>
                                </div>
                            </a>
                            <a href="{{ route('public.contact') }}" class="block px-4 py-3 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-green-600">mail</span>
                                    <span class="font-medium">Contact</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>
            
            <div class="flex items-center gap-2 sm:gap-3">
                <!-- Dark Mode Toggle -->
                <button id="darkModeToggle" class="flex items-center justify-center w-10 h-10 header-text hover:bg-white/20 rounded-lg transition-colors" title="Toggle dark mode">
                    <span id="darkModeIcon" class="material-symbols-outlined">dark_mode</span>
                </button>
                
                @guest
                    <button onclick="openLoginModal()" class="hidden sm:flex items-center justify-center rounded-lg h-9 sm:h-10 px-3 sm:px-5 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-[#111816] dark:text-white text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Sign In
                    </button>
                    <button onclick="openSignupModal()" class="hidden sm:flex items-center justify-center rounded-lg h-9 sm:h-10 px-3 sm:px-5 bg-primary text-white text-sm font-bold hover:bg-primary/90 transition-colors">
                        Sign Up
                    </button>
                @else
                    <!-- Profile Dropdown -->
                    <div class="hidden sm:block relative group">
                        <button class="flex items-center gap-2 hover:opacity-80 transition-opacity">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="size-9 sm:size-10 rounded-full object-cover border-2 border-primary">
                            @else
                                <div class="size-9 sm:size-10 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-sm font-bold text-white border-2 border-primary">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </div>
                            @endif
                            <span class="material-symbols-outlined text-sm text-[#111816] dark:text-white">expand_more</span>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div class="absolute right-0 top-full mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="p-3 border-b border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-semibold text-[#111816] dark:text-white truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="p-2">
                                <!-- User Menu -->
                                <a href="{{ route('public.counseling.sessions') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-green-600">psychology</span>
                                    <span>My Counseling</span>
                                </a>
                                <a href="{{ route('public.assessments.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-blue-600">quiz</span>
                                    <span>My Assessments</span>
                                </a>
                                <a href="{{ route('public.forum.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-purple-600">forum</span>
                                    <span>My Posts</span>
                                </a>
                                <a href="{{ route('campaigns.index') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-orange-600">campaign</span>
                                    <span>My Campaigns</span>
                                </a>
                                @if(auth()->user()->role !== 'user')
                                    <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                                    <!-- Admin/Counselor Menu -->
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined text-primary">dashboard</span>
                                        <span>Dashboard</span>
                                    </a>
                                @endif
                                <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>
                                <button onclick="openProfileModal()" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors w-full text-left">
                                    <span class="material-symbols-outlined text-blue-600">person</span>
                                    <span>Profile Settings</span>
                                </button>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                        <span class="material-symbols-outlined">logout</span>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
                
                <!-- Mobile Menu Toggle -->
                <button onclick="toggleMobileSidebar()" class="lg:hidden flex items-center justify-center w-10 h-10 header-text hover:bg-white/20 rounded-lg transition-colors">
                    <span class="material-symbols-outlined">menu</span>
                </button>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Sidebar Overlay -->
<div id="mobile-sidebar-overlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden transition-opacity" onclick="toggleMobileSidebar()"></div>

<!-- Mobile Sidebar -->
<div id="mobile-sidebar" class="fixed top-0 left-0 bottom-0 w-80 max-w-[85vw] glass-sidebar z-50 transform -translate-x-full transition-transform duration-300 ease-in-out lg:hidden shadow-2xl">
    <div class="flex flex-col h-full">
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-lg font-bold text-[#111816] dark:text-white">Menu</h3>
            <div class="flex items-center gap-2">
                <!-- Mobile Dark Mode Toggle -->
                <button id="mobileDarkModeToggle" class="flex items-center justify-center w-10 h-10 text-[#111816] dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors" title="Toggle dark mode">
                    <span id="mobileDarkModeIcon" class="material-symbols-outlined">dark_mode</span>
                </button>
                <button onclick="toggleMobileSidebar()" class="flex items-center justify-center w-10 h-10 text-[#111816] dark:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
        </div>
        
        <!-- Sidebar Content -->
        <div class="flex-1 overflow-y-auto p-4">
            <nav class="space-y-1">
                <a class="flex items-center gap-3 text-primary hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary/80 px-4 py-3 rounded-lg transition-colors" href="{{ route('home') }}">
                    <span class="material-symbols-outlined">home</span>
                    <span class="font-medium">Home</span>
                </a>
                
                <a class="flex items-center gap-3 text-primary hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary/80 px-4 py-3 rounded-lg transition-colors" href="{{ route('content.index') }}">
                    <span class="material-symbols-outlined">library_books</span>
                    <span class="font-medium">Educational Resources</span>
                </a>
                
                <!-- Counseling Section -->
                <div class="py-2">
                    <div class="flex items-center gap-3 text-primary px-4 py-2 font-semibold">
                        <span class="material-symbols-outlined">psychology</span>
                        <span>Counseling</span>
                    </div>
                    <div class="ml-8 space-y-1 mt-1">
                        <a class="block text-primary hover:text-primary/80 px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" href="{{ route('public.counseling.index') }}">Our Services</a>
                        <a class="block text-primary hover:text-primary/80 px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" href="{{ route('public.counseling.counselors') }}">Our Counselors</a>
                        @auth
                            <a class="block text-primary hover:text-primary/80 px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors" href="{{ route('public.counseling.sessions') }}">My Sessions</a>
                            <a class="block text-primary font-medium px-4 py-2 rounded-lg hover:bg-primary/10 transition-colors" href="{{ route('public.counseling.sessions') }}">Request Session</a>
                        @else
                            <button onclick="openLoginModal(); toggleMobileSidebar();" class="block w-full text-left text-primary font-medium px-4 py-2 rounded-lg hover:bg-primary/10 transition-colors">Login to Request Session</button>
                        @endauth
                    </div>
                </div>
                
                <a class="flex items-center gap-3 text-primary hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary/80 px-4 py-3 rounded-lg transition-colors" href="{{ route('public.assessments.index') }}">
                    <span class="material-symbols-outlined">quiz</span>
                    <span class="font-medium">Assessments</span>
                </a>
                
                <a class="flex items-center gap-3 text-primary hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary/80 px-4 py-3 rounded-lg transition-colors" href="{{ route('public.forum.index') }}">
                    <span class="material-symbols-outlined">forum</span>
                    <span class="font-medium">Community Forum</span>
                </a>
                
                <a class="flex items-center gap-3 text-primary hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary/80 px-4 py-3 rounded-lg transition-colors" href="{{ route('campaigns.index') }}">
                    <span class="material-symbols-outlined">campaign</span>
                    <span class="font-medium">Events</span>
                </a>
                
                <a class="flex items-center gap-3 text-primary hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary/80 px-4 py-3 rounded-lg transition-colors" href="{{ route('public.about') }}">
                    <span class="material-symbols-outlined">info</span>
                    <span class="font-medium">About Us</span>
                </a>
                
                <a class="flex items-center gap-3 text-primary hover:bg-gray-100 dark:hover:bg-gray-800 hover:text-primary/80 px-4 py-3 rounded-lg transition-colors" href="{{ route('public.contact') }}">
                    <span class="material-symbols-outlined">mail</span>
                    <span class="font-medium">Contact</span>
                </a>
            </nav>
        </div>
        
        <!-- Sidebar Footer -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-800 space-y-2">
            @guest
                <button onclick="openSignupModal(); toggleMobileSidebar();" class="flex items-center justify-center gap-2 w-full bg-primary text-white py-3 px-4 rounded-lg font-bold hover:bg-primary/90 transition-colors">
                    <span class="material-symbols-outlined">person_add</span>
                    Sign Up
                </button>
                <button onclick="openLoginModal(); toggleMobileSidebar();" class="flex items-center justify-center gap-2 w-full bg-gray-200 dark:bg-gray-800 text-[#111816] dark:text-white py-3 px-4 rounded-lg font-bold hover:bg-gray-300 dark:hover:bg-gray-700 transition-colors">
                    <span class="material-symbols-outlined">login</span>
                    Sign In
                </button>
            @else
                @if(auth()->user()->role !== 'user')
                    <a href="{{ route('dashboard') }}" class="flex items-center justify-center gap-2 w-full bg-primary text-white py-3 px-4 rounded-lg font-bold hover:bg-primary/90 transition-colors">
                        <span class="material-symbols-outlined">dashboard</span>
                        Dashboard
                    </a>
                @endif
                <button onclick="openProfileModal(); toggleMobileSidebar();" class="flex items-center justify-center gap-2 w-full bg-gray-200 dark:bg-gray-800 text-[#111816] dark:text-white py-3 px-4 rounded-lg font-bold hover:bg-gray-300 dark:hover:bg-gray-700 transition-colors">
                    <span class="material-symbols-outlined">person</span>
                    Profile
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center justify-center gap-2 w-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 py-3 px-4 rounded-lg font-bold hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors">
                        <span class="material-symbols-outlined">logout</span>
                        Logout
                    </button>
                </form>
            @endguest
        </div>
    </div>
</div>

<script>
function toggleMobileSidebar() {
    const sidebar = document.getElementById('mobile-sidebar');
    const overlay = document.getElementById('mobile-sidebar-overlay');
    
    sidebar.classList.toggle('-translate-x-full');
    overlay.classList.toggle('hidden');
    
    // Prevent body scroll when sidebar is open
    document.body.classList.toggle('overflow-hidden');
}
</script>