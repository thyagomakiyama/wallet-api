<?php

namespace Domain\UseCases\Transfer;

use Domain\Entities\User;
use Domain\Entities\Wallet;
use Domain\Repositories\AuthorizationTransferRepository;
use Domain\Repositories\NotificationRepository;
use Domain\Repositories\UserRepository;
use Domain\Repositories\WalletRepository;

abstract class Transfer implements ITransfer
{
    private UserRepository $userRepository;
    protected WalletRepository $walletRepository;
    protected NotificationRepository $notificationRepository;
    protected AuthorizationTransferRepository $authorizationTransferRepository;

    public function __construct(UserRepository $userRepository,
                                WalletRepository $walletRepository,
                                NotificationRepository $notificationRepository,
                                AuthorizationTransferRepository $authorizationTransferRepository)
    {
        $this->userRepository = $userRepository;
        $this->walletRepository = $walletRepository;
        $this->notificationRepository = $notificationRepository;
        $this->authorizationTransferRepository = $authorizationTransferRepository;
    }

    abstract public function handle(float $value, string $payerId, string $payeeId): array;

    protected function validatePayer(string $payerId): void
    {
        $payer = $this->userRepository->getById($payerId);

        if (!$payer)
            throw new \DomainException('Payer not found');

        if (strtoupper($payer->getType()) == User::SHOPKEEPER)
            throw new \DomainException('Shopkeeper type user cannot transfer');
    }

    private function getWallet(string $userId): Wallet
    {
        $wallet = $this->walletRepository->getByUserId($userId);

        if (!$wallet)
            throw new \DomainException('Wallet not found');

        return $wallet;
    }

    protected function withdraw(float $value, string $payerId): Wallet
    {
        $wallet = $this->getWallet($payerId);

        $wallet->withdraw($value);

        return $wallet;
    }

    protected function deposit(float $value, string $payeeId): Wallet
    {
        $wallet = $this->getWallet($payeeId);

        $wallet->deposit($value);

        return $wallet;
    }

    protected function commitTransfer(Wallet $payerWallet, Wallet $payeeWallet): void
    {
        $this->walletRepository->updateBalanceAfterTransfer($payerWallet->getId(), $payerWallet->getBalance(), $payeeWallet->getId(), $payeeWallet->getBalance());
    }
}
