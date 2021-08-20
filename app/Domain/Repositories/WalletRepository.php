<?php

namespace Domain\Repositories;

use Domain\Entities\Wallet;

interface WalletRepository
{
    public function save(Wallet $wallet): void;
    public function getById(string $id): ?Wallet;
}
