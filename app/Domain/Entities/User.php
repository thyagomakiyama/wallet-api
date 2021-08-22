<?php

namespace Domain\Entities;

use Domain\ValueObjects\Document;
use Domain\ValueObjects\Email;
use Illuminate\Support\Str;

class User
{
    const SHOPKEEPER = 'SHOPKEEPER';
    const COMMON = 'COMMON';

    private string $id;
    private string $name;
    private Document $documentNumber;
    private Email $email;
    private string $password;
    private string $userType;

    /**
     * @param string|null $id
     * @param string $name
     * @param Document $documentNumber
     * @param Email $email
     * @param string $password
     * @param string $userType
     */
    public function __construct(string $name, Document $documentNumber, Email $email, string $password, string $userType, string $id = null)
    {
        if (strtoupper($userType) != self::COMMON && strtoupper($userType) != self::SHOPKEEPER)
            throw new \DomainException('Invalid user type');

        $this->id = empty($id) ? Str::uuid()->toString() : $id;
        $this->name = $name;
        $this->documentNumber = $documentNumber;
        $this->email = $email;
        $this->password = md5($password);
        $this->userType = $userType;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'document_number' => (string) $this->documentNumber,
            'user_type' => $this->userType,
            'email' => (string) $this->email,
            'password' => $this->password
        ];
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->userType;
    }

}
