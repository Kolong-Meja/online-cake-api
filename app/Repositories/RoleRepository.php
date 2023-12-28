<?php

namespace App\Repositories;
use App\Http\Requests\Api\RoleRequest;
use App\Interfaces\RoleInterface;
use App\Models\Role;
use Illuminate\Http\JsonResponse;

class RoleRepository implements RoleInterface {

    public function getAllRoles(): JsonResponse
    {
        $roles = Role::with('users')->select('*')->get();

        if (!$roles->isEmpty()) {
            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'message' => 'Role model data has been successfully retrieve!',
                'content' => $roles
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'message' => 'Role model data not found, make sure to re-check the data again',
                'content' => null
            ], 404);
        }
    }

    public function getOneRoleById(string $id): JsonResponse
    {
        $recentRoleData = Role::with('users')
        ->select('*')
        ->where('id', $id)
        ->first();

        if (!$recentRoleData) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'message' => 'Role model data not found, make sure to re-check the data again',
                'content' => null
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'message' => 'Role model data has been successfully retrieve!',
                'content' => $recentRoleData
            ], 200);
        }
    }

    public function storeNewRole(RoleRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $newRoleData = Role::create([
            'title' => $validatedData['title'],
            'abilities' => $validatedData['abilities'],
        ]);

        return response()->json([
            'success' => true,
            'statusCode' => 201,
            'message' => 'New Role data has been successfully created!',
            'content' => $newRoleData
        ], 201);
    }

    public function updateRecentRole(RoleRequest $request, string $id): JsonResponse
    {   
        $recentRoleData = Role::findOrFail($id);

        $validatedData = $request->validated();

        $recentRoleData->update([
            'title' => $validatedData['title'],
            'abilities' => $validatedData['abilities'],
        ]);

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Role model data has been successfully updated!',
            'content' => $recentRoleData
        ], 200);
    }

    public function removeOneRoleById(string $id): JsonResponse
    {
        $recentRoleData = Role::find($id);

        if (!$recentRoleData) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'message' => 'Role model data not found, make sure to re-check the data again',
                'content' => null
            ], 404);
        } else {
            $recentRoleData->delete();

            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'message' => 'Role data has been successfully removed!',
            ], 200);
        }
    }
}