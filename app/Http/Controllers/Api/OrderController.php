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
     * @description загрузка данных Заказа на основании данных из запроса (пагинация, сортировка)
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse {
        // $limit = $request->input('limit', 10);
        // $orderBy = $request->input('orderBy', 'id');
        // $orderDirection = $request->input('orderDirection', 'asc');
        // $pagination = $request->input('pagination', 0);

        // $builder = Order::offset((int)$pagination)
        //     ->take((int)$limit);
        // if ($orderDirection === 'asc') {
        //     $builder->orderBy($orderBy);
        // } else {
        //     $builder->orderByDesc($orderBy);
        // }

        $orders = Order::with('order_products.product')->get();

        return response()->json([
            // 'orders' => [
                'orders' => $orders,
                // 'count' => Order::count(),
            // ]
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
