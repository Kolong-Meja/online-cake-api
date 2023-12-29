<?php

namespace App\Repositories;
use App\Http\Requests\Api\CartRequest;
use App\Interfaces\CartInterface;
use App\Models\Cart;
use App\Utils\CheckRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CartRepository implements CartInterface
{
    private const REQUIRED_ROLE = ["customer", "admin"];

    public function getAllCarts(): JsonResponse
    {
        if (!in_array(CheckRole::authUserRole(), self::REQUIRED_ROLE)) {
            return response()->json([
                'success' => false,
                'statusCode' => 403,
                'message' => "Access denied! you don't have the required role, customer and admin",
                'content' => null
            ], 403);
        }

        $carts = Cart::with(['user', 'cake'])->get();

        if (!$carts->isEmpty()) {
            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'message' => 'Cart model data has been successfully retrieve!',
                'content' => $carts
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'message' => 'Cart model data not found, make sure to re-check the data again',
                'content' => null
            ], 404);
        }
    }

    public function getOneCartById(string $id): JsonResponse
    {
        if (!in_array(CheckRole::authUserRole(), self::REQUIRED_ROLE)) {
            return response()->json([
                'success' => false,
                'statusCode' => 403,
                'message' => "Access denied! you don't have the required role, customer and admin",
                'content' => null
            ], 403);
        }

        $recentCartData = Cart::with(['user', 'cake'])->where('id', $id)->first();
       

        if (!$recentCartData) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'message' => 'Cart model data not found, make sure to re-check the data again',
                'content' => null
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'message' => 'Cart model data has been successfully retrieve!',
                'content' => $recentCartData
            ], 200);
        }
    }

    public function storeNewCart(CartRequest $request): JsonResponse
    {
        if (!in_array(CheckRole::authUserRole(), self::REQUIRED_ROLE)) {
            return response()->json([
                'success' => false,
                'statusCode' => 403,
                'message' => "Access denied! you don't have the required role, customer and admin",
                'content' => null
            ], 403);
        }

        $validatedData = $request->validated();

        $newCartData = Cart::create([
            'user_id' => $validatedData['user_id'],
            'cake_id' => $validatedData['cake_id'],
            'quantity' => $validatedData['quantity'],
        ]);

        return response()->json([
            'success' => true,
            'statusCode' => 201,
            'message' => 'New Cart data has been successfully created!',
            'content' => $newCartData
        ], 201);
    }

    public function updateRecentCart(CartRequest $request, string $id): JsonResponse
    {
        if (!in_array(CheckRole::authUserRole(), self::REQUIRED_ROLE)) {
            return response()->json([
                'success' => false,
                'statusCode' => 403,
                'message' => "Access denied! you don't have the required role, customer and admin",
                'content' => null
            ], 403);
        }

        $recentCartData = Cart::findOrFail($id);

        $validatedData = $request->validated();

        $recentCartData->update([
            'user_id' => $validatedData['user_id'],
            'cake_id' => $validatedData['cake_id'],
            'quantity' => $validatedData['quantity'],
        ]);

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Cart model data has been successfully updated!',
            'content' => $recentCartData
        ], 200);
    }

    public function removeOneCartById(string $id): JsonResponse
    {
        if (!in_array(CheckRole::authUserRole(), self::REQUIRED_ROLE)) {
            return response()->json([
                'success' => false,
                'statusCode' => 403,
                'message' => "Access denied! you don't have the required role, customer and admin",
                'content' => null
            ], 403);
        }

        $recentCartData = Cart::findOrFail($id);

        $recentCartData->delete();

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Cart data has been successfully removed!',
        ], 200);
    }
}