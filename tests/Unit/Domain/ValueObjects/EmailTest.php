<?php

namespace Unit\Domain\ValueObjects;

use Domain\ValueObjects\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testEmailShouldBeValid()
    {
        $email = new Email('email@email.com');

        $this->assertEquals('email@email.com', $email);
    }

    public function testEmailShouldBeInvalid()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Invalid email');

        new Email('invalidEmail');
    }
}
