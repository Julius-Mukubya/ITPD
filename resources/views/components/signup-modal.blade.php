<!-- Signup Modal -->
<div id="signupModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl max-w-sm w-full max-h-[95vh] overflow-y-auto shadow-2xl border border-gray-200 dark:border-gray-700">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-3 border-b border-gray-200 dark:border-gray-700">
            <div>
                <h3 class="text-lg font-bold text-[#111816] dark:text-white">Get Started</h3>
                <p class="text-gray-600 dark:text-gray-400 text-xs">Create your account</p>
            </div>
            <button onclick="closeSignupModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <span class="material-symbols-outlined text-lg">close</span>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-3">
            <!-- Error Messages Container - REMOVED, using toasts instead -->

            <!-- Success Message Container - REMOVED, using toasts instead -->

            <form id="signupForm" class="space-y-3">

                <!-- Name Field -->
                <div>
                    <label for="modal_name" class="block text-xs font-medium text-[#111816] dark:text-white mb-1">
                        Full Name
                    </label>
                    <input id="modal_name" 
                           name="name" 
                           type="text" 
                           required 
                           autofocus
                           oninput="debouncedUpdateSubmitButton()"
                           class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 text-xs"
                           placeholder="Enter your full name">
                </div>

                <!-- Profile Picture Field -->
                <div>
                    <label for="modal_avatar" class="block text-xs font-medium text-[#111816] dark:text-white mb-1">
                        Profile Picture (Optional)
                    </label>
                    <div class="flex items-center gap-2">
                        <!-- Avatar Preview -->
                        <div class="relative">
                            <div id="avatarPreview" class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 flex items-center justify-center overflow-hidden border border-gray-300 dark:border-gray-600">
                                <span class="material-symbols-outlined text-sm text-gray-500 dark:text-gray-400">person</span>
                            </div>
                            <div class="absolute -bottom-0.5 -right-0.5 bg-primary rounded-full p-0.5 shadow-lg">
                                <span class="material-symbols-outlined text-white text-xs">photo_camera</span>
                            </div>
                        </div>
                        <!-- Upload Button -->
                        <div class="flex-1">
                            <input type="file" id="modal_avatar" name="avatar" accept="image/*" class="hidden" onchange="previewSignupAvatar(this)">
                            <button type="button" onclick="document.getElementById('modal_avatar').click()" 
                                    class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 px-2 py-1 rounded text-xs font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors flex items-center gap-1">
                                <span class="material-symbols-outlined text-xs">upload</span>
                                Choose Photo
                            </button>
                            <p class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">Max 2MB</p>
                        </div>
                    </div>
                </div>

                <!-- Email Field -->
                <div>
                    <label for="modal_signup_email" class="block text-xs font-medium text-[#111816] dark:text-white mb-1">
                        Email Address
                    </label>
                    <input id="modal_signup_email" 
                           name="email" 
                           type="email" 
                           required
                           oninput="debouncedUpdateSubmitButton()"
                           class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 text-xs"
                           placeholder="Enter your email address">
                </div>

                <!-- Password Field -->
                <div>
                    <label for="modal_signup_password" class="block text-xs font-medium text-[#111816] dark:text-white mb-1">
                        Password
                    </label>
                    <input id="modal_signup_password" 
                           name="password" 
                           type="password" 
                           required 
                           autocomplete="new-password"
                           oninput="checkPasswordMatch(); checkPasswordStrength()"
                           class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 text-xs"
                           placeholder="Create a password">
                    <div id="passwordStrengthMessage" class="hidden mt-1 text-xs text-gray-500 dark:text-gray-400">Minimum 8 characters required</div>
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label for="modal_password_confirmation" class="block text-xs font-medium text-[#111816] dark:text-white mb-1">
                        Confirm Password
                    </label>
                    <input id="modal_password_confirmation" 
                           name="password_confirmation" 
                           type="password" 
                           required 
                           autocomplete="new-password"
                           oninput="checkPasswordMatch()"
                           class="w-full px-2 py-1.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 text-xs"
                           placeholder="Confirm your password">
                    <div id="passwordMatchMessage" class="hidden mt-1 text-xs"></div>
                </div>

                <!-- Terms and Privacy -->
                <div class="flex items-start">
                    <input id="modal_terms" 
                           name="terms" 
                           type="checkbox" 
                           required
                           onchange="debouncedUpdateSubmitButton()"
                           class="h-3 w-3 text-primary focus:ring-primary border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 mt-0.5">
                    <label for="modal_terms" class="ml-2 text-xs text-gray-600 dark:text-gray-400">
                        I agree to the <a class="text-primary hover:text-primary/80 font-medium cursor-pointer" onclick="openTermsModal()">Terms</a> and <a class="text-primary hover:text-primary/80 font-medium cursor-pointer" onclick="openPrivacyModal()">Privacy Policy</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        id="signupSubmitBtn"
                        class="w-full bg-primary text-[#111816] py-2 px-4 rounded-lg font-bold text-xs hover:bg-primary/90 focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                    <span id="signupBtnText">Create Account</span>
                    <span id="signupBtnLoading" class="hidden">
                        <span class="material-symbols-outlined animate-spin text-sm">progress_activity</span>
                        Creating Account...
                    </span>
                </button>

                <!-- Login Link -->
                <div class="text-center pt-1">
                    <p class="text-xs text-gray-600 dark:text-gray-400">
                        Already have an account? 
                        <button type="button" onclick="switchToLogin()" class="text-primary hover:text-primary/80 font-medium">
                            Sign in here
                        </button>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openSignupModal() {
    document.getElementById('signupModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    // Focus on name field
    setTimeout(() => {
        document.getElementById('modal_name').focus();
    }, 100);
}

function closeSignupModal() {
    document.getElementById('signupModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    // Clear form
    document.getElementById('signupForm').reset();
    // Reset avatar preview
    resetAvatarPreview();
    // Hide messages
    document.getElementById('passwordMatchMessage').classList.add('hidden');
    document.getElementById('passwordStrengthMessage').classList.add('hidden');
    // Reset submit button to disabled state
    const submitBtn = document.getElementById('signupSubmitBtn');
    submitBtn.disabled = true;
    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
}

function resetAvatarPreview() {
    const preview = document.getElementById('avatarPreview');
    preview.innerHTML = '<span class="material-symbols-outlined text-sm text-gray-500 dark:text-gray-400">person</span>';
}

function checkPasswordMatch() {
    const password = document.getElementById('modal_signup_password').value;
    const confirmPassword = document.getElementById('modal_password_confirmation').value;
    const messageDiv = document.getElementById('passwordMatchMessage');
    const submitBtn = document.getElementById('signupSubmitBtn');
    
    if (confirmPassword.length === 0) {
        messageDiv.classList.add('hidden');
        updateSubmitButton();
        return;
    }
    
    if (password === confirmPassword) {
        messageDiv.textContent = '✓ Passwords match';
        messageDiv.className = 'mt-1 text-xs text-green-600 dark:text-green-400';
        messageDiv.classList.remove('hidden');
    } else {
        messageDiv.textContent = '✗ Passwords do not match';
        messageDiv.className = 'mt-1 text-xs text-red-600 dark:text-red-400';
        messageDiv.classList.remove('hidden');
    }
    
    updateSubmitButton();
}

function checkPasswordStrength() {
    const password = document.getElementById('modal_signup_password').value;
    const messageDiv = document.getElementById('passwordStrengthMessage');
    
    if (password.length === 0) {
        messageDiv.classList.add('hidden');
        updateSubmitButton();
        return;
    }
    
    if (password.length < 8) {
        messageDiv.textContent = `Password too short (${password.length}/8 characters)`;
        messageDiv.className = 'mt-1 text-xs text-red-600 dark:text-red-400';
        messageDiv.classList.remove('hidden');
    } else {
        messageDiv.textContent = '✓ Password meets requirements';
        messageDiv.className = 'mt-1 text-xs text-green-600 dark:text-green-400';
        messageDiv.classList.remove('hidden');
    }
    
    updateSubmitButton();
}

let validationTimeout;

function updateSubmitButton() {
    const name = document.getElementById('modal_name').value.trim();
    const email = document.getElementById('modal_signup_email').value.trim();
    const password = document.getElementById('modal_signup_password').value;
    const confirmPassword = document.getElementById('modal_password_confirmation').value;
    const terms = document.getElementById('modal_terms').checked;
    const submitBtn = document.getElementById('signupSubmitBtn');
    
    // Check all validation requirements
    const nameValid = name.length > 0;
    const emailValid = email.length > 0 && email.includes('@');
    const passwordValid = password.length >= 8;
    const passwordsMatch = password === confirmPassword && confirmPassword.length > 0;
    const termsAccepted = terms;
    
    // Enable button only if all requirements are met
    const allValid = nameValid && emailValid && passwordValid && passwordsMatch && termsAccepted;
    
    if (allValid) {
        submitBtn.disabled = false;
        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    } else {
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
    }
}

function debouncedUpdateSubmitButton() {
    clearTimeout(validationTimeout);
    validationTimeout = setTimeout(updateSubmitButton, 100);
}

function previewSignupAvatar(input) {
    const file = input.files[0];
    const preview = document.getElementById('avatarPreview');
    
    if (file) {
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB');
            input.value = '';
            resetAvatarPreview();
            return;
        }
        
        // Validate file type
        if (!file.type.match(/^image\/(jpeg|jpg|png|gif)$/)) {
            alert('Please select a valid image file (JPG, PNG, or GIF)');
            input.value = '';
            resetAvatarPreview();
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Avatar Preview" class="w-full h-full object-cover">`;
        };
        reader.readAsDataURL(file);
    } else {
        resetAvatarPreview();
    }
}

function switchToLogin() {
    closeSignupModal();
    setTimeout(() => {
        openLoginModal();
    }, 100);
}

// Close modal when clicking outside
document.getElementById('signupModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeSignupModal();
    }
});

// Handle form submission
document.getElementById('signupForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const password = document.getElementById('modal_signup_password').value;
    const confirmPassword = document.getElementById('modal_password_confirmation').value;
    
    // Final validation before submission
    if (password !== confirmPassword) {
        showToast('Passwords do not match', 'error');
        return;
    }
    
    if (password.length < 8) {
        showToast('Password must be at least 8 characters long', 'error');
        return;
    }
    
    const submitBtn = document.getElementById('signupSubmitBtn');
    const btnText = document.getElementById('signupBtnText');
    const btnLoading = document.getElementById('signupBtnLoading');
    
    // Show loading state
    submitBtn.disabled = true;
    btnText.classList.add('hidden');
    btnLoading.classList.remove('hidden');
    
    try {
        const formData = new FormData(this);
        
        const response = await fetch('{{ route("ajax.register") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        const data = await response.json();
        
        if (response.ok) {
            // Success - close modal and redirect immediately (toast will show on destination page)
            closeSignupModal();
            
            // Redirect immediately to avoid showing toast on wrong page
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                window.location.href = '{{ route("home") }}';
            }
        } else {
            // Handle validation errors
            if (data.errors) {
                // Show each error as a separate toast
                Object.values(data.errors).flat().forEach(error => {
                    showToast(error, 'error');
                });
            } else if (data.message) {
                // Handle other error messages
                showToast(data.message, 'error');
            }
        }
    } catch (error) {
        console.error('Signup error:', error);
        // Show generic error toast
        showToast('An error occurred. Please try again.', 'error');
    } finally {
        // Reset loading state
        submitBtn.disabled = false;
        btnText.classList.remove('hidden');
        btnLoading.classList.add('hidden');
    }
});

// Handle escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !document.getElementById('signupModal').classList.contains('hidden')) {
        closeSignupModal();
    }
});
</script>