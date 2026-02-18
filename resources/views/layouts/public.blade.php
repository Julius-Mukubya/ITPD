<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'WellPath')</title>
    
    <!-- Dark Mode Detection Script - Must run before page renders -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = savedTheme === 'dark' || (!savedTheme && prefersDark);
            
            if (isDark) {
                document.documentElement.classList.remove('light');
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.classList.add('light');
            }
        })();
    </script>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined&display=swap" rel="stylesheet"/>
    
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#14eba3",
                        "background-light": "#f6f8f7",
                        "background-dark": "#10221c",
                    },
                    fontFamily: {
                        "display": ["Lexend", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    
    <style>
        body {
            font-family: 'Lexend', sans-serif;
        }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            font-size: 20px;
        }
        
        /* Fix for icon font loading - prevent FOIT/FOUT */
        .material-symbols-outlined {
            font-display: swap;
            /* Hide text fallback until font loads */
            text-rendering: optimizeLegibility;
        }
        
        /* Optional: Add a subtle loading state */
        .material-symbols-outlined:not(.font-loaded) {
            opacity: 0.7;
            transition: opacity 0.2s ease;
        }
        
        /* MUBS Blue header that stands out from hero sections */
        .glass-header {
            background: #0099CC;
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        
        /* Header text styling - white text */
        .glass-header .header-text {
            color: #ffffff;
            text-shadow: none;
            font-weight: 600;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .glass-header .header-logo {
            filter: brightness(0) invert(1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Dark mode header - same blue */
        .dark .glass-header {
            background: #0099CC;
            border-bottom: 1px solid rgba(0, 0, 0, 0.2);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
        }
        
        .dark .glass-header .header-text {
            color: #ffffff;
        }
        
        /* Header when scrolled - slightly darker blue */
        .glass-header.scrolled {
            background: #0088BB;
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border-bottom: 1px solid rgba(0, 0, 0, 0.15);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }
        
        .glass-header.scrolled .header-text {
            color: #ffffff;
            text-shadow: none;
        }
        
        .glass-header.scrolled .header-logo {
            filter: brightness(0) invert(1);
        }
        
        .dark .glass-header.scrolled {
            background: #0088BB;
            border-bottom: 1px solid rgba(0, 0, 0, 0.25);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
        }
        
        .dark .glass-header.scrolled .header-text {
            color: #ffffff;
        }
        
        .glass-dropdown {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
        }
        
        .dark .glass-dropdown {
            background: rgba(31, 41, 55, 0.85);
            border: 1px solid rgba(75, 85, 99, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
        }
        
        .glass-sidebar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .dark .glass-sidebar {
            background: rgba(17, 24, 39, 0.9);
            border-right: 1px solid rgba(75, 85, 99, 0.3);
        }
    </style>
    
    @stack('styles')
</head>
<body class="font-display bg-background-light dark:bg-background-dark text-[#111816] dark:text-gray-200">
    <!-- Loading Screen -->
    @include('components.loading-screen')
    
    <div id="mainContent" class="relative flex min-h-screen w-full flex-col group/design-root overflow-x-hidden">
        <div class="layout-container flex h-full grow flex-col">
            <div class="flex flex-1 justify-center">
                <div class="layout-content-container flex flex-col w-full">
                    
                    <!-- Header -->
                    @include('partials.public-header')
                    
                    <!-- Toast Notifications -->
                    @include('components.toast-notifications')

                    <!-- Main Content -->
                    <main class="flex-1">
                        @yield('content')
                    </main>
                    
                    <!-- Footer -->
                    @include('partials.public-footer')
                    
                </div>
            </div>
        </div>
    </div> <!-- End mainContent -->
    
    <!-- Crisis Support Modal (Available on all pages) -->
    @include('components.crisis-support-modal')
    
    <!-- Assessment Result Modal -->
    @include('components.assessment-result-modal')
    
    <!-- Authentication Modals -->
    @guest
        <x-login-modal />
        <x-signup-modal />
        @include('components.forgot-password-modal')
    @endguest
    
    <!-- Profile Modal (for authenticated users) -->
    @auth
        @include('components.profile-modal')
    @endauth
    
    <!-- Legal Modals -->
    @include('components.privacy-modal')
    @include('components.terms-modal')
    
    <!-- Flag Content Modal -->
    @include('components.flag-content-modal')
    
    @stack('scripts')
    
    <!-- Notification Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notification = document.getElementById('notification');
            if (notification) {
                // Slide in
                setTimeout(() => {
                    notification.classList.remove('translate-x-full');
                }, 100);
                
                // Auto hide after 5 seconds
                setTimeout(() => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.parentNode.removeChild(notification);
                        }
                    }, 300);
                }, 5000);
                
                // Click to dismiss
                notification.addEventListener('click', () => {
                    notification.classList.add('translate-x-full');
                    setTimeout(() => {
                        if (notification.parentNode) {
                            notification.parentNode.removeChild(notification);
                        }
                    }, 300);
                });
            }
            
            // Header scroll effect
            const header = document.querySelector('.glass-header');
            if (header) {
                let ticking = false;
                
                function updateHeader() {
                    const scrolled = window.scrollY > 50;
                    if (scrolled) {
                        header.classList.add('scrolled');
                    } else {
                        header.classList.remove('scrolled');
                    }
                    ticking = false;
                }
                
                function requestTick() {
                    if (!ticking) {
                        requestAnimationFrame(updateHeader);
                        ticking = true;
                    }
                }
                
                window.addEventListener('scroll', requestTick);
                
                // Initial check
                updateHeader();
            }
            
            // Dark Mode Toggle
            const darkModeToggle = document.getElementById('darkModeToggle');
            const darkModeIcon = document.getElementById('darkModeIcon');
            const htmlElement = document.documentElement;
            
            if (darkModeToggle && darkModeIcon) {
                // Check for saved theme preference or default to light mode
                const savedTheme = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                
                // Update icon function
                function updateIcons(isDark) {
                    const iconText = isDark ? 'light_mode' : 'dark_mode';
                    darkModeIcon.textContent = iconText;
                }
                
                // Set initial theme
                if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                    htmlElement.classList.add('dark');
                    updateIcons(true);
                } else {
                    htmlElement.classList.remove('dark');
                    updateIcons(false);
                }
                
                // Toggle function
                function toggleDarkMode() {
                    const isDark = htmlElement.classList.contains('dark');
                    
                    if (isDark) {
                        htmlElement.classList.remove('dark');
                        updateIcons(false);
                        localStorage.setItem('theme', 'light');
                    } else {
                        htmlElement.classList.add('dark');
                        updateIcons(true);
                        localStorage.setItem('theme', 'dark');
                    }
                }
                
                // Add click event listener
                darkModeToggle.addEventListener('click', toggleDarkMode);
                
                // Listen for system theme changes
                window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                    if (!localStorage.getItem('theme')) {
                        if (e.matches) {
                            htmlElement.classList.add('dark');
                            updateIcons(true);
                        } else {
                            htmlElement.classList.remove('dark');
                            updateIcons(false);
                        }
                    }
                });
            }
            
            // Font loading detection for Material Symbols
            if ('fonts' in document) {
                document.fonts.ready.then(() => {
                    document.querySelectorAll('.material-symbols-outlined').forEach(icon => {
                        icon.classList.add('font-loaded');
                    });
                });
            }
        });
    </script>
</body>
</html>