<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\RestApiOrder;
use App\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller implements RestApiOrder {

    /**
     * @description загрузка данных Заказа на основании данных из запроса (пагинация, сортировка)
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse {
        $limit = $request->input('limit', 10);
        $orderBy = $request->input('orderBy', 'id');
        $orderDirection = $request->input('orderDirection', 'asc');
        $pagination = $request->input('pagination', 0);

        $builder = Order::offset((int)$pagination)
            ->take((int)$limit);
        if ($orderDirection === 'asc') {
            $builder->orderBy($orderBy);
        } else {
            $builder->orderByDesc($orderBy);
        }

        $orders = $builder->get();

        return response()->json([
            'orders' => [
                'items' => $orders,
                'count' => Order::count(),
            ]
        ]);
    }

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

    /**
     * @description создание нового Заказа на основании данных из запроса
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request):JsonResponse {
        $order_data = $request->order;

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
        return response()->json([
            'new_order' => $new_order
        ]);
    }

    /**
     * @description изменение данных Заказа на данные из запроса
     * @param Order $order
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Order $order, Request $request):JsonResponse {
        $order_data = $request->order;

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

        $order->update($order_data);
        return response()->json([
            'new_order' => $order_data
        ]);
    }

    /**
     * @description удаление Заказа
     * @param Order $order
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(Order $order):JsonResponse {
        $result = $order->delete();
        return response()->json([
            'result' => (bool)$result,
        ]);
    }
}
