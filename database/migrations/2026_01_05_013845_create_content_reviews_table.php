<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('educational_content_id')->constrained()->onDelete('cascade');
            $table->integer('rating')->unsigned()->comment('1-5 star rating');
            $table->text('review')->nullable()->comment('Written review text');
            $table->boolean('is_helpful')->nullable()->comment('Whether user found content helpful');
            $table->json('feedback_data')->nullable()->comment('Additional structured feedback');
            $table->boolean('is_approved')->default(true)->comment('Admin approval status');
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            // Ensure one review per user per content
            $table->unique(['user_id', 'educational_content_id']);
            
            // Indexes for performance
            $table->index(['educational_content_id', 'is_approved']);
            $table->index(['rating', 'is_approved']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_reviews');
    }
}
