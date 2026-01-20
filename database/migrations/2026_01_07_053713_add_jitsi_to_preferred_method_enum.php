<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddJitsiToPreferredMethodEnum extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // For MySQL, we need to alter the enum column to add 'jitsi'
        DB::statement("ALTER TABLE counseling_sessions MODIFY COLUMN preferred_method ENUM('zoom', 'google_meet', 'whatsapp', 'physical', 'phone_call', 'jitsi') NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Remove 'jitsi' from the enum
        DB::statement("ALTER TABLE counseling_sessions MODIFY COLUMN preferred_method ENUM('zoom', 'google_meet', 'whatsapp', 'physical', 'phone_call') NULL");
    }
}