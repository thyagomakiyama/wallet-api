<?php

namespace App\Infrastructure\Repositories;

use Domain\Entities\User;
use Domain\ValueObjects\Email;

class UserRepository implements \Domain\Repositories\UserRepository
{

    public function save(User $user): void
    {
    }

    public function getByEmail(Email $email): ?User
    {
        return null;
    }

    public function getById(string $id): ?User
    {
        return null;
    }
}
