<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Order extends Model implements HasMedia {
    use InteractsWithMedia;

    //Набор предопределенных статусов заказа
    const STATUSES = [
        'Open',
        'Needs offer',
        'Offered',
        'Approved',
        'In progress',
        'Ready',
        'Verified',
        'Closed',
    ];

    //Заполняемые параметры
    protected $fillable = [
        'name',
        'description',
        'completion_date',
        'status',
    ];

    //Файлы, прикрепленные к заказу
    protected $appends = ['files'];

    //Правила заполнения данных заказа
    public static function rules(): array {
        return [
            'name' => 'required|string', //Имя - обязательное строковое
            'description' => 'required|string', //Описание - обязательное строковое
            'completion_date' => 'required|after_or_equal:date', //Дата завершения - обязательное, дата больше или равная сегодня
            'status' => 'required|string|in:' . implode(',', self::STATUSES), //Статус - обязательное, соответствовать константе статусов
        ];
    }

    /**
     * @description получим файлы с данными
     * @return array
     */
    public function getFilesAttribute(): array {
        return $this->getMedia('orders_files')->all();
    }
}
