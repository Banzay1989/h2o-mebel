<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Country extends Model implements HasMedia {
    use InteractsWithMedia;

    //Заполняемые параметры
    protected $fillable = [
        'name',
        'description',
    ];

    //Файлы, прикрепленные к заказу
    protected $appends = ['flag'];

    //Правила заполнения данных заказа
    public static function rules(): array {
        return [
            'name' => 'required|string', //Имя - обязательное строковое
            'description' => 'string', //Описание - обязательное строковое
        ];
    }

    /**
     * @description получим файлы с данными
     * @return array
     */
    public function getFlagAttribute(): array {
        return $this->getMedia('flag')->first();
    }

    /**
     * @return HasMany
     */
    public function brands(): HasMany {
        return $this->hasMany(Brand::class);
    }
}
