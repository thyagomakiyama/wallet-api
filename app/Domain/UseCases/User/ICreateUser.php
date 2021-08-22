<?php

namespace Domain\UseCases\User;

use Domain\Entities\User;

interface ICreateUser
{
    public function handle(User $user):array;
}
