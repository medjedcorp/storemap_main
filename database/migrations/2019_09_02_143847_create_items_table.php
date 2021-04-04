<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->string('barcode',20)->nullable()->index();
            $table->string('product_code',40)->index();
            $table->string('product_name',255)->index();
            $table->string('brand_name',100)->nullable()->index();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->nullable()->onDelete('SET NULL');
            $table->boolean('display_flag')->default(1)->index();
            $table->decimal('original_price', 10, 0)->nullable();
            $table->text('description')->nullable();
            $table->string('color_name',30)->nullable();
            $table->unsignedInteger('color_id')->nullable();
            $table->foreign('color_id')->references('id')->on('colors')->nullable()->onDelete('SET NULL'); //外部キー参照
            $table->text('size')->nullable();
            $table->string('size_name',10)->nullable();
            $table->string('tag', 100)->nullable()->index();
            $table->unsignedBigInteger('group_code_id')->nullable();
            $table->foreign('group_code_id')->references('id')->on('group_codes')->nullable()->onDelete('SET NULL');
            $table->unsignedBigInteger('storemap_category_id')->nullable();
            $table->foreign('storemap_category_id')->references('id')->on('storemap_categories')->nullable()->onDelete('SET NULL');
            $table->boolean('item_status')->default(1)->index();
            $table->boolean('global_flag')->default(0)->index();
            $table->string('item_img1')->nullable();
            $table->string('item_img2')->nullable();
            $table->string('item_img3')->nullable();
            $table->string('item_img4')->nullable();
            $table->string('item_img5')->nullable();
            $table->string('item_img6')->nullable();
            $table->string('item_img7')->nullable();
            $table->string('item_img8')->nullable();
            $table->string('item_img9')->nullable();
            $table->string('item_img10')->nullable();
            $table->string('ext_product_code', 40)->nullable();
            $table->timestamps();
            // $table->unique(['company_id', 'barcode'], 'company_barcode');
            $table->unique(['company_id', 'product_code'], 'company_product_code');
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
    }
}
