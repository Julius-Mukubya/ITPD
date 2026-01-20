<?php

namespace App\Http\Controllers;

use App\Models\ContentReview;
use App\Models\EducationalContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ContentReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }

    /**
     * Store a new review
     */
    public function store(Request $request, EducationalContent $content)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
            'is_helpful' => 'nullable|boolean'
        ]);

        // Check if user already reviewed this content
        $existingReview = ContentReview::where('user_id', Auth::id())
            ->where('educational_content_id', $content->id)
            ->first();

        if ($existingReview) {
            // Update existing review
            $existingReview->update([
                'rating' => $request->rating,
                'review' => $request->review,
                'is_helpful' => $request->is_helpful,
                'is_approved' => true, // Auto-approve for now
                'approved_at' => now()
            ]);

            // Get fresh content with updated stats
            $content = EducationalContent::find($existingReview->educational_content_id);
            $content->clearReviewCache(); // Clear any cached review data

            return response()->json([
                'success' => true,
                'message' => 'Your review has been updated successfully!',
                'review' => $existingReview->fresh()->load('user'),
                'stats' => [
                    'average_rating' => $content->formatted_average_rating,
                    'total_reviews' => $content->total_reviews,
                    'rating_distribution' => $content->rating_distribution,
                    'helpful_percentage' => $content->helpful_percentage
                ]
            ]);
        }

        // Create new review
        $review = ContentReview::create([
            'user_id' => Auth::id(),
            'educational_content_id' => $content->id,
            'rating' => $request->rating,
            'review' => $request->review,
            'is_helpful' => $request->is_helpful,
            'is_approved' => true, // Auto-approve for now
            'approved_at' => now()
        ]);

        // Refresh content to get updated stats
        $content = EducationalContent::find($content->id);
        $content->clearReviewCache(); // Clear any cached review data

        return response()->json([
            'success' => true,
            'message' => 'Thank you for your review!',
            'review' => $review->load('user'),
            'stats' => [
                'average_rating' => $content->formatted_average_rating,
                'total_reviews' => $content->total_reviews,
                'rating_distribution' => $content->rating_distribution,
                'helpful_percentage' => $content->helpful_percentage
            ]
        ]);
    }

    /**
     * Update an existing review
     */
    public function update(Request $request, ContentReview $review)
    {
        // Debug logging
        \Log::info('Review update attempt', [
            'review_id' => $review->id,
            'user_id' => Auth::id(),
            'review_user_id' => $review->user_id,
            'request_data' => $request->all()
        ]);

        // Ensure user can only update their own review
        if ($review->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
            'is_helpful' => 'nullable|boolean'
        ]);

        $oldData = $review->toArray();
        
        $review->update([
            'rating' => $request->rating,
            'review' => $request->review,
            'is_helpful' => $request->is_helpful
        ]);

        // Get fresh content with updated stats - force refresh from database
        $content = EducationalContent::find($review->educational_content_id);
        $content->clearReviewCache(); // Clear any cached review data

        \Log::info('Review updated', [
            'old_data' => $oldData,
            'new_data' => $review->fresh()->toArray(),
            'updated_stats' => [
                'average_rating' => $content->formatted_average_rating,
                'total_reviews' => $content->total_reviews,
                'helpful_percentage' => $content->helpful_percentage
            ]
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your review has been updated!',
            'review' => $review->fresh()->load('user'),
            'stats' => [
                'average_rating' => $content->formatted_average_rating,
                'total_reviews' => $content->total_reviews,
                'rating_distribution' => $content->rating_distribution,
                'helpful_percentage' => $content->helpful_percentage
            ]
        ]);
    }

    /**
     * Delete a review
     */
    public function destroy(ContentReview $review)
    {
        // Ensure user can only delete their own review
        if ($review->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Your review has been deleted.'
        ]);
    }

    /**
     * Get reviews for content
     */
    public function index(Request $request, EducationalContent $content)
    {
        $sort = $request->get('sort', 'newest');
        
        $query = $content->approvedReviews()->with('user');
        
        // Apply sorting
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'highest':
                $query->orderBy('rating', 'desc')->orderBy('created_at', 'desc');
                break;
            case 'lowest':
                $query->orderBy('rating', 'asc')->orderBy('created_at', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $reviews = $query->paginate(5);
        
        // Transform reviews for frontend
        $reviews->getCollection()->transform(function ($review) {
            return [
                'id' => $review->id,
                'rating' => $review->rating,
                'review' => $review->review,
                'is_helpful' => $review->is_helpful,
                'time_ago' => $review->time_ago,
                'user' => [
                    'name' => $review->user->name,
                    'profile_photo_url' => $review->user->profile_photo_url ?? asset('images/default-avatar.png')
                ]
            ];
        });

        return response()->json([
            'success' => true,
            'reviews' => $reviews,
            'stats' => [
                'average_rating' => $content->formatted_average_rating,
                'total_reviews' => $content->total_reviews,
                'rating_distribution' => $content->rating_distribution,
                'helpful_percentage' => $content->helpful_percentage
            ]
        ]);
    }

    /**
     * Quick feedback (helpful/not helpful)
     */
    public function quickFeedback(Request $request, EducationalContent $content)
    {
        $request->validate([
            'is_helpful' => 'required|boolean'
        ]);

        // Check if user already gave feedback
        $existingReview = ContentReview::where('user_id', Auth::id())
            ->where('educational_content_id', $content->id)
            ->first();

        if ($existingReview) {
            $existingReview->update(['is_helpful' => $request->is_helpful]);
            $message = 'Your feedback has been updated!';
        } else {
            ContentReview::create([
                'user_id' => Auth::id(),
                'educational_content_id' => $content->id,
                'rating' => 5, // Default rating for quick feedback
                'is_helpful' => $request->is_helpful,
                'is_approved' => true,
                'approved_at' => now()
            ]);
            $message = 'Thank you for your feedback!';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'helpful_percentage' => $content->fresh()->helpful_percentage
        ]);
    }
}