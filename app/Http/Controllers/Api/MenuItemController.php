<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\MenuItem;
use App\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;

//Класс реализующий работу с Меню на сайте
class MenuItemController extends Controller {

    /**
     * @description загрузка данных Меню
     * @return JsonResponse
     */
    public function index(): JsonResponse {
        $menu = MenuItem::with('category.children')->get();

        return response()->json([
            'menu_items' => $menu,
        ]);
    }

    /**
     * @description создание нового Пункта меню на основании данных из запроса
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request):JsonResponse {
        $menu_item_data = $request->all();
        $validator = Validator::make(
            $menu_item_data,
            MenuItem::rules()
        );
        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Данные введены некорректно',
                    'errors' => $validator->errors()
                ], 500);
        }

        $menu_item = MenuItem::create($menu_item_data);

        return response()->json([
            'menu_item' => $menu_item->load('category.children'),
        ]);
    }

    /**
     * @description изменение данных Заказа на данные из запроса
     * @param MenuItem $menu_item
     * @param Request $request
     * @return JsonResponse
     */
    public function update(MenuItem $menu_item, Request $request):JsonResponse {
        $menu_item_data = $request->all();
        $validator = Validator::make(
            $menu_item_data,
            MenuItem::rules()
        );
        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Данные введены некорректно',
                    'errors' => $validator->errors()
                ], 500);
        }

        $menu_item->update($menu_item_data);

        return response()->json([
            'new_menu_item' => $menu_item->load('category.children'),
        ]);
    }

    /**
     * @description удаление Заказа
     * @param MenuItem $menu_item
     * @return JsonResponse
     * @throws \Exception
     */
    public function delete(MenuItem $menu_item):JsonResponse {
        $result = $menu_item->delete();
        return response()->json([
            'result' => (bool)$result,
        ]);
    }
}
