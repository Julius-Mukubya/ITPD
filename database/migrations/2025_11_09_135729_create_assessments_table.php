<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssessmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // AUDIT or DUDIT
            $table->string('full_name'); // Alcohol Use Disorders Identification Test
            $table->text('description');
            $table->enum('type', ['audit', 'dudit', 'phq9', 'gad7', 'dass21', 'pss', 'cage'])->unique();
            $table->json('scoring_guidelines'); // JSON with risk level thresholds
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessments');
    }
}
