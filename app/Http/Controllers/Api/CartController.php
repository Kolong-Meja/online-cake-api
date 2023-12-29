<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CartRequest;
use App\Interfaces\CartInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartInterface $cartInterface;

    public function __construct(CartInterface $cartInterface)
    {
        $this->cartInterface = $cartInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return $this->cartInterface->getAllCarts();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CartRequest $request): JsonResponse
    {
        return $this->cartInterface->storeNewCart($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return $this->cartInterface->getOneCartById($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CartRequest $request, string $id): JsonResponse
    {
        return $this->cartInterface->updateRecentCart($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        return $this->cartInterface->removeOneCartById($id);
    }
}
