<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model {

    //Заполняемые параметры
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
    ];

    //Правила заполнения данных заказа
    public static function rules(): array {
        return [
            'name' => 'required|string', //Имя - обязательное строковое
            'parent_id' => 'integer', //Родительская категория - целочисленное
            'slug' => 'required|string', //URL - обязательное строковое
            'description' => 'required|string', //Описание - обязательное строковое
        ];
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo {
        return $this->belongsTo(self::class);
    }

    /**
     * @return HasOne
     */
    public function menu_item(): HasOne {
        return $this->hasOne(Category::class);
    }

    /**
     * @return HasMany
     */
    public function products(): HasMany {
        return $this->hasMany(Product::class);
    }

}
