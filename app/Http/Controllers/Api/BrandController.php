<?php

namespace App\Http\Controllers\Api;

use App\Brand;
use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\MenuItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

//Класс реализующий работу с Брендами на сайте
class BrandController extends Controller {

    /**
     * @description загрузка данных Категорий
     * @return JsonResponse
     */
    public function index(): JsonResponse {
        return response()->json([
            'brands' => Brand::all(),
        ]);
    }

    /**
     * @description создание новой категории на основании данных из запроса
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request):JsonResponse {
        $category_item_data = $request->all();
        $validator = Validator::make(
            $category_item_data,
            Category::rules()
        );
        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Данные введены некорректно',
                    'errors' => $validator->errors()
                ], 500);
        }

        $category_item = Category::create($category_item_data);

        return response()->json([
            'category' => $category_item,
        ]);
    }

    /**
     * @description изменение данных Категории на данные из запроса
     * @param Category $category_item
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Category $category_item, Request $request):JsonResponse {
        $category_item_data = $request->all();
        $validator = Validator::make(
            $category_item_data,
            Category::rules()
        );
        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Данные введены некорректно',
                    'errors' => $validator->errors()
                ], 500);
        }

        $category_item->update($category_item_data);

        return response()->json([
            'category_item' => $category_item,
        ]);
    }

    /**
     * @description удаление Заказа
     * @param Category $category_item
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(Category $category_item):JsonResponse {
        $result = $category_item->delete();
        return response()->json([
            'result' => (bool)$result,
        ]);
    }
}
