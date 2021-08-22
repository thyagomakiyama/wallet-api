<?php

namespace Application\DTO;

use Domain\Entities\User;
use Domain\ValueObjects\CNPJ;
use Domain\ValueObjects\CPF;
use Domain\ValueObjects\Email;
use Illuminate\Http\Request;

class UserDTO
{
    private User $user;

    public function __construct(Request $request)
    {
        $this->user = $this->build($request);
    }

    private function build(Request $request): User
    {
        return $request->get('user_type') == User::SHOPKEEPER ?
            new User($request->get('name'), new CNPJ($request->get('document_number')), new Email($request->get('email')), $request->get('password'), $request->get('user_type')) :
            new User($request->get('name'), new CPF($request->get('document_number')), new Email($request->get('email')), $request->get('password'), $request->get('user_type'));
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
