<?php

namespace App\Domain\UseCases\Wallet;

use Domain\Entities\Wallet;

interface ICreateWallet
{
    public function handle(Wallet $wallet): array;
}
