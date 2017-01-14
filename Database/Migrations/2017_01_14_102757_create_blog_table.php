<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->longText('body');
            $table->string('slug')->unique();
            $table->boolean('active');
            $table->string('image')->nullable();


            $table->timestamps();
            $table->softDeletes();
            $table->boolean('is_deleted')->default(false);
        });

        Schema::create('post_tags', function(Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('name');
        });

        Schema::create('posts_tags', function(Blueprint $table) {
            $table->integer('post_id')->unsigned();
            $table->integer('tag_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('post_tags')->onDelete('cascade');
            $table->primary(['post_id', 'tag_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts_tags');
        Schema::dropIfExists('post_tags');
        Schema::dropIfExists('posts');
    }
}
