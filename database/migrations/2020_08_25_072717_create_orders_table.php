<?php

use App\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id()->comment('Уникальный ключ таблицы');
            $table->string('name')->comment('Название заявки');
            $table->text('description')->comment('Полнотекстовое описание с HTML тэгами');
            $table->date('completion_date')->comment('Дата завершения заявки');
            $table->set('status', Order::STATUSES)->comment('Статус заявки'); //Статусы лучше вынести в отдельную morph таблицу, чтоб при смене статусов у нас оставался постоянный id заявки, но при этом статусы менялись и оставались в истории
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
        Schema::dropIfExists('orders');
    }
}
