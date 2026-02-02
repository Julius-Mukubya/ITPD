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
        Schema::create('session_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('counseling_session_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Who gave the feedback
            $table->enum('feedback_type', ['student_to_counselor', 'counselor_to_student']);
            $table->integer('rating')->nullable(); // 1-5 star rating (optional)
            $table->text('feedback_text'); // The actual feedback
            $table->boolean('is_anonymous')->default(false);
            $table->timestamps();

            // Ensure one feedback per user per session per type
            $table->unique(['counseling_session_id', 'user_id', 'feedback_type'], 'session_feedback_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_feedback');
    }
};