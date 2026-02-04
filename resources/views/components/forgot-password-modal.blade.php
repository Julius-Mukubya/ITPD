<!-- Forgot Password Modal -->
<div id="forgotPasswordModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl max-w-md w-full max-h-[90vh] overflow-y-auto shadow-2xl border border-gray-200 dark:border-gray-700">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
            <div>
                <h3 class="text-xl font-bold text-[#111816] dark:text-white">Reset Password</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Enter your email to receive a reset link</p>
            </div>
            <button onclick="closeForgotPasswordModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-4">
            <!-- Success State (Hidden by default) -->
            <div id="forgotPasswordSuccess" class="hidden text-center py-6">
                <div class="mx-auto flex items-center justify-center w-12 h-12 rounded-full bg-green-100 dark:bg-green-900 mb-4">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400 text-2xl">mark_email_read</span>
                </div>
                <h4 class="text-lg font-semibold text-[#111816] dark:text-white mb-2">Check Your Email</h4>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4">
                    We've sent a password reset link to your email address. Please check your inbox and follow the instructions to reset your password.
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-500 mb-4">
                    Didn't receive the email? Check your spam folder or try again.
                </p>
                <div class="space-y-2">
                    <button type="button" onclick="showForgotPasswordForm()" 
                            class="w-full text-primary hover:text-primary/80 font-medium text-sm py-2">
                        Try Different Email
                    </button>
                    <button type="button" onclick="closeForgotPasswordModal()" 
                            class="w-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 py-2 px-4 rounded-lg font-medium text-sm hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        Close
                    </button>
                </div>
            </div>

            <!-- Form State (Visible by default) -->
            <div id="forgotPasswordForm">
                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                    Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
                </div>

                <form id="forgotPasswordFormElement" class="space-y-4">
                    <!-- Email Field -->
                    <div>
                        <label for="forgot_email" class="block text-sm font-medium text-[#111816] dark:text-white mb-1">
                            Email Address
                        </label>
                        <input id="forgot_email" 
                               name="email" 
                               type="email" 
                               required 
                               autofocus
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 text-sm"
                               placeholder="Enter your email address">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            id="forgotPasswordSubmitBtn"
                            class="w-full bg-primary text-[#111816] py-2.5 px-4 rounded-lg font-bold text-sm hover:bg-primary/90 focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="forgotPasswordBtnText">Send Reset Link</span>
                        <span id="forgotPasswordBtnLoading" class="hidden flex items-center justify-center">
                            <span class="material-symbols-outlined animate-spin text-xl mr-2">progress_activity</span>
                            Sending...
                        </span>
                    </button>

                    <!-- Back to Login Link -->
                    <div class="text-center pt-2">
                        <p class="text-xs text-gray-600 dark:text-gray-400">
                            Remember your password? 
                            <button type="button" onclick="switchToLogin()" class="text-primary hover:text-primary/80 font-medium">
                                Sign in here
                            </button>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openForgotPasswordModal() {
    console.log('openForgotPasswordModal called');
    const modal = document.getElementById('forgotPasswordModal');
    if (!modal) {
        console.error('Forgot password modal not found');
        return;
    }
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Reset to form state
    showForgotPasswordForm();
    
    // Focus on email field
    setTimeout(() => {
        const emailField = document.getElementById('forgot_email');
        if (emailField) {
            emailField.focus();
        }
    }, 100);
}

function closeForgotPasswordModal() {
    document.getElementById('forgotPasswordModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    // Clear form
    document.getElementById('forgotPasswordFormElement').reset();
    // Reset to form state
    showForgotPasswordForm();
}

function showForgotPasswordForm() {
    document.getElementById('forgotPasswordForm').classList.remove('hidden');
    document.getElementById('forgotPasswordSuccess').classList.add('hidden');
}

function showForgotPasswordSuccess() {
    document.getElementById('forgotPasswordForm').classList.add('hidden');
    document.getElementById('forgotPasswordSuccess').classList.remove('hidden');
}

function switchToLogin() {
    closeForgotPasswordModal();
    setTimeout(() => {
        if (typeof openLoginModal === 'function') {
            openLoginModal();
        }
    }, 100);
}

// Close modal when clicking outside
document.getElementById('forgotPasswordModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeForgotPasswordModal();
    }
});

// Handle form submission
document.addEventListener('DOMContentLoaded', function() {
    const forgotPasswordForm = document.getElementById('forgotPasswordFormElement');
    if (!forgotPasswordForm) return;
    
    forgotPasswordForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        console.log('Forgot password form submitted');
        
        const submitBtn = document.getElementById('forgotPasswordSubmitBtn');
        const btnText = document.getElementById('forgotPasswordBtnText');
        const btnLoading = document.getElementById('forgotPasswordBtnLoading');
        
        // Show loading state
        submitBtn.disabled = true;
        btnText.classList.add('hidden');
        btnLoading.classList.remove('hidden');
        
        try {
            const formData = new FormData(this);
            console.log('Sending forgot password request...');
            
            const response = await fetch('{{ route("password.email") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            console.log('Response status:', response.status);
            const data = await response.json();
            console.log('Response data:', data);
            
            if (response.ok) {
                // Success - show success state
                showForgotPasswordSuccess();
                showToast('Password reset link sent to your email!', 'success');
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
            console.error('Forgot password error:', error);
            // Show generic error toast
            showToast('An error occurred. Please try again.', 'error');
        } finally {
            // Reset loading state
            submitBtn.disabled = false;
            btnText.classList.remove('hidden');
            btnLoading.classList.add('hidden');
        }
    });
});

// Handle escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !document.getElementById('forgotPasswordModal').classList.contains('hidden')) {
        closeForgotPasswordModal();
    }
});
</script>