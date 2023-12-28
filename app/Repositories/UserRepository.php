<?php

namespace App\Repositories;

use App\Http\Requests\Api\UserRequest;
use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserRepository implements UserInterface {
    public function getAllUsers(): JsonResponse
    {
        $users = User::with('role')->select('*')->get();

        if (!$users->isEmpty()) {
            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'message' => 'User model data has been successfully retrieve!',
                'content' => $users
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'message' => 'User model data not found, make sure to re-check the data again',
                'content' => null
            ], 404);
        }
    }

    public function getOneUserById(string $id): JsonResponse
    {
        $recentUserData = User::with('role')
        ->select('*')
        ->where('id', $id)
        ->first();

        if (!$recentUserData) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'message' => 'User model data not found, make sure to re-check the data again',
                'content' => null
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'message' => 'User model data has been successfully retrieve!',
                'content' => $recentUserData
            ], 200);
        }
    }

    public function getOneUserByUsername(string $username): JsonResponse
    {
        $recentUserData = User::with('role')
        ->select('*')
        ->where('username', $username)
        ->first();

        if (!$recentUserData) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'message' => 'User model data not found, make sure to re-check the data again',
                'content' => null
            ], 404);
        } else {
            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'message' => 'User model data has been successfully retrieve!',
                'content' => $recentUserData
            ], 200);
        }
    }

    public function updateRecentUser(UserRequest $userRequest, string $id): JsonResponse
    {
        $recentUserData = User::with('role')
        ->select('*')
        ->where('id', $id)
        ->first();

        if (!$recentUserData) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'message' => 'User model data not found, make sure to re-check the data again',
                'content' => null
            ], 404);
        } else {
            $validatedData = $userRequest->validated();

            $recentUserData->update([
                'role_id' => $validatedData['role_id'],
                'username' => $validatedData['username'],
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => $validatedData['password'],
                'password_confimation' => $validatedData['password_confimation'],
            ]);

            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'message' => 'User model data has been successfully retrieve!',
                'content' => $recentUserData
            ], 200);
        }
    }

    public function removeOneUserById(string $id): JsonResponse
    {
        $recentUserData = User::find($id);

        if (!$recentUserData) {
            return response()->json([
                'success' => false,
                'statusCode' => 404,
                'message' => 'User model data not found, make sure to re-check the data again',
                'content' => null
            ], 404);
        } else {
            $recentUserData->delete();

            return response()->json([
                'success' => true,
                'statusCode' => 200,
                'message' => 'User data has been successfully removed!',
            ], 200);
        }
    }
}