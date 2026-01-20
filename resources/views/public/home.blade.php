@extends('layouts.public')

@section('title', 'WellPath - Your Wellbeing Matters')

@section('content')
<div class="w-full">
    <!-- Hero Section -->
<section class="relative overflow-hidden h-screen">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2073&q=80" 
             alt="Student wellness and support" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>
    
    <!-- Content -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center justify-center">
        <div class="text-center">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-semibold mb-6">
                <span class="material-symbols-outlined !text-lg">favorite</span>
                WellPath
            </div>
            <h1 class="text-4xl lg:text-6xl font-black text-white tracking-tight mb-6">Your Wellbeing, Our Priority</h1>
            <p class="text-xl lg:text-2xl text-white/90 max-w-4xl mx-auto leading-relaxed mb-8">A confidential, supportive space for students to access resources and find community for drug and alcohol awareness.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                    <button onclick="openSignupModal()" class="inline-flex items-center gap-2 bg-white text-primary px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="material-symbols-outlined !text-xl">person_add</span>
                        Get Started
                    </button>
                    <a href="{{ route('content.index') }}" class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm border-2 border-white/30 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/30 transition-all duration-200 transform hover:scale-105">
                        <span class="material-symbols-outlined !text-xl">library_books</span>
                        Explore Resources
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-white text-primary px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="material-symbols-outlined !text-xl">dashboard</span>
                        Go to Dashboard
                    </a>
                    <a href="{{ route('content.index') }}" class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm border-2 border-white/30 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/30 transition-all duration-200 transform hover:scale-105">
                        <span class="material-symbols-outlined !text-xl">library_books</span>
                        Explore Resources
                    </a>
                @endguest
            </div>
        </div>
    </div>
</section>

    <!-- Services Section -->
    <div class="w-full bg-white dark:bg-gray-900 py-16 sm:py-20 border-t border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    How We Support You
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Comprehensive resources and support services designed to help you thrive
                </p>
            </div>
            
            <!-- Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <x-service-card 
                    icon="quiz"
                    title="Self-Assessment Tools"
                    description="Understand your habits with confidential, easy-to-use assessment tools."
                    color="emerald-600"
                />
                <x-service-card 
                    icon="health_and_safety"
                    title="Professional Counseling"
                    description="Connect with qualified counselors for private and supportive guidance."
                    color="green-600"
                />
                <x-service-card 
                    icon="auto_stories"
                    title="Educational Resources"
                    description="Access a rich library of articles, videos, and guides to stay informed."
                    color="teal-600"
                />
            </div>
        </div>
    </div>
    
    <!-- Featured Content Section -->
    <div class="w-full py-16 sm:py-24 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Featured Content
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Discover our most popular and impactful resources to support your wellbeing journey.
                </p>
            </div>
            
            @if(isset($featuredContents) && $featuredContents->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($featuredContents as $content)
                    <div class="content-card-wrapper">
                        <x-content-card 
                            :content="$content"
                            :title="$content->title"
                            :category="$content->category->name ?? 'General'"
                            :description="$content->excerpt ?? Str::limit(strip_tags($content->content), 120)"
                            :image="$content->featured_image_url"
                            :type="$content->type"
                            :url="route('content.show', $content)"
                        />
                    </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
                    <span class="material-symbols-outlined text-6xl text-gray-400 mb-4">auto_stories</span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Featured Content</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">We're curating amazing resources for you. Check back soon for featured articles, videos, and guides!</p>
                    <a href="{{ route('content.index') }}" class="inline-flex items-center gap-2 text-primary hover:underline font-semibold">
                        <span>Browse All Content</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Topics Section -->
    <div class="w-full py-16 sm:py-24 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Explore Topics
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Find information and resources on topics that matter to you. Get expert guidance and support for your wellbeing journey.
                </p>
            </div>
            <!-- Carousel Container -->
            <div class="relative mt-12 max-w-[1032px] mx-auto">
                <!-- Navigation Buttons -->
                <button id="prevBtn" class="absolute -left-6 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white dark:bg-gray-800 rounded-full shadow-lg border border-gray-200 dark:border-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:text-primary hover:border-primary transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="material-symbols-outlined">chevron_left</span>
                </button>
                <button id="nextBtn" class="absolute -right-6 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white dark:bg-gray-800 rounded-full shadow-lg border border-gray-200 dark:border-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:text-primary hover:border-primary transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="material-symbols-outlined">chevron_right</span>
                </button>

                <!-- Carousel Track -->
                <div class="overflow-hidden">
                    <div id="topicsCarousel" class="flex transition-transform duration-300 ease-in-out gap-6">
                        @if(isset($categories) && $categories->count() > 0)
                            @foreach($categories->take(8) as $category)
                            <div class="flex-none w-80">
                                <x-topic-card 
                                    :icon="$category->icon ?? 'category'"
                                    :title="$category->name"
                                    :description="$category->description ?? 'Explore resources and information'"
                                    :image="$category->image"
                                    :url="route('content.index', ['category' => $category->slug])"
                                />
                            </div>
                            @endforeach
                        @else
                            <!-- Default topic categories -->
                            <x-default-topic-cards />
                        @endif
                    </div>
                </div>

                <!-- Dots Indicator -->
                <div id="dotsContainer" class="flex justify-center mt-8 gap-2">
                    <!-- Dots will be generated by JavaScript -->
                </div>
            </div>
        </div>
    </div>
    
    <!-- Featured Campaigns Section -->
    <div class="w-full py-16 sm:py-24 bg-gray-50 dark:bg-black/20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-header 
                title="Featured Campaigns"
                description="Get involved in our featured initiatives to promote a healthy and safe campus environment."
            />
            @if(isset($activeCampaigns) && $activeCampaigns->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mt-12">
                    @foreach($activeCampaigns->take(2) as $campaign)
                    <x-campaign-card 
                        :title="$campaign->title"
                        :description="$campaign->description"
                        :image="$campaign->banner_image ? $campaign->banner_url : 'https://lh3.googleusercontent.com/aida-public/AB6AXuAwMb1C6MtZohZ1eKj35TLv2GRwHxtebwwtcIyoiKVjFHFn_B9GvgNA4sAOEpEklaHgWJhvgYRFrxlrKsZYFL9EW7KMeKnDYhkx3SY2uLUF0PvOgmFKCJw2PZWnYEKqYydHlRUMP5uzn0tlgh57_Kdn8DD4cStq8lJxOdV2OVatvClqef6yur4lj7arsClsRFtvvwWDEj0VdbZpwtP76ebmYNeatBGOTQzbreTDo1BrztNhb3ruUgMB2GOgaUYgkKIFa_ybhunxUA'"
                        :url="route('campaigns.show', $campaign)"
                    />
                    @endforeach
                </div>
            @else
                <div class="mt-12 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
                    <span class="material-symbols-outlined text-6xl text-gray-400 mb-4">campaign</span>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Featured Campaigns</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">There are currently no featured campaigns. Check back soon for upcoming events and initiatives!</p>
                    <a href="{{ route('campaigns.index') }}" class="inline-flex items-center gap-2 text-primary hover:underline font-semibold">
                        <span>View All Campaigns</span>
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Call to Action Section -->
    <div class="w-full py-16 sm:py-24 bg-background-light dark:bg-background-dark">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-primary/80 to-primary rounded-xl p-8 md:p-12 text-center">
                <h2 class="text-3xl font-bold text-background-dark tracking-tight">Ready to Take the Next Step?</h2>
                <p class="mt-4 text-lg text-background-dark/80 max-w-2xl mx-auto">Create a free, confidential account to access personalized tools, save resources, and connect with counselors.</p>
                <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-8 text-background-dark">
                    <div class="flex flex-col">
                        <span class="text-4xl font-black">100%</span>
                        <span class="text-sm font-medium">Confidential</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-4xl font-black">500+</span>
                        <span class="text-sm font-medium">Students Supported</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-4xl font-black">24/7</span>
                        <span class="text-sm font-medium">Resource Access</span>
                    </div>
                </div>
                @guest
                    <button onclick="openSignupModal()" class="inline-block mt-10 rounded-lg bg-primary px-8 py-3 text-base font-bold text-background-dark hover:bg-opacity-80 transition-colors">Create Your Account</button>
                @else
                    <a class="inline-block mt-10 rounded-lg bg-primary px-8 py-3 text-base font-bold text-background-dark hover:bg-opacity-80 transition-colors" href="{{ route('dashboard') }}">Go to Dashboard</a>
                @endguest
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Topics Carousel
    const carousel = document.getElementById('topicsCarousel');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const dotsContainer = document.getElementById('dotsContainer');
    
    if (!carousel || !prevBtn || !nextBtn) return;
    
    const cards = carousel.children;
    const totalCards = cards.length;
    const cardsPerView = 3; // Show 3 cards at a time
    const cardWidth = 320; // 80 * 4 (w-80 = 20rem = 320px)
    const gap = 24; // gap-6 = 1.5rem = 24px
    const slideWidth = cardWidth + gap;
    const autoSlideInterval = 5000; // Auto-slide every 5 seconds
    
    let currentIndex = 0;
    let autoSlideTimer = null;
    let isUserInteracting = false;
    const maxIndex = Math.max(0, totalCards - cardsPerView);
    
    // Create dots
    const totalDots = Math.ceil(totalCards / cardsPerView);
    for (let i = 0; i < totalDots; i++) {
        const dot = document.createElement('button');
        dot.className = 'w-2 h-2 rounded-full transition-all duration-300';
        dot.setAttribute('aria-label', `Go to slide ${i + 1}`);
        dot.addEventListener('click', () => {
            isUserInteracting = true;
            goToSlide(i * cardsPerView);
            resetAutoSlide();
        });
        dotsContainer.appendChild(dot);
    }
    
    function updateCarousel() {
        const offset = -(currentIndex * slideWidth);
        carousel.style.transform = `translateX(${offset}px)`;
        
        // Hide/show buttons based on position
        if (currentIndex === 0) {
            prevBtn.style.opacity = '0';
            prevBtn.style.pointerEvents = 'none';
        } else {
            prevBtn.style.opacity = '1';
            prevBtn.style.pointerEvents = 'auto';
        }
        
        if (currentIndex >= maxIndex) {
            nextBtn.style.opacity = '0';
            nextBtn.style.pointerEvents = 'none';
        } else {
            nextBtn.style.opacity = '1';
            nextBtn.style.pointerEvents = 'auto';
        }
        
        // Update dots
        const dots = dotsContainer.children;
        const activeDotIndex = Math.floor(currentIndex / cardsPerView);
        Array.from(dots).forEach((dot, index) => {
            if (index === activeDotIndex) {
                dot.className = 'w-8 h-2 rounded-full bg-primary transition-all duration-300';
            } else {
                dot.className = 'w-2 h-2 rounded-full bg-gray-300 dark:bg-gray-600 transition-all duration-300';
            }
        });
    }
    
    function goToSlide(index) {
        currentIndex = Math.max(0, Math.min(index, maxIndex));
        updateCarousel();
    }
    
    function nextCarouselSlide() {
        if (currentIndex < maxIndex) {
            currentIndex++;
            updateCarousel();
        }
    }
    
    function prevCarouselSlide() {
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
        }
    }
    
    // Auto-slide functionality
    function startAutoSlide() {
        stopAutoSlide();
        autoSlideTimer = setInterval(() => {
            if (!isUserInteracting && currentIndex < maxIndex) {
                nextCarouselSlide();
            } else if (currentIndex >= maxIndex) {
                stopAutoSlide(); // Stop when reaching the end
            }
        }, autoSlideInterval);
    }
    
    function stopAutoSlide() {
        if (autoSlideTimer) {
            clearInterval(autoSlideTimer);
            autoSlideTimer = null;
        }
    }
    
    function resetAutoSlide() {
        stopAutoSlide();
        setTimeout(() => {
            isUserInteracting = false;
            startAutoSlide();
        }, autoSlideInterval);
    }
    
    prevBtn.addEventListener('click', () => {
        isUserInteracting = true;
        prevCarouselSlide();
        resetAutoSlide();
    });
    
    nextBtn.addEventListener('click', () => {
        isUserInteracting = true;
        nextCarouselSlide();
        resetAutoSlide();
    });
    
    // Pause auto-slide on hover
    carousel.addEventListener('mouseenter', () => {
        isUserInteracting = true;
        stopAutoSlide();
    });
    
    carousel.addEventListener('mouseleave', () => {
        isUserInteracting = false;
        startAutoSlide();
    });
    
    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            isUserInteracting = true;
            prevBtn.click();
        } else if (e.key === 'ArrowRight') {
            isUserInteracting = true;
            nextBtn.click();
        }
    });
    
    // Touch/swipe support
    let touchStartX = 0;
    let touchEndX = 0;
    
    carousel.addEventListener('touchstart', (e) => {
        isUserInteracting = true;
        stopAutoSlide();
        touchStartX = e.changedTouches[0].screenX;
    });
    
    carousel.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
        resetAutoSlide();
    });
    
    function handleSwipe() {
        const swipeThreshold = 50;
        if (touchStartX - touchEndX > swipeThreshold) {
            nextCarouselSlide();
        } else if (touchEndX - touchStartX > swipeThreshold) {
            prevCarouselSlide();
        }
    }
    
    // Initialize
    updateCarousel();
    startAutoSlide();
    
    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            updateCarousel();
        }, 250);
    });
    
    // Pause when page is not visible
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            stopAutoSlide();
        } else {
            startAutoSlide();
        }
    });
    
    // Animate Featured Content Cards on scroll
    const contentCards = document.querySelectorAll('.content-card-wrapper');
    
    if (contentCards.length > 0) {
        // Set initial state
        contentCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
        });
        
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.transition = 'all 0.6s ease-out';
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 100);
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);
        
        contentCards.forEach(card => {
            observer.observe(card);
        });
    }
});
</script>
@endpush