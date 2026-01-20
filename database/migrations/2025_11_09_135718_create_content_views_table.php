<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('content_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id')->constrained('educational_contents')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->integer('duration')->nullable()->comment('Time spent in seconds');
            $table->timestamp('viewed_at')->nullable();
            $table->timestamps();
            
            $table->index(['content_id', 'user_id']);
            $table->index('viewed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_views');
    }
}
