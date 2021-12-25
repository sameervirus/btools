<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id()->startingValue(100001);
            $table->bigInteger('code');
            $table->string('name');
            $table->integer('unit_id')->index();
            $table->integer('category_id')->index();
            $table->float('iprice');
            $table->timestamps();
        });

        Schema::create('item_warehouse', function (Blueprint $table)
        {
            $table->bigInteger('item_id')->index();
            $table->bigInteger('warehouse_id')->index();            
            $table->bigInteger('qty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
        Schema::dropIfExists('item_warehouse');
    }
}
