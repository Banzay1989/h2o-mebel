<?php

namespace App\Interfaces;

use App\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface RestApiOrder {
    /**
     * @description загрузка данных Заказа на основании данных из запроса (пагинация, сортировка)
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request):JsonResponse;

    /**
     * @description создание нового Заказа на основании данных из запроса
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request):JsonResponse;

    /**
     * @description Просмотр одного Заказа
     * @param Order $model
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Order $model):JsonResponse;

    /**
     * @description изменение данных Заказа на данные из запроса
     * @param Order $model
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Order $model, Request $request):JsonResponse;

    /**
     * @description удаление Заказа
     * @param Order $model
     * @return JsonResponse
     */
    public function delete(Order $model):JsonResponse;
}
