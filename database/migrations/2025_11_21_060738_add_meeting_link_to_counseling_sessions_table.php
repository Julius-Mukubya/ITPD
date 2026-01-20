<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMeetingLinkToCounselingSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('counseling_sessions', function (Blueprint $table) {
            $table->text('meeting_link')->nullable()->after('preferred_method');
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
            $table->dropColumn('meeting_link');
        });
    }
}
