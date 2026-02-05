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
            <h1 class="text-3xl sm:text-4xl lg:text-6xl font-black text-white tracking-tight mb-6">Your Wellbeing, Our Priority</h1>
            <p class="text-lg sm:text-xl lg:text-2xl text-white/90 max-w-4xl mx-auto leading-relaxed mb-8">A confidential, supportive space for students to access resources and find community for drug and alcohol awareness.</p>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center items-center">
                @guest
                    <button onclick="openSignupModal()" class="inline-flex items-center gap-2 bg-white text-primary px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-bold text-base sm:text-lg hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-lg w-full sm:w-auto justify-center">
                        <span class="material-symbols-outlined !text-lg sm:!text-xl">person_add</span>
                        Get Started
                    </button>
                    <a href="{{ route('content.index') }}" class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm border-2 border-white/30 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-bold text-base sm:text-lg hover:bg-white/30 transition-all duration-200 transform hover:scale-105 w-full sm:w-auto justify-center">
                        <span class="material-symbols-outlined !text-lg sm:!text-xl">library_books</span>
                        Explore Resources
                    </a>
                @else
                    @if(auth()->user()->role === 'user')
                        <a href="{{ route('public.counseling.sessions') }}" class="inline-flex items-center gap-2 bg-white text-primary px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-bold text-base sm:text-lg hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-lg w-full sm:w-auto justify-center">
                            <span class="material-symbols-outlined !text-lg sm:!text-xl">psychology</span>
                            Request Counseling
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 bg-white text-primary px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-bold text-base sm:text-lg hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-lg w-full sm:w-auto justify-center">
                            <span class="material-symbols-outlined !text-lg sm:!text-xl">dashboard</span>
                            Go to Dashboard
                        </a>
                    @endif
                    <a href="{{ route('content.index') }}" class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm border-2 border-white/30 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-xl font-bold text-base sm:text-lg hover:bg-white/30 transition-all duration-200 transform hover:scale-105 w-full sm:w-auto justify-center">
                        <span class="material-symbols-outlined !text-lg sm:!text-xl">library_books</span>
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
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mt-12 max-w-5xl mx-auto">
                    @foreach($activeCampaigns->take(2) as $campaign)
                    <article class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-primary/30 transform hover:-translate-y-1">
                        <!-- Image Container -->
                        <div class="relative overflow-hidden">
                            @if($campaign->banner_image)
                                <img src="{{ $campaign->banner_url }}" alt="{{ $campaign->title }}" 
                                     class="w-full h-48 object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-primary/20 to-green-500/20 flex items-center justify-center">
                                    <div class="text-center">
                                        <div class="w-12 h-12 bg-primary/30 rounded-full flex items-center justify-center mb-2 mx-auto">
                                            <span class="material-symbols-outlined text-primary !text-xl">campaign</span>
                                        </div>
                                        <p class="text-[#111816] dark:text-white font-medium text-sm">{{ $campaign->title }}</p>
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Overlay Gradient -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            
                            <!-- Status Badge -->
                            <div class="absolute top-3 left-3">
                                <div class="flex items-center gap-1.5 bg-green-500 text-white px-2.5 py-1 rounded-full text-xs font-bold shadow-lg">
                                    <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                                    Active
                                </div>
                            </div>
                            
                            <!-- Campaign Type Badge -->
                            <div class="absolute top-3 right-3">
                                <div class="bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm px-2.5 py-1 rounded-full text-xs font-semibold text-[#111816] dark:text-white shadow-lg">
                                    {{ ucfirst($campaign->type ?? 'General') }}
                                </div>
                            </div>
                            
                            <!-- Hover Action -->
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <div class="bg-primary/90 backdrop-blur-sm rounded-full p-3 transform scale-75 group-hover:scale-100 transition-transform duration-300 shadow-2xl">
                                    <span class="material-symbols-outlined text-white !text-xl">arrow_forward</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Content -->
                        <div class="p-5">
                            <!-- Title -->
                            <h3 class="text-lg font-bold text-[#111816] dark:text-white mb-2 group-hover:text-primary dark:group-hover:text-primary transition-colors duration-200 line-clamp-2">
                                {{ $campaign->title }}
                            </h3>
                            
                            <!-- Description -->
                            <p class="text-[#61897c] dark:text-gray-400 text-sm leading-relaxed mb-4 line-clamp-3">
                                {{ Str::limit($campaign->description, 100) }}
                            </p>
                            
                            <!-- Campaign Details -->
                            <div class="flex items-center justify-between mb-4 p-3 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                                <div class="flex items-center gap-1.5 text-[#61897c] dark:text-gray-400">
                                    <span class="material-symbols-outlined !text-base">calendar_today</span>
                                    <span class="text-xs font-medium">
                                        {{ $campaign->start_date->format('M d') }} - {{ $campaign->end_date->format('M d') }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-1 text-[#61897c] dark:text-gray-400">
                                    <span class="material-symbols-outlined !text-base">schedule</span>
                                    <span class="text-xs font-medium">
                                        @if($campaign->end_date && $campaign->end_date->isFuture())
                                            {{ $campaign->end_date->diffInDays(now()) }}d left
                                        @else
                                            Ongoing
                                        @endif
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                <a href="{{ route('campaigns.show', $campaign) }}" 
                                   class="flex-1 bg-gradient-to-r from-primary to-green-500 text-white text-center py-2.5 rounded-lg font-semibold text-sm hover:from-primary/90 hover:to-green-500/90 transition-all duration-200 transform hover:scale-105 shadow-md hover:shadow-lg">
                                    <span class="flex items-center justify-center gap-1.5">
                                        <span class="material-symbols-outlined !text-base">info</span>
                                        Learn More
                                    </span>
                                </a>
                                <a href="{{ route('campaigns.show', $campaign) }}" 
                                   class="px-3 py-2.5 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-[#61897c] dark:text-gray-400 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-primary dark:hover:text-primary transition-all duration-200">
                                    <span class="material-symbols-outlined !text-base">contact_support</span>
                                </a>
                            </div>
                        </div>
                    </article>
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
                    @if(auth()->user()->role === 'user')
                        <a class="inline-block mt-10 rounded-lg bg-primary px-8 py-3 text-base font-bold text-background-dark hover:bg-opacity-80 transition-colors" href="{{ route('public.counseling.sessions') }}">My Counseling Sessions</a>
                    @else
                        <a class="inline-block mt-10 rounded-lg bg-primary px-8 py-3 text-base font-bold text-background-dark hover:bg-opacity-80 transition-colors" href="{{ route('dashboard') }}">Go to Dashboard</a>
                    @endif
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
    
    // Animate Campaign Cards on scroll
    const campaignCards = document.querySelectorAll('article.group');
    
    if (campaignCards.length > 0) {
        // Set initial state
        campaignCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
        });
        
        const campaignObserverOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const campaignObserver = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    setTimeout(() => {
                        entry.target.style.transition = 'all 0.6s ease-out';
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, index * 150);
                    campaignObserver.unobserve(entry.target);
                }
            });
        }, campaignObserverOptions);
        
        campaignCards.forEach(card => {
            campaignObserver.observe(card);
        });
    }
});
</script>
@endpush

@push('styles')
<style>
    /* Smooth animations */
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    /* Line clamping */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush