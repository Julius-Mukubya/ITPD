@extends('layouts.public')

@section('title', 'Our Counselors - WellPath')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden h-screen">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1582750433449-648ed127bb54?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2087&q=80" 
             alt="Professional counselors and therapists" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>
    
    <!-- Content -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center justify-center">
        <div class="text-center">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-semibold mb-6">
                <span class="material-symbols-outlined !text-lg">group</span>
                Our Counselors
            </div>
            <h1 class="text-4xl lg:text-6xl font-black text-white tracking-tight mb-6">Meet Our Professional Counselors</h1>
            <p class="text-xl lg:text-2xl text-white/90 max-w-4xl mx-auto leading-relaxed mb-8">Our team of licensed mental health professionals brings years of experience and specialized training to support your wellbeing journey with compassion and confidentiality.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('public.counseling.sessions') }}" class="inline-flex items-center gap-2 bg-white text-primary px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="material-symbols-outlined !text-xl">add_circle</span>
                        Book Session
                    </a>
                @else
                    <button onclick="openLoginModal()" class="inline-flex items-center gap-2 bg-white text-primary px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="material-symbols-outlined !text-xl">login</span>
                        Login to Book Session
                    </button>
                @endauth
                <a href="#counselors-filters" class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm border-2 border-white/30 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/30 transition-all duration-200 transform hover:scale-105 scroll-to-filters">
                    <span class="material-symbols-outlined !text-xl">visibility</span>
                    Browse Counselors
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Filter Section -->
<div id="counselors-filters" class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-6 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
        <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
            <!-- Search Bar -->
            <div class="relative flex-1 max-w-md">
                <span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-[#61897c] dark:text-gray-400 !text-xl">search</span>
                <input id="search-input" type="text" placeholder="Search by name or specialization..." 
                       class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-[#111816] dark:text-white placeholder-[#61897c] dark:placeholder-gray-400 focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200">
            </div>
            
            <!-- Filter Buttons -->
            <div class="flex items-center gap-2">
                <button data-filter="all" class="filter-btn px-4 py-2 rounded-lg bg-primary text-white font-semibold text-sm transition-all duration-200 transform hover:scale-105 shadow-sm">
                    All Counselors
                </button>
                <button data-filter="available" class="filter-btn px-4 py-2 rounded-lg bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 text-[#61897c] dark:text-gray-400 hover:text-[#111816] dark:hover:text-white font-medium text-sm transition-colors">
                    Available
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Counselors Grid -->
<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
    <div class="flex flex-col flex-1 gap-10">
        @if($counselors->isEmpty())
        <div class="col-span-full flex flex-col items-center justify-center gap-8 py-20 text-center">
            <div class="relative">
                <div class="w-32 h-32 bg-gradient-to-br from-primary/20 to-primary/10 rounded-full flex items-center justify-center">
                    <span class="material-symbols-outlined text-primary !text-6xl">person_search</span>
                </div>
            </div>
            <div class="flex max-w-lg flex-col items-center gap-4">
                <h3 class="text-[#111816] dark:text-white text-2xl font-bold leading-tight">No Counselors Available</h3>
                <p class="text-[#61897c] dark:text-gray-400 text-base leading-relaxed">
                    Our counseling team is currently being set up. Please check back soon or contact us for more information.
                </p>
            </div>
        </div>
        @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php
                $gradients = [
                    'from-blue-500 to-indigo-600',
                    'from-emerald-500 to-teal-600',
                    'from-purple-500 to-pink-600',
                    'from-orange-500 to-red-600',
                    'from-cyan-500 to-blue-600',
                    'from-pink-500 to-rose-600',
                ];
                $badgeColors = [
                    'blue' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300',
                    'emerald' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300',
                    'purple' => 'bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300',
                    'orange' => 'bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-300',
                    'cyan' => 'bg-cyan-100 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-300',
                    'pink' => 'bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-300',
                ];
            @endphp
            
            @foreach($counselors as $index => $counselor)
            @php
                $initials = strtoupper(substr($counselor->name, 0, 2));
                $gradients = [
                    'from-purple-500 to-indigo-600',
                    'from-blue-500 to-cyan-600',
                    'from-green-500 to-teal-600',
                    'from-orange-500 to-red-600',
                    'from-pink-500 to-rose-600',
                    'from-indigo-500 to-purple-600',
                ];
                $gradient = $gradients[$index % count($gradients)];
            @endphp

            <article class="group block bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary/30 hover:-translate-y-1 h-full" data-counselor-name="{{ strtolower($counselor->name) }}" data-counselor-email="{{ strtolower($counselor->email) }}">
                <!-- Image Section -->
                <div class="relative h-48 overflow-hidden">
                    @if($counselor->avatar)
                        <img src="{{ asset('storage/' . $counselor->avatar) }}" alt="{{ $counselor->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full bg-gradient-to-br {{ $gradient }} flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                            <span class="text-6xl font-bold text-white">{{ $initials }}</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    
                    <!-- Available Badge -->
                    <div class="absolute top-4 right-4">
                        <div class="flex items-center gap-1.5 bg-green-500/90 backdrop-blur-sm px-3 py-1.5 rounded-full">
                            <span class="h-2 w-2 rounded-full bg-white animate-pulse"></span>
                            <span class="text-xs font-semibold text-white">Available</span>
                        </div>
                    </div>
                    
                    <!-- Name Overlay -->
                    <div class="absolute bottom-4 left-4 right-4">
                        <h3 class="text-xl font-bold text-white mb-1">{{ $counselor->name }}</h3>
                        <p class="text-white/90 text-sm font-medium">Professional Counselor</p>
                    </div>
                </div>
                
                <!-- Content Section -->
                <div class="p-6">
                    <div class="space-y-3 mb-4">
                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                            <span class="material-symbols-outlined !text-base text-primary">email</span>
                            <span class="truncate">{{ $counselor->email }}</span>
                        </div>
                        
                        @if($counselor->phone)
                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                            <span class="material-symbols-outlined !text-base text-primary">phone</span>
                            <span>{{ $counselor->phone }}</span>
                        </div>
                        @endif
                        
                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                            <span class="material-symbols-outlined !text-base text-primary">calendar_today</span>
                            <span>Member since {{ $counselor->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                    
                    <!-- Action Link -->
                    @auth
                        <a href="{{ route('public.counseling.sessions') }}" class="flex items-center justify-center gap-2 text-primary font-semibold text-sm group-hover:gap-3 transition-all">
                            <span>Request Session</span>
                            <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                        </a>
                    @else
                    <button onclick="document.getElementById('loginModal').classList.remove('hidden')" class="flex items-center justify-center gap-2 text-primary font-semibold text-sm group-hover:gap-3 transition-all w-full">
                        <span>Login to Book</span>
                        <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </button>
                    @endauth
                </div>
            </article>
            @endforeach
        </div>
        @endif
    </div>
</div>

<!-- CTA Section -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-gradient-to-r from-primary/10 to-green-50 dark:from-gray-800 dark:to-gray-800/50 rounded-2xl p-8 border border-primary/20 dark:border-gray-700 overflow-hidden">
            <!-- Decorative Icons -->
            <div class="absolute top-4 left-4 opacity-10">
                <span class="material-symbols-outlined text-6xl text-primary">support_agent</span>
            </div>
            <div class="absolute bottom-4 right-4 opacity-10">
                <span class="material-symbols-outlined text-6xl text-primary">groups</span>
            </div>
            
            <div class="relative text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/20 rounded-full mb-4">
                    <span class="material-symbols-outlined text-3xl text-primary">favorite</span>
                </div>
                <h3 class="text-xl font-bold text-[#111816] dark:text-white mb-2">Ready to Connect with a Counselor?</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-2xl mx-auto">Take the first step towards better mental health. Request a session with one of our professional counselors today.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    @auth
                        <a href="{{ route('public.counseling.sessions') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition-colors text-sm">
                            <span class="material-symbols-outlined text-base">add_circle</span>
                            <span>Request Session</span>
                        </a>
                    @else
                        <button onclick="document.getElementById('loginModal').classList.remove('hidden')" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition-colors text-sm">
                            <span class="material-symbols-outlined text-base">login</span>
                            <span>Login to Get Started</span>
                        </button>
                    @endauth
                    <a href="{{ route('public.counseling.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white dark:bg-gray-700 text-[#111816] dark:text-white border border-gray-300 dark:border-gray-600 rounded-lg font-semibold hover:border-primary hover:text-primary transition-colors text-sm">
                        <span class="material-symbols-outlined text-base">arrow_back</span>
                        <span>Back to Services</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@include('components.login-modal')
@endsection

@push('styles')
<style>
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
    
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #14eba3;
        border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #12d494;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentFilter = 'all';
    
    // Smooth scroll functionality for Browse Counselors button
    const scrollToFiltersBtn = document.querySelector('.scroll-to-filters');
    if (scrollToFiltersBtn) {
        scrollToFiltersBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const filtersSection = document.getElementById('counselors-filters');
            if (filtersSection) {
                // Calculate header height for offset
                const header = document.querySelector('header');
                const headerHeight = header ? header.offsetHeight : 80; // fallback to 80px
                const additionalOffset = 20; // Extra spacing for better UX
                
                // Get the position of the filters section
                const elementPosition = filtersSection.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerHeight - additionalOffset;
                
                // Smooth scroll to the calculated position
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
            }
        });
    }
    
    // Get all counselor cards
    const counselorCards = document.querySelectorAll('article.group');
    
    // Function to apply filters
    function applyFilters() {
        const searchValue = document.getElementById('search-input').value.toLowerCase();
        let visibleCount = 0;
        
        counselorCards.forEach(card => {
            let shouldShow = true;
            
            // Get card data
            const cardText = card.textContent.toLowerCase();
            const hasAvailableBadge = card.querySelector('.animate-pulse') !== null;
            
            // Search filter
            if (searchValue && !cardText.includes(searchValue)) {
                shouldShow = false;
            }
            
            // Availability filter
            if (currentFilter === 'available' && !hasAvailableBadge) {
                shouldShow = false;
            }
            
            // Show/hide card with animation
            if (shouldShow) {
                card.style.display = 'block';
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 10);
                visibleCount++;
            } else {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.display = 'none';
                }, 300);
            }
        });
        
        // Show/hide empty state
        showEmptyState(visibleCount === 0);
    }
    
    // Function to show/hide empty state
    function showEmptyState(show) {
        let emptyState = document.querySelector('.empty-state-message');
        
        if (show && !emptyState) {
            const grid = document.querySelector('.grid');
            emptyState = document.createElement('div');
            emptyState.className = 'empty-state-message col-span-full flex flex-col items-center justify-center gap-8 py-20 text-center';
            emptyState.innerHTML = `
                <div class="relative">
                    <div class="w-32 h-32 bg-gradient-to-br from-primary/20 to-primary/10 rounded-full flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary !text-6xl">person_search</span>
                    </div>
                </div>
                <div class="flex max-w-lg flex-col items-center gap-4">
                    <h3 class="text-[#111816] dark:text-white text-2xl font-bold leading-tight">No Counselors Found</h3>
                    <p class="text-[#61897c] dark:text-gray-400 text-base leading-relaxed">
                        No counselors match your current filters. Try adjusting your search criteria.
                    </p>
                </div>
            `;
            grid.appendChild(emptyState);
        } else if (!show && emptyState) {
            emptyState.remove();
        }
    }
    
    // Search functionality with debounce
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        let debounceTimer;
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                applyFilters();
            }, 300);
        });
    }
    
    // Filter buttons
    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active state from all buttons
            filterButtons.forEach(btn => {
                btn.classList.remove('bg-primary', 'text-white', 'shadow-sm');
                btn.classList.add('bg-white', 'dark:bg-gray-800', 'border-2', 'border-gray-200', 'dark:border-gray-700', 'text-[#61897c]', 'dark:text-gray-400');
            });
            
            // Add active state to clicked button
            this.classList.add('bg-primary', 'text-white', 'shadow-sm');
            this.classList.remove('bg-white', 'dark:bg-gray-800', 'border-2', 'border-gray-200', 'dark:border-gray-700', 'text-[#61897c]', 'dark:text-gray-400');
            
            // Update filter and apply
            currentFilter = this.getAttribute('data-filter');
            applyFilters();
        });
    });
    
    // Intersection Observer for fade-in animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe all counselor cards
    counselorCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});
</script>
@endpush