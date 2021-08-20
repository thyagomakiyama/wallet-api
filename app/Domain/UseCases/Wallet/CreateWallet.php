<?php

namespace Domain\UseCases\Wallet;

use Domain\Entities\Wallet;
use Domain\Repositories\WalletRepository;

class CreateWallet
{
    private WalletRepository $repository;

    public function __construct(WalletRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(Wallet $wallet): array
    {
        if ($this->repository->getById($wallet->getId()))
            throw new \DomainException('Wallet already registered');

        $this->repository->save($wallet);

        return [
            'message' => 'success',
            'wallet' => $wallet->toArray()
        ];
    }
}
