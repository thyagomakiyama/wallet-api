<?php

namespace Domain\UseCases\Transfer;

interface ITransfer
{
    public function handle(float $value, string $payerId, string $payeeId): array;
}
