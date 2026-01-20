@extends('layouts.public')

@section('title', 'Create Account - WellPath Platform')

@section('content')
<div class="w-full">
    <!-- Hero Section with Registration Form -->
    <div class="relative w-full py-12 sm:py-16">
        <img alt="Abstract green leaves background" class="absolute inset-0 h-full w-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBaei4zVm6LMjCzOVeGiCrhI7yoToYFSZ67NFRSOpSi2mS78a4OlW5SUWJ6pb6uehKbKJYkyLdYuWxLOLcYqgTxhJDdOV5-TGjhJGRIC6Mw6f0BpUtqOf2WUzvouDx1C-cX7IZq5sTR_0tZQY81G8hmA7w609vHtY53hIjl_Z7uKMuJtcfu9xj_w-h5h-tQzhnl1SKW4blx_rDkSirm7BB0IdRYU1p10v-DVIT3Qqi_xtXuBK_86-uuVTLeC4WFxj7_2DutIbO4XA"/>
        <div class="absolute inset-0 bg-gradient-to-br from-primary/80 to-primary/60 dark:from-primary/90 dark:to-background-dark/70"></div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                <!-- Left Side - Welcome Text -->
                <div class="flex flex-col gap-6 text-center lg:text-left text-white lg:w-1/2">
                    <div class="flex flex-col gap-4">
                        <h1 class="text-4xl font-black leading-tight tracking-tighter sm:text-5xl md:text-6xl">Join Our Community</h1>
                        <h2 class="text-gray-200 text-base font-normal leading-normal sm:text-lg">Create your account to access personalized resources, connect with counselors, and take control of your wellbeing journey.</h2>
                    </div>
                </div>

                <!-- Right Side - Registration Form -->
                <div class="w-full lg:w-1/2 max-w-md">
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-2xl border border-gray-200 dark:border-gray-700">
                        <div class="text-center mb-6">
                            <h3 class="text-2xl font-bold text-[#111816] dark:text-white">Create Account</h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-2">Join the WellPath community</p>
                        </div>

                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <span class="material-symbols-outlined text-red-400 text-xl">error</span>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                                            There were some errors with your submission
                                        </h3>
                                        <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                            <ul class="list-disc list-inside space-y-1">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}" class="space-y-6">
                            @csrf

                            <!-- Name Field -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-[#111816] dark:text-white mb-2">
                                    Full Name
                                </label>
                                <input id="name" 
                                       name="name" 
                                       type="text" 
                                       value="{{ old('name') }}" 
                                       required 
                                       autofocus
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                                       placeholder="Enter your full name">
                            </div>

                            <!-- Email Field -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-[#111816] dark:text-white mb-2">
                                    Email Address
                                </label>
                                <input id="email" 
                                       name="email" 
                                       type="email" 
                                       value="{{ old('email') }}" 
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                                       placeholder="Enter your email address">
                            </div>



                            <!-- Password Field -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-[#111816] dark:text-white mb-2">
                                    Password
                                </label>
                                <input id="password" 
                                       name="password" 
                                       type="password" 
                                       required 
                                       autocomplete="new-password"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                                       placeholder="Create a password">
                            </div>

                            <!-- Confirm Password Field -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-[#111816] dark:text-white mb-2">
                                    Confirm Password
                                </label>
                                <input id="password_confirmation" 
                                       name="password_confirmation" 
                                       type="password" 
                                       required 
                                       autocomplete="new-password"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                                       placeholder="Confirm your password">
                            </div>

                            <!-- Terms and Privacy -->
                            <div class="flex items-start">
                                <input id="terms" 
                                       name="terms" 
                                       type="checkbox" 
                                       required
                                       class="h-4 w-4 text-primary focus:ring-primary border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 mt-1">
                                <label for="terms" class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                    I agree to the <a href="#" class="text-primary hover:text-primary/80 font-medium">Terms of Service</a> and <a href="#" class="text-primary hover:text-primary/80 font-medium">Privacy Policy</a>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" 
                                    class="w-full bg-primary text-[#111816] py-3 px-4 rounded-lg font-bold text-base hover:bg-primary/90 focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-colors">
                                Create Account
                            </button>

                            <!-- Login Link -->
                            <div class="text-center">
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Already have an account? 
                                    <button type="button" onclick="openLoginModal()" class="text-primary hover:text-primary/80 font-medium">
                                        Sign in here
                                    </button>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Benefits Section -->
    <div class="w-full bg-background-light dark:bg-background-dark py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-[#111816] dark:text-white mb-4">Why Join Us?</h2>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Become part of a supportive community dedicated to student wellbeing and success.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-primary/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-primary text-2xl">shield</span>
                    </div>
                    <h3 class="text-lg font-bold text-[#111816] dark:text-white mb-2">100% Confidential</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Your privacy is our priority. All interactions and data are kept strictly confidential.</p>
                </div>
                <div class="text-center">
                    <div class="bg-primary/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-primary text-2xl">psychology</span>
                    </div>
                    <h3 class="text-lg font-bold text-[#111816] dark:text-white mb-2">Professional Support</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Access qualified counselors and mental health professionals when you need them.</p>
                </div>
                <div class="text-center">
                    <div class="bg-primary/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-primary text-2xl">groups</span>
                    </div>
                    <h3 class="text-lg font-bold text-[#111816] dark:text-white mb-2">Peer Community</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Connect with fellow students who understand your journey and challenges.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
