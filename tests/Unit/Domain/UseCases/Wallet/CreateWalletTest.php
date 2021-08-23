<?php

namespace Unit\Domain\UseCases\Wallet;

use Domain\Entities\User;
use Domain\Entities\Wallet;
use Domain\Repositories\UserRepository;
use Domain\Repositories\WalletRepository;
use Domain\UseCases\Wallet\CreateWallet;
use Domain\ValueObjects\CPF;
use Domain\ValueObjects\Email;
use PHPUnit\Framework\TestCase;

class CreateWalletTest extends TestCase
{
    private Wallet $wallet;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = new User('Thyago Makiyama', new CPF('40227300050'),  new Email('thyago@gmail.com'), 'password', 'common');
        $userId = $this->user->getId();

        $this->wallet = new Wallet($userId);
    }

    public function testCreateWalletShouldBeSuccess()
    {
        $repository = \Mockery::mock(WalletRepository::class);
        $repository->shouldReceive('getById')->andReturns(null);
        $repository->shouldReceive('save')->andReturn(null);

        $userRepository = \Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getById')->andReturns($this->user);

        $useCase = new CreateWallet($repository, $userRepository);
        $response = $useCase->handle($this->wallet);

        $this->assertArrayHasKey('message', $response);
        $this->assertEquals('success', $response['message']);
    }

    public function testCreateWalletWhenAlreadyRegistered()
    {
        $repository = \Mockery::mock(WalletRepository::class);
        $repository->shouldReceive('getById')->andReturns($this->wallet);
        $repository->shouldReceive('save')->andReturn(null);

        $userRepository = \Mockery::mock(UserRepository::class);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Wallet already registered');

        $useCase = new CreateWallet($repository, $userRepository);
        $useCase->handle($this->wallet);
    }

    public function testCreateWalletWhenUserNotFound()
    {
        $repository = \Mockery::mock(WalletRepository::class);
        $repository->shouldReceive('getById')->andReturns(null);
        $repository->shouldReceive('save')->andReturn(null);

        $userRepository = \Mockery::mock(UserRepository::class);
        $userRepository->shouldReceive('getById')->andReturns(null);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('User not found for this wallet');

        $useCase = new CreateWallet($repository, $userRepository);
        $useCase->handle($this->wallet);
    }
}
