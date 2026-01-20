@extends('layouts.public')

@section('title', 'Sign In - WellPath Platform')

@section('content')
<div class="w-full">
    <!-- Hero Section with Login Form -->
    <div class="relative w-full py-12 sm:py-16">
        <img alt="Abstract green leaves background" class="absolute inset-0 h-full w-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBaei4zVm6LMjCzOVeGiCrhI7yoToYFSZ67NFRSOpSi2mS78a4OlW5SUWJ6pb6uehKbKJYkyLdYuWxLOLcYqgTxhJDdOV5-TGjhJGRIC6Mw6f0BpUtqOf2WUzvouDx1C-cX7IZq5sTR_0tZQY81G8hmA7w609vHtY53hIjl_Z7uKMuJtcfu9xj_w-h5h-tQzhnl1SKW4blx_rDkSirm7BB0IdRYU1p10v-DVIT3Qqi_xtXuBK_86-uuVTLeC4WFxj7_2DutIbO4XA"/>
        <div class="absolute inset-0 bg-gradient-to-br from-primary/80 to-primary/60 dark:from-primary/90 dark:to-background-dark/70"></div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                <!-- Left Side - Welcome Text -->
                <div class="flex flex-col gap-6 text-center lg:text-left text-white lg:w-1/2">
                    <div class="flex flex-col gap-4">
                        <h1 class="text-4xl font-black leading-tight tracking-tighter sm:text-5xl md:text-6xl">Welcome Back</h1>
                        <h2 class="text-gray-200 text-base font-normal leading-normal sm:text-lg">Sign in to access your personalized resources, track your progress, and connect with support services.</h2>
                    </div>
                </div>

                <!-- Right Side - Login Form -->
                <div class="w-full lg:w-1/2 max-w-md">
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-2xl border border-gray-200 dark:border-gray-700">
                        <div class="text-center mb-6">
                            <h3 class="text-2xl font-bold text-[#111816] dark:text-white">Sign In</h3>
                            <p class="text-gray-600 dark:text-gray-400 mt-2">Access your account</p>
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

                        <!-- Status Message -->
                        @if (session('status'))
                            <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <span class="material-symbols-outlined text-green-400 text-xl">check_circle</span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-800 dark:text-green-200">
                                            {{ session('status') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf

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
                                       autofocus
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
                                       autocomplete="current-password"
                                       class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400"
                                       placeholder="Enter your password">
                            </div>

                            <!-- Remember Me -->
                            <div class="flex items-center justify-between">
                                <label for="remember_me" class="flex items-center">
                                    <input id="remember_me" 
                                           name="remember" 
                                           type="checkbox" 
                                           class="h-4 w-4 text-primary focus:ring-primary border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700">
                                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                                </label>

                                @if (Route::has('password.request'))
                                    <a class="text-sm text-primary hover:text-primary/80 font-medium" href="{{ route('password.request') }}">
                                        Forgot password?
                                    </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" 
                                    class="w-full bg-primary text-[#111816] py-3 px-4 rounded-lg font-bold text-base hover:bg-primary/90 focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-colors">
                                Sign In
                            </button>

                            <!-- Register Link -->
                            <div class="text-center">
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Don't have an account? 
                                    <a href="{{ route('register') }}" class="text-primary hover:text-primary/80 font-medium">
                                        Create one here
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="w-full bg-background-light dark:bg-background-dark py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-[#111816] dark:text-white mb-4">Why Sign In?</h2>
                <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">Access personalized features designed to support your wellbeing journey.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-primary/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-primary text-2xl">person</span>
                    </div>
                    <h3 class="text-lg font-bold text-[#111816] dark:text-white mb-2">Personal Dashboard</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Track your progress, save resources, and manage your wellbeing journey.</p>
                </div>
                <div class="text-center">
                    <div class="bg-primary/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-primary text-2xl">health_and_safety</span>
                    </div>
                    <h3 class="text-lg font-bold text-[#111816] dark:text-white mb-2">Counseling Access</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Book confidential sessions with qualified counselors and support staff.</p>
                </div>
                <div class="text-center">
                    <div class="bg-primary/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-symbols-outlined text-primary text-2xl">quiz</span>
                    </div>
                    <h3 class="text-lg font-bold text-[#111816] dark:text-white mb-2">Assessment Tools</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">Take confidential self-assessments and receive personalized recommendations.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
