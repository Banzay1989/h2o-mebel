<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id()->comment('Уникальный ключ таблицы');
            $table->string('name')->comment('Название бренда');
            $table->foreignId('country_id')->comment('ID страны');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->text('description')->comment('Полнотекстовое описание');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brands');
    }
}
