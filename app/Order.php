<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    //Набор предопределенных статусов заказа
    const STATUSES = [
        'Открыта',
        'Подтверждена клиентом',
        'Отменена',
        'Оплачена',
        'Доставлена',
        'Завершена',
        'Взята в работу',
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
            'comment' => 'required|string', //Комментарий - обязательное строковое
            'status' => 'required|string|in:' . implode(',', self::STATUSES), //Статус - обязательное, соответствовать константе статусов
        ];
    }
}
