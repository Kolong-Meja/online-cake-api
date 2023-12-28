<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterUserRequest $request): Response
    {
        $validatedData = $request->validated();

        $newUser = User::create([
            'role_id' => $validatedData['role_id'],
            'username' => $validatedData['username'],
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        event(new Registered($newUser));

        $jwtToken = Auth::login($newUser);

        Auth::user()->update([
            'last_login_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'status' => 'online',
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
}
