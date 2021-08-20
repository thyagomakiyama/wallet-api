<?php

namespace Domain\UseCases\User;

use Domain\Entities\User;
use Domain\Repositories\UserRepository;

class CreateUser
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(User $user): array
    {
        if ($this->repository->getByEmail($user->getEmail()))
            throw new \DomainException('User already be registered');

        $this->repository->save($user);

        return [
            'message' => 'success',
            'user' => $user->toArray()
        ];
    }
}
