@extends('layouts.student')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<div class="max-w-5xl mx-auto">


    @if($errors->any())
    <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-800 dark:text-red-200 px-6 py-4 rounded-lg mb-6">
        <div class="flex items-start gap-3">
            <span class="material-symbols-outlined text-red-600">error</span>
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

    <!-- Profile Header Card -->
    <div class="bg-gradient-to-r from-primary to-green-600 rounded-2xl p-8 text-white mb-6">
        <div class="flex items-center gap-6">
            @if(auth()->user()->avatar)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-24 h-24 rounded-full object-cover border-4 border-white/20">
            @else
                <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center text-4xl font-bold backdrop-blur-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
            @endif
            <div>
                <h2 class="text-2xl font-bold mb-1">{{ auth()->user()->name }}</h2>
                <p class="text-white/90">{{ auth()->user()->email }}</p>
                <div class="flex items-center gap-2 mt-2">
                    <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-semibold">Student</span>
                    <span class="bg-white/20 px-3 py-1 rounded-full text-sm">Member since {{ auth()->user()->created_at->format('M Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
        <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary text-2xl">person</span>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Profile Information</h3>
            </div>
        </div>
        
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PATCH')
            
            <div class="space-y-6">
                <!-- Profile Image -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                        Profile Image
                    </label>
                    <div class="flex items-center gap-6">
                        <div class="relative">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" 
                                     id="avatar-preview" class="w-20 h-20 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600">
                            @else
                                <div id="avatar-preview" class="w-20 h-20 bg-gradient-to-br from-primary to-green-600 rounded-full flex items-center justify-center text-2xl font-bold text-white">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden" onchange="previewAvatar(event)">
                            <div class="flex gap-3">
                                <button type="button" onclick="document.getElementById('avatar').click()" 
                                        class="bg-primary text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-primary/90 transition-colors flex items-center gap-2">
                                    <span class="material-symbols-outlined text-lg">upload</span>
                                    Upload Photo
                                </button>
                                @if(auth()->user()->avatar)
                                    <button type="button" onclick="removeAvatar()" 
                                            class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-700 transition-colors flex items-center gap-2">
                                        <span class="material-symbols-outlined text-lg">delete</span>
                                        Remove
                                    </button>
                                @endif
                            </div>
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">JPG, PNG or GIF. Max size 1MB.</p>
                        </div>
                    </div>
                    @error('avatar')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone (Optional) -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Phone Number <span class="text-gray-400 text-xs">(Optional)</span>
                    </label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}"
                           placeholder="+256 700 000 000"
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bio (Optional) -->
                <div>
                    <label for="bio" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        About Me <span class="text-gray-400 text-xs">(Optional)</span>
                    </label>
                    <textarea name="bio" id="bio" rows="4"
                              placeholder="Tell us a bit about yourself..."
                              class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary resize-none">{{ old('bio', auth()->user()->bio ?? '') }}</textarea>
                    @error('bio')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary/90 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Change Password -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
        <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary text-2xl">lock</span>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Change Password</h3>
            </div>
        </div>
        
        <form action="{{ route('profile.password.update') }}" method="POST" class="p-6">
            @csrf
            @method('PATCH')
            
            <div class="space-y-6">
                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Current Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="current_password" id="current_password" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        New Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" id="password" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Must be at least 8 characters long</p>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Confirm New Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-primary">
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary/90 transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined">lock_reset</span>
                    Update Password
                </button>
            </div>
        </form>
    </div>

    <!-- Privacy & Preferences -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
        <div class="bg-gray-50 dark:bg-gray-900/50 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary text-2xl">settings</span>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Privacy & Preferences</h3>
            </div>
        </div>
        
        <div class="p-6 space-y-4">
            <!-- Email Notifications -->
            <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white">Email Notifications</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Receive updates about your activities</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 dark:peer-focus:ring-primary/40 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                </label>
            </div>

            <!-- Anonymous Forum Posts -->
            <div class="flex items-center justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white">Anonymous by Default</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Post anonymously in forums by default</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 dark:peer-focus:ring-primary/40 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                </label>
            </div>

            <!-- Show Profile to Others -->
            <div class="flex items-center justify-between py-3">
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white">Public Profile</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Allow others to see your profile</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer" checked>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 dark:peer-focus:ring-primary/40 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                </label>
            </div>
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-red-200 dark:border-red-900 overflow-hidden">
        <div class="bg-red-50 dark:bg-red-900/20 px-6 py-4 border-b border-red-200 dark:border-red-900">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-red-600 dark:text-red-400 text-2xl">warning</span>
                <h3 class="text-xl font-semibold text-red-900 dark:text-red-100">Danger Zone</h3>
            </div>
        </div>
        
        <div class="p-6">
            <div class="flex items-start justify-between">
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Delete Account</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Permanently delete your account and all associated data. This action cannot be undone.</p>
                </div>
                <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-red-700 transition-colors whitespace-nowrap">
                        Delete Account
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewAvatar(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatar-preview');
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-20 h-20 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600">`;
        }
        reader.readAsDataURL(file);
    }
}

function removeAvatar() {
    if (confirm('Are you sure you want to remove your profile image?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('profile.avatar.remove') }}';
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
