<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\JsonResponse;

//Класс реализующий работу с Категориями на сайте
class CategoryController extends Controller {

    /**
     * @description загрузка данных Меню
     * @return JsonResponse
     */
    public function index(): JsonResponse {
        return response()->json([
            'categories' => CategoryResource::collection(Category::whereNull('parent_id')->get()),
        ]);
    }
}
