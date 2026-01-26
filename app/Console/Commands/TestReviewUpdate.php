<?php

namespace App\Console\Commands;

use App\Models\ContentReview;
use App\Models\EducationalContent;
use Illuminate\Console\Command;

class TestReviewUpdate extends Command
{
    protected $signature = 'test:review-update {content_id} {review_id} {new_rating}';
    protected $description = 'Test review update and rating calculation';

    public function handle()
    {
        $contentId = $this->argument('content_id');
        $reviewId = $this->argument('review_id');
        $newRating = $this->argument('new_rating');

        $this->info("Testing review update for content ID: {$contentId}");

        // Get the content and review
        $content = EducationalContent::find($contentId);
        $review = ContentReview::find($reviewId);

        if (!$content || !$review) {
            $this->error('Content or review not found');
            return;
        }

        // Show current stats
        $this->info("Before update:");
        $this->info("- Average rating: {$content->formatted_average_rating}");
        $this->info("- Total reviews: {$content->total_reviews}");
        $this->info("- Review rating: {$review->rating}");

        // Update the review
        $oldRating = $review->rating;
        $review->update(['rating' => $newRating]);

        // Clear cache and refresh
        $content->clearReviewCache();
        $content->refresh();

        // Show updated stats
        $this->info("\nAfter update:");
        $this->info("- Average rating: {$content->fresh()->formatted_average_rating}");
        $this->info("- Total reviews: {$content->fresh()->total_reviews}");
        $this->info("- Review rating: {$review->fresh()->rating}");

        // Direct database check
        $directAvg = ContentReview::where('educational_content_id', $contentId)
            ->where('is_approved', true)
            ->avg('rating');
        $this->info("- Direct DB average: " . number_format($directAvg, 1));

        // Revert the change
        $review->update(['rating' => $oldRating]);
        $this->info("\nReverted review rating back to: {$oldRating}");
    }
}