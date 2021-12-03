<?php

namespace App\Interfaces;

use App\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface RestApiOrder {
    /**
     * @description загрузка данных модели
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request):JsonResponse;

    /**
     * @description создание новой модели
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request):JsonResponse;

    /**
     * @description изменение модели
     * @param Order $model
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Order $model, Request $request):JsonResponse;

    /**
     * @description удаление модели
     * @param Order $model
     * @return JsonResponse
     */
    public function delete(Order $model):JsonResponse;
}
