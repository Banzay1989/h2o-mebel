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
            $table->id()->comment('Уникальный ключ таблицы');
            $table->string('name')->comment('Название продукта');
            $table->string('article')->unique()->comment('Артикул');
            $table->text('description')->comment('Полнотекстовое описание');
            $table->foreignId('category_id')->comment('ID категории');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreignId('brand_id')->comment('ID бренда');
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->unsignedFloat('price', 8, 2);
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
        Schema::dropIfExists('products');
    }
}
