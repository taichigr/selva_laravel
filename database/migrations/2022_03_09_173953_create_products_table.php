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
            $table->bigIncrements('id')->comment('商品ID');
            $table->integer('member_id')->comment('会員ID');
            $table->integer('product_category_id')->comment('カテゴリID');
            $table->integer('product_subcategory_id')->comment('サブカテゴリID');
            $table->string('name', 255)->comment('商品名');
            $table->string('image_1', 255)->nullable()->default(null)->comment('写真1');
            $table->string('image_2', 255)->nullable()->default(null)->comment('写真2');
            $table->string('image_3', 255)->nullable()->default(null)->comment('写真3');
            $table->string('image_4', 255)->nullable()->default(null)->comment('写真4');
            $table->text('product_content')->comment('商品説明');
            $table->timestamps();
            $table->softDeletes()->comment('削除日時');
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
