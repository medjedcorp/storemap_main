<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_user', function (Blueprint $table) {
        $table->unsignedBigInteger('store_id');
        $table->unsignedBigInteger('user_id');
        $table->primary(['store_id', 'user_id']);

        //外部キー制約
        $table->foreign('store_id')
                ->references('id')
                ->on('stores')
                ->onDelete('cascade');
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
        Schema::dropIfExists('store_user');
    }
}
