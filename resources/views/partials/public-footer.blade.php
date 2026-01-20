<footer class="bg-gray-100 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
            <!-- Brand Section -->
            <div class="lg:col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <div class="size-10 text-primary">
                        <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path d="M44 11.2727C44 14.0109 39.8386 16.3957 33.69 17.6364C39.8386 18.877 44 21.2618 44 24C44 26.7382 39.8386 29.123 33.69 30.3636C39.8386 31.6043 44 33.9891 44 36.7273C44 40.7439 35.0457 44 24 44C12.9543 44 4 40.7439 4 36.7273C4 33.9891 8.16144 31.6043 14.31 30.3636C8.16144 29.123 4 26.7382 4 24C4 21.2618 8.16144 18.877 14.31 17.6364C8.16144 16.3957 4 14.0109 4 11.2727C4 7.25611 12.9543 4 24 4C35.0457 4 44 7.25611 44 11.2727Z" fill="currentColor"></path>
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold text-[#111816] dark:text-white">WellPath</h2>
                </div>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed max-w-md mb-6">Your confidential resource for support and information on wellness and substance abuse awareness.</p>
                
                <!-- Emergency Contact Card -->
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-2xl">emergency</span>
                        <div class="flex-1">
                            <h4 class="font-bold text-red-600 dark:text-red-400 mb-1">Mental Health Crisis Support</h4>
                            <a href="tel:0800212121" class="text-lg font-bold text-[#111816] dark:text-white hover:text-primary transition-colors block">0800 21 21 21</a>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Mental Health Uganda - Toll Free</p>
                            <p class="text-xs text-gray-500 dark:text-gray-500 mt-0.5">Mon-Fri, 8:30 AM - 5:00 PM</p>
                            <button onclick="document.getElementById('emergencyModal').classList.remove('hidden')" class="text-xs text-red-600 dark:text-red-400 hover:underline mt-2 font-semibold">
                                View all crisis resources →
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-[#111816] dark:text-white mb-6">Quick Links</h3>
                <ul class="space-y-3">
                    <li><a class="text-gray-600 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors text-sm" href="{{ route('public.about') }}">About Us</a></li>
                    <li><a class="text-gray-600 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors text-sm" href="{{ route('content.index') }}">Resources</a></li>
                    @auth
                        @if(auth()->user()->role === 'user')
                            <li><a class="text-gray-600 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors text-sm" href="{{ route('student.counseling.index') }}">Get Help</a></li>
                        @endif
                    @endauth
                    <li><a class="text-gray-600 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors text-sm" href="{{ route('public.contact') }}">Contact</a></li>
                    <li><a class="text-gray-600 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors text-sm" href="#privacy">Privacy Policy</a></li>
                    <li><a class="text-gray-600 dark:text-gray-400 hover:text-primary dark:hover:text-primary transition-colors text-sm" href="#terms">Terms of Service</a></li>
                </ul>
            </div>
            
            <!-- Connect Section -->
            <div>
                <h3 class="text-sm font-bold uppercase tracking-wider text-[#111816] dark:text-white mb-6">Connect With Us</h3>
                <div class="flex gap-3 mb-8">
                    <a class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-800 hover:bg-primary hover:text-white flex items-center justify-center transition-all text-gray-600 dark:text-gray-400" href="#" aria-label="Facebook">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                        </svg>
                    </a>
                    <a class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-800 hover:bg-primary hover:text-white flex items-center justify-center transition-all text-gray-600 dark:text-gray-400" href="#" aria-label="Twitter">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.71v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                        </svg>
                    </a>
                    <a class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-800 hover:bg-primary hover:text-white flex items-center justify-center transition-all text-gray-600 dark:text-gray-400" href="#" aria-label="Instagram">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                </div>
                
                <!-- Trust Badges -->
                <div class="space-y-2">
                    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <span class="material-symbols-outlined text-primary">verified_user</span>
                        <span>100% Confidential</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <span class="material-symbols-outlined text-primary">lock</span>
                        <span>Secure & Private</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <span class="material-symbols-outlined text-primary">schedule</span>
                        <span>Available 24/7</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom Bar -->
        <div class="border-t border-gray-200 dark:border-gray-800 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">© {{ date('Y') }} WellPath. All rights reserved.</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Made with <span class="text-red-500">❤</span> for Students</p>
            </div>
        </div>
    </div>
</footer>