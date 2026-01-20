@extends('layouts.admin')

@section('title', 'Profile Settings')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-2">
            <a href="{{ url()->previous() }}" class="text-gray-600 dark:text-gray-400 hover:text-primary">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Profile Settings</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1">Manage your account information and preferences</p>
            </div>
        </div>
    </div>



    @if($errors->any())
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200 px-6 py-4 rounded-lg mb-6">
        <div class="flex items-start gap-3">
            <span class="material-symbols-outlined text-red-600 dark:text-red-400">error</span>
            <div>
                <p class="font-semibold mb-2">Please fix the following errors:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                    <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <!-- Profile Information -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-6 shadow-sm">
        <div class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700 px-6 py-4">
            <div class="flex items-center gap-3 text-gray-900 dark:text-white">
                <span class="material-symbols-outlined text-2xl text-primary">person</span>
                <h3 class="text-xl font-semibold">Profile Information</h3>
            </div>
        </div>
        <div class="p-6">
        
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <div class="space-y-6">
                <!-- Avatar -->
                <div class="flex items-center gap-6 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                    <div class="relative">
                        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 flex items-center justify-center overflow-hidden ring-4 ring-white dark:ring-gray-800">
                            @if(auth()->user()->avatar)
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                            <span class="material-symbols-outlined text-4xl text-gray-600 dark:text-gray-300">person</span>
                            @endif
                        </div>
                        <div class="absolute bottom-0 right-0 bg-gray-600 dark:bg-gray-500 rounded-full p-2 shadow-lg">
                            <span class="material-symbols-outlined text-white text-sm">photo_camera</span>
                        </div>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">Profile Photo</label>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">JPG, PNG or GIF. Max size 2MB</p>
                        <input type="file" name="avatar" accept="image/*" 
                            class="block w-full text-sm text-gray-500 dark:text-gray-400
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-primary file:text-white
                            hover:file:opacity-90 file:cursor-pointer">
                        @error('avatar')<p class="text-red-500 text-sm mt-2 flex items-center gap-1"><span class="material-symbols-outlined text-sm">error</span>{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name *</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address *</label>
                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                    <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    @error('phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Registration Number (for students) -->
                @if(auth()->user()->role === 'user')
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Registration Number</label>
                    <input type="text" name="registration_number" value="{{ old('registration_number', auth()->user()->registration_number) }}"
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    @error('registration_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                @endif

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="bg-primary text-white px-8 py-3 rounded-lg hover:opacity-90 flex items-center gap-2 font-semibold">
                        <span class="material-symbols-outlined text-sm">save</span>
                        Save Changes
                    </button>
                    <button type="reset" class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-8 py-3 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 font-semibold">
                        Reset
                    </button>
                </div>
            </div>
        </form>
        </div>
    </div>

    <!-- Update Password -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-6 shadow-sm">
        <div class="bg-gray-50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700 px-6 py-4">
            <div class="flex items-center gap-3 text-gray-900 dark:text-white">
                <span class="material-symbols-outlined text-2xl text-blue-600 dark:text-blue-400">lock</span>
                <h3 class="text-xl font-semibold">Security Settings</h3>
            </div>
        </div>
        <div class="p-6">
        
        <form action="{{ route('profile.password.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Current Password *</label>
                    <input type="password" name="current_password" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    @error('current_password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Password *</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                    @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm New Password *</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 flex items-center gap-2 font-semibold">
                        <span class="material-symbols-outlined text-sm">lock_reset</span>
                        Update Password
                    </button>
                </div>
            </div>
        </form>
        </div>
    </div>

    <!-- Delete Account -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-red-200 dark:border-red-800 overflow-hidden shadow-sm">
        <div class="bg-red-50 dark:bg-red-900/20 border-b border-red-200 dark:border-red-800 px-6 py-4">
            <div class="flex items-center gap-3 text-red-900 dark:text-red-200">
                <span class="material-symbols-outlined text-2xl text-red-600 dark:text-red-400">warning</span>
                <h3 class="text-xl font-semibold">Danger Zone</h3>
            </div>
        </div>
        <div class="p-6">
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-4">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-red-600 dark:text-red-400">info</span>
                    <div>
                        <h4 class="font-semibold text-red-900 dark:text-red-200 mb-1">Permanently Delete Account</h4>
                        <p class="text-sm text-red-700 dark:text-red-300">
                            Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
                        </p>
                    </div>
                </div>
            </div>
            
            <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('⚠️ WARNING: This action cannot be undone!\n\nAre you absolutely sure you want to delete your account?\n\nAll your data including:\n• Quiz attempts and scores\n• Counseling sessions\n• Forum posts and comments\n• Bookmarks and progress\n\nwill be permanently deleted.\n\nType DELETE in the confirmation box if you understand.')">
                @csrf
                @method('DELETE')
                
                <button type="submit" class="bg-red-600 text-white px-8 py-3 rounded-lg hover:bg-red-700 flex items-center gap-2 font-semibold">
                    <span class="material-symbols-outlined text-sm">delete_forever</span>
                    Delete My Account
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
