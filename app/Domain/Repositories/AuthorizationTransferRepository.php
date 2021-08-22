<?php

namespace Domain\Repositories;

interface AuthorizationTransferRepository
{
    public function getAuthorization(): bool;
}
