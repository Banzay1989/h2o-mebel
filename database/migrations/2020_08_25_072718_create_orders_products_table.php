<?php

use App\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id()->comment('Уникальный ключ таблицы');
            $table->foreignId('order_id')->comment('ID заказа');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreignId('product_id')->comment('ID продукта');
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('quantity')->comment('Количество заказанных товаров');
            $table->unsignedFloat('price', 8, 2)->comment('Цена за единицу товара');
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
        Schema::dropIfExists('order_products');
    }
}
