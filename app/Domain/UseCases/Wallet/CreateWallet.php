<?php

namespace Domain\UseCases\Wallet;

use App\Domain\UseCases\Wallet\ICreateWallet;
use Domain\Entities\Wallet;
use Domain\Repositories\WalletRepository;

class CreateWallet implements ICreateWallet
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

        if (!$this->repository->getByUserId($wallet->getUserId()))
            throw new \DomainException('User not found for this wallet');

        $this->repository->save($wallet);

        return [
            'message' => 'success',
            'wallet' => $wallet->toArray()
        ];
    }
}
