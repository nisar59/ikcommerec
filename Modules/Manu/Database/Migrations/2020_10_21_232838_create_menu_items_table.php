<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('menu_id');
            $table->string('menu_type');
            $table->tinyInteger('parent_id')->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->tinyInteger('cms_id')->nullable();
            $table->tinyInteger('category_id')->nullable();
            $table->tinyInteger('sort_order')->nullable();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->string('type')->nullable();
            $table->string('image')->nullable();
            $table->string('tagline')->nullable();
            $table->string('link')->nullable();
            $table->string('short_desc')->nullable();
            $table->string('m_title')->nullable();
            $table->string('target')->nullable();
            $table->string('status')->nullable();
            $table->string('icon')->nullable();
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
        Schema::dropIfExists('menu_items');
    }
}
