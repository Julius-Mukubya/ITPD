<!-- Flag Content Modal -->
<div id="flagContentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Flag Content</h3>
            <button onclick="closeFlagModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors p-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Content -->
        <form id="flagContentForm" class="p-4">
            <input type="hidden" id="flaggable_type" name="flaggable_type">
            <input type="hidden" id="flaggable_id" name="flaggable_id">
            
            <div class="mb-4">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                    Help us maintain a safe and supportive community by reporting content that violates our guidelines.
                </p>
                
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Reason for flagging <span class="text-red-500">*</span>
                </label>
                <select name="reason" id="flag_reason" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white">
                    <option value="">Select a reason...</option>
                    <option value="inappropriate_content">Inappropriate Content</option>
                    <option value="harassment">Harassment or Bullying</option>
                    <option value="spam">Spam or Promotional Content</option>
                    <option value="misinformation">Misinformation</option>
                    <option value="hate_speech">Hate Speech</option>
                    <option value="violence">Violence or Threats</option>
                    <option value="self_harm">Self-Harm Content</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Additional details (optional)
                </label>
                <textarea name="description" id="flag_description" rows="3" maxlength="500" 
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-700 dark:text-white resize-none"
                    placeholder="Please provide any additional context that might help our review..."></textarea>
                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    <span id="description_count">0</span>/500 characters
                </div>
            </div>

            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3 mb-4">
                <div class="flex items-start">
                    <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <div>
                        <h4 class="text-yellow-800 dark:text-yellow-200 font-semibold text-xs mb-1">Important</h4>
                        <p class="text-yellow-700 dark:text-yellow-300 text-xs">
                            False reports may result in restrictions on your account. Only flag content that genuinely violates our community guidelines.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeFlagModal()" 
                    class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-lg transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                    class="px-4 py-2 bg-red-600 text-white hover:bg-red-700 rounded-lg transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                    </svg>
                    Submit Flag
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Wrap in IIFE to avoid duplicate declarations
(function() {
    // Only initialize once
    if (window.flagModalInitialized) {
        return;
    }
    window.flagModalInitialized = true;

    let currentFlaggableType = '';
    let currentFlaggableId = '';

    window.openFlagModal = function(type, id) {
        currentFlaggableType = type;
        currentFlaggableId = id;
        
        document.getElementById('flaggable_type').value = type;
        document.getElementById('flaggable_id').value = id;
        document.getElementById('flagContentModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    };

    window.closeFlagModal = function() {
        document.getElementById('flagContentModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
        
        // Reset form
        document.getElementById('flagContentForm').reset();
        document.getElementById('description_count').textContent = '0';
    };

    // Character counter for description
    const descriptionField = document.getElementById('flag_description');
    if (descriptionField) {
        descriptionField.addEventListener('input', function() {
            const count = this.value.length;
            document.getElementById('description_count').textContent = count;
        });
    }

    // Handle form submission
    const flagForm = document.getElementById('flagContentForm');
    if (flagForm) {
        flagForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            
            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<svg class="w-4 h-4 animate-spin mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Submitting...';
            
            fetch('/content-flags', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.closeFlagModal();
                    showToast(data.message, 'success');
                    
                    // Update flag button state
                    updateFlagButtonState(currentFlaggableType, currentFlaggableId, true);
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('An error occurred while submitting the flag.', 'error');
            })
            .finally(() => {
                // Reset button state
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
            });
        });
    }

    // Update flag button state
    function updateFlagButtonState(type, id, isFlagged) {
        const flagButton = document.querySelector(`[data-flag-type="${type}"][data-flag-id="${id}"]`);
        if (flagButton) {
            if (isFlagged) {
                flagButton.classList.add('text-red-600', 'dark:text-red-400');
                flagButton.classList.remove('text-gray-500', 'dark:text-gray-400');
                flagButton.title = 'Content flagged';
            } else {
                flagButton.classList.remove('text-red-600', 'dark:text-red-400');
                flagButton.classList.add('text-gray-500', 'dark:text-gray-400');
                flagButton.title = 'Flag content';
            }
        }
    }

    // Close modal when clicking outside
    const flagModal = document.getElementById('flagContentModal');
    if (flagModal) {
        flagModal.addEventListener('click', function(e) {
            if (e.target === this) {
                window.closeFlagModal();
            }
        });
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('flagContentModal');
        if (modal && e.key === 'Escape' && !modal.classList.contains('hidden')) {
            window.closeFlagModal();
        }
    });

    // Toast notification function
    function showToast(message, type = 'info') {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 translate-x-full ${
            type === 'success' ? 'bg-green-500 text-white' : 
            type === 'error' ? 'bg-red-500 text-white' : 
            'bg-blue-500 text-white'
        }`;
        toast.innerHTML = `
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${type === 'success' ? 
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>' :
                        type === 'error' ?
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>' :
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                    }
                </svg>
                <span class="text-sm">${message}</span>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Slide in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 5000);
        
        // Click to dismiss
        toast.addEventListener('click', () => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        });
    }
})();
</script>