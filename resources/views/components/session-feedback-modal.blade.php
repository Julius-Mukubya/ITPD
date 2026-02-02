<!-- Session Feedback Modal -->
<div id="feedbackModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-lg w-full max-h-[90vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-symbols-outlined text-emerald-600">rate_review</span>
                Session Feedback
            </h3>
            <button onclick="closeFeedbackModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors p-1 hover:bg-gray-100 dark:hover:bg-gray-700 rounded">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Content -->
        <form id="feedbackForm" method="POST" class="p-6">
            @csrf
            <input type="hidden" id="feedback_session_id" name="session_id">
            
            <div class="mb-6">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                    Your feedback helps improve the counseling experience and will be shared with the other party to foster better communication and support.
                </p>
                
                <!-- Rating Section -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                        Overall Experience (Optional)
                    </label>
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-1" id="starRating">
                            <button type="button" class="star-btn text-2xl text-gray-300 hover:text-yellow-400 transition-colors" data-rating="1">★</button>
                            <button type="button" class="star-btn text-2xl text-gray-300 hover:text-yellow-400 transition-colors" data-rating="2">★</button>
                            <button type="button" class="star-btn text-2xl text-gray-300 hover:text-yellow-400 transition-colors" data-rating="3">★</button>
                            <button type="button" class="star-btn text-2xl text-gray-300 hover:text-yellow-400 transition-colors" data-rating="4">★</button>
                            <button type="button" class="star-btn text-2xl text-gray-300 hover:text-yellow-400 transition-colors" data-rating="5">★</button>
                        </div>
                        <span id="ratingText" class="text-sm text-gray-500 dark:text-gray-400 ml-2"></span>
                    </div>
                    <input type="hidden" name="rating" id="selectedRating">
                </div>
                
                <!-- Feedback Text -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Your Feedback <span class="text-red-500">*</span>
                    </label>
                    <textarea name="feedback_text" id="feedbackText" rows="5" required maxlength="1000" 
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white resize-none"
                        placeholder="Share your thoughts about the session, what went well, areas for improvement, or any other feedback..."></textarea>
                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex justify-between">
                        <span>Minimum 10 characters</span>
                        <span><span id="charCount">0</span>/1000</span>
                    </div>
                </div>

                <!-- Anonymous Option -->
                <div class="mb-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="is_anonymous" id="isAnonymous" 
                            class="w-4 h-4 text-emerald-600 bg-gray-100 border-gray-300 rounded focus:ring-emerald-500 dark:focus:ring-emerald-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        <div>
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Submit anonymously</span>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Your name will not be shown with this feedback</p>
                        </div>
                    </label>
                </div>

                <!-- Important Note -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h4 class="text-blue-800 dark:text-blue-200 font-semibold text-sm mb-1">Feedback Sharing</h4>
                            <p class="text-blue-700 dark:text-blue-300 text-xs">
                                This feedback will be visible to both you and the other party involved in the session to promote transparency and continuous improvement.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeFeedbackModal()" 
                    class="px-6 py-3 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl font-semibold transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                    class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white hover:from-emerald-600 hover:to-teal-700 rounded-xl font-semibold transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">send</span>
                    Submit Feedback
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let currentRating = 0;

function openFeedbackModal(sessionId) {
    document.getElementById('feedback_session_id').value = sessionId;
    document.getElementById('feedbackForm').action = `/sessions/${sessionId}/feedback`;
    document.getElementById('feedbackModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    // Reset form
    resetFeedbackForm();
}

function closeFeedbackModal() {
    document.getElementById('feedbackModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    resetFeedbackForm();
}

function resetFeedbackForm() {
    document.getElementById('feedbackForm').reset();
    currentRating = 0;
    document.getElementById('selectedRating').value = '';
    updateStarDisplay();
    updateCharCount();
}

function updateStarDisplay() {
    const stars = document.querySelectorAll('.star-btn');
    const ratingText = document.getElementById('ratingText');
    
    stars.forEach((star, index) => {
        if (index < currentRating) {
            star.classList.remove('text-gray-300');
            star.classList.add('text-yellow-400');
        } else {
            star.classList.remove('text-yellow-400');
            star.classList.add('text-gray-300');
        }
    });
    
    const ratingLabels = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
    ratingText.textContent = currentRating > 0 ? ratingLabels[currentRating] : '';
}

function updateCharCount() {
    const textarea = document.getElementById('feedbackText');
    const charCount = document.getElementById('charCount');
    charCount.textContent = textarea.value.length;
}

// Star rating functionality
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-btn');
    
    stars.forEach((star, index) => {
        star.addEventListener('click', function(e) {
            e.preventDefault();
            currentRating = parseInt(this.dataset.rating);
            document.getElementById('selectedRating').value = currentRating;
            updateStarDisplay();
        });
        
        star.addEventListener('mouseenter', function() {
            const hoverRating = parseInt(this.dataset.rating);
            stars.forEach((s, i) => {
                if (i < hoverRating) {
                    s.classList.remove('text-gray-300');
                    s.classList.add('text-yellow-400');
                } else {
                    s.classList.remove('text-yellow-400');
                    s.classList.add('text-gray-300');
                }
            });
        });
    });
    
    document.getElementById('starRating').addEventListener('mouseleave', function() {
        updateStarDisplay();
    });
    
    // Character counter
    document.getElementById('feedbackText').addEventListener('input', updateCharCount);
});

// Close modal when clicking outside
document.getElementById('feedbackModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeFeedbackModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !document.getElementById('feedbackModal').classList.contains('hidden')) {
        closeFeedbackModal();
    }
});
</script>