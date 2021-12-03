<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface RestApi {
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
     * @param Model $model
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Model $model, Request $request):JsonResponse;

    /**
     * @description удаление модели
     * @param Model $model
     * @return JsonResponse
     */
    public function delete(Model $model):JsonResponse;
}
