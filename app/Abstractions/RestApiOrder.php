<?php

namespace App\Abstractions;

use App\Http\Controllers\Controller;
use App\Interfaces\RestApiOrder as RestApiOrderInterface;
use App\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

//Абстрактный класс реализующий RestApi функции доступа к данным Заказа
abstract class RestApiOrder extends Controller implements RestApiOrderInterface {

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
     * @description создание нового Заказа на основании данных из запроса
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request):JsonResponse {
        $order_data = $request->all();
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
            foreach ($request->file("files") as $file) {
                if ($file instanceof UploadedFile) {
                    // Сохраняем файл на сервере
                    $new_order->addMedia($file)
                        ->toMediaCollection('orders_files');
                }
            }
        return response()->json([
            'new_order' => $new_order,
        ]);
    }

    /**
     * @description Просмотр одного Заказа
     * @param Order $model
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Order $order):JsonResponse{
        return response()->json([
            'order' => $order
        ]);
    }

    /**
     * @description изменение данных Заказа на данные из запроса
     * @param Order $order
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Order $order, Request $request):JsonResponse {
        $order_data = $request->all();
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
        foreach ($request->file("files") as $file) {
            if ($file instanceof UploadedFile) {
                // Сохраняем файл на сервере
                $order->addMedia($file)
                    ->toMediaCollection('orders_files');
            }
        }
        return response()->json([
            'new_order' => $order,
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
