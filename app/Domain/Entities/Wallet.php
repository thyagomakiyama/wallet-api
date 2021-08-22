<?php

namespace Domain\Entities;

use Illuminate\Support\Str;

class Wallet
{
    private float $balance;
    private string $id;
    private string $userId;

    public function __construct(string $userId, float $balance = 0.0, string $id = null)
    {
        $this->id = empty($id) ? Str::uuid()->toString() : $id;
        $this->userId = $userId;
        $this->balance = $balance;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'balance' => $this->balance,
            'userId' => $this->userId
        ];
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function withdraw(float $value): void
    {
        if ($value <= 0)
            throw new \DomainException('Withdraw value less than zero');

        if ($this->balance < $value)
            throw new \DomainException('Insufficient balance');

        $this->balance = $this->balance - $value;
    }

    public function deposit(float $value): void
    {
        if ($value <= 0)
            throw new \DomainException('Deposit value less than zero');

        $this->balance = $this->balance + $value;
    }
}
