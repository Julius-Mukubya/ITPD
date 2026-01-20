<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPreferredMethodToCounselingSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('counseling_sessions', function (Blueprint $table) {
            $table->enum('preferred_method', ['zoom', 'google_meet', 'whatsapp', 'physical', 'phone_call'])->nullable()->after('priority');
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
            $table->dropColumn('preferred_method');
        });
    }
}
