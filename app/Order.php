<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Order extends Model implements HasMedia {
    use InteractsWithMedia;

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
    protected $fillable = [
        'name',
        'description',
        'completion_date',
        'status',
    ];
    protected $appends = ['photos'];


    public static function rules(): array {
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'completion_date' => 'required|after_or_equal:date',
            'status' => 'required|string|in:' . implode(',', self::STATUSES),
        ];
    }

    /**
     * @return array
     */
    public function getPhotosAttribute(): array {
        $ar_file_links = [];
        $files = $this->getMedia('orders_photos')->all();

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
