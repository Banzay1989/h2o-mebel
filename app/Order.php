<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    //Набор предопределенных статусов заказа
    const STATUSES = [
        'Создан',
        'Открыт',
        'Подтвержден клиентом',
        'Отменен',
        'Оплачен',
        'Доставлен',
        'Завершен',
        'Взят в работу',
    ];

    //Заполняемые параметры
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'comment',
        'status',
    ];

    //Правила заполнения данных заказа
    public static function rules(): array {
        return [
            'name' => 'required|string', //Имя - обязательное строковое
            'phone' => 'required|string', //Телефон - обязательное строковое
            'email' => 'required|string', //E-mail - обязательное строковое
            'address' => 'required|string', //Адрес - обязательное строковое
            'comment' => 'string', //Комментарий - строковое
            'status' => 'required|string|in:' . implode(',', self::STATUSES), //Статус - обязательное, соответствовать константе статусов
        ];
    }

    public function order_products() {
        return $this->hasMany(OrderProduct::class);
    }
}
