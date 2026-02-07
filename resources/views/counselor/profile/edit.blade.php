@extends('layouts.counselor')

@section('title', 'My Profile')

@section('content')
<div class="px-2 sm:px-0">
<!-- Header -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
    <div class="flex flex-col gap-1">
        <p class="text-gray-900 dark:text-white text-xl sm:text-2xl lg:text-3xl font-bold tracking-tight">My Profile</p>
        <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">Manage your profile information and settings</p>
    </div>
</div>

<div class="max-w-5xl mx-auto">
    @if($errors->any())
    <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-800 dark:text-red-200 px-4 sm:px-6 py-4 rounded-2xl mb-6">
        <div class="flex items-start gap-3">
            <span class="material-symbols-outlined text-red-600 flex-shrink-0">error</span>
            <div>
                <p class="font-semibold mb-2 text-sm sm:text-base">Please fix the following errors:</p>
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                    <li class="text-xs sm:text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <!-- Profile Header Card -->
    <div class="group bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl p-4 sm:p-6 lg:p-8 text-white mb-6 shadow-sm hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-300 hover:-translate-y-1">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 sm:gap-6">
            @if(auth()->user()->avatar)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" class="w-20 h-20 sm:w-24 sm:h-24 rounded-full object-cover border-4 border-white/20 group-hover:scale-105 transition-transform duration-300 flex-shrink-0">
            @else
                <div class="w-20 h-20 sm:w-24 sm:h-24 bg-white/20 rounded-full flex items-center justify-center text-2xl sm:text-4xl font-bold backdrop-blur-sm group-hover:scale-105 transition-transform duration-300 flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
            @endif
            <div class="text-center sm:text-left">
                <h2 class="text-xl sm:text-2xl font-bold mb-1">{{ auth()->user()->name }}</h2>
                <p class="text-white/90 text-sm sm:text-base">{{ auth()->user()->email }}</p>
                <div class="flex flex-col sm:flex-row items-center gap-2 mt-2">
                    <span class="bg-white/20 px-3 py-1 rounded-full text-xs sm:text-sm font-semibold">Counselor</span>
                    <span class="bg-white/20 px-3 py-1 rounded-full text-xs sm:text-sm">Member since {{ auth()->user()->created_at->format('M Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Information -->
    <div class="group bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-6 shadow-sm hover:shadow-lg hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1 relative">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-emerald-600"></div>
        <div class="bg-emerald-50 dark:bg-emerald-900/20 px-4 sm:px-6 py-4 border-b border-emerald-100 dark:border-emerald-900/30">
            <div class="flex items-center gap-3">
                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                    <span class="material-symbols-outlined text-lg sm:text-xl text-emerald-600 dark:text-emerald-400">person</span>
                </div>
                <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white">Profile Information</h3>
            </div>
        </div>
        
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="p-4 sm:p-6">
            @csrf
            @method('PATCH')
            
            <div class="space-y-4 sm:space-y-6">
                <!-- Profile Image -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                        Profile Image
                    </label>
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 sm:gap-6">
                        <div class="relative flex-shrink-0">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}" 
                                     id="avatar-preview" class="w-20 h-20 rounded-full object-cover border-2 border-emerald-300 dark:border-emerald-600">
                            @else
                                <div id="avatar-preview" class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-full flex items-center justify-center text-2xl font-bold text-white">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 text-center sm:text-left">
                            <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden" onchange="previewAvatar(event)">
                            <div class="flex flex-col sm:flex-row gap-3">
                                <button type="button" onclick="document.getElementById('avatar').click()" 
                                        class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-200 flex items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-lg">upload</span>
                                    Upload Photo
                                </button>
                                @if(auth()->user()->avatar)
                                    <button type="button" onclick="removeAvatar()" 
                                            class="bg-red-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-red-700 transition-colors flex items-center justify-center gap-2">
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
                           class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
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
                           class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Phone Number <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" required
                           placeholder="+256 700 000 000"
                           class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Students may contact you via this number</p>
                </div>

                <!-- Specialization -->
                <div>
                    <label for="specialization" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Specialization <span class="text-gray-400 text-xs">(Optional)</span>
                    </label>
                    <input type="text" name="specialization" id="specialization" value="{{ old('specialization', auth()->user()->specialization ?? '') }}"
                           placeholder="e.g., Substance Abuse, Mental Health, Trauma Counseling"
                           class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                    @error('specialization')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Bio -->
                <div>
                    <label for="bio" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Professional Bio <span class="text-gray-400 text-xs">(Optional)</span>
                    </label>
                    <textarea name="bio" id="bio" rows="4"
                              placeholder="Share your experience, qualifications, and approach to counseling..."
                              class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 resize-none transition-all">{{ old('bio', auth()->user()->bio ?? '') }}</textarea>
                    @error('bio')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Availability -->
                <div>
                    <label for="availability" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Availability <span class="text-gray-400 text-xs">(Optional)</span>
                    </label>
                    <input type="text" name="availability" id="availability" value="{{ old('availability', auth()->user()->availability ?? '') }}"
                           placeholder="e.g., Mon-Fri 9AM-5PM"
                           class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all">
                    @error('availability')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-center sm:justify-end">
                <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg hover:shadow-emerald-500/30 transition-all duration-200 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">save</span>
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    <!-- Change Password -->
    <div class="group bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-6 shadow-sm hover:shadow-lg hover:shadow-green-500/10 transition-all duration-300 hover:-translate-y-1 relative">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-green-600"></div>
        <div class="bg-green-50 dark:bg-green-900/20 px-4 sm:px-6 py-4 border-b border-green-100 dark:border-green-900/30">
            <div class="flex items-center gap-3">
                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                    <span class="material-symbols-outlined text-lg sm:text-xl text-green-600 dark:text-green-400">lock</span>
                </div>
                <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white">Change Password</h3>
            </div>
        </div>
        
        <form action="{{ route('profile.password.update') }}" method="POST" class="p-4 sm:p-6">
            @csrf
            @method('PATCH')
            
            <div class="space-y-4 sm:space-y-6">
                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Current Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="current_password" id="current_password" required
                           class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
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
                           class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
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
                           class="w-full px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all">
                </div>
            </div>

            <div class="mt-6 flex justify-center sm:justify-end">
                <button type="submit" class="w-full sm:w-auto bg-gradient-to-r from-green-500 to-green-600 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg hover:shadow-green-500/30 transition-all duration-200 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">lock_reset</span>
                    Update Password
                </button>
            </div>
        </form>
    </div>

    <!-- Danger Zone -->
    <div class="group bg-white dark:bg-gray-800 rounded-2xl border border-red-200 dark:border-red-900 overflow-hidden shadow-sm hover:shadow-lg hover:shadow-red-500/10 transition-all duration-300 hover:-translate-y-1 relative">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-red-600"></div>
        <div class="bg-red-50 dark:bg-red-900/20 px-4 sm:px-6 py-4 border-b border-red-200 dark:border-red-900">
            <div class="flex items-center gap-3">
                <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-xl p-2 group-hover:scale-110 transition-transform duration-300">
                    <span class="material-symbols-outlined text-lg sm:text-xl text-red-600 dark:text-red-400">warning</span>
                </div>
                <h3 class="text-lg sm:text-xl font-semibold text-red-900 dark:text-red-100">Danger Zone</h3>
            </div>
        </div>
        
        <div class="p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white mb-1">Delete Account</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Permanently delete your account and all associated data. This action cannot be undone.</p>
                </div>
                <form action="{{ route('profile.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.')" class="flex-shrink-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full sm:w-auto bg-red-600 text-white px-6 py-2 rounded-xl font-semibold hover:bg-red-700 transition-colors whitespace-nowrap">
                        Delete Account
                    </button>
                </form>
            </div>
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
