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
        Schema::table('campaigns', function (Blueprint $table) {
            $table->string('contact_email')->nullable()->after('max_participants');
            $table->string('contact_phone')->nullable()->after('contact_email');
            $table->string('contact_office')->nullable()->after('contact_phone');
            $table->string('contact_hours')->nullable()->after('contact_office');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn(['contact_email', 'contact_phone', 'contact_office', 'contact_hours']);
        });
    }
};