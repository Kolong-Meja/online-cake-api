<?php

namespace App\Interfaces;
use App\Http\Requests\Api\RoleRequest;
use Illuminate\Http\JsonResponse;

interface RoleInterface {
    public function getAllRoles(): JsonResponse;

    public function getOneRoleById(string $id): JsonResponse;

    public function storeNewRole(RoleRequest $request): JsonResponse;

    public function updateRecentRole(RoleRequest $request, string $id): JsonResponse;

    public function removeOneRoleById(string $id): JsonResponse;
}