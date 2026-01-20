<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RemoveJitsiFromPreferredMethodEnum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // First, update any existing 'jitsi' values to 'zoom' as a fallback
        DB::table('counseling_sessions')
            ->where('preferred_method', 'jitsi')
            ->update(['preferred_method' => 'zoom']);

        // Remove 'jitsi' from the enum
        DB::statement("ALTER TABLE counseling_sessions MODIFY COLUMN preferred_method ENUM('zoom', 'google_meet', 'whatsapp', 'physical', 'phone_call') NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Add 'jitsi' back to the enum
        DB::statement("ALTER TABLE counseling_sessions MODIFY COLUMN preferred_method ENUM('zoom', 'google_meet', 'whatsapp', 'physical', 'phone_call', 'jitsi') NULL");
    }
}