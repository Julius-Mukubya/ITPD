<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('content_flags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('flaggable_type'); // App\Models\ForumPost, App\Models\ForumComment, etc.
            $table->unsignedBigInteger('flaggable_id');
            $table->enum('reason', [
                'inappropriate_content',
                'harassment',
                'spam',
                'misinformation',
                'hate_speech',
                'violence',
                'self_harm',
                'other'
            ]);
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'reviewed', 'dismissed', 'action_taken'])->default('pending');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('admin_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['flaggable_type', 'flaggable_id']);
            $table->index(['status', 'created_at']);
            
            // Prevent duplicate flags from same user for same content
            $table->unique(['user_id', 'flaggable_type', 'flaggable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_flags');
    }
};