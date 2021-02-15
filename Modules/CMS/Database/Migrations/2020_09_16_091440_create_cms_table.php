<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->integer('template_id')->nullable();
            $table->string('name');
            $table->string('tag_line_1')->nullable();
            $table->string('tag_line_2')->nullable();
            $table->string('tag_line_3')->nullable();
            $table->string('link')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->string('image', 50)->nullable();
            $table->integer('sort_order')->nullable();
            $table->tinyInteger('status')->default(1)->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->string('meta_keywords', 500)->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms');
    }
}
