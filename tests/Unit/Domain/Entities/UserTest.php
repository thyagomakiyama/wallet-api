<?php

namespace Unit\Domain\Entities;

use Domain\Entities\User;
use Domain\ValueObjects\CPF;
use Domain\ValueObjects\Email;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testUserShouldBeValid()
    {
        $user = new User('Thyago Makiyama', new CPF('40227300050'),  new Email('thyago@gmail.com'), 'password', 'common');

        $user = $user->toArray();

        $this->assertIsArray($user);
        $this->assertNotEmpty($user['id']);
    }
}
