@php
    // Define main public pages that should show loading screen
    $mainPublicPages = [
        'home',
        'public.about',
        'public.contact',
        'content.index',
        'campaigns.index',
        'public.counseling.index',
        'public.assessments.index',
        'public.forum.index'
    ];
    
    // Check if current route is a main public page
    $showLoadingScreen = in_array(request()->route()->getName(), $mainPublicPages);
@endphp

@if($showLoadingScreen)
<!-- Loading Screen -->
<div id="loadingScreen" class="fixed inset-0 z-[9999] bg-gradient-to-br from-white via-gray-50 to-primary/5 dark:from-gray-900 dark:via-gray-800 dark:to-primary/10 flex items-center justify-center transition-opacity duration-500">
    <div class="text-center">
        <!-- Animated Logo Container -->
        <div class="relative mb-8">
            <div class="w-20 h-20 mx-auto relative">
                <!-- Pulsing background circle -->
                <div class="absolute inset-0 bg-primary/20 rounded-full animate-ping"></div>
                <div class="absolute inset-2 bg-primary/30 rounded-full animate-pulse"></div>
                
                <!-- Logo -->
                <div class="relative z-10 w-full h-full bg-white dark:bg-gray-800 rounded-full flex items-center justify-center shadow-lg">
                    <img src="{{ asset('images/leaf-logo.svg') }}" alt="WellPath Logo" class="w-12 h-12 animate-pulse">
                </div>
            </div>
        </div>
        
        <!-- Spinner with gradient -->
        <div class="relative mb-6">
            <div class="w-12 h-12 mx-auto">
                <div class="w-full h-full border-4 border-gray-200 dark:border-gray-700 rounded-full animate-spin border-t-primary border-r-primary/70 border-b-primary/40"></div>
            </div>
        </div>
        
        <!-- Loading Text with fade animation -->
        <div class="space-y-2 animate-pulse">
            <h3 class="text-xl font-bold bg-gradient-to-r from-primary to-green-600 bg-clip-text text-transparent">
                WellPath
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Preparing your wellness journey...</p>
        </div>
        
        <!-- Animated progress bar -->
        <div class="mt-6 w-48 mx-auto">
            <div class="h-1 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-primary to-green-500 rounded-full animate-pulse" style="width: 100%; animation: loadingBar 2s ease-in-out infinite;"></div>
            </div>
        </div>
        
        <!-- Progress Dots -->
        <div class="flex justify-center space-x-2 mt-4">
            <div class="w-2 h-2 bg-primary rounded-full animate-bounce" style="animation-delay: 0ms"></div>
            <div class="w-2 h-2 bg-primary/80 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
            <div class="w-2 h-2 bg-primary/60 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
        </div>
    </div>
</div>

<style>
    /* Enhanced loading screen styles */
    #loadingScreen {
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }
    
    /* Hide page content until loaded */
    body.loading #mainContent {
        opacity: 0;
        pointer-events: none;
        transform: translateY(20px);
    }
    
    /* Smooth fade in when loaded */
    body.loaded #mainContent {
        opacity: 1;
        transform: translateY(0);
        transition: opacity 0.2s ease-in-out, transform 0.2s ease-in-out;
    }
    
    /* Hide loading screen when loaded */
    body.loaded #loadingScreen {
        opacity: 0;
        pointer-events: none;
        transform: scale(0.95);
        transition: opacity 0.2s ease-in-out, transform 0.2s ease-in-out;
    }
    
    /* Custom loading bar animation */
    @keyframes loadingBar {
        0% { transform: translateX(-100%); }
        50% { transform: translateX(0%); }
        100% { transform: translateX(100%); }
    }
    
    /* Prevent flash of unstyled content */
    body:not(.loaded) {
        overflow: hidden;
    }
</style>

<script>
    // Scroll position reset and loading screen management
    document.addEventListener('DOMContentLoaded', function() {
        // Only run loading screen logic if it exists on the page
        const loadingScreen = document.getElementById('loadingScreen');
        if (!loadingScreen) return;
        
        // Force scroll to top immediately when loading screen is active
        window.scrollTo(0, 0);
        document.documentElement.scrollTop = 0;
        document.body.scrollTop = 0;
        
        // Add loading class to body initially
        document.body.classList.add('loading');
        
        // Prevent scroll restoration during loading
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
        
        // Fixed loading time - exactly 1 second
        const loadTime = 1000;
        
        // Hide loading screen after exactly 1 second
        setTimeout(() => {
            document.body.classList.remove('loading');
            document.body.classList.add('loaded');
            
            // Ensure we're still at the top after loading
            window.scrollTo(0, 0);
            
            // Remove loading screen from DOM immediately after animation
            setTimeout(() => {
                if (loadingScreen) {
                    loadingScreen.remove();
                }
                // Allow scrolling again and restore scroll behavior
                document.body.style.overflow = '';
                if ('scrollRestoration' in history) {
                    history.scrollRestoration = 'auto';
                }
            }, 250);
        }, loadTime);
    });
    
    // Also ensure scroll to top on page load (before DOMContentLoaded)
    window.addEventListener('load', function() {
        const loadingScreen = document.getElementById('loadingScreen');
        if (loadingScreen) {
            window.scrollTo(0, 0);
        }
    });
    
    // Immediate scroll reset (runs as soon as script loads)
    (function() {
        window.scrollTo(0, 0);
        document.documentElement.scrollTop = 0;
        document.body.scrollTop = 0;
    })();
</script>
@endif