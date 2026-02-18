@extends('layouts.public')

@section('title', 'Contact Us - WellPath')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden h-screen">
    <!-- Background Image -->
    <div class="absolute inset-0 overflow-hidden">
        <img src="{{ asset('images/contact-hero.avif') }}" 
             alt="Customer support team" 
             class="w-full h-full object-cover animate-hero-zoom">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>
    
    <!-- Content -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center justify-center">
        <div class="text-center">
            <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-semibold mb-6">
                <span class="material-symbols-outlined !text-lg">mail</span>
                Contact Us
            </div>
            <h1 class="text-4xl lg:text-6xl font-black text-white tracking-tight mb-6">Get in Touch</h1>
            <p class="text-xl lg:text-2xl text-white/90 max-w-4xl mx-auto leading-relaxed mb-8">We're here to help. Reach out to us for support, questions, or feedback.</p>
            <div class="flex justify-center">
                <a href="#contact-info" class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-md border border-white/30 text-white px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/30 hover:border-white/50 transition-all duration-200 transform hover:scale-105 shadow-lg">
                    <span class="material-symbols-outlined !text-xl">expand_more</span>
                    View Contact Info
                </a>
            </div>
        </div>
    </div>
</section>

<div id="contact-info" class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 scroll-mt-20">
    <div class="flex flex-col flex-1 gap-10">
        <!-- Contact Information -->
        <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-8 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/20 rounded-full mb-4">
                    <span class="material-symbols-outlined text-3xl text-primary">support_agent</span>
                </div>
                <h2 class="text-3xl font-bold text-[#111816] dark:text-white mb-4">How to Reach Us</h2>
                <p class="text-[#61897c] dark:text-gray-400 max-w-2xl mx-auto">
                    Multiple ways to connect with our support team for assistance, guidance, or emergency help.
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-white text-2xl">phone</span>
                    </div>
                    <h3 class="text-lg font-bold text-[#111816] dark:text-white mb-2 group-hover:text-primary transition-colors">Crisis Hotline</h3>
                    <p class="text-[#61897c] dark:text-gray-400 mb-2">24/7 Emergency Support</p>
                    <a href="tel:999" class="text-red-600 dark:text-red-400 font-bold text-lg hover:text-red-700 dark:hover:text-red-300 transition-colors">999</a>
                </div>
                
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-white text-2xl">email</span>
                    </div>
                    <h3 class="text-lg font-bold text-[#111816] dark:text-white mb-2 group-hover:text-primary transition-colors">Email Support</h3>
                    <p class="text-[#61897c] dark:text-gray-400 mb-2">General inquiries and support</p>
                    <a href="mailto:support@wellpath.edu" class="text-primary hover:text-primary/80 transition-colors break-all">support@wellpath.edu</a>
                </div>
                
                <div class="text-center group">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-white text-2xl">location_on</span>
                    </div>
                    <h3 class="text-lg font-bold text-[#111816] dark:text-white mb-2 group-hover:text-primary transition-colors">Campus Location</h3>
                    <p class="text-[#61897c] dark:text-gray-400">Student Wellness Center</p>
                    <p class="text-[#61897c] dark:text-gray-400">Main Campus</p>
                </div>
            </div>
        </div>

        <!-- Feedback Form -->
        <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-8 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/20 rounded-full mb-4">
                    <span class="material-symbols-outlined text-3xl text-primary">send</span>
                </div>
                <h2 class="text-3xl font-bold text-[#111816] dark:text-white mb-4">Send Us a Message</h2>
                <p class="text-[#61897c] dark:text-gray-400 max-w-2xl mx-auto">We'd love to hear from you. Fill out the form below and we'll get back to you as soon as possible.</p>
            </div>

            <form id="contactForm" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-[#111816] dark:text-white mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" required
                            class="w-full px-4 py-3 rounded-xl border border-[#f0f4f3] dark:border-gray-700 bg-white dark:bg-gray-900 text-[#111816] dark:text-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                            placeholder="John Doe">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-[#111816] dark:text-white mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" required
                            class="w-full px-4 py-3 rounded-xl border border-[#f0f4f3] dark:border-gray-700 bg-white dark:bg-gray-900 text-[#111816] dark:text-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all"
                            placeholder="john@example.com">
                    </div>
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium text-[#111816] dark:text-white mb-2">
                        Subject <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="subject" name="subject" required
                            class="w-full px-4 py-3 rounded-xl border border-[#f0f4f3] dark:border-gray-700 bg-white dark:bg-gray-900 text-[#111816] dark:text-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all appearance-none">
                            <option value="">Select a subject</option>
                            <option value="general">General Inquiry</option>
                            <option value="counseling">Counseling Services</option>
                            <option value="technical">Technical Support</option>
                            <option value="feedback">Feedback</option>
                            <option value="other">Other</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-[#61897c] dark:text-gray-400 pointer-events-none">expand_more</span>
                    </div>
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-[#111816] dark:text-white mb-2">
                        Message <span class="text-red-500">*</span>
                    </label>
                    <textarea id="message" name="message" rows="6" required
                        class="w-full px-4 py-3 rounded-xl border border-[#f0f4f3] dark:border-gray-700 bg-white dark:bg-gray-900 text-[#111816] dark:text-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all resize-none"
                        placeholder="Tell us how we can help you..."></textarea>
                </div>

                <div class="flex items-start gap-3 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-xl">
                    <input type="checkbox" id="privacy" name="privacy" required
                        class="mt-1 w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                    <label for="privacy" class="text-sm text-[#61897c] dark:text-gray-400">
                        I agree to the <a class="text-primary hover:underline cursor-pointer" onclick="openPrivacyModal()">privacy policy</a> and understand that my information will be handled confidentially. <span class="text-red-500">*</span>
                    </label>
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-primary text-white py-4 px-6 rounded-xl font-bold text-lg hover:bg-primary/90 transition-all duration-200 transform hover:scale-[1.02] shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">send</span>
                        Send Message
                    </button>
                </div>

                <div id="formMessage" class="hidden p-4 rounded-xl"></div>
            </form>
        </div>
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
                <h3 class="text-xl font-bold text-[#111816] dark:text-white mb-2">Need Immediate Support?</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-2xl mx-auto">Access our counseling services or join the community for immediate assistance and peer support.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('public.counseling.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-primary text-white rounded-lg font-semibold hover:bg-primary/90 transition-colors text-sm">
                        <span class="material-symbols-outlined text-base">psychology</span>
                        <span>Get Counseling</span>
                    </a>
                    <a href="{{ route('public.forum.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white dark:bg-gray-700 text-[#111816] dark:text-white border border-gray-300 dark:border-gray-600 rounded-lg font-semibold hover:border-primary hover:text-primary transition-colors text-sm">
                        <span class="material-symbols-outlined text-base">forum</span>
                        <span>Join Community</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formMessage = document.getElementById('formMessage');
    const submitButton = this.querySelector('button[type="submit"]');
    
    // Disable submit button
    submitButton.disabled = true;
    submitButton.innerHTML = '<span class="material-symbols-outlined animate-spin">refresh</span> Sending...';
    
    // Simulate form submission (replace with actual AJAX call)
    setTimeout(() => {
        formMessage.classList.remove('hidden', 'bg-red-100', 'text-red-700');
        formMessage.classList.add('bg-green-100', 'dark:bg-green-900/30', 'text-green-700', 'dark:text-green-400');
        formMessage.innerHTML = '<strong>Success!</strong> Your message has been sent. We\'ll get back to you soon.';
        
        // Reset form
        this.reset();
        
        // Re-enable submit button
        submitButton.disabled = false;
        submitButton.innerHTML = '<span class="material-symbols-outlined">send</span> Send Message';
        
        // Hide message after 5 seconds
        setTimeout(() => {
            formMessage.classList.add('hidden');
        }, 5000);
    }, 1500);
});
</script>
@endpush
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
