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
        Schema::create('forum_upvotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('votable_type'); // ForumPost or ForumComment
            $table->unsignedBigInteger('votable_id');
            $table->timestamps();
            
            $table->unique(['user_id', 'votable_type', 'votable_id']);
            $table->index(['votable_type', 'votable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forum_upvotes');
    }
};
