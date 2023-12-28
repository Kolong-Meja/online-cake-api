<?php

namespace App\Interfaces;
use App\Http\Requests\Api\RegisterUserRequest;
use App\Http\Requests\Api\UserRequest;
use Illuminate\Http\JsonResponse;

interface UserInterface {
    public function getAllUsers(): JsonResponse;

    public function getOneUserById(string $id): JsonResponse;

    public function getOneUserByUsername(string $username): JsonResponse;

    public function updateRecentUser(UserRequest $userRequest, string $id): JsonResponse;

    public function removeOneUserById(string $id): JsonResponse;
}