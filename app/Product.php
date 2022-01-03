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

class Product extends Model implements HasMedia {
    use InteractsWithMedia, SoftDeletes;

    public const MEDIA_SOURCE_COLLECTION = 'product_file';

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
            'article' => 'required|string', //Артикул - обязательное строковое
            // 'article' => 'required|string|unique:App\Product,article', //Артикул - обязательное строковое
            'description' => 'required|string', //Описание - обязательное строковое
            'category_id' => 'required|integer', //Ссылка на категорию - обязательное целочисленное
            'brand_id' => 'required|integer', //Ссылка на бренд - обязательное целочисленное
            'price' => 'required|numeric', //Стоимость - обязательное в формате цены "XXXX.XX"
        ];
    }

    /**
     * @description получим файлы с данными
     * @return array
     */
    public function getFilesAttribute(): array {
        return array_map(static function ($file){
            // dd($file);
            return $file->getUrl();
        }, $this->getMedia(self::MEDIA_SOURCE_COLLECTION)->all());
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

    /**
     * @param Collection $files - Collection<UploadedFile>|Collection<string>
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function attachFiles(Collection $files): void {

        $exist_medias = $this->getMedia(self::MEDIA_SOURCE_COLLECTION);

        foreach ($files as $file) {

            $exist_media_w_same_name = $exist_medias->first(static function ($exist_media) use ($file) {
                return $exist_media->file_name === ($file instanceof UploadedFile ? $file->getClientOriginalName() : basename($file));
            });
            if ($exist_media_w_same_name) {
                $exist_media_w_same_name->delete();
            }

            $this
                ->addMedia($file)
                ->preservingOriginal()
                ->toMediaCollection(self::MEDIA_SOURCE_COLLECTION);
        }
    }
}
