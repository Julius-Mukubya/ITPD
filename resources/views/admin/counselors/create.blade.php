@extends('layouts.admin')

@section('title', 'Add Counselor - Admin')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Add Counselor</h2>
            <p class="text-gray-600 dark:text-gray-400">Add new counselor to the system</p>
        </div>
        <a href="{{ route('admin.counseling.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
            Back to Counseling
        </a>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="role" value="counselor">
        <input type="hidden" name="redirect_to_counseling" value="1">

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address *</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password *</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password *</label>
                <input type="password" name="password_confirmation" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                <input type="tel" name="phone" value="{{ old('phone') }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white">
                @error('phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Registration Number</label>
                <input type="text" name="registration_number" value="{{ old('registration_number') }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary dark:bg-gray-700 dark:text-white"
                    placeholder="Professional registration number (if applicable)">
                @error('registration_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Profile Photo</label>
                <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 p-6 transition-colors hover:border-primary/50 hover:bg-gray-100/50 dark:hover:bg-gray-800/50" 
                     id="upload_area"
                     ondragover="handleDragOver(event)"
                     ondragleave="handleDragLeave(event)"
                     ondrop="handleDrop(event)"
                     onclick="document.getElementById('avatar_input').click()"
                     style="cursor: pointer;">
                    <div class="flex flex-col items-center text-center">
                        <!-- Avatar Preview -->
                        <div class="relative mb-4">
                            <div class="w-32 h-32 rounded-full bg-gradient-to-br from-primary to-blue-600 flex items-center justify-center overflow-hidden ring-4 ring-white dark:ring-gray-800 shadow-lg">
                                <span class="material-symbols-outlined text-5xl text-white" id="avatar_icon">person</span>
                                <img id="avatar_preview" src="" alt="Preview" class="w-full h-full object-cover hidden">
                            </div>
                            <div class="absolute bottom-2 right-2 bg-primary rounded-full p-2 shadow-lg ring-2 ring-white dark:ring-gray-800">
                                <span class="material-symbols-outlined text-white text-lg">photo_camera</span>
                            </div>
                        </div>
                        
                        <!-- Upload Instructions -->
                        <div class="space-y-2 mb-4">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                <span class="text-primary">Click to upload</span> or drag and drop
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                JPG, PNG or GIF (max. 2MB)
                            </p>
                        </div>
                        
                        <!-- Hidden File Input -->
                        <input type="file" name="avatar" accept="image/*" id="avatar_input" 
                               class="hidden" 
                               onchange="previewAvatar(event)">
                        
                        <!-- Upload Button -->
                        <button type="button" onclick="event.stopPropagation(); document.getElementById('avatar_input').click()" 
                                class="inline-flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors shadow-sm z-10 relative">
                            <span class="material-symbols-outlined text-lg">upload</span>
                            Choose File
                        </button>
                        
                        <!-- Remove Button (hidden by default) -->
                        <button type="button" id="remove_avatar" onclick="event.stopPropagation(); removeAvatar()" 
                                class="hidden mt-2 text-sm text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors z-10 relative">
                            Remove Photo
                        </button>
                    </div>
                </div>
                @error('avatar')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Active Account</span>
                </label>
            </div>
        </div>

        <div class="flex gap-3 mt-8">
            <button type="submit" class="bg-primary text-white px-8 py-3 rounded-lg hover:opacity-90 font-semibold">Add Counselor</button>
            <a href="{{ route('admin.counseling.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-8 py-3 rounded-lg hover:opacity-90 font-semibold">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewAvatar(event) {
    const file = event.target.files[0];
    if (file) {
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB');
            return;
        }
        
        // Validate file type
        if (!file.type.match('image.*')) {
            alert('Please select a valid image file');
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar_preview').src = e.target.result;
            document.getElementById('avatar_preview').classList.remove('hidden');
            document.getElementById('avatar_icon').classList.add('hidden');
            document.getElementById('remove_avatar').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

function removeAvatar() {
    document.getElementById('avatar_input').value = '';
    document.getElementById('avatar_preview').classList.add('hidden');
    document.getElementById('avatar_icon').classList.remove('hidden');
    document.getElementById('remove_avatar').classList.add('hidden');
}

function handleDragOver(event) {
    event.preventDefault();
    event.stopPropagation();
    document.getElementById('upload_area').classList.add('border-primary', 'bg-primary/5');
}

function handleDragLeave(event) {
    event.preventDefault();
    event.stopPropagation();
    document.getElementById('upload_area').classList.remove('border-primary', 'bg-primary/5');
}

function handleDrop(event) {
    event.preventDefault();
    event.stopPropagation();
    document.getElementById('upload_area').classList.remove('border-primary', 'bg-primary/5');
    
    const files = event.dataTransfer.files;
    if (files.length > 0) {
        const input = document.getElementById('avatar_input');
        input.files = files;
        previewAvatar({ target: { files: files } });
    }
}

// Prevent default drag behaviors on the document
document.addEventListener('dragover', function(e) {
    e.preventDefault();
});

document.addEventListener('drop', function(e) {
    e.preventDefault();
});
</script>
@endpush