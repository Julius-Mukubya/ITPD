<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('counseling_sessions')->onDelete('cascade');
            $table->foreignId('counselor_id')->constrained('users')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('content');
            $table->enum('type', ['progress', 'observation', 'reminder', 'general'])->default('general');
            $table->boolean('is_private')->default(true); // Private notes only visible to counselors
            $table->timestamps();
            
            $table->index(['session_id', 'created_at']);
            $table->index('counselor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('session_notes');
    }
}
