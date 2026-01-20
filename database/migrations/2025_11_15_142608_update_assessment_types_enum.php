<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateAssessmentTypesEnum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Modify the type enum to include new assessment types
        DB::statement("ALTER TABLE assessments MODIFY COLUMN type ENUM('audit', 'dudit', 'phq9', 'gad7', 'dass21', 'pss', 'cage') NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE assessments MODIFY COLUMN type ENUM('audit', 'dudit') NOT NULL");
    }
}
