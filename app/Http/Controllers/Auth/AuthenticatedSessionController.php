<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): Response
    {
        $jwtToken = $request->authenticate();

        $request->session()->regenerate();

        $token = $request->user()->createToken('auth_token')->plaintTextToken;

        $request->user()->update([
            'last_login_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'status' => 'online'
        ]);

        $authUserName = Auth::user()->name;

        return response()->json([
            'success' => true,
            'statusCode' => 201,
            'message' => "Welcome back $authUserName",
            'access_token' => [
                'token' => $jwtToken,
                'type' => 'Bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ]
        ], 201);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        $request->user()->update([
            'status' => 'offline'
        ]);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'See you again!'
        ], 200);
    }
}
