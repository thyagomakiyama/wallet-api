<?php

namespace Domain\UseCases\User;

use Domain\Entities\User;
use Domain\Repositories\UserRepository;
use Domain\ValueObjects\CPF;
use Domain\ValueObjects\Email;
use PHPUnit\Framework\TestCase;

class CreateUserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = new User('Thyago Makiyama', new CPF('40227300050'),  new Email('thyago@gmail.com'), 'password', 'common');
    }

    public function testCreateUserShouldBeSuccess()
    {
        $repository = \Mockery::mock(UserRepository::class);
        $repository->shouldReceive('getByEmail')->andReturns(null);
        $repository->shouldReceive('save')->andReturn(null);

        $useCase = new CreateUser($repository);
        $response = $useCase->handle($this->user);

        $this->assertArrayHasKey('message', $response);
        $this->assertEquals($response['message'], 'success');
    }

    public function testCreateUserWhenEmailAlreadyRegistered()
    {
        $repository = \Mockery::mock(UserRepository::class);
        $repository->shouldReceive('getByEmail')->andReturns($this->user);
        $repository->shouldReceive('save')->andReturn(null);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('User already be registered');

        $useCase = new CreateUser($repository);
        $useCase->handle($this->user);
    }
}
