<?php

namespace Domain\Repositories;

use Domain\Entities\User;
use Domain\ValueObjects\Email;

interface UserRepository
{
    public function save(User $user): void;
    public function getByEmail(Email $email): ?User;
    public function getById(string $id): ?User;
}
