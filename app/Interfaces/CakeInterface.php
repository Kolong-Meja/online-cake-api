<?php

namespace App\Interfaces;
use App\Http\Requests\Api\CakeRequest;
use Illuminate\Http\JsonResponse;

interface CakeInterface {
    public function getAllCakes(): JsonResponse;

    public function getAllCakesOrders(): JsonResponse;

    public function getOneCakeById(string $id): JsonResponse;

    public function getOneCakeByName(string $name): JsonResponse;

    public function createNewCake(CakeRequest $request): JsonResponse;

    public function updateRecentCake(CakeRequest $request, string $id): JsonResponse;

    public function removeOneCakeById(string $id): JsonResponse;
}