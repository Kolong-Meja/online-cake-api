<?php

namespace App\Interfaces;
use App\Http\Requests\Api\CartRequest;
use Illuminate\Http\JsonResponse;

interface CartInterface {
    public function getAllCarts(): JsonResponse;

    public function getOneCartById(string $id): JsonResponse;

    public function storeNewCart(CartRequest $request): JsonResponse;

    public function updateRecentCart(CartRequest $request, string $id): JsonResponse;

    public function removeOneCartById(string $id): JsonResponse;
}