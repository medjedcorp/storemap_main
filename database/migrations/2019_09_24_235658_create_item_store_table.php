<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemStoreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_store', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('item_id');
        $table->unsignedBigInteger('store_id');
        $table->string('catch_copy', 140)->nullable()->index();
        $table->string('shelf_number',10)->nullable();
        $table->integer('sort_num')->nullable();
        $table->boolean('selling_flag')->default(1)->index();
        $table->tinyInteger('price_type')->default(0)->unsigned();
        $table->decimal('price', 10, 0)->nullable();
        $table->decimal('value', 10, 0)->nullable();
        $table->dateTime('start_date')->nullable();
        $table->dateTime('end_date')->nullable();
        $table->integer('stock_amount')->default(0);
        $table->boolean('stock_set')->default(1);
        $table->timestamps();
        $table->unique(['item_id','store_id']);
        $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_store');
    }
}
