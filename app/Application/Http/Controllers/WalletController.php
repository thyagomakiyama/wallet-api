<?php

namespace Application\Http\Controllers;

use Application\DTO\WalletDTO;
use Domain\UseCases\Wallet\ICreateWallet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    private ICreateWallet $useCase;

    public function __construct(ICreateWallet $useCase)
    {
        $this->useCase = $useCase;
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $wallet = new WalletDTO($request);

            $response = $this->useCase->handle($wallet->getWallet());

            return response()->json($response);
        } catch (\DomainException $exception) {
            $data = [
                'message' => $exception->getMessage()
            ];

            return response()->json($data, 422);
        } catch (\Exception $exception) {
            $data = [
                'message' => $exception->getMessage()
            ];

            return response()->json($data, 400);
        }
    }

}
