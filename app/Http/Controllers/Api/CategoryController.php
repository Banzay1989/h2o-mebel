<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

//Класс реализующий работу с Категориями на сайте
class CategoryController extends Controller {

    /**
     * @description загрузка данных Меню
     * @return JsonResponse
     */
    public function index(): JsonResponse {
        $categories = Category::with('children')->get();

        return response()->json([
            'categories' => $categories,
        ]);
    }
}
