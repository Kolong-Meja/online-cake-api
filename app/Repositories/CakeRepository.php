<?php

namespace App\Repositories;
use App\Enums\CakeStatus;
use App\Http\Requests\Api\CakeRequest;
use App\Interfaces\CakeInterface;
use App\Models\Cake;
use App\Utils\CheckRole;
use Illuminate\Http\JsonResponse;

class CakeRepository implements CakeInterface {
    private const REQUIRED_ROLE = ["customer", "admin"];

    protected CakeStatus $cakeStatus;

    public function __construct(CakeStatus $cakeStatus)
    {
        $this->cakeStatus = $cakeStatus;
    }

    public function getAllCakes(): JsonResponse
    {
        if (!in_array(CheckRole::authUserRole(), self::REQUIRED_ROLE)) {
            return response()->json([
                'success' => false,
                'statusCode' => 403,
                'message' => "Access denied! you don't have the required role, customer and admin",
                'content' => null
            ], 403);
        }

        $cakes = Cake::with('carts')->select('*')->get();

        if (!$cakes->isEmpty()) {
            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'message' => 'Cake model data has been successfully retrieve!',
                'content' => $cakes
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'message' => 'Cake model data not found, make sure to re-check the data again',
                'content' => null
            ], 404);
        }
    }

    public function getOneCakeById(string $id): JsonResponse
    {
        if (!in_array(CheckRole::authUserRole(), self::REQUIRED_ROLE)) {
            return response()->json([
                'success' => false,
                'statusCode' => 403,
                'message' => "Access denied! you don't have the required role, customer and admin",
                'content' => null
            ], 403);
        }

        $recentCakeData = Cake::with('carts')->where('id', $id)->first();

        if (!$recentCakeData) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'message' => 'Cake model data not found, make sure to re-check the data again',
                'content' => null
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'message' => 'Cake model data has been successfully retrieve!',
                'content' => $recentCakeData
            ], 200);
        }
    }

    public function getOneCakeByName(string $name): JsonResponse
    {
        if (!in_array(CheckRole::authUserRole(), self::REQUIRED_ROLE)) {
            return response()->json([
                'success' => false,
                'statusCode' => 403,
                'message' => "Access denied! you don't have the required role, customer and admin",
                'content' => null
            ], 403);
        }

        $recentCakeData = Cake::with('carts')->where('name', $name)->first();
        
        if (!$recentCakeData) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'message' => 'Cake model data not found, make sure to re-check the data again',
                'content' => null
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'message' => 'Cake model data has been successfully retrieve!',
                'content' => $recentCakeData
            ], 200);
        }
    }

    // just for admin only!
    public function storeNewCake(CakeRequest $request): JsonResponse
    {
        if (CheckRole::authUserRole() !== self::REQUIRED_ROLE[1]) {
            return response()->json([
                'success' => false,
                'statusCode' => 403,
                'message' => "Access denied! you don't have the required role admin",
                'content' => null
            ], 403);
        }

        $validatedData = $request->validated();

        $newCakeData = Cake::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'weight' => $validatedData['weight'],
            'price' => $validatedData['price'],
            'stock' => $validatedData['stock'],
            'status' => $validatedData['status']
        ]);

        return response()->json([
            'success' => true,
            'statusCode' => 201,
            'message' => 'New Cake data has been successfully created!',
            'content' => $newCakeData
        ], 201);
    }

    public function updateRecentCake(CakeRequest $request, string $id): JsonResponse
    {
        if (CheckRole::authUserRole() !== self::REQUIRED_ROLE[1]) {
            return response()->json([
                'success' => false,
                'statusCode' => 403,
                'message' => "Access denied! you don't have the required role admin",
                'content' => null
            ], 403);
        }

        $recentCakeData = Cake::findOrFail($id);

        $validatedData = $request->validated();

        $recentCakeData->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'weight' => $validatedData['weight'],
            'price' => $validatedData['price'],
            'stock' => $validatedData['stock'],
            'status' => $validatedData['status']
        ]);

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Cake model data has been successfully updated!',
            'content' => $recentCakeData
        ], 200);
    }

    public function removeOneCakeById(string $id): JsonResponse
    {
        if (CheckRole::authUserRole() !== self::REQUIRED_ROLE[1]) {
            return response()->json([
                'success' => false,
                'statusCode' => 403,
                'message' => "Access denied! you don't have the required role admin",
                'content' => null
            ], 403);
        }

        $recentCakeData = Cake::findOrFail($id);

        $recentCakeData->delete();

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Cake data has been successfully removed!',
        ], 200);
    }
}