<?php

namespace App\Repositories;

use App\Enums\UserStatusActivity;
use App\Http\Requests\Api\RegisterUserRequest;
use App\Http\Requests\Api\UserRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Interfaces\UserInterface;
use App\Models\User;
use App\Utils\CheckRole;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserRepository implements UserInterface {
    private const REQUIRED_ROLE = ["customer", "admin"];

    public function getAllUsers(): JsonResponse
    {
        if (!in_array(CheckRole::authUserRole(), self::REQUIRED_ROLE)) {
            return response()->json([
                'success' => false,
                'statusCode' => 403,
                'message' => "Access denied! you don't have the required role, customer and admin",
                'content' => null
            ], 403);
        }

        $users = User::with(['role', 'carts'])->get();

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
        if (!in_array(CheckRole::authUserRole(), self::REQUIRED_ROLE)) {
            return response()->json([
                'success' => false,
                'statusCode' => 403,
                'message' => "Access denied! you don't have the required role, customer and admin",
                'content' => null
            ], 403);
        }

        $recentUserData = User::with(['role', 'carts'])
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
        if (!in_array(CheckRole::authUserRole(), self::REQUIRED_ROLE)) {
            return response()->json([
                'success' => false,
                'statusCode' => 403,
                'message' => "Access denied! you don't have the required role, customer and admin",
                'content' => null
            ], 403);
        }
        
        $recentUserData = User::with(['role', 'carts'])
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

    public function registerNewAccount(RegisterUserRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $newUser = User::create([
            'role_id' => $validatedData['role_id'],
            'username' => $validatedData['username'],
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
            'address' => $validatedData['address'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $jwtToken = JWTAuth::fromUser($newUser);

        $newUser->update([
            'last_login_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'status' => UserStatusActivity::ONLINE,
        ]);

        return response()->json([
            'success' => true,
            'statusCode' => 201,
            'message' => "Welcome $newUser->name",
            'content' => [
                'data' => $newUser->only(['id', 'name', 'email']),
                'access_token' => [
                    'token' => $jwtToken,
                    'type' => 'Bearer',
                    'expires_in' => auth()->factory()->getTTL() * 60,
                ]
            ]
        ], 201);
    }

    public function loginAccount(LoginRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $jwtToken = auth()->attempt([
            'username' => $validatedData['username'],
            'password' => $validatedData['password'],
        ]);

        $request->user()->update([
            'last_login_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'status' => UserStatusActivity::ONLINE,
        ]);

        $authUserName = Auth::user()->name;

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => "Welcome back $authUserName",
            'access_token' => [
                'token' => $jwtToken,
                'type' => 'Bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ]
        ], 200);
    }

    public function logoutAccount(Request $request): JsonResponse
    {
        $request->user()->update([
            'status' => UserStatusActivity::OFFLINE,
        ]);
        
        $jwtToken = JWTAuth::getToken();

        JWTAuth::invalidate($jwtToken);

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => "See ya!",
            'content' => null
        ]);
    }

    public function updateRecentUser(UserRequest $userRequest, string $id): JsonResponse
    {
        if (CheckRole::authUserRole() !== self::REQUIRED_ROLE[1]) {
            return response()->json([
                'success' => false,
                'statusCode' => 403,
                'message' => "Access denied! you don't have the required role ". self::REQUIRED_ROLE[1],
                'content' => null
            ], 403);
        }

        $recentUserData = User::findOrFail($id);

        $validatedData = $userRequest->validated();

        $recentUserData->update([
            'role_id' => $validatedData['role_id'],
            'username' => $validatedData['username'],
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone_number' => $validatedData['phone_number'],
            'address' => $validatedData['address'],
            'password' => $validatedData['password'],
        ]);

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'User model data has been successfully updated!',
            'content' => $recentUserData
        ], 200);
    }

    public function removeOneUserById(string $id): JsonResponse
    {
        if (CheckRole::authUserRole() !== self::REQUIRED_ROLE[1]) {
            return response()->json([
                'success' => false,
                'statusCode' => 403,
                'message' => "Access denied! you don't have the required role ". self::REQUIRED_ROLE[1],
                'content' => null
            ], 403);
        }
        
        $recentUserData = User::findOrFail($id);

        $recentUserData->delete();
        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'User data has been successfully removed!',
            'content' => null,
        ], 200);
    }
}