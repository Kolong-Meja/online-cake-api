<?php

namespace App\Repositories;
use App\Enums\CakeStatus;
use App\Interfaces\CakeInterface;
use App\Models\Cake;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CakeRepository implements CakeInterface {
    private const REQUIRED_ROLE = ["customer", "admin"];

    protected CakeStatus $cakeStatus;

    public function __construct(CakeStatus $cakeStatus)
    {
        $this->cakeStatus = $cakeStatus;
    }

    public function getAllCakes(): JsonResponse
    {
        $cakes = Cake::get();

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
}