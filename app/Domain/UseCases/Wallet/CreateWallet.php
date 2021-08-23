<?php

namespace Domain\UseCases\Wallet;

use Domain\Repositories\UserRepository;
use Domain\UseCases\Wallet\ICreateWallet;
use Domain\Entities\Wallet;
use Domain\Repositories\WalletRepository;

class CreateWallet implements ICreateWallet
{
    private WalletRepository $repository;
    private UserRepository $userRepository;

    public function __construct(WalletRepository $repository, UserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    public function handle(Wallet $wallet): array
    {
        if ($this->repository->getById($wallet->getId()))
            throw new \DomainException('Wallet already registered');

        if (!$this->userRepository->getById($wallet->getUserId()))
            throw new \DomainException('User not found for this wallet');

        $this->repository->save($wallet);

        return [
            'message' => 'success',
            'wallet' => $wallet->toArray()
        ];
    }
}
