<?php

namespace App\Providers;

use App\Enums\UserStatusActivity;
use App\Interfaces\CakeInterface;
use App\Interfaces\CartInterface;
use App\Interfaces\RoleInterface;
use App\Interfaces\UserInterface;
use App\Repositories\CakeRepository;
use App\Repositories\CartRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RoleInterface::class, RoleRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(CakeInterface::class, CakeRepository::class);
        $this->app->bind(CartInterface::class, CartRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
