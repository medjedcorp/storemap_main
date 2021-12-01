<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtcodeToCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('ext_id')->nullable()->comment('外部連携用ID')->unique(); //カラム追加
            $table->string('ext_token')->nullable()->comment('外部連携用トークン')->unique();  //カラム追加
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
            $table->dropColumn('ext_id');
            $table->dropColumn('ext_token');
        });
    }
}
