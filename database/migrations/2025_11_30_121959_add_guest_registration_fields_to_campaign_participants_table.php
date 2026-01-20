<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuestRegistrationFieldsToCampaignParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaign_participants', function (Blueprint $table) {
            $table->string('guest_name')->nullable()->after('user_id');
            $table->string('guest_email')->nullable()->after('guest_name');
            $table->string('guest_phone')->nullable()->after('guest_email');
            $table->string('student_id')->nullable()->after('guest_phone');
            $table->string('year_of_study')->nullable()->after('student_id');
            $table->string('course')->nullable()->after('year_of_study');
            $table->text('motivation')->nullable()->after('course');
            $table->boolean('is_guest_registration')->default(false)->after('motivation');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaign_participants', function (Blueprint $table) {
            $table->dropColumn([
                'guest_name',
                'guest_email', 
                'guest_phone',
                'student_id',
                'year_of_study',
                'course',
                'motivation',
                'is_guest_registration'
            ]);
        });
    }
}
