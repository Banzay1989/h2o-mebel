<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Brand extends Model implements HasMedia {
    use InteractsWithMedia;

    //Заполняемые параметры
    protected $fillable = [
        'name',
        'country_id',
        'description',
    ];

    //Файлы, прикрепленные к заказу
    protected $appends = ['brand_logo'];

    //Правила заполнения данных заказа
    public static function rules(): array {
        return [
            'name' => 'required|string', //Имя - обязательное строковое
            'country_id' => 'required|integer', //Ссылка на страну обязательное целочисленное
            'description' => 'required|string', //Описание - обязательное строковое
        ];
    }

    /**
     * @description получим файлы с данными
     * @return
     */
    public function getBrandLogoAttribute() {
        return $this->getMedia('brand_logo')->first();
    }

    /**
     * @return BelongsTo
     */
    public function country(): BelongsTo {
        return $this->belongsTo(Country::class);
    }

    /**
     * @return HasMany
     */
    public function products(): HasMany {
        return $this->hasMany(Product::class);
    }
}
