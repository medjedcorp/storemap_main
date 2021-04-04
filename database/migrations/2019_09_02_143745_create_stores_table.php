<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->bigIncrements('id'); // 自動採番
            $table->string('store_code',20)->index();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade'); //外部キー参照
            $table->string('store_name',85)->index();  # Index;
            $table->string('store_kana',85)->nullable();
            $table->char('store_postcode',8);
            $table->string('prefecture');
            $table->string('store_city',30);
            $table->string('store_adnum',50);
            $table->string('store_apart',100)->nullable();
            $table->string('store_phone_number',20);
            $table->string('store_fax_number',20)->nullable();
            $table->string('store_email')->nullable();
            $table->boolean('pause_flag')->default(1)->index();
            $table->string('store_img1')->nullable();
            $table->string('store_img2')->nullable();
            $table->string('store_img3')->nullable();
            $table->string('store_img4')->nullable();
            $table->string('store_img5')->nullable();
            $table->text('store_info')->nullable();
            $table->unsignedInteger('industry_id');
            $table->foreign('industry_id')->references('id')->on('industries'); //外部キー参照
            $table->string('store_url')->nullable();
            $table->string('flyer_url')->nullable();
            $table->string('floor_guide')->nullable();
            $table->string('pay_info',500)->nullable()->comment('決済方法');
            $table->string('access',255)->nullable()->comment('アクセス');
            $table->string('opening_hour',255)->nullable()->comment('営業時間');
            $table->string('closed_day',255)->nullable()->comment('定休日');
            $table->string('parking',255)->nullable()->comment('駐車場');
            // $table->point('location')->nullable(); // 位置情報(緯度経度)
            $table->geometry('location')->nullable()->comment('緯度経度');
            // $table->geometry('positions');
            // $table->double('latitude', 9, 6)->nullable();
            // $table->double('longitude', 9, 6)->nullable();
            $table->string('ext_store_code')->nullable();
            $table->unique(['company_id', 'store_code'], 'company_store'); // 追加
            
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
        Schema::dropIfExists('stores');
    }
}
