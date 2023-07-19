<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement()->comment('スレッドID');
            $table->integer('member_id')->comment('会員ID');
            $table->integer('product_category_id')->comment('カテゴリID');
            $table->integer('product_subcategory_id')->comment('サブカテゴリID');
            $table->string('name', 255)->nullable()->comment('商品名');
            $table->string('image_1', 255)->nullable()->comment('写真１');
            $table->string('image_2', 255)->nullable()->comment('写真２');
            $table->string('image_3', 255)->nullable()->comment('写真３');
            $table->string('image_4', 255)->nullable()->comment('写真４');
            $table->text('product_content')->comment('商品説明');
            $table->timestamp('created_at')->nullable()->comment('登録日時');
            $table->timestamp('updated_at')->nullable()->comment('編集日時');
            $table->timestamp('deleted_at')->nullable()->comment('削除日時');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
