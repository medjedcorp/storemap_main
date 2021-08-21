<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTokenToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('api_token',32)->nullable()->unique();  //カラム追加
            $table->string('company_code',7)->nullable()->unique(); //カラム追加
            $table->boolean('api_flag')->default(0);  //カラム追加
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            //カラムの削除
            $table->dropColumn('api_token');
            $table->dropColumn('company_code');
            $table->dropColumn('api_flag');
        });
    }
}
