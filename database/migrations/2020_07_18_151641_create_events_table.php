<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('title');
          $table->dateTime('start');
          $table->dateTime('end');
          $table->string('color', 7);
          $table->longText('description')->nullable();
          $table->unsignedBigInteger('store_id');
          $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
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
        Schema::dropIfExists('events');
    }
}
