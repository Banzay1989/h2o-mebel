<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model {

    //Заполняемые параметры
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    //Правила заполнения данных
    public static function rules(): array {
        return [
            'order_id' => 'required|integer', //Ссылка на заказ - обязательное целочисленное
            'product_id' => 'required|integer', //Ссылка на продукт - обязательное целочисленное
            'quantity' => 'required|integer', //Кол-во товаров - обязательное целочисленное
            'price' => 'required|numeric', //Стоимость - обязательное в формате цены "XXXX.XX"
        ];
    }
}
