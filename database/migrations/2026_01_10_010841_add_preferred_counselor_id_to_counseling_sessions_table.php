<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPreferredCounselorIdToCounselingSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('counseling_sessions', function (Blueprint $table) {
            // Add preferred_counselor_id to track which counselor the session was specifically requested to
            $table->foreignId('preferred_counselor_id')->nullable()->after('counselor_id')->constrained('users')->onDelete('set null');
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
            $table->dropForeign(['preferred_counselor_id']);
            $table->dropColumn('preferred_counselor_id');
        });
    }
}
