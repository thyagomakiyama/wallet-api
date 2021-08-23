<?php

namespace App\Infrastructure\Repositories;

use Domain\Entities\User;
use Domain\Repositories\UserRepository as InterfaceRepository;
use Domain\ValueObjects\CNPJ;
use Domain\ValueObjects\CPF;
use Domain\ValueObjects\Email;
use Infrastructure\Models\User as Model;

class UserRepository implements InterfaceRepository
{

    public function save(User $user): void
    {
        $model = new Model();

        $model->fill($user->toArray());

        $model->save();
    }

    public function getByEmail(Email $email): ?User
    {
        $user = Model::where('email', (string) $email)->first();

        if (!$user) {
            return null;
        }

        return $this->toUser($user->toArray());
    }

    public function getById(string $id): ?User
    {
        $user = Model::where('id', $id)->first();

        if (!$user) {
            return null;
        }

        return $this->toUser($user->toArray());
    }

    private function toUser(array $user): User
    {
        return $user['user_type'] == User::SHOPKEEPER ?
            new User($user['name'], new CNPJ($user['document_number']), new Email($user['email']), $user['password'], $user['user_type']) :
            new User($user['name'], new CPF($user['document_number']), new Email($user['email']), $user['password'], $user['user_type']);
    }
}
