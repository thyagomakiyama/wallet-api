<?php

namespace App\Infrastructure\Repositories;

use Domain\Entities\Wallet;

class WalletRepository implements \Domain\Repositories\WalletRepository
{

    public function save(Wallet $wallet): void
    {
        // TODO: Implement save() method.
    }

    public function getById(string $id): ?Wallet
    {
        return null;
    }

    public function getByUserId(string $userId): ?Wallet
    {
        return null;
    }

    public function updateBalance(string $walletId, float $balance): void
    {
        // TODO: Implement updateBalance() method.
    }
}
