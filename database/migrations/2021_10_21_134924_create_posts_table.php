<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->nullable();
            $table->string('title');
            $table->string('title_sub')->nullable();
            $table->string('slug')->nullable();
            $table->string('image_url')->nullable();
            $table->string('cover_url')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->integer('imdb')->nullable();
            $table->string('quality')->nullable();
            $table->string('duration')->nullable();
            $table->string('year')->nullable();
            $table->string('released')->nullable();
            $table->string('trailer')->nullable();
            $table->json('data')->nullable();
            $table->boolean('private')->default(false);
            $table->boolean('featured')->default(false);
            $table->boolean('slider')->default(false);
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
