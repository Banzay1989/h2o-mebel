<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuItem extends Model {
    public $timestamps = false;

    //Заполняемые параметры
    protected $fillable = [
        'category_id',
        'priority',
    ];

    //Правила заполнения данных заказа
    public static function rules(): array {
        return [
            'category_id' => 'required|integer', //ID категории - обязательное целочисленное
            'priority' => 'integer', //Приоритет - целочисленное
        ];
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }
}
