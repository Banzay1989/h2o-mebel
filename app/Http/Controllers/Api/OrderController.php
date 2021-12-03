<?php

namespace App\Http\Controllers\Api;

use App\Abstractions\RestApiOrder;
use App\Order;
use Illuminate\Http\JsonResponse;

//Класс реализующий работу с Заказами на сайте
class OrderController extends RestApiOrder {
    /**
     * @description Загрузка констант модели (статусов) для создания редактора Заказа
     * @return JsonResponse
     */
    final public function getConsts():JsonResponse {
        return response()->json([
            'order_const' => [
                'statuses' => Order::STATUSES,
            ],
        ]);
    }
}
