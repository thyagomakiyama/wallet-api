<?php

namespace Domain\ValueObjects;

use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testEmailShouldBeValid()
    {
        $email = new Email('email@email.com');

        $this->assertEquals($email, 'email@email.com');
    }

    public function testEmailShouldBeInvalid()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Invalid email');

        new Email('invalidEmail');
    }
}
