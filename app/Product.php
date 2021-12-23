<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia {
    use InteractsWithMedia, SoftDeletes;

    //Заполняемые параметры
    protected $fillable = [
        'name',
        'article',
        'description',
        'category_id',
        'brand_id',
        'price',
    ];

    //Файлы, прикрепленные к заказу
    protected $appends = ['files'];

    //Правила заполнения данных заказа
    public static function rules(): array {
        return [
            'name' => 'required|string', //Имя - обязательное строковое
            'article' => 'required|string|unique:App\Product,article', //Артикул - обязательное строковое
            'description' => 'required|string', //Описание - обязательное строковое
            'category_id' => 'required|integer', //Ссылка на категорию - обязательное целочисленное
            'brand_id' => 'required|integer:date', //Ссылка на бренд - обязательное целочисленное
            'price' => 'required|number', //Стоимость - обязательное в формате цены "XXXX.XX"
        ];
    }

    /**
     * @description получим файлы с данными
     * @return array
     */
    public function getFilesAttribute(): array {
        return $this->getMedia('product_photos')->all();
    }

    /**
     * @return BelongsTo
     */
    public function brand():BelongsTo {
        return $this->belongsTo(Brand::class);
    }

    /**
     * @return BelongsTo
     */
    public function category():BelongsTo {
        return $this->belongsTo(Category::class);
    }
}
