<?php

namespace Domain\Entities;

use Domain\ValueObjects\CPF;
use Domain\ValueObjects\Email;
use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase
{
    private string $userId;

    protected function setUp(): void
    {
        parent::setUp();

        $user = new User('Thyago Makiyama', new CPF('40227300050'),  new Email('thyago@gmail.com'), 'password', 'common');
        $this->userId = $user->getId();
    }

    public function testWithdrawWhenSuccess()
    {
        $wallet = new Wallet($this->userId, 100.0);
        $wallet->withdraw(50.0);

        $this->assertEquals($wallet->getBalance(), 50.0);
    }

    public function testWithdrawWhenInsufficientBalance()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Insufficient balance');

        $wallet = new Wallet($this->userId);
        $wallet->withdraw(50.0);
    }

    public function testDepositWhenSuccess()
    {
        $wallet = new Wallet($this->userId);
        $wallet->deposit(50.0);

        $this->assertEquals($wallet->getBalance(), 50.0);
    }

    public function testDepositWhenValueLessThenZero()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Deposit value less than zero');

        $wallet = new Wallet($this->userId);
        $wallet->deposit(-1.0);
    }

    public function testWithdrawWhenValueLessThenZero()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Withdraw value less than zero');

        $wallet = new Wallet($this->userId);
        $wallet->withdraw(0.0);
    }
}
