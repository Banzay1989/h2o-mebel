<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    /**
     * @description изменение данных Продукта на данные из запроса
     * @param Product $product
     * @param Request $request
     * @return JsonResponse
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function update(Product $product, Request $request):JsonResponse {
        $product_data = $request->all();
        $validator = Validator::make(
            $product_data,
            Product::rules()
        );
        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Данные введены некорректно',
                    'errors' => $validator->errors()
                ], 500);
        }

        $product->update($product_data);

        $product->attachFiles(collect($request->file('new_files')));

        foreach($product->getMedia(Product::MEDIA_SOURCE_COLLECTION)->whereIn('id', $product_data['deletable_files']) as $file){
            unlink($file->getPath());
            $file->delete();
        }

        return response()->json([
            'new_product' => $product,
        ]);
    }

    /**
     * @description новый Продукт
     * @param Request $request
     * @return JsonResponse
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function store(Request $request):JsonResponse {
        $product_data = $request->all();
        $validator = Validator::make(
            $product_data,
            Product::rules()
        );
        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Данные введены некорректно',
                    'errors' => $validator->errors()
                ], 500);
        }
        $product = Product::create($product_data);
        $product->attachFiles(collect($request->file('new_files')));
        return response()->json([
            'new_product' => $product,
        ]);
    }

    /**
     * @description удаление Продукта
     * @param Product $product
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(Product $product):JsonResponse {
        $result = $product->delete();
        return response()->json([
            'result' => (bool)$result,
        ]);
    }

}
