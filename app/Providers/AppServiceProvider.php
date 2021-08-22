<?php

namespace App\Providers;

use Domain\Repositories\UserRepository;
use Domain\UseCases\User\CreateUser;
use Domain\UseCases\User\ICreateUser;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ICreateUser::class, CreateUser::class);
        $this->app->bind(UserRepository::class, \App\Infrastructure\Repositories\UserRepository::class);
    }
}
