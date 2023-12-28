<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterUserRequest;
use App\Http\Requests\Api\UserRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Interfaces\UserInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserInterface $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return $this->userInterface->getAllUsers();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return $this->userInterface->getOneUserById($id);
    }

    public function showByUsername(string $username): JsonResponse
    {
        return $this->userInterface->getOneUserByUsername($username);
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        return $this->userInterface->registerNewAccount($request);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->userInterface->loginAccount($request);
    }

    public function logout(Request $request): JsonResponse
    {
        return $this->userInterface->logoutAccount($request);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id): JsonResponse
    {
        return $this->userInterface->updateRecentUser($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        return $this->userInterface->removeOneUserById($id);
    }
}
