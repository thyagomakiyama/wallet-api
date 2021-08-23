<?php

namespace Infrastructure\Repositories;

use Domain\Entities\Wallet;
use Domain\Repositories\WalletRepository as InterfaceRepository;
use Infrastructure\Models\Wallet as Model;

class WalletRepository implements InterfaceRepository
{

    public function save(Wallet $wallet): void
    {
        $model = new Model();

        $model->fill($wallet->toArray());

        $model->save();
    }

    public function getById(string $id): ?Wallet
    {
        $wallet = Model::where('id', $id)->first();

        if (!$wallet) {
            return null;
        }

        return $this->toWallet($wallet->toArray());
    }

    public function getByUserId(string $userId): ?Wallet
    {
        $wallet = Model::where('user_id', $userId)->first();

        if (!$wallet) {
            return null;
        }

        return $this->toWallet($wallet->toArray());
    }

    public function updateBalance(string $walletId, float $balance): void
    {
        // TODO: Implement updateBalance() method.
    }

    private function toWallet(array $wallet): Wallet
    {
        return new Wallet($wallet['user_id'], $wallet['balance'], $wallet['id']);
    }
}
