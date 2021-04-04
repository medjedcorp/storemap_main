<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
//            $table->unsignedBigInteger('user_id');
//            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); //外部キー参照
            // $table->string('company_code',60)->unique();
            $table->string('company_name',85);
            $table->string('company_kana',85)->nullable();
            $table->char('company_postcode',8);
            $table->string('prefecture');
            $table->string('company_city',30);
            $table->string('company_adnum',50);
            $table->string('company_apart',100)->nullable();
            $table->string('company_phone_number',20);
            $table->string('company_fax_number',20)->nullable();
            $table->string('manager_name',85);
            $table->string('manager_kana',85)->nullable();
            $table->string('site_url',255)->nullable();
            $table->string('certificate',255)->nullable(); // 会社証明
            $table->boolean('maker_flag')->default(0);
            $table->boolean('img_flag')->default(0);
            $table->bigInteger('gs1_company_prefix')->unsigned()->nullable()->unique();
            $table->tinyInteger('status')->default(1)->unsigned();
            $table->string('ext_id')->nullable();
            $table->string('ext_token')->nullable();
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
        Schema::dropIfExists('companies');
    }
}
