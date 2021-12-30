<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

//Класс реализующий работу с Продуктами на сайте
class ProductController {
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
        $slug = $request->input('slug', null);

        $builder = Product::select('*');
        if ($slug) {
            $builder->whereHas('category', function ($query) use ($slug) {
                $query->where('slug', $slug);
            });
        }

        $count = $builder->count();

        $builder->offset((int)$pagination*(int)$limit)
            ->take((int)$limit);
        if ($orderDirection === 'asc') {
            $builder->orderBy($orderBy);
        } else {
            $builder->orderByDesc($orderBy);
        }

        $products = $builder->get();

        return response()->json([
            'products' => [
                'items' => $products,
                'count' => $count],
        ]);
    }

    /**
     * @description Просмотр одного Продукта
     * @param Product $model
     * @return JsonResponse
     */
    public function get(Product $product): JsonResponse {
        return response()->json([
            'product' => $product->load('brand')
        ]);
    }
}
