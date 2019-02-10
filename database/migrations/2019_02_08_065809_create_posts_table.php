<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('categoryId')->unsigned();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->longText('content');
            $table->boolean('status')->default('1');
            $table->integer('created')->unsigned()->default(0);
            $table->integer('published')->unsigned()->default(0);
            $table->integer('numberofviews')->default(0);
            $table->boolean('isPopular')->default(0);
            $table->boolean('homepageTop')->default(0);
            $table->string('featuredImage');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('categoryId')->references('id')->on('categories')->onDelete('cascade');
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
