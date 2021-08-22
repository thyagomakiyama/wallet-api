<?php

namespace Domain\UseCases\Transfer;

class SyncTransfer extends Transfer
{
    public function handle(float $value, string $payerId, string $payeeId): void
    {
        $this->validatePayer($payerId);

        if (!$this->authorizationTransferRepository->getAuthorization())
            throw new \DomainException('Transfer service not responding');

        $payerWallet = $this->withdraw($value, $payerId);
        $payeeWallet = $this->deposit($value, $payeeId);
        $this->commitTransfer($payerWallet, $payeeWallet);

        $this->notificationRepository->send(
            sprintf('User %s transfer %s to you', $payerId, $value),
            $payeeId
        );
    }
}
