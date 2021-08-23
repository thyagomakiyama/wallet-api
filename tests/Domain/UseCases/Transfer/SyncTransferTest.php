<?php

namespace Domain\UseCases\Transfer;

use Domain\Entities\User;
use Domain\Entities\Wallet;
use Domain\Repositories\AuthorizationTransferRepository;
use Domain\Repositories\NotificationRepository;
use Domain\Repositories\UserRepository;
use Domain\Repositories\WalletRepository;
use Domain\ValueObjects\CPF;
use Domain\ValueObjects\Email;
use PHPUnit\Framework\TestCase;

class SyncTransferTest extends TestCase
{
    private User $userCommon;
    private User $userShopkeeper;
    private Wallet $userCommonWallet;
    private Wallet $userShopkeeperWallet;
    private NotificationRepository $notificationRepository;
    private AuthorizationTransferRepository $authorizationTransferRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userCommon = new User('Thyago Makiyama', new CPF('40227300050'),  new Email('thyago@gmail.com'), 'password', 'common');
        $this->userShopkeeper = new User('Ana Makiyama', new CPF('43747015085'),  new Email('ana@gmail.com'), 'password', 'shopkeeper');

        $this->userCommonWallet = new Wallet($this->userCommon->getId(), 100.00);
        $this->userShopkeeperWallet = new Wallet($this->userShopkeeper->getId());

        $this->notificationRepository = \Mockery::mock(NotificationRepository::class);
        $this->notificationRepository->shouldReceive('send')->andReturn(null);

        $this->authorizationTransferRepository = \Mockery::mock(AuthorizationTransferRepository::class);
        $this->authorizationTransferRepository->shouldReceive('getAuthorization')->andReturn(true);
    }

    public function testTransferShouldBeSuccess()
    {
        $walletRepository = \Mockery::mock(WalletRepository::class);
        $walletRepository->shouldReceive('getByUserId')->with($this->userCommon->getId())->andReturn($this->userCommonWallet);
        $walletRepository->shouldReceive('getByUserId')->with($this->userShopkeeper->getId())->andReturn($this->userShopkeeperWallet);
        $walletRepository->shouldReceive('updateBalanceAfterTransfer')->andReturn(null);

        $userRepository = \Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getById')->with($this->userCommon->getId())->andReturn($this->userCommon);

        $useCase = new SyncTransfer($userRepository, $walletRepository, $this->notificationRepository, $this->authorizationTransferRepository);
        $response = $useCase->handle(50.0, $this->userCommon->getId(), $this->userShopkeeper->getId());

        $this->assertEquals(50.0, $this->userCommonWallet->getBalance());
        $this->assertEquals(50.0, $this->userShopkeeperWallet->getBalance());
        $this->assertEquals(['message' => 'success'], $response);
    }

    public function testErrorTransferWhenPayerIsShopkeeper()
    {
        $walletRepository = \Mockery::mock(WalletRepository::class);

        $userRepository = \Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getById')->andReturn($this->userShopkeeper);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Shopkeeper type user cannot transfer');

        $useCase = new SyncTransfer($userRepository, $walletRepository, $this->notificationRepository, $this->authorizationTransferRepository);
        $useCase->handle(50.0, $this->userShopkeeper->getId(), $this->userCommon->getId());
    }

    public function testErrorTransferWhenPayerNotFound()
    {
        $walletRepository = \Mockery::mock(WalletRepository::class);

        $userRepository = \Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getById')->andReturn(null);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Payer not found');

        $useCase = new SyncTransfer($userRepository, $walletRepository, $this->notificationRepository, $this->authorizationTransferRepository);
        $useCase->handle(50.0, $this->userCommon->getId(), $this->userShopkeeper->getId());
    }

    public function testErrorTransferWhenAuthorizationServiceNotResponding()
    {
        $walletRepository = \Mockery::mock(WalletRepository::class);

        $userRepository = \Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getById')->with($this->userCommon->getId())->andReturn($this->userCommon);

        $authorizationTransferRepository = \Mockery::mock(AuthorizationTransferRepository::class);
        $authorizationTransferRepository->shouldReceive('getAuthorization')->andReturn(false);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Transfer service not responding');

        $useCase = new SyncTransfer($userRepository, $walletRepository, $this->notificationRepository, $authorizationTransferRepository);
        $useCase->handle(50.0, $this->userCommon->getId(), $this->userShopkeeper->getId());
    }

    public function testErrorTransferWhenPayerWalletNotFound()
    {
        $walletRepository = \Mockery::mock(WalletRepository::class);
        $walletRepository->shouldReceive('getByUserId')->with($this->userCommon->getId())->andReturn(null);

        $userRepository = \Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getById')->with($this->userCommon->getId())->andReturn($this->userCommon);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Wallet not found');

        $useCase = new SyncTransfer($userRepository, $walletRepository, $this->notificationRepository, $this->authorizationTransferRepository);
        $useCase->handle(50.0, $this->userCommon->getId(), $this->userShopkeeper->getId());
    }

    public function testErrorTransferWhenPayeeWalletNotFound()
    {
        $walletRepository = \Mockery::mock(WalletRepository::class);
        $walletRepository->shouldReceive('getByUserId')->with($this->userCommon->getId())->andReturn($this->userCommonWallet);
        $walletRepository->shouldReceive('getByUserId')->with($this->userShopkeeper->getId())->andReturn(null);
        $walletRepository->shouldReceive('updateBalance')->andReturn(null);

        $userRepository = \Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getById')->with($this->userCommon->getId())->andReturn($this->userCommon);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Wallet not found');

        $useCase = new SyncTransfer($userRepository, $walletRepository, $this->notificationRepository, $this->authorizationTransferRepository);
        $useCase->handle(50.0, $this->userCommon->getId(), $this->userShopkeeper->getId());
    }
}
