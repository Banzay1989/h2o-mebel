<?php

namespace App\Http\Controllers\Api;

use App\Abstractions\RestApiOrder;
use App\Order;
use App\OrderProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

//Класс реализующий работу с Заказами на сайте
class OrderController {
    /**
     * @description Загрузка констант модели (статусов) для создания редактора Заказа
     * @return JsonResponse
     */
    final public function getConsts(): JsonResponse {
        return response()->json([
            'order_const' => [
                'statuses' => Order::STATUSES,
            ],
        ]);
    }

    /**
     * @description создание нового Заказа на основании данных из запроса
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse {
        $order_data = $request->credential;
        $order_data['status'] = Order::STATUSES[0];
        $validator = Validator::make(
            $order_data,
            Order::rules()
        );
        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Данные введены некорректно',
                    'errors' => $validator->errors()
                ], 500);
        }
        $new_order = Order::create($order_data);

        foreach ($request->products as $product) {
            $product_data = [
                'order_id' => $new_order->id,
                'product_id' => $product['product']['id'],
                'quantity' => $product['quantity'],
                'price' => $product['product']['price'],
            ];
            OrderProduct::create($product_data);
        }


        return response()->json([
            'new_order' => $new_order,
        ]);
    }
}
