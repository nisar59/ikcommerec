<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProducsWarehouseStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producs_warehouse_stocks', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->integer('p_id');
            $table->integer('ware_house_id');
            $table->integer('quantity');
            $table->integer('available_quantity');
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
        Schema::dropIfExists('producs_warehouse_stocks');
    }
}
