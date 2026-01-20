<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('assessment_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->integer('total_score');
            $table->enum('risk_level', ['low', 'medium', 'high']);
            $table->text('recommendation')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->timestamp('taken_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'assessment_id', 'taken_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessment_attempts');
    }
}
