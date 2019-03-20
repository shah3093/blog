<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->unsigned();
            $table->integer('created')->unsigned()->default(0);
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('seo_descriptions')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->string('featuredImage');
            $table->boolean('homepageTop')->default('0');
            $table->boolean('status')->default('1');
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
}
