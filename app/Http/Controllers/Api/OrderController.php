<?php

namespace App\Http\Controllers\Api;

use App\Abstractions\RestApiOrder;
use App\Order;
use Illuminate\Http\JsonResponse;

class OrderController extends RestApiOrder {
    /**
     * @description Загрузка констант модели (статусов) для создания редактора Заказа
     * @return JsonResponse
     */
    public function getConsts():JsonResponse {
        return response()->json([
            'order_const' => [
                'statuses' => Order::STATUSES,
            ],
        ]);
    }
}
