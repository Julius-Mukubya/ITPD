@extends('layouts.public')

@section('title', 'About Us - WellPath Hub')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden h-screen">
    <!-- Background Image -->
    <div class="absolute inset-0 overflow-hidden">
        <img src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2084&q=80" 
             alt="Students collaborating" 
             class="w-full h-full object-cover animate-hero-zoom">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>
    
    <!-- Content -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center justify-center">
        <div class="text-center">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-semibold mb-6">
                <span class="material-symbols-outlined !text-lg">info</span>
                About Us
            </div>
            <h1 class="text-4xl lg:text-6xl font-black text-white tracking-tight mb-6">About Our Platform</h1>
            <p class="text-xl lg:text-2xl text-white/90 max-w-4xl mx-auto leading-relaxed mb-8">Supporting students with comprehensive drug and alcohol awareness resources, counseling services, and peer support.</p>
            <div class="flex justify-center">
                <a href="#about-content" class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md border border-white/30 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/30 hover:border-white/50 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <span class="material-symbols-outlined !text-xl">expand_more</span>
                    Learn More About Us
                </a>
            </div>
        </div>
    </div>
</section>

<div id="about-content" class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 scroll-mt-16">
    <div class="flex flex-col flex-1 gap-10">
        <!-- Mission Section -->
        <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-8 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/20 rounded-full mb-4">
                    <span class="material-symbols-outlined text-3xl text-primary">flag</span>
                </div>
                <h2 class="text-3xl font-bold text-[#111816] dark:text-white mb-4">Our Mission</h2>
                <p class="text-lg text-[#61897c] dark:text-gray-400 leading-relaxed max-w-3xl mx-auto">
                    To provide a safe, confidential, and supportive environment where students can access evidence-based information, professional counseling, and peer support for drug and alcohol awareness and mental health wellbeing.
                </p>
            </div>
        </div>

        <!-- What We Offer -->
        <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-8 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/20 rounded-full mb-4">
                    <span class="material-symbols-outlined text-3xl text-primary">health_and_safety</span>
                </div>
                <h2 class="text-3xl font-bold text-[#111816] dark:text-white mb-4">What We Offer</h2>
                <p class="text-[#61897c] dark:text-gray-400 max-w-2xl mx-auto">
                    Comprehensive support services designed to help you thrive academically, personally, and socially.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="group bg-gray-50 dark:bg-gray-800/50 p-6 rounded-xl hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-primary/30">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-white">psychology</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-[#111816] dark:text-white mb-2 group-hover:text-primary transition-colors">Professional Counseling</h3>
                            <p class="text-[#61897c] dark:text-gray-400 leading-relaxed">Access to licensed counselors who provide confidential support for mental health, substance use, and personal challenges.</p>
                        </div>
                    </div>
                </div>

                <div class="group bg-gray-50 dark:bg-gray-800/50 p-6 rounded-xl hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-primary/30">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-white">library_books</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-[#111816] dark:text-white mb-2 group-hover:text-primary transition-colors">Educational Resources</h3>
                            <p class="text-[#61897c] dark:text-gray-400 leading-relaxed">Evidence-based articles, videos, and guides on drug and alcohol awareness, mental health, and wellness.</p>
                        </div>
                    </div>
                </div>

                <div class="group bg-gray-50 dark:bg-gray-800/50 p-6 rounded-xl hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-primary/30">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-white">campaign</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-[#111816] dark:text-white mb-2 group-hover:text-primary transition-colors">Awareness Campaigns</h3>
                            <p class="text-[#61897c] dark:text-gray-400 leading-relaxed">Participate in campus-wide initiatives promoting mental health awareness and substance education.</p>
                        </div>
                    </div>
                </div>

                <div class="group bg-gray-50 dark:bg-gray-800/50 p-6 rounded-xl hover:shadow-lg transition-all duration-300 border border-gray-100 dark:border-gray-700 hover:border-primary/30">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-white">diversity_3</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-[#111816] dark:text-white mb-2 group-hover:text-primary transition-colors">Peer Support</h3>
                            <p class="text-[#61897c] dark:text-gray-400 leading-relaxed">Connect with fellow students through forums and support groups in a safe, moderated environment.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Our Values -->
        <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-8 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/20 rounded-full mb-4">
                    <span class="material-symbols-outlined text-3xl text-primary">star</span>
                </div>
                <h2 class="text-3xl font-bold text-[#111816] dark:text-white mb-4">Our Core Values</h2>
                <p class="text-[#61897c] dark:text-gray-400 max-w-2xl mx-auto">
                    The principles that guide everything we do and shape our commitment to student wellbeing.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-white text-2xl">security</span>
                    </div>
                    <h3 class="text-lg font-bold text-[#111816] dark:text-white mb-2 group-hover:text-primary transition-colors">Confidentiality</h3>
                    <p class="text-[#61897c] dark:text-gray-400 leading-relaxed">Your privacy is our priority. All services are completely confidential and secure.</p>
                </div>

                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-white text-2xl">favorite</span>
                    </div>
                    <h3 class="text-lg font-bold text-[#111816] dark:text-white mb-2 group-hover:text-primary transition-colors">Compassion</h3>
                    <p class="text-[#61897c] dark:text-gray-400 leading-relaxed">We provide non-judgmental support with empathy and understanding.</p>
                </div>

                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-white text-2xl">verified</span>
                    </div>
                    <h3 class="text-lg font-bold text-[#111816] dark:text-white mb-2 group-hover:text-primary transition-colors">Evidence-Based</h3>
                    <p class="text-[#61897c] dark:text-gray-400 leading-relaxed">All our resources and approaches are backed by research and best practices.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative bg-gradient-to-r from-primary/10 to-green-50 dark:from-gray-800 dark:to-gray-800/50 rounded-2xl p-8 border border-primary/20 dark:border-gray-700 overflow-hidden">
            <!-- Decorative Icons -->
            <div class="absolute top-4 left-4 opacity-10">
                <span class="material-symbols-outlined text-6xl text-primary">handshake</span>
            </div>
            <div class="absolute bottom-4 right-4 opacity-10">
                <span class="material-symbols-outlined text-6xl text-primary">diversity_3</span>
            </div>
            
            <div class="relative text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/20 rounded-full mb-4">
                    <span class="material-symbols-outlined text-3xl text-primary">connect_without_contact</span>
                </div>
                <h3 class="text-xl font-bold text-[#111816] dark:text-white mb-2">Want to Learn More?</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-2xl mx-auto">Have questions about our services or want to get involved? We'd love to hear from you and help you find the support you need.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('public.contact') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition-colors text-sm">
                        <span class="material-symbols-outlined text-base">mail</span>
                        <span>Contact Us</span>
                    </a>
                    <a href="{{ route('public.counseling.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white dark:bg-gray-700 text-[#111816] dark:text-white border border-gray-300 dark:border-gray-600 rounded-lg font-semibold hover:border-primary hover:text-primary transition-colors text-sm">
                        <span class="material-symbols-outlined text-base">psychology</span>
                        <span>Explore Services</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    @keyframes hero-zoom {
        0% {
            transform: scale(1);
        }
        100% {
            transform: scale(1.1);
        }
    }
    
    .animate-hero-zoom {
        animation: hero-zoom 8s ease-out infinite alternate;
    }
</style>
@endpush