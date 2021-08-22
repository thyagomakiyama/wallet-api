<?php

namespace Application\Http\Controllers;

use Application\DTO\UserDTO;
use Domain\UseCases\User\ICreateUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    private ICreateUser $useCase;

    public function __construct(ICreateUser $useCase)
    {
        $this->useCase = $useCase;
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $user = new UserDTO($request);

            $response = $this->useCase->handle($user->getUser());

            return response()->json($response);
        } catch (\DomainException $exception) {
            $data = [
                'message' => $exception->getMessage()
            ];

            return response()->json($data, 422);
        }
    }
}
