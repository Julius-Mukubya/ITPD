<!-- Profile Settings Modal -->
<div id="profileModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-hidden border border-gray-200 dark:border-gray-700">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-2xl text-primary">person</span>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Profile Settings</h2>
            </div>
            <button onclick="closeProfileModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors p-2 hover:bg-gray-200 dark:hover:bg-gray-700 rounded-lg">
                <span class="material-symbols-outlined text-2xl">close</span>
            </button>
        </div>

        <!-- Modal Content -->
        <div class="overflow-y-auto max-h-[calc(90vh-120px)]">
            <!-- Profile Information Section -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-xl text-primary">account_circle</span>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Profile Information</h3>
                </div>

                <form id="profileForm" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-4">
                        <!-- Avatar -->
                        <div class="flex items-center gap-4 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                            <div class="relative">
                                <div id="avatarPreview" class="w-16 h-16 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 flex items-center justify-center overflow-hidden ring-2 ring-white dark:ring-gray-800">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                    @else
                                        <span class="material-symbols-outlined text-2xl text-gray-600 dark:text-gray-300">person</span>
                                    @endif
                                </div>
                                <div class="absolute bottom-0 right-0 bg-primary rounded-full p-1 shadow-lg">
                                    <span class="material-symbols-outlined text-white text-xs">photo_camera</span>
                                </div>
                            </div>
                            <div class="flex-1">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Profile Photo</label>
                                <input type="file" id="avatarInput" name="avatar" accept="image/*" 
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400
                                    file:mr-3 file:py-1 file:px-3
                                    file:rounded-md file:border-0
                                    file:text-xs file:font-medium
                                    file:bg-primary file:text-white
                                    hover:file:opacity-90 file:cursor-pointer">
                            </div>
                        </div>

                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Full Name *</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white text-sm">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Address *</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white text-sm">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone Number</label>
                            <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white text-sm">
                        </div>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="submit" class="bg-primary text-white px-6 py-2 rounded-lg hover:opacity-90 flex items-center gap-2 font-medium text-sm">
                            <span class="material-symbols-outlined text-sm">save</span>
                            Save Changes
                        </button>
                        <button type="button" onclick="resetProfileForm()" class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 font-medium text-sm">
                            Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Password Section -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-xl text-blue-600">lock</span>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Change Password</h3>
                </div>

                <form id="passwordForm" action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Current Password *</label>
                            <input type="password" name="current_password" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">New Password *</label>
                            <input type="password" name="password" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirm New Password *</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white text-sm">
                        </div>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 flex items-center gap-2 font-medium text-sm">
                            <span class="material-symbols-outlined text-sm">lock_reset</span>
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Account Actions -->
            <div class="p-6">
                <div class="flex items-center gap-3 mb-4">
                    <span class="material-symbols-outlined text-xl text-gray-600">settings</span>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Account Actions</h3>
                </div>

                <div class="space-y-3">
                    <button onclick="confirmDeleteAccount()" class="flex items-center gap-3 px-4 py-3 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors w-full text-left">
                        <span class="material-symbols-outlined">delete_forever</span>
                        <span>Delete Account</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function openProfileModal() {
    const modal = document.getElementById('profileModal');
    const modalContent = modal.querySelector('div');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
    
    // Add animation
    modalContent.style.transform = 'scale(0.95)';
    modalContent.style.opacity = '0';
    
    setTimeout(() => {
        modalContent.style.transform = 'scale(1)';
        modalContent.style.opacity = '1';
        modalContent.style.transition = 'all 0.2s ease-out';
    }, 10);
}

function closeProfileModal() {
    const modal = document.getElementById('profileModal');
    const modalContent = modal.querySelector('div');
    
    modalContent.style.transform = 'scale(0.95)';
    modalContent.style.opacity = '0';
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
        modalContent.style.transition = '';
    }, 200);
}

function resetProfileForm() {
    document.getElementById('profileForm').reset();
    
    // Reset avatar preview to original
    const preview = document.getElementById('avatarPreview');
    @if(auth()->user()->avatar)
        preview.innerHTML = `<img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">`;
    @else
        preview.innerHTML = `<span class="material-symbols-outlined text-2xl text-gray-600 dark:text-gray-300">person</span>`;
    @endif
}

function confirmDeleteAccount() {
    if (confirm('⚠️ WARNING: This action cannot be undone!\n\nAre you absolutely sure you want to delete your account?\n\nAll your data including:\n• Quiz attempts and scores\n• Counseling sessions\n• Forum posts and comments\n• Bookmarks and progress\n\nwill be permanently deleted.')) {
        // Create and submit delete form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("profile.destroy") }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

// Close modal when clicking outside
document.getElementById('profileModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeProfileModal();
    }
});

// Handle avatar preview
document.getElementById('avatarInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('avatarPreview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Avatar Preview" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(file);
    }
});

// Handle form submissions with AJAX for better UX
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Clear previous errors
    clearFormErrors(this);
    
    submitBtn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">refresh</span> Saving...';
    submitBtn.disabled = true;
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(data => Promise.reject(data));
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showToast('Profile updated successfully!', 'success');
            // Optionally reload the page to reflect changes
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            showToast('Error updating profile. Please try again.', 'error');
        }
    })
    .catch(error => {
        if (error.errors) {
            showFormErrors(this, error.errors);
            showToast('Please fix the validation errors.', 'error');
        } else {
            showToast('Error updating profile. Please try again.', 'error');
        }
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

document.getElementById('passwordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    // Clear previous errors
    clearFormErrors(this);
    
    submitBtn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">refresh</span> Updating...';
    submitBtn.disabled = true;
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
        }
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(data => Promise.reject(data));
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showToast('Password updated successfully!', 'success');
            this.reset();
        } else {
            showToast('Error updating password. Please check your current password.', 'error');
        }
    })
    .catch(error => {
        if (error.errors) {
            showFormErrors(this, error.errors);
            showToast('Please fix the validation errors.', 'error');
        } else {
            showToast('Error updating password. Please try again.', 'error');
        }
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});

function clearFormErrors(form) {
    const errorElements = form.querySelectorAll('.error-message');
    errorElements.forEach(el => el.remove());
    
    const inputElements = form.querySelectorAll('input');
    inputElements.forEach(input => {
        input.classList.remove('border-red-500', 'focus:ring-red-500');
        input.classList.add('border-gray-300', 'dark:border-gray-600', 'focus:ring-primary');
    });
}

function showFormErrors(form, errors) {
    Object.keys(errors).forEach(fieldName => {
        const input = form.querySelector(`[name="${fieldName}"]`);
        if (input) {
            // Style the input as error
            input.classList.remove('border-gray-300', 'dark:border-gray-600', 'focus:ring-primary');
            input.classList.add('border-red-500', 'focus:ring-red-500');
            
            // Add error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message text-red-500 text-sm mt-1 flex items-center gap-1';
            errorDiv.innerHTML = `<span class="material-symbols-outlined text-sm">error</span>${errors[fieldName][0]}`;
            
            input.parentNode.appendChild(errorDiv);
        }
    });
}

function showToast(message, type = 'info') {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium transform translate-x-full transition-transform duration-300 ${
        type === 'success' ? 'bg-green-600' : 
        type === 'error' ? 'bg-red-600' : 
        'bg-blue-600'
    }`;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    // Show toast
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    // Hide toast after 3 seconds
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}
</script>