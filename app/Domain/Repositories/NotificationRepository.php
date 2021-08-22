<?php

namespace Domain\Repositories;

interface NotificationRepository
{
    public function send(string $message, string $payeeId): void;
}
