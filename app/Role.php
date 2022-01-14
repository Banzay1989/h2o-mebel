<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class Role extends Model {


    //Заполняемые параметры
    protected $fillable = [
        'user_id',
        'role',
    ];


    //Файлы, прикрепленные к заказу
    protected $appends = ['images'];

    //Правила заполнения данных заказа
    public static function rules(): array {
        return [
            'user_id' => 'required|integer', //ID пользователя - обязательное целочисленное
            'role' => 'required|string', //Роль - обязательное строковое ('administrator', 'user', 'manager')
        ];
    }


}
