<?php

use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// for authentication purpose
Route::prefix('v1/auth')->group(function () {
    Route::post('/register', [UserController::class, 'store'])
    ->middleware('guest')
    ->name('auth.register');
                
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('auth.login');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:api')
    ->name('auth.logout');
});

// for role route purpose
Route::prefix('v1')->middleware('guest')->group(function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('role.index');
    Route::get('/roles/{id}', [RoleController::class, 'show'])->name('role.show');
    Route::post('/roles', [RoleController::class, 'store'])->name('role.store');
    Route::put('/roles/{id}', [RoleController::class, 'update'])->name('role.update');
    Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('role.delete');
});

// for admin purpose
Route::prefix('v1/admin')->middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/users/username/{username}', [UserController::class, 'showByUsername'])->name('user.username');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.delete');
});
