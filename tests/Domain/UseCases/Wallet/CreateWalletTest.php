<?php

namespace Domain\UseCases\Wallet;

use Domain\Entities\User;
use Domain\Entities\Wallet;
use Domain\Repositories\WalletRepository;
use Domain\ValueObjects\CPF;
use Domain\ValueObjects\Email;
use PHPUnit\Framework\TestCase;

class CreateWalletTest extends TestCase
{
    private Wallet $wallet;

    protected function setUp(): void
    {
        parent::setUp();

        $user = new User('Thyago Makiyama', new CPF('40227300050'),  new Email('thyago@gmail.com'), 'password', 'common');
        $userId = $user->getId();

        $this->wallet = new Wallet($userId);
    }

    public function testCreateWalletShouldBeSuccess()
    {
        $repository = \Mockery::mock(WalletRepository::class);
        $repository->shouldReceive('getById')->andReturns(null);
        $repository->shouldReceive('save')->andReturn(null);

        $useCase = new CreateWallet($repository);
        $response = $useCase->handle($this->wallet);

        $this->assertArrayHasKey('message', $response);
        $this->assertEquals($response['message'], 'success');
    }

    public function testCreateWalletWhenAlreadyRegistered()
    {
        $repository = \Mockery::mock(WalletRepository::class);
        $repository->shouldReceive('getById')->andReturns($this->wallet);
        $repository->shouldReceive('save')->andReturn(null);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Wallet already registered');

        $useCase = new CreateWallet($repository);
        $useCase->handle($this->wallet);
    }
}
