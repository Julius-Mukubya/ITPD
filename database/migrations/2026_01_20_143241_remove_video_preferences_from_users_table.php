<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'preferred_video_service',
                'auto_start_video',
                'default_camera_on',
                'default_microphone_on'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('preferred_video_service', ['jitsi', 'google_meet', 'zoom', 'phone_call'])->default('jitsi')->after('email_verified_at');
            $table->boolean('auto_start_video')->default(true)->after('preferred_video_service');
            $table->boolean('default_camera_on')->default(false)->after('auto_start_video');
            $table->boolean('default_microphone_on')->default(false)->after('default_camera_on');
        });
    }
};