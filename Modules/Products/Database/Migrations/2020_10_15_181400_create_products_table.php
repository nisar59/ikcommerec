<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('slug');
            $table->string('sku')->nullable();
            $table->text('short_description')->nullable();
            $table->text('description')->nullable();
            $table->integer('brand_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('supplier_id')->nullable();
            $table->integer('warehouse_id')->nullable();

            $table->double('purchase_price')->nullable();
            $table->double('price')->nullable();
            $table->double('sale_price')->nullable();

            $table->string('weight')->nullable();

            $table->string('product_doc')->nullable();
            $table->integer('sort_order')->nullable();
            $table->tinyInteger('status')->default(1)->nullable();
            $table->Integer('viewed')->default(0);
            $table->Integer('sold')->default(0);
            $table->integer('stock_status')->default(1)->nullable();

            $table->tinyInteger('enable_reviews')->default(1)->nullable();
            $table->tinyInteger('featured')->default(1)->nullable();

            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->string('meta_keywords', 500)->nullable();
            $table->string('meta_schema', 500)->nullable();

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
        Schema::dropIfExists('products');
    }
}
