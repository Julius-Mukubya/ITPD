<!-- Signup Modal -->
<div id="signupModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl max-w-md w-full max-h-[90vh] overflow-y-auto shadow-2xl border border-gray-200 dark:border-gray-700">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
            <div>
                <h3 class="text-xl font-bold text-[#111816] dark:text-white">Get Started</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Create your account</p>
            </div>
            <button onclick="closeSignupModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-4">
            <!-- Error Messages Container -->
            <div id="signupErrors" class="hidden mb-3 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <span class="material-symbols-outlined text-red-400 text-lg">error</span>
                    </div>
                    <div class="ml-2">
                        <h3 class="text-xs font-medium text-red-800 dark:text-red-200">
                            There were some errors with your submission
                        </h3>
                        <div id="signupErrorsList" class="mt-1 text-xs text-red-700 dark:text-red-300">
                            <ul class="list-disc list-inside space-y-1"></ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success Message Container -->
            <div id="signupSuccess" class="hidden mb-3 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <span class="material-symbols-outlined text-green-400 text-lg">check_circle</span>
                    </div>
                    <div class="ml-2">
                        <p id="signupSuccessMessage" class="text-xs font-medium text-green-800 dark:text-green-200"></p>
                    </div>
                </div>
            </div>

            <form id="signupForm" class="space-y-4">

                <!-- Name Field -->
                <div>
                    <label for="modal_name" class="block text-sm font-medium text-[#111816] dark:text-white mb-1">
                        Full Name
                    </label>
                    <input id="modal_name" 
                           name="name" 
                           type="text" 
                           required 
                           autofocus
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 text-sm"
                           placeholder="Enter your full name">
                </div>

                <!-- Email Field -->
                <div>
                    <label for="modal_signup_email" class="block text-sm font-medium text-[#111816] dark:text-white mb-1">
                        Email Address
                    </label>
                    <input id="modal_signup_email" 
                           name="email" 
                           type="email" 
                           required
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 text-sm"
                           placeholder="Enter your email address">
                </div>



                <!-- Password Field -->
                <div>
                    <label for="modal_signup_password" class="block text-sm font-medium text-[#111816] dark:text-white mb-1">
                        Password
                    </label>
                    <input id="modal_signup_password" 
                           name="password" 
                           type="password" 
                           required 
                           autocomplete="new-password"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 text-sm"
                           placeholder="Create a password">
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label for="modal_password_confirmation" class="block text-sm font-medium text-[#111816] dark:text-white mb-1">
                        Confirm Password
                    </label>
                    <input id="modal_password_confirmation" 
                           name="password_confirmation" 
                           type="password" 
                           required 
                           autocomplete="new-password"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 text-sm"
                           placeholder="Confirm your password">
                </div>

                <!-- Terms and Privacy -->
                <div class="flex items-start">
                    <input id="modal_terms" 
                           name="terms" 
                           type="checkbox" 
                           required
                           class="h-4 w-4 text-primary focus:ring-primary border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 mt-1">
                    <label for="modal_terms" class="ml-2 text-xs text-gray-600 dark:text-gray-400">
                        I agree to the <a href="#" class="text-primary hover:text-primary/80 font-medium">Terms of Service</a> and <a href="#" class="text-primary hover:text-primary/80 font-medium">Privacy Policy</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        id="signupSubmitBtn"
                        class="w-full bg-primary text-[#111816] py-2.5 px-4 rounded-lg font-bold text-sm hover:bg-primary/90 focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <span id="signupBtnText">Create Account</span>
                    <span id="signupBtnLoading" class="hidden">
                        <span class="material-symbols-outlined animate-spin text-xl">progress_activity</span>
                        Creating Account...
                    </span>
                </button>

                <!-- Login Link -->
                <div class="text-center pt-2">
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
    // Hide messages
    document.getElementById('signupErrors').classList.add('hidden');
    document.getElementById('signupSuccess').classList.add('hidden');
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
    
    const submitBtn = document.getElementById('signupSubmitBtn');
    const btnText = document.getElementById('signupBtnText');
    const btnLoading = document.getElementById('signupBtnLoading');
    const errorsDiv = document.getElementById('signupErrors');
    const successDiv = document.getElementById('signupSuccess');
    
    // Show loading state
    submitBtn.disabled = true;
    btnText.classList.add('hidden');
    btnLoading.classList.remove('hidden');
    
    // Hide previous messages
    errorsDiv.classList.add('hidden');
    successDiv.classList.add('hidden');
    
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
            // Success - show success message and redirect
            document.getElementById('signupSuccessMessage').textContent = data.message || 'Account created successfully!';
            successDiv.classList.remove('hidden');
            
            // Redirect after a short delay
            setTimeout(() => {
                if (data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    window.location.href = '{{ route("dashboard") }}';
                }
            }, 1500);
        } else {
            // Handle validation errors
            if (data.errors) {
                const errorsList = document.querySelector('#signupErrorsList ul');
                errorsList.innerHTML = '';
                
                Object.values(data.errors).flat().forEach(error => {
                    const li = document.createElement('li');
                    li.textContent = error;
                    errorsList.appendChild(li);
                });
                
                errorsDiv.classList.remove('hidden');
            }
        }
    } catch (error) {
        console.error('Signup error:', error);
        // Show generic error
        const errorsList = document.querySelector('#signupErrorsList ul');
        errorsList.innerHTML = '<li>An error occurred. Please try again.</li>';
        errorsDiv.classList.remove('hidden');
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