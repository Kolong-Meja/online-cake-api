<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CakeRequest;
use App\Interfaces\CakeInterface;
use Illuminate\Http\JsonResponse;

class CakeController extends Controller
{
    protected CakeInterface $cakeInterface;

    public function __construct(CakeInterface $cakeInterface)
    {
        $this->cakeInterface = $cakeInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return $this->cakeInterface->getAllCakes();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CakeRequest $request): JsonResponse
    {
        return $this->cakeInterface->storeNewCake($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return $this->cakeInterface->getOneCakeById($id);
    }

    public function showByName(string $name): JsonResponse
    {
        return $this->cakeInterface->getOneCakeByName($name);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CakeRequest $request, string $id): JsonResponse
    {
        return $this->cakeInterface->updateRecentCake($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        return $this->cakeInterface->removeOneCakeById($id);
    }
}
