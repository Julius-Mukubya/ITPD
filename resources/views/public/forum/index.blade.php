@extends('layouts.public')

@section('title', 'Community Forum - WellPath')

@section('content')


<!-- Error Messages -->
@if($errors->any())
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-4">
        <div class="flex items-start gap-2">
            <span class="material-symbols-outlined text-red-600 dark:text-red-400">error</span>
            <div>
                <p class="text-red-800 dark:text-red-200 font-medium mb-2">Please fix the following errors:</p>
                <ul class="text-sm text-red-700 dark:text-red-300 list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Hero Section -->
<section class="relative overflow-hidden h-screen">
    <!-- Background Image -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2071&q=80" 
             alt="Students discussing and connecting in community" 
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>
    
    <!-- Content -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center justify-center">
        <div class="text-center">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-semibold mb-6">
                <span class="material-symbols-outlined !text-lg">forum</span>
                Community Forum
            </div>
            <h1 class="text-4xl lg:text-6xl font-black text-white tracking-tight mb-6">Community Forum</h1>
            <p class="text-xl lg:text-2xl text-white/90 max-w-4xl mx-auto leading-relaxed mb-8">Connect with peers, share experiences, and find support in a safe, moderated environment. Join the conversation today.</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <button onclick="document.getElementById('createDiscussionModal').classList.remove('hidden')" class="inline-flex items-center gap-2 bg-white text-primary px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="material-symbols-outlined !text-xl">add_circle</span>
                        Start Discussion
                    </button>
                @else
                    <button onclick="openLoginModal()" class="inline-flex items-center gap-2 bg-white text-primary px-8 py-4 rounded-xl font-bold text-lg hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="material-symbols-outlined !text-xl">login</span>
                        Login to Participate
                    </button>
                @endauth
                <a href="#discussions" class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm border-2 border-white/30 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/30 transition-all duration-200 transform hover:scale-105">
                    <span class="material-symbols-outlined !text-xl">visibility</span>
                    Browse Discussions
                </a>
            </div>
        </div>
    </div>
</section>

<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-col flex-1 gap-10">
    <!-- Info Banner -->
    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 border border-emerald-200 dark:border-emerald-800 rounded-2xl p-6">
        <div class="flex gap-4">
            <span class="material-symbols-outlined text-primary text-3xl flex-shrink-0">info</span>
            <div class="flex-1">
                <h3 class="font-bold text-emerald-900 dark:text-emerald-100 mb-2">Safe & Supportive Space</h3>
                <p class="text-sm text-emerald-800 dark:text-emerald-200 mb-3">
                    Our community forum is moderated by professional counselors to ensure a respectful and supportive environment for all members.
                </p>
                @guest
                <button onclick="openSignupModal()" class="bg-primary text-white px-4 py-2 rounded-lg font-semibold hover:bg-primary/90 transition-colors text-sm">
                    Sign Up to Join the Discussion
                </button>
                @endguest
            </div>
        </div>
    </div>

    <!-- Categories -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Discussion Categories</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
                $categoryImages = [
                    'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=400&h=300&fit=crop', // General Discussion - People talking
                    'https://images.unsplash.com/photo-1559757175-0eb30cd8c063?w=400&h=300&fit=crop', // Mental Health - Therapy/counseling
                    'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=300&fit=crop', // Stress & Anxiety - Meditation/calm
                    'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=400&h=300&fit=crop', // Academic Support - Books/studying
                    'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=400&h=300&fit=crop', // Substance Use - Health/recovery
                    'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=400&h=300&fit=crop', // Relationships - People connecting
                    'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=400&h=300&fit=crop', // Self-Care - Wellness/spa
                    'https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=400&h=300&fit=crop', // Success Stories - Achievement/celebration
                ];
            @endphp
            @foreach($categories ?? [] as $index => $category)
            @php
                $categoryImage = $categoryImages[$index % count($categoryImages)];
            @endphp
            <a href="{{ route('public.forum.category', $category->slug ?? 'general') }}" class="group block bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary/30 hover:-translate-y-1 h-full">
                <!-- Image Section -->
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $categoryImage }}" alt="{{ $category->name ?? 'General' }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    
                    <!-- Icon Badge -->
                    <div class="absolute top-4 left-4">
                        <div class="w-12 h-12 bg-white/90 backdrop-blur-sm rounded-lg flex items-center justify-center shadow-lg">
                            <span class="material-symbols-outlined text-primary text-2xl">{{ $category->icon ?? 'forum' }}</span>
                        </div>
                    </div>
                    
                    <!-- Posts Count Badge -->
                    <div class="absolute top-4 right-4">
                        <div class="flex items-center gap-1 bg-primary/90 backdrop-blur-sm px-3 py-1.5 rounded-full text-xs font-semibold text-white">
                            <span class="material-symbols-outlined !text-sm">article</span>
                            {{ $category->posts_count ?? 0 }} posts
                        </div>
                    </div>
                </div>
                
                <!-- Content Section -->
                <div class="p-6">
                    <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2 group-hover:text-primary transition-colors line-clamp-2">
                        {{ $category->name ?? 'General' }}
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed mb-4">
                        {{ $category->description ?? 'General discussions' }}
                    </p>
                    
                    <!-- Browse Link -->
                    <span class="flex items-center justify-center gap-2 text-primary font-semibold text-sm group-hover:gap-3 transition-all">
                        <span>Browse Discussions</span>
                        <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </span>
                </div>
            </a>
            @endforeach
        </div>
    </div>



    <!-- Community Guidelines -->
    <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-2xl p-8 border border-emerald-200 dark:border-emerald-800">
        <div class="flex items-start gap-4">
            <span class="material-symbols-outlined text-primary text-3xl flex-shrink-0">verified_user</span>
            <div>
                <h3 class="text-xl font-bold text-emerald-900 dark:text-emerald-100 mb-4">Community Guidelines</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-emerald-800 dark:text-emerald-200">
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                        <span>Be respectful and supportive of others</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                        <span>Keep discussions relevant and constructive</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                        <span>Protect your privacy and that of others</span>
                    </div>
                    <div class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                        <span>Report inappropriate content to moderators</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
</div>

<!-- Community Features Section -->
<section class="py-16 bg-gradient-to-br from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/20 rounded-full mb-4">
                <span class="material-symbols-outlined text-3xl text-primary">groups</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">Why Join Our Community?</h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Connect with peers, share experiences, and find support in a safe, moderated environment designed for student wellness.
            </p>
        </div>

        <!-- Features Carousel -->
        <div class="relative mt-12 max-w-[1032px] mx-auto mb-12">
            <!-- Navigation Buttons -->
            <button id="prevBtn" class="absolute -left-6 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white dark:bg-gray-800 rounded-full shadow-lg border border-gray-200 dark:border-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:text-primary hover:border-primary transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                <span class="material-symbols-outlined">chevron_left</span>
            </button>
            <button id="nextBtn" class="absolute -right-6 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white dark:bg-gray-800 rounded-full shadow-lg border border-gray-200 dark:border-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:text-primary hover:border-primary transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                <span class="material-symbols-outlined">chevron_right</span>
            </button>

            <!-- Carousel Track -->
            <div class="overflow-hidden">
                <div id="featuresCarousel" class="flex transition-transform duration-300 ease-in-out gap-6">
                    <!-- Safe Environment -->
                    <div class="flex-none w-80">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary/30 hover:-translate-y-1 h-full group">
                            <!-- Image Section -->
                            <div class="relative h-48 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?w=600&h=400&fit=crop&crop=center" 
                                     alt="Safe & Moderated Community" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                                
                                <!-- Category Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="bg-white/90 backdrop-blur-sm text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                                        Safe & Moderated
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Content Section -->
                            <div class="p-6">
                                <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2 group-hover:text-primary transition-colors">
                                    Safe & Moderated
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed">
                                    Our community is moderated by professional counselors to ensure respectful, supportive conversations that prioritize your wellbeing.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Anonymous Posting -->
                    <div class="flex-none w-80">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary/30 hover:-translate-y-1 h-full group">
                            <!-- Image Section -->
                            <div class="relative h-48 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1614064641938-3bbee52942c7?w=600&h=400&fit=crop&crop=center" 
                                     alt="Anonymous Posting" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                                
                                <!-- Category Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="bg-white/90 backdrop-blur-sm text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                                        Anonymous Posting
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Content Section -->
                            <div class="p-6">
                                <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2 group-hover:text-primary transition-colors">
                                    Anonymous Posting
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed">
                                    Share your thoughts and experiences anonymously when you need privacy, while still connecting with others who understand.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Peer Support -->
                    <div class="flex-none w-80">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary/30 hover:-translate-y-1 h-full group">
                            <!-- Image Section -->
                            <div class="relative h-48 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=600&h=400&fit=crop&crop=center" 
                                     alt="Peer Support Community" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                                
                                <!-- Category Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="bg-white/90 backdrop-blur-sm text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                                        Peer Support
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Content Section -->
                            <div class="p-6">
                                <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2 group-hover:text-primary transition-colors">
                                    Peer Support
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed">
                                    Connect with fellow students who understand your challenges. Share experiences, offer support, and build meaningful connections.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Expert Guidance -->
                    <div class="flex-none w-80">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary/30 hover:-translate-y-1 h-full group">
                            <!-- Image Section -->
                            <div class="relative h-48 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1559757175-0eb30cd8c063?w=600&h=400&fit=crop&crop=center" 
                                     alt="Expert Guidance" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                                
                                <!-- Category Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="bg-white/90 backdrop-blur-sm text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                                        Expert Guidance
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Content Section -->
                            <div class="p-6">
                                <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2 group-hover:text-primary transition-colors">
                                    Expert Guidance
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed">
                                    Benefit from insights and guidance from qualified counselors and mental health professionals within our community.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Always Available -->
                    <div class="flex-none w-80">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary/30 hover:-translate-y-1 h-full group">
                            <!-- Image Section -->
                            <div class="relative h-48 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=600&h=400&fit=crop&crop=center" 
                                     alt="Always Available Support" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                                
                                <!-- Category Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="bg-white/90 backdrop-blur-sm text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                                        Always Available
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Content Section -->
                            <div class="p-6">
                                <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2 group-hover:text-primary transition-colors">
                                    Always Available
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed">
                                    Access support and conversations whenever you need them. Our community is here around the clock for you.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Diverse Topics -->
                    <div class="flex-none w-80">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700 hover:border-primary/30 hover:-translate-y-1 h-full group">
                            <!-- Image Section -->
                            <div class="relative h-48 overflow-hidden">
                                <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=600&h=400&fit=crop&crop=center" 
                                     alt="Diverse Topics Discussion" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                                
                                <!-- Category Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="bg-white/90 backdrop-blur-sm text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">
                                        Diverse Topics
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Content Section -->
                            <div class="p-6">
                                <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2 group-hover:text-primary transition-colors">
                                    Diverse Topics
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-3 leading-relaxed">
                                    Explore discussions on mental health, academic stress, relationships, self-care, and all aspects of student life and wellness.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dots Indicator -->
            <div id="dotsContainer" class="flex justify-center mt-8 gap-2">
                <!-- Dots will be generated by JavaScript -->
            </div>
        </div>

        <!-- Quick Start Guide -->
        <div class="bg-gradient-to-r from-primary/5 to-green-50 dark:from-primary/10 dark:to-gray-800 rounded-2xl p-8 border border-primary/20 dark:border-primary/30">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Ready to Get Started?</h3>
                <p class="text-gray-600 dark:text-gray-400">Follow these simple steps to join our supportive community</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-3 font-bold text-lg">1</div>
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Choose a Category</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Browse our discussion categories and find topics that resonate with you</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-3 font-bold text-lg">2</div>
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Read & Engage</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Read existing discussions and engage with comments that speak to you</p>
                </div>
                <div class="text-center">
                    <div class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center mx-auto mb-3 font-bold text-lg">3</div>
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Share Your Voice</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Start your own discussion or reply to others with your experiences</p>
                </div>
            </div>
            
            <div class="text-center mt-8">
                @auth
                    <button onclick="openCreateDiscussionModal()" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-semibold hover:bg-primary/90 transition-all duration-200 transform hover:scale-105 shadow-lg">
                        <span class="material-symbols-outlined">add</span>
                        Start Your First Discussion
                    </button>
                @else
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <button onclick="openSignupModal()" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-semibold hover:bg-primary/90 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <span class="material-symbols-outlined">person_add</span>
                            Join the Community
                        </button>
                        <button onclick="openLoginModal()" class="inline-flex items-center gap-2 px-6 py-3 bg-white dark:bg-gray-700 text-primary border-2 border-primary rounded-xl font-semibold hover:bg-primary hover:text-white transition-all duration-200">
                            <span class="material-symbols-outlined">login</span>
                            Sign In
                        </button>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
@guest
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-gradient-to-r from-primary/10 to-green-50 dark:from-gray-800 dark:to-gray-800/50 rounded-2xl p-8 border border-primary/20 dark:border-gray-700 overflow-hidden">
            <!-- Decorative Icons -->
            <div class="absolute top-4 left-4 opacity-10">
                <span class="material-symbols-outlined text-6xl text-primary">forum</span>
            </div>
            <div class="absolute bottom-4 right-4 opacity-10">
                <span class="material-symbols-outlined text-6xl text-primary">groups</span>
            </div>
            
            <div class="relative text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/20 rounded-full mb-4">
                    <span class="material-symbols-outlined text-3xl text-primary">favorite</span>
                </div>
                <h3 class="text-xl font-bold text-[#111816] dark:text-white mb-2">Join Our Community Today</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-2xl mx-auto">Connect with peers, share your experiences, and find support in a safe, moderated environment. Your voice matters.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <button onclick="openSignupModal()" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition-colors text-sm">
                        <span class="material-symbols-outlined text-base">person_add</span>
                        <span>Create Free Account</span>
                    </button>
                    <button onclick="openLoginModal()" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white dark:bg-gray-700 text-[#111816] dark:text-white border border-gray-300 dark:border-gray-600 rounded-lg font-semibold hover:border-primary hover:text-primary transition-colors text-sm">
                        <span class="material-symbols-outlined text-base">login</span>
                        <span>Sign In</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
@endguest


@auth
@include('components.create-discussion-modal')

<!-- Floating Action Button (Mobile) -->
<button onclick="openCreateDiscussionModal()" 
        class="fixed bottom-6 right-6 w-14 h-14 bg-primary text-white rounded-full shadow-lg hover:bg-primary/90 transition-all duration-200 transform hover:scale-110 z-40 md:hidden flex items-center justify-center">
    <span class="material-symbols-outlined text-2xl">add</span>
</button>
@endauth

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
    
    .comment-preview {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    .comment-preview::before {
        content: '';
        position: absolute;
        top: 15px;
        left: -5px;
        width: 10px;
        height: 10px;
        background: inherit;
        border-left: 1px solid;
        border-bottom: 1px solid;
        border-color: inherit;
        transform: rotate(45deg);
        z-index: -1;
    }
    
    @media (max-width: 1024px) {
        .comment-preview {
            left: -320px !important;
            right: auto !important;
        }
        
        .comment-preview::before {
            left: auto;
            right: 15px;
            transform: rotate(-135deg);
        }
    }
</style>
@endpush

@push('scripts')
<script>
function filterByCategory(categoryName) {
    const discussions = document.querySelectorAll('article.group');
    let visibleCount = 0;
    
    discussions.forEach(discussion => {
        const categoryBadge = discussion.querySelector('.bg-primary\\/10');
        const discussionCategory = categoryBadge ? categoryBadge.textContent.trim() : '';
        
        if (discussionCategory.includes(categoryName)) {
            discussion.style.display = 'block';
            setTimeout(() => {
                discussion.style.opacity = '1';
                discussion.style.transform = 'translateY(0)';
            }, 10);
            visibleCount++;
        } else {
            discussion.style.opacity = '0';
            discussion.style.transform = 'translateY(20px)';
            setTimeout(() => {
                discussion.style.display = 'none';
            }, 300);
        }
    });
    
    // Smooth scroll to discussions
    document.getElementById('discussions').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// Reset filter function
function showAllDiscussions() {
    const discussions = document.querySelectorAll('article.group');
    discussions.forEach(discussion => {
        discussion.style.display = 'block';
        discussion.style.opacity = '1';
        discussion.style.transform = 'translateY(0)';
    });
}

// Comment preview functionality
let commentPreviewTimeout;
let currentPreviewElement = null;

function showCommentPreview(element) {
    // Clear any existing timeout
    if (commentPreviewTimeout) {
        clearTimeout(commentPreviewTimeout);
    }
    
    const postId = element.dataset.postId;
    const preview = element.parentElement.querySelector('.comment-preview');
    
    if (!preview) return;
    
    // Show the preview immediately
    preview.classList.remove('hidden');
    currentPreviewElement = preview;
    
    // Load comments if not already loaded
    if (!preview.dataset.loaded) {
        loadCommentPreview(postId, preview);
        preview.dataset.loaded = 'true';
    }
}

function hideCommentPreview(element) {
    const preview = element.parentElement.querySelector('.comment-preview');
    if (!preview) return;
    
    // Delay hiding to allow mouse movement to tooltip
    commentPreviewTimeout = setTimeout(() => {
        if (currentPreviewElement && !currentPreviewElement.matches(':hover')) {
            currentPreviewElement.classList.add('hidden');
            currentPreviewElement = null;
        }
    }, 150);
}

function loadCommentPreview(postId, previewElement) {
    const contentDiv = previewElement.querySelector('.comment-content');
    
    fetch(`/forum/${postId}/comments`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.message || data.error);
            }
            
            if (data.success && data.comments && data.comments.length > 0) {
                let html = '';
                data.comments.forEach(comment => {
                    const initial = comment.is_anonymous ? '?' : comment.author.charAt(0).toUpperCase();
                    const upvoteDisplay = comment.upvotes > 0 ? `
                        <div class="flex items-center gap-1 text-xs text-primary">
                            <span class="material-symbols-outlined text-xs">thumb_up</span>
                            <span>${comment.upvotes}</span>
                        </div>
                    ` : '';
                    
                    html += `
                        <div class="flex gap-3 mb-3 last:mb-0">
                            <div class="w-8 h-8 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                                ${initial}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-semibold text-gray-900 dark:text-white text-sm">${comment.author}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">${comment.created_at}</span>
                                    </div>
                                    ${upvoteDisplay}
                                </div>
                                <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed">${comment.comment}</p>
                            </div>
                        </div>
                    `;
                });
                
                if (data.has_more) {
                    html += `
                        <div class="text-center pt-3 border-t border-gray-200 dark:border-gray-700 mt-3">
                            <a href="/forum/${postId}" class="text-primary hover:text-primary/80 text-sm font-semibold">
                                View all ${data.total} comments →
                            </a>
                        </div>
                    `;
                }
                
                contentDiv.innerHTML = html;
            } else {
                contentDiv.innerHTML = `
                    <div class="text-center py-4">
                        <span class="material-symbols-outlined text-gray-400 text-2xl mb-2">chat_bubble_outline</span>
                        <p class="text-sm text-gray-500 dark:text-gray-400">No comments yet</p>
                        <a href="/forum/${postId}" class="text-primary hover:text-primary/80 text-sm font-semibold">
                            Be the first to comment →
                        </a>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading comments:', error);
            contentDiv.innerHTML = `
                <div class="text-center py-4">
                    <p class="text-sm text-red-500">Failed to load comments</p>
                    <p class="text-xs text-gray-500 mt-1">Check console for details</p>
                </div>
            `;
        });
}

// Features Carousel Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Keep tooltip visible when hovering over it - comment preview functionality
    document.addEventListener('mouseenter', function(e) {
        if (e.target && e.target.closest && e.target.closest('.comment-preview')) {
            if (commentPreviewTimeout) {
                clearTimeout(commentPreviewTimeout);
                commentPreviewTimeout = null;
            }
        }
    }, true);
    
    document.addEventListener('mouseleave', function(e) {
        if (e.target && e.target.closest && e.target.closest('.comment-preview')) {
            commentPreviewTimeout = setTimeout(() => {
                if (currentPreviewElement) {
                    currentPreviewElement.classList.add('hidden');
                    currentPreviewElement = null;
                }
            }, 150);
        }
    }, true);

    // Carousel functionality
    const carousel = document.getElementById('featuresCarousel');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const dotsContainer = document.getElementById('dotsContainer');
    
    if (!carousel || !prevBtn || !nextBtn) return;
    
    const cards = carousel.children;
    const totalCards = cards.length;
    const cardsPerView = 3; // Show 3 cards at a time
    const cardWidth = 320; // w-80 = 20rem = 320px
    const gap = 24; // gap-6 = 1.5rem = 24px
    const slideWidth = cardWidth + gap;
    const autoSlideInterval = 5000;
    
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
                stopAutoSlide();
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

    // Auto-resize textarea
    const textarea = document.getElementById('content');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 200) + 'px';
        });
    }
    
    // Character counter for title
    const titleInput = document.getElementById('title');
    if (titleInput) {
        const maxLength = 255;
        const counter = document.createElement('div');
        counter.className = 'text-xs text-gray-500 dark:text-gray-400 mt-1';
        counter.textContent = `0/${maxLength} characters`;
        titleInput.parentNode.appendChild(counter);
        
        titleInput.addEventListener('input', function() {
            const length = this.value.length;
            counter.textContent = `${length}/${maxLength} characters`;
            counter.className = length > maxLength * 0.9 
                ? 'text-xs text-orange-500 dark:text-orange-400 mt-1'
                : 'text-xs text-gray-500 dark:text-gray-400 mt-1';
        });
    }
});
</script>
@endpush
@endsection
