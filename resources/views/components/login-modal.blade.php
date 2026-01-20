<!-- Login Modal -->
<div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl max-w-md w-full max-h-[90vh] overflow-y-auto shadow-2xl border border-gray-200 dark:border-gray-700">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
            <div>
                <h3 class="text-xl font-bold text-[#111816] dark:text-white">Sign In</h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Access your account</p>
            </div>
            <button onclick="closeLoginModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <span class="material-symbols-outlined text-xl">close</span>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-4">
            <!-- Error Messages Container -->
            <div id="loginErrors" class="hidden mb-3 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <span class="material-symbols-outlined text-red-400 text-lg">error</span>
                    </div>
                    <div class="ml-2">
                        <h3 class="text-xs font-medium text-red-800 dark:text-red-200">
                            There were some errors with your submission
                        </h3>
                        <div id="loginErrorsList" class="mt-1 text-xs text-red-700 dark:text-red-300">
                            <ul class="list-disc list-inside space-y-1"></ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success Message Container -->
            <div id="loginSuccess" class="hidden mb-3 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <span class="material-symbols-outlined text-green-400 text-lg">check_circle</span>
                    </div>
                    <div class="ml-2">
                        <p id="loginSuccessMessage" class="text-xs font-medium text-green-800 dark:text-green-200"></p>
                    </div>
                </div>
            </div>

            <form id="loginForm" class="space-y-4">

                <!-- Email Field -->
                <div>
                    <label for="modal_email" class="block text-sm font-medium text-[#111816] dark:text-white mb-1">
                        Email Address
                    </label>
                    <input id="modal_email" 
                           name="email" 
                           type="email" 
                           required 
                           autofocus
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 text-sm"
                           placeholder="Enter your email address">
                </div>

                <!-- Password Field -->
                <div>
                    <label for="modal_password" class="block text-sm font-medium text-[#111816] dark:text-white mb-1">
                        Password
                    </label>
                    <input id="modal_password" 
                           name="password" 
                           type="password" 
                           required 
                           autocomplete="current-password"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary dark:bg-gray-700 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 text-sm"
                           placeholder="Enter your password">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label for="modal_remember_me" class="flex items-center">
                        <input id="modal_remember_me" 
                               name="remember" 
                               type="checkbox" 
                               class="h-4 w-4 text-primary focus:ring-primary border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700">
                        <span class="ml-2 text-xs text-gray-600 dark:text-gray-400">Remember me</span>
                    </label>

                    <a class="text-xs text-primary hover:text-primary/80 font-medium" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        id="loginSubmitBtn"
                        class="w-full bg-primary text-[#111816] py-2.5 px-4 rounded-lg font-bold text-sm hover:bg-primary/90 focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    <span id="loginBtnText">Sign In</span>
                    <span id="loginBtnLoading" class="hidden">
                        <span class="material-symbols-outlined animate-spin text-xl">progress_activity</span>
                        Signing In...
                    </span>
                </button>

                <!-- Register Link -->
                <div class="text-center pt-2">
                    <p class="text-xs text-gray-600 dark:text-gray-400">
                        Don't have an account? 
                        <button type="button" onclick="switchToSignup()" class="text-primary hover:text-primary/80 font-medium">
                            Create one here
                        </button>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openLoginModal() {
    console.log('openLoginModal called'); // Debug log
    const modal = document.getElementById('loginModal');
    if (!modal) {
        console.error('Login modal not found');
        return;
    }
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    // Focus on email field
    setTimeout(() => {
        const emailField = document.getElementById('modal_email');
        if (emailField) {
            emailField.focus();
        }
    }, 100);
}

function closeLoginModal() {
    document.getElementById('loginModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    // Clear form
    document.getElementById('loginForm').reset();
    // Hide messages
    document.getElementById('loginErrors').classList.add('hidden');
    document.getElementById('loginSuccess').classList.add('hidden');
}

function switchToSignup() {
    closeLoginModal();
    setTimeout(() => {
        openSignupModal();
    }, 100);
}

// Close modal when clicking outside
document.getElementById('loginModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeLoginModal();
    }
});

// Handle form submission
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    if (!loginForm) return;
    
    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        console.log('Login form submitted');
        
        const submitBtn = document.getElementById('loginSubmitBtn');
        const btnText = document.getElementById('loginBtnText');
        const btnLoading = document.getElementById('loginBtnLoading');
        const errorsDiv = document.getElementById('loginErrors');
        const successDiv = document.getElementById('loginSuccess');
        
        // Show loading state
        submitBtn.disabled = true;
        btnText.classList.add('hidden');
        btnLoading.classList.remove('hidden');
        
        // Hide previous messages
        errorsDiv.classList.add('hidden');
        successDiv.classList.add('hidden');
        
        try {
            const formData = new FormData(this);
            console.log('Sending login request...');
            
            const response = await fetch('{{ route("ajax.login") }}', {
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
                // Success - redirect to intended page or dashboard
                console.log('Login successful, redirecting...');
                if (data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    window.location.href = '{{ route("dashboard") }}';
                }
            } else {
                // Handle validation errors
                if (data.errors) {
                    const errorsList = document.querySelector('#loginErrorsList ul');
                    errorsList.innerHTML = '';
                    
                    Object.values(data.errors).flat().forEach(error => {
                        const li = document.createElement('li');
                        li.textContent = error;
                        errorsList.appendChild(li);
                    });
                    
                    errorsDiv.classList.remove('hidden');
                } else if (data.message) {
                    const errorsList = document.querySelector('#loginErrorsList ul');
                    errorsList.innerHTML = `<li>${data.message}</li>`;
                    errorsDiv.classList.remove('hidden');
                }
            }
        } catch (error) {
            console.error('Login error:', error);
            // Show generic error
            const errorsList = document.querySelector('#loginErrorsList ul');
            errorsList.innerHTML = '<li>An error occurred. Please try again.</li>';
            errorsDiv.classList.remove('hidden');
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
    if (e.key === 'Escape' && !document.getElementById('loginModal').classList.contains('hidden')) {
        closeLoginModal();
    }
});
</script>