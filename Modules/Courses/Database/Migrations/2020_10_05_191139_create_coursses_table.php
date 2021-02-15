<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourssesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('title');
            $table->string('slug');
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->integer('image_id')->nullable();
            $table->integer('featured')->nullable();
            $table->string('course_duration')->nullable();
            $table->integer('max_student')->nullable();
            $table->integer('allowed_retake')->nullable();
            $table->integer('passing_condition')->nullable();
            $table->integer('course_result')->nullable();
            $table->double('price')->nullable();
            $table->double('sale_price')->nullable();
            $table->integer('required_enroll')->nullable()->default('1');
            $table->integer('instructor_id')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('sort_order')->nullable();
            $table->tinyInteger('status')->default(1)->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->string('meta_keywords', 500)->nullable();
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
        Schema::dropIfExists('courses');
    }
}
