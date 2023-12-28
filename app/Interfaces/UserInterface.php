<?php

namespace App\Interfaces;
use App\Http\Requests\Api\RegisterUserRequest;
use App\Http\Requests\Api\UserRequest;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

interface UserInterface {
    public function getAllUsers(): JsonResponse;

    public function getOneUserById(string $id): JsonResponse;

    public function getOneUserByUsername(string $username): JsonResponse;

    public function registerNewAccount(RegisterUserRequest $request): JsonResponse;

    public function loginAccount(LoginRequest $request): JsonResponse;

    public function logoutAccount(Request $request): JsonResponse;

    public function updateRecentUser(UserRequest $userRequest, string $id): JsonResponse;

    public function removeOneUserById(string $id): JsonResponse;
}