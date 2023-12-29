<?php

use App\Http\Controllers\Api\CakeController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\UserController;
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
    Route::post('/register', [UserController::class, 'register'])
    ->middleware('guest')
    ->name('auth.register');
    
    Route::post('/login', [UserController::class, 'login'])
    ->middleware('guest')
    ->name('auth.login');

    Route::post('/logout', [UserController::class, 'logout'])
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
Route::prefix('v1')->middleware(['auth:api'])->group(function () {
    // for users route purpose
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/users/username/{username}', [UserController::class, 'showByUsername'])->name('user.username');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('user.delete');

    // for cakes route purpose
    Route::get('/cakes', [CakeController::class, 'index'])->name('cake.index');
    Route::get('/cakes/{id}', [CakeController::class, 'show'])->name('cake.show');
    Route::get('/cakes/name/{name}', [CakeController::class, 'showByName'])->name('cake.name');
    Route::post('/cakes', [CakeController::class, 'store'])->name('cake.store');
    Route::put('/cakes/{id}', [CakeController::class, 'update'])->name('cake.update');
    Route::delete('/cakes/{id}', [CakeController::class, 'destroy'])->name('cake.delete');

    // for carts route purpose
    Route::get('/carts', [CartController::class, 'index'])->name('cart.index');
    Route::get('/carts/{id}', [CartController::class, 'show'])->name('cart.show');
    Route::post('/carts', [CartController::class, 'store'])->name('cart.store');
    Route::put('/carts/{id}', [CartController::class, 'update'])->named('cart.update');
    Route::delete('/carts/{id}', [CartController::class, 'destroy'])->name('cart.delete');
});
