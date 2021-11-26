<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Order;
use Illuminate\Http\Request;

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
                'items' => OrderResource::collection($orders),
                'count' => Order::count(),
            ]
        ]);
    }
}
