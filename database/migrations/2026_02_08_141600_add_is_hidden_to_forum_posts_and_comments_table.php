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
        Schema::table('forum_posts', function (Blueprint $table) {
            $table->boolean('is_hidden')->default(false)->after('is_reported');
        });

        Schema::table('forum_comments', function (Blueprint $table) {
            $table->boolean('is_hidden')->default(false)->after('is_reported');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forum_posts', function (Blueprint $table) {
            $table->dropColumn('is_hidden');
        });

        Schema::table('forum_comments', function (Blueprint $table) {
            $table->dropColumn('is_hidden');
        });
    }
};
