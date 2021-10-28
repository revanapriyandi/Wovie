<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('content_id');
            $table->foreignId('episode_id');
            $table->string('name')->nullable();
            $table->foreignId('service_id')->nullable();
            $table->foreignId('language_id')->nullable();
            $table->string('quality')->nullable();
            $table->string('player')->nullable();
            $table->string('embed')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_videos');
    }
}
