<?php

namespace Domain\Repositories;

use Domain\Entities\Wallet;

interface WalletRepository
{
    public function save(Wallet $wallet): void;
    public function getById(string $id): ?Wallet;
    public function getByUserId(string $userId): ?Wallet;
    public function updateBalance(string $walletId, float $balance): void;
}
