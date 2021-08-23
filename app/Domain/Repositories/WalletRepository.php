<?php

namespace Domain\Repositories;

use Domain\Entities\Wallet;

interface WalletRepository
{
    public function save(Wallet $wallet): void;
    public function getById(string $id): ?Wallet;
    public function getByUserId(string $userId): ?Wallet;
    public function updateBalanceAfterTransfer(string $walletPayer, float $balancePayer, string $walletPayee, float $balancePayee): void;
}
