<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_codes', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('company_id');
          $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
          $table->string('group_code',40);
          $table->timestamps();
          $table->unique(['company_id', 'group_code'], 'company_group_code');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_codes');
    }
}
