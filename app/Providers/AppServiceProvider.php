<?php

namespace Provider;

use Domain\Repositories\AuthorizationTransferRepository;
use Domain\Repositories\NotificationRepository;
use Domain\UseCases\Transfer\ITransfer;
use Domain\UseCases\Transfer\SyncTransfer;
use Domain\UseCases\Wallet\ICreateWallet;
use Domain\Repositories\UserRepository;
use Domain\Repositories\WalletRepository;
use Domain\UseCases\User\CreateUser;
use Domain\UseCases\User\ICreateUser;
use Domain\UseCases\Wallet\CreateWallet;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Repositories\AuthorizationTransferAPI;
use Infrastructure\Repositories\NotificationAPI;

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
        $this->app->bind(UserRepository::class, \Infrastructure\Repositories\UserRepository::class);
        $this->app->bind(ICreateWallet::class, CreateWallet::class);
        $this->app->bind(WalletRepository::class, \Infrastructure\Repositories\WalletRepository::class);
        $this->app->bind(ITransfer::class, SyncTransfer::class);
        $this->app->bind(NotificationRepository::class, NotificationAPI::class);
        $this->app->bind(AuthorizationTransferRepository::class, AuthorizationTransferAPI::class);
    }
}
