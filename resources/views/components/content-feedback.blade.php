@props(['content'])

<div class="mb-16">
    <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-3xl p-8 border border-purple-200/50 dark:border-purple-800/50 shadow-lg">
        <div class="text-center mb-8">
            <h3 class="text-2xl md:text-3xl font-bold text-[#111816] dark:text-white mb-2">
                Your Feedback Matters
            </h3>
            <p class="text-[#61897c] dark:text-gray-400 max-w-2xl mx-auto">
                Help us improve our content and support the community by sharing your thoughts.
            </p>
        </div>
        
        <div class="max-w-4xl mx-auto">
            <!-- Rating Overview -->
            <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-6 shadow-sm border border-[#f0f4f3] dark:border-gray-800 mb-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Overall Rating -->
                    <div class="text-center">
                        <div class="mb-4">
                            <div class="text-4xl font-bold text-[#111816] dark:text-white mb-2" id="average-rating">
                                {{ $content->formatted_average_rating }}
                            </div>
                            <div class="flex items-center justify-center gap-1 mb-2" id="rating-stars">
                                @php
                                    $rating = $content->average_rating;
                                    $fullStars = floor($rating);
                                    $hasHalfStar = ($rating - $fullStars) >= 0.5;
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $fullStars)
                                        <span class="material-symbols-outlined !text-2xl text-yellow-400">star</span>
                                    @elseif($i == $fullStars + 1 && $hasHalfStar)
                                        <span class="material-symbols-outlined !text-2xl text-yellow-400">star_half</span>
                                    @else
                                        <span class="material-symbols-outlined !text-2xl text-gray-300 dark:text-gray-600">star</span>
                                    @endif
                                @endfor
                            </div>
                            <p class="text-sm text-[#61897c] dark:text-gray-400" id="total-reviews">
                                Based on {{ $content->total_reviews }} {{ Str::plural('review', $content->total_reviews) }}
                            </p>
                        </div>
                        
                        <!-- Helpful Percentage -->
                        <div class="bg-green-50 dark:bg-green-900/30 rounded-xl p-4">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400" id="helpful-percentage">
                                {{ $content->helpful_percentage }}%
                            </div>
                            <p class="text-sm text-green-700 dark:text-green-300">found this helpful</p>
                        </div>
                    </div>
                    
                    <!-- Rating Distribution -->
                    <div class="space-y-2">
                        <h4 class="font-semibold text-[#111816] dark:text-white mb-3">Rating Breakdown</h4>
                        @foreach(array_reverse($content->rating_distribution, true) as $rating => $data)
                        <div class="flex items-center gap-3" data-rating="{{ $rating }}">
                            <span class="text-sm font-medium text-[#111816] dark:text-white w-8">{{ $rating }}★</span>
                            <div class="flex-1 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-yellow-400 h-2 rounded-full transition-all duration-500" 
                                     style="width: {{ $data['percentage'] }}%"></div>
                            </div>
                            <span class="text-sm text-[#61897c] dark:text-gray-400 w-12">{{ $data['count'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @auth
                <!-- User Review Section -->
                <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-6 shadow-sm border border-[#f0f4f3] dark:border-gray-800 mb-6">
                    @php
                        $userReview = $content->getReviewBy(auth()->id());
                    @endphp
                    
                    @if($userReview)
                        <!-- Edit Existing Review -->
                        <div id="existing-review">
                            <h4 class="text-lg font-bold text-[#111816] dark:text-white mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">edit</span>
                                Your Review
                            </h4>
                            
                            <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4 mb-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="flex items-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="material-symbols-outlined !text-lg {{ $i <= $userReview->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}">star</span>
                                        @endfor
                                    </div>
                                    <span class="text-sm text-[#61897c] dark:text-gray-400">{{ $userReview->time_ago }}</span>
                                </div>
                                @if($userReview->has_review_text)
                                    <p class="text-[#111816] dark:text-white">{{ $userReview->review }}</p>
                                @endif
                                @if($userReview->is_helpful !== null)
                                    <div class="mt-2">
                                        <span class="inline-flex items-center gap-1 text-sm {{ $userReview->is_helpful ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            <span class="material-symbols-outlined !text-base">{{ $userReview->is_helpful ? 'thumb_up' : 'thumb_down' }}</span>
                                            {{ $userReview->is_helpful ? 'Helpful' : 'Not Helpful' }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex gap-3">
                                <button onclick="editReview()" class="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors text-sm font-medium">
                                    <span class="material-symbols-outlined !text-base">edit</span>
                                    Edit Review
                                </button>
                                <button onclick="deleteReview({{ $userReview->id }})" class="flex items-center gap-2 px-4 py-2 bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/50 transition-colors text-sm font-medium">
                                    <span class="material-symbols-outlined !text-base">delete</span>
                                    Delete
                                </button>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Review Form -->
                    <div id="review-form" class="{{ $userReview ? 'hidden' : '' }}">
                        <h4 class="text-lg font-bold text-[#111816] dark:text-white mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">rate_review</span>
                            {{ $userReview ? 'Edit Your Review' : 'Write a Review' }}
                        </h4>
                        
                        <form id="reviewForm" class="space-y-4">
                            @csrf
                            
                            <!-- Star Rating -->
                            <div>
                                <label class="block text-sm font-semibold text-[#111816] dark:text-white mb-2">
                                    Rating *
                                </label>
                                <div class="flex items-center gap-1" id="star-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <button type="button" 
                                                class="star-btn text-3xl text-gray-300 dark:text-gray-600 hover:text-yellow-400 transition-colors" 
                                                data-rating="{{ $i }}"
                                                onclick="setRating({{ $i }})">
                                            <span class="material-symbols-outlined !text-3xl">star</span>
                                        </button>
                                    @endfor
                                </div>
                                <input type="hidden" id="rating-input" name="rating" value="{{ $userReview->rating ?? '' }}" required>
                            </div>
                            
                            <!-- Written Review -->
                            <div>
                                <label for="review-text" class="block text-sm font-semibold text-[#111816] dark:text-white mb-2">
                                    Your Review (Optional)
                                </label>
                                <textarea id="review-text" 
                                          name="review" 
                                          rows="4" 
                                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary bg-white dark:bg-gray-800 text-[#111816] dark:text-white resize-none"
                                          placeholder="Share your thoughts about this content... What did you find helpful? How could it be improved?">{{ $userReview->review ?? '' }}</textarea>
                                <p class="text-xs text-[#61897c] dark:text-gray-400 mt-1">Maximum 1000 characters</p>
                            </div>
                            
                            <!-- Helpful Toggle -->
                            <div>
                                <label class="block text-sm font-semibold text-[#111816] dark:text-white mb-2">
                                    Was this content helpful?
                                </label>
                                <div class="flex gap-3">
                                    <button type="button" 
                                            class="helpful-btn flex items-center gap-2 px-4 py-2 rounded-lg border-2 transition-all {{ ($userReview && $userReview->is_helpful === true) ? 'bg-green-50 dark:bg-green-900/30 border-green-500 text-green-600 dark:text-green-400' : 'border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:border-green-500 hover:text-green-600' }}"
                                            data-helpful="true"
                                            onclick="setHelpful(true)">
                                        <span class="material-symbols-outlined !text-base">thumb_up</span>
                                        Yes, helpful
                                    </button>
                                    <button type="button" 
                                            class="helpful-btn flex items-center gap-2 px-4 py-2 rounded-lg border-2 transition-all {{ ($userReview && $userReview->is_helpful === false) ? 'bg-red-50 dark:bg-red-900/30 border-red-500 text-red-600 dark:text-red-400' : 'border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400 hover:border-red-500 hover:text-red-600' }}"
                                            data-helpful="false"
                                            onclick="setHelpful(false)">
                                        <span class="material-symbols-outlined !text-base">thumb_down</span>
                                        Not helpful
                                    </button>
                                </div>
                                <input type="hidden" id="helpful-input" name="is_helpful" value="{{ $userReview && $userReview->is_helpful !== null ? ($userReview->is_helpful ? 'true' : 'false') : '' }}">
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="flex gap-3 pt-4">
                                <button type="submit" 
                                        class="flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-semibold hover:bg-primary/90 transition-all duration-200 transform hover:scale-105 shadow-sm">
                                    <span class="material-symbols-outlined !text-base">send</span>
                                    {{ $userReview ? 'Update Review' : 'Submit Review' }}
                                </button>
                                
                                @if($userReview)
                                    <button type="button" 
                                            onclick="cancelEdit()"
                                            class="flex items-center gap-2 px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                        <span class="material-symbols-outlined !text-base">cancel</span>
                                        Cancel
                                    </button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <!-- Login Prompt -->
                <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-6 shadow-sm border border-[#f0f4f3] dark:border-gray-800 mb-6 text-center">
                    <div class="mb-4">
                        <span class="material-symbols-outlined text-primary !text-4xl mb-2 block">login</span>
                        <h4 class="text-lg font-bold text-[#111816] dark:text-white mb-2">Share Your Experience</h4>
                        <p class="text-[#61897c] dark:text-gray-400 mb-4">
                            Join our community to rate and review content, helping others discover valuable resources.
                        </p>
                    </div>
                    <button onclick="openLoginModal()" 
                            class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white rounded-xl font-semibold hover:bg-primary/90 transition-all duration-200 transform hover:scale-105 shadow-sm">
                        <span class="material-symbols-outlined !text-lg">login</span>
                        Login to Review
                    </button>
                </div>
            @endauth

            <!-- Reviews List -->
            <div class="bg-white dark:bg-gray-800/50 rounded-2xl p-6 shadow-sm border border-[#f0f4f3] dark:border-gray-800">
                <div class="flex items-center justify-between mb-6">
                    <h4 class="text-lg font-bold text-[#111816] dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">reviews</span>
                        Community Reviews
                    </h4>
                    <div class="flex items-center gap-2">
                        <select id="review-sort" class="text-sm border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-1 bg-white dark:bg-gray-800 text-[#111816] dark:text-white">
                            <option value="newest">Newest First</option>
                            <option value="oldest">Oldest First</option>
                            <option value="highest">Highest Rated</option>
                            <option value="lowest">Lowest Rated</option>
                        </select>
                    </div>
                </div>
                
                <div id="reviews-container">
                    <!-- Reviews will be loaded here -->
                    <div class="text-center py-8">
                        <div class="animate-spin w-8 h-8 border-4 border-primary border-t-transparent rounded-full mx-auto mb-4"></div>
                        <p class="text-[#61897c] dark:text-gray-400">Loading reviews...</p>
                    </div>
                </div>
                
                <!-- Load More Button -->
                <div id="load-more-container" class="text-center mt-6 hidden">
                    <button id="load-more-btn" 
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded-xl font-semibold hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        <span class="material-symbols-outlined !text-base">expand_more</span>
                        Load More Reviews
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
@php
    $userReview = auth()->check() ? $content->getReviewBy(auth()->id()) : null;
@endphp
// Global variables for rating and helpful state
let currentRating = {{ $userReview->rating ?? 0 }};
let currentHelpful = {{ $userReview && $userReview->is_helpful !== null ? ($userReview->is_helpful ? 'true' : 'false') : 'null' }};

// Global functions that need to be accessible from HTML attributes
window.setRating = function(rating) {
    currentRating = rating; // Update global variable
    const currentRatingInput = document.getElementById('rating-input');
    if (currentRatingInput) {
        currentRatingInput.value = rating;
    }
    
    const stars = document.querySelectorAll('.star-btn');
    stars.forEach((star, index) => {
        const starIcon = star.querySelector('.material-symbols-outlined');
        if (index < rating) {
            starIcon.classList.remove('text-gray-300', 'dark:text-gray-600');
            starIcon.classList.add('text-yellow-400');
        } else {
            starIcon.classList.remove('text-yellow-400');
            starIcon.classList.add('text-gray-300', 'dark:text-gray-600');
        }
    });
};

window.setHelpful = function(isHelpful) {
    currentHelpful = isHelpful ? 'true' : 'false'; // Store as string to match comparison
    const helpfulInput = document.getElementById('helpful-input');
    if (helpfulInput) {
        helpfulInput.value = isHelpful ? 'true' : 'false';
    }
    
    const buttons = document.querySelectorAll('.helpful-btn');
    buttons.forEach(btn => {
        const helpful = btn.getAttribute('data-helpful') === 'true';
        btn.classList.remove('bg-green-50', 'dark:bg-green-900/30', 'border-green-500', 'text-green-600', 'dark:text-green-400');
        btn.classList.remove('bg-red-50', 'dark:bg-red-900/30', 'border-red-500', 'text-red-600', 'dark:text-red-400');
        btn.classList.add('border-gray-300', 'dark:border-gray-600', 'text-gray-600', 'dark:text-gray-400');
        
        if (helpful === isHelpful) {
            if (isHelpful) {
                btn.classList.remove('border-gray-300', 'dark:border-gray-600', 'text-gray-600', 'dark:text-gray-400');
                btn.classList.add('bg-green-50', 'dark:bg-green-900/30', 'border-green-500', 'text-green-600', 'dark:text-green-400');
            } else {
                btn.classList.remove('border-gray-300', 'dark:border-gray-600', 'text-gray-600', 'dark:text-gray-400');
                btn.classList.add('bg-red-50', 'dark:bg-red-900/30', 'border-red-500', 'text-red-600', 'dark:text-red-400');
            }
        }
    });
};

window.editReview = function() {
    const existingReview = document.getElementById('existing-review');
    const reviewForm = document.getElementById('review-form');
    if (existingReview) existingReview.classList.add('hidden');
    if (reviewForm) reviewForm.classList.remove('hidden');
};

window.cancelEdit = function() {
    const existingReview = document.getElementById('existing-review');
    const reviewForm = document.getElementById('review-form');
    if (existingReview) existingReview.classList.remove('hidden');
    if (reviewForm) reviewForm.classList.add('hidden');
};

window.deleteReview = function(reviewId) {
    if (!confirm('Are you sure you want to delete your review?')) {
        return;
    }
    
    fetch(`/content/reviews/${reviewId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast(data.message, 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showToast(data.message || 'An error occurred', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Network error. Please try again.', 'error');
    });
};

// Toast notification function
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `fixed top-20 right-4 z-50 px-6 py-3 rounded-xl shadow-lg transform translate-x-full transition-transform duration-300 ${
        type === 'success' ? 'bg-green-500 text-white' : 
        type === 'error' ? 'bg-red-500 text-white' : 
        'bg-primary text-white'
    }`;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    // Slide in
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);
    
    // Slide out and remove
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            if (document.body.contains(toast)) {
                document.body.removeChild(toast);
            }
        }, 300);
    }, 3000);
}

document.addEventListener('DOMContentLoaded', function() {
    let reviewsPage = 1;
    let reviewsLoading = false;
    
    // Initialize rating display
    if (currentRating > 0) {
        setRating(currentRating);
    }
    
    // Initialize helpful display
    if (currentHelpful !== 'null' && currentHelpful !== null) {
        setHelpful(currentHelpful === 'true');
    }
    
    // Load initial reviews
    loadReviews();
    
    // Form submission
    document.getElementById('reviewForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (currentRating === 0) {
            showToast('Please select a rating', 'error');
            return;
        }
        
        const formData = new FormData(this);
        const isUpdate = {{ $userReview ? 'true' : 'false' }};
        const url = isUpdate 
            ? `/content/reviews/{{ $userReview->id ?? '' }}`
            : `/content/{{ $content->id }}/reviews`;
        const method = isUpdate ? 'PUT' : 'POST';
        
        // Debug logging
        console.log('Form submission:', {
            isUpdate,
            url,
            method,
            currentRating,
            currentHelpful,
            currentHelpfulType: typeof currentHelpful,
            reviewText: formData.get('review'),
            finalIsHelpful: currentHelpful === 'true' ? true : (currentHelpful === 'false' ? false : null)
        });
        
        // Show loading state
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<span class="material-symbols-outlined animate-spin !text-base">refresh</span> Submitting...';
        submitBtn.disabled = true;
        
        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                rating: currentRating,
                review: formData.get('review'),
                is_helpful: currentHelpful === 'true' ? true : (currentHelpful === 'false' ? false : null)
            })
        })
        .then(response => {
            console.log('Response status:', response.status);
            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);
            if (data.success) {
                showToast(data.message, 'success');
                
                // Update the UI immediately with the returned stats
                if (data.stats) {
                    updateReviewStats(data.stats);
                }
                
                // Update the existing review display if it's an update
                if (isUpdate) {
                    updateExistingReviewDisplay(data.review);
                    cancelEdit();
                } else {
                    // For new reviews, reload to show the new review in the list
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            } else {
                showToast(data.message || 'An error occurred', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Network error. Please try again.', 'error');
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });
    
    // Load reviews function
    function loadReviews(page = 1, sort = 'newest') {
        if (reviewsLoading) return;
        reviewsLoading = true;
        
        console.log('Loading reviews for content ID:', {{ $content->id }});
        
        fetch(`/content/{{ $content->id }}/reviews?page=${page}&sort=${sort}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    return response.text().then(text => {
                        console.error('Response text:', text);
                        throw new Error(`HTTP ${response.status}: ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                console.log('Reviews data received:', data);
                const container = document.getElementById('reviews-container');
                
                if (page === 1) {
                    container.innerHTML = '';
                }
                
                if (data.success) {
                    if (data.reviews.data.length === 0 && page === 1) {
                        container.innerHTML = `
                            <div class="text-center py-8">
                                <span class="material-symbols-outlined text-gray-400 !text-4xl mb-4 block">rate_review</span>
                                <h5 class="text-lg font-semibold text-[#111816] dark:text-white mb-2">No Reviews Yet</h5>
                                <p class="text-[#61897c] dark:text-gray-400">Be the first to share your thoughts about this content!</p>
                            </div>
                        `;
                    } else {
                        data.reviews.data.forEach(review => {
                            container.appendChild(createReviewElement(review));
                        });
                        
                        // Show/hide load more button
                        const loadMoreContainer = document.getElementById('load-more-container');
                        if (data.reviews.next_page_url) {
                            loadMoreContainer.classList.remove('hidden');
                        } else {
                            loadMoreContainer.classList.add('hidden');
                        }
                    }
                    
                    // Update stats
                    updateReviewStats(data.stats);
                } else {
                    throw new Error(data.message || 'Failed to load reviews');
                }
            })
            .catch(error => {
                console.error('Error loading reviews:', error);
                document.getElementById('reviews-container').innerHTML = `
                    <div class="text-center py-8">
                        <span class="material-symbols-outlined text-red-400 !text-4xl mb-4 block">error</span>
                        <p class="text-red-600 dark:text-red-400">Failed to load reviews: ${error.message}</p>
                        <button onclick="loadReviews(1, 'newest')" class="mt-3 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors">
                            Retry
                        </button>
                    </div>
                `;
            })
            .finally(() => {
                reviewsLoading = false;
            });
    }
    
    // Create review element
    function createReviewElement(review) {
        const div = document.createElement('div');
        div.className = 'border-b border-gray-200 dark:border-gray-700 pb-6 mb-6 last:border-b-0 last:pb-0 last:mb-0';
        
        const stars = Array.from({length: 5}, (_, i) => 
            `<span class="material-symbols-outlined !text-base ${i < review.rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'}">star</span>`
        ).join('');
        
        div.innerHTML = `
            <div class="flex items-start gap-4">
                <img src="${review.user.profile_photo_url || '/images/default-avatar.png'}" 
                     alt="${review.user.name}" 
                     class="w-10 h-10 rounded-full border-2 border-primary/20 flex-shrink-0">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h5 class="font-semibold text-[#111816] dark:text-white">${review.user.name}</h5>
                        <div class="flex items-center gap-1">${stars}</div>
                        <span class="text-xs text-[#61897c] dark:text-gray-400">${review.time_ago}</span>
                    </div>
                    ${review.review ? `<p class="text-[#111816] dark:text-white mb-3 leading-relaxed">${review.review}</p>` : ''}
                    ${review.is_helpful !== null ? `
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined !text-base ${review.is_helpful ? 'text-green-600' : 'text-red-600'}">
                                ${review.is_helpful ? 'thumb_up' : 'thumb_down'}
                            </span>
                            <span class="text-sm ${review.is_helpful ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}">
                                ${review.is_helpful ? 'Found this helpful' : 'Did not find this helpful'}
                            </span>
                        </div>
                    ` : ''}
                </div>
            </div>
        `;
        
        return div;
    }
    
    // Update review stats
    function updateReviewStats(stats) {
        console.log('Updating stats:', stats);
        
        // Update average rating
        const avgRatingEl = document.getElementById('average-rating');
        if (avgRatingEl) {
            avgRatingEl.textContent = stats.average_rating;
        }
        
        // Update total reviews
        const totalReviewsEl = document.getElementById('total-reviews');
        if (totalReviewsEl) {
            totalReviewsEl.textContent = `Based on ${stats.total_reviews} ${stats.total_reviews === 1 ? 'review' : 'reviews'}`;
        }
        
        // Update helpful percentage
        const helpfulPercentageEl = document.getElementById('helpful-percentage');
        if (helpfulPercentageEl) {
            helpfulPercentageEl.textContent = `${stats.helpful_percentage}%`;
        }
        
        // Update star display
        const starsContainer = document.getElementById('rating-stars');
        if (starsContainer) {
            const avgRating = parseFloat(stats.average_rating);
            const fullStars = Math.floor(avgRating);
            const hasHalfStar = (avgRating - fullStars) >= 0.5;
            
            starsContainer.innerHTML = Array.from({length: 5}, (_, i) => {
                const starIndex = i + 1;
                if (starIndex <= fullStars) {
                    return `<span class="material-symbols-outlined !text-2xl text-yellow-400">star</span>`;
                } else if (starIndex === fullStars + 1 && hasHalfStar) {
                    return `<span class="material-symbols-outlined !text-2xl text-yellow-400">star_half</span>`;
                } else {
                    return `<span class="material-symbols-outlined !text-2xl text-gray-300 dark:text-gray-600">star</span>`;
                }
            }).join('');
        }
        
        // Update rating distribution if available
        if (stats.rating_distribution) {
            Object.keys(stats.rating_distribution).forEach(rating => {
                const data = stats.rating_distribution[rating];
                const barEl = document.querySelector(`[data-rating="${rating}"] .bg-yellow-400`);
                if (barEl) {
                    barEl.style.width = `${data.percentage}%`;
                }
                const countEl = document.querySelector(`[data-rating="${rating}"] .text-sm:last-child`);
                if (countEl) {
                    countEl.textContent = data.count;
                }
            });
        }
    }
    
    // Update existing review display
    function updateExistingReviewDisplay(review) {
        console.log('Updating existing review display:', review);
        
        // Update the review display in the existing review section
        const existingReview = document.getElementById('existing-review');
        if (existingReview) {
            // Update rating stars
            const stars = existingReview.querySelectorAll('.material-symbols-outlined');
            stars.forEach((star, index) => {
                if (index < review.rating) {
                    star.classList.remove('text-gray-300', 'dark:text-gray-600');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300', 'dark:text-gray-600');
                }
            });
            
            // Update review text
            const reviewTextEl = existingReview.querySelector('p');
            if (reviewTextEl) {
                if (review.review && review.review.trim()) {
                    reviewTextEl.textContent = review.review;
                    reviewTextEl.style.display = 'block';
                } else {
                    reviewTextEl.style.display = 'none';
                }
            }
            
            // Update helpful status
            const helpfulEl = existingReview.querySelector('.inline-flex');
            if (helpfulEl && review.is_helpful !== null) {
                const isHelpful = review.is_helpful;
                helpfulEl.className = `inline-flex items-center gap-1 text-sm ${isHelpful ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'}`;
                helpfulEl.innerHTML = `
                    <span class="material-symbols-outlined !text-base">${isHelpful ? 'thumb_up' : 'thumb_down'}</span>
                    ${isHelpful ? 'Helpful' : 'Not Helpful'}
                `;
                helpfulEl.style.display = 'flex';
            } else if (helpfulEl) {
                helpfulEl.style.display = 'none';
            }
            
            // Update timestamp - find the span with time ago text
            const timeElements = existingReview.querySelectorAll('span');
            timeElements.forEach(el => {
                if (el.textContent.includes('ago') || el.textContent.includes('minute') || el.textContent.includes('hour') || el.textContent.includes('day')) {
                    el.textContent = 'just now';
                }
            });
        }
    }
    
    // Sort change handler
    document.getElementById('review-sort').addEventListener('change', function() {
        reviewsPage = 1;
        loadReviews(1, this.value);
    });
    
    // Load more button
    document.getElementById('load-more-btn').addEventListener('click', function() {
        reviewsPage++;
        const sort = document.getElementById('review-sort').value;
        loadReviews(reviewsPage, sort);
    });
});
</script>
@endpush