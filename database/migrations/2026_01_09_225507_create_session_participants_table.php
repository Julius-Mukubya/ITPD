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
        Schema::create('session_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('counseling_session_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->enum('status', ['invited', 'joined', 'declined'])->default('invited');
            $table->string('invitation_token')->unique()->nullable();
            $table->timestamp('invited_at')->nullable();
            $table->timestamp('joined_at')->nullable();
            $table->timestamps();
            
            $table->index(['counseling_session_id', 'status']);
            $table->unique(['counseling_session_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_participants');
    }
};