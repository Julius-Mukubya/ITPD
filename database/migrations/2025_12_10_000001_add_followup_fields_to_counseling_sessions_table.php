<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFollowupFieldsToCounselingSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('counseling_sessions', function (Blueprint $table) {
            // Track if student wants follow-up sessions
            $table->boolean('wants_followup')->default(false)->after('is_anonymous');
            
            // Link to parent session if this is a follow-up
            $table->foreignId('parent_session_id')->nullable()->after('counselor_id')->constrained('counseling_sessions')->onDelete('set null');
            
            // Track session type (initial or follow-up)
            $table->enum('session_type', ['individual', 'group', 'crisis', 'academic'])->default('individual')->after('priority');
            
            // Index for better query performance
            $table->index('parent_session_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('counseling_sessions', function (Blueprint $table) {
            $table->dropForeign(['parent_session_id']);
            $table->dropIndex(['parent_session_id']);
            $table->dropColumn(['wants_followup', 'parent_session_id', 'session_type']);
        });
    }
}
