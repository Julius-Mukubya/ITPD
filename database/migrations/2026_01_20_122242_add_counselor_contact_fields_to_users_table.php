<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCounselorContactFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('whatsapp_number')->nullable()->after('phone');
            $table->string('counselor_email')->nullable()->after('whatsapp_number');
            $table->text('office_address')->nullable()->after('counselor_email');
            $table->string('office_phone')->nullable()->after('office_address');
            $table->json('availability_hours')->nullable()->after('office_phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'whatsapp_number',
                'counselor_email', 
                'office_address',
                'office_phone',
                'availability_hours'
            ]);
        });
    }
}
