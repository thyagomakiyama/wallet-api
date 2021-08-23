<?php

namespace Unit\Domain\ValueObjects;

use Domain\ValueObjects\CPF;
use Faker\Factory;
use PHPUnit\Framework\TestCase;

class CPFTest extends TestCase
{
    public function testCPFShouldBeValid()
    {
        $faker = Factory::create('pt_BR');
        $cpf = preg_replace('/[^0-9]/', '', $faker->cpf());

        $document = new CPF($cpf);

        $this->assertEquals($document, $cpf);
    }

    public function testCPFShouldBeInvalid()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Invalid document number');

        new CPF('123456789');
    }
}
