<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->longText('content');
            $table->boolean('status')->default('1');
            $table->integer('created')->unsigned()->default(0);
            $table->integer('numberofviews')->default(0);
            $table->boolean('isPopular')->default(0);
            $table->string('featuredImage');
            $table->text('seo_descriptions')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
