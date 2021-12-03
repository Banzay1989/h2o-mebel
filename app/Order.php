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
     * @return array
     */
    public function getFilesAttribute(): array {
        $ar_file_links = [];
        $files = $this->getMedia('orders_files')->all();

        if (count($files)) {
            foreach ($files as $file) {
                $ar_file_links[] = [
                    'id' => $file->id,
                    'url' => route('files.orders', [
                        'orderId' => $this->id,
                        'fileId' => $file->id,
                        'r' => time()
                    ], false),
                    'mime_type' => $file->mime_type,
                    'name' => $file->file_name,
                ];
            }
        }

        return $ar_file_links;
    }

    /**
     * @return string
     */
    public function getDirectory(): string {
        return '/orders/order-' . $this->id . '/';
    }
}
