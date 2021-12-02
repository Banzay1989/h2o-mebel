<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller {

    public function index(Request $request) {
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

    public function getConsts() {
        return response()->json([
            'order_const' => [
                'statuses' => Order::STATUSES,
            ],
        ]);
    }

    public function store(Request $request){
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

    public function update(Order $order, Request $request){
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

    public function delete(Order $order){
        $result = $order->delete();
        return response()->json([
            'result' => (bool)$result,
        ]);
    }
}
