<?php

namespace Domain\ValueObjects;

use Faker\Factory;
use PHPUnit\Framework\TestCase;

class CNPJTest extends TestCase
{
    public function testCNPJShouldBeValid()
    {
        $faker = Factory::create('pt_BR');
        $cpf = preg_replace('/[^0-9]/', '', $faker->cnpj());

        $document = new CNPJ($cpf);

        $this->assertEquals($document, $cpf);
    }

    public function testCNPJShouldBeInvalid()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Invalid document number');

        new CNPJ('123456789');
    }
}
