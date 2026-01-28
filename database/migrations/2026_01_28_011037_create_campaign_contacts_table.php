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
        Schema::create('campaign_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Contact person name
            $table->string('title')->nullable(); // Job title/role
            $table->string('email');
            $table->string('phone');
            $table->string('office_location')->nullable();
            $table->string('office_hours')->nullable();
            $table->boolean('is_primary')->default(false); // Mark primary contact
            $table->integer('sort_order')->default(0); // For ordering contacts
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campaign_contacts');
    }
};