<?php

namespace Application\Http\Controllers;

use Domain\UseCases\Transfer\ITransfer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransferController
{
    private ITransfer $useCase;

    public function __construct(ITransfer $useCase)
    {
        $this->useCase = $useCase;
    }

    public function handle(Request $request): JsonResponse
    {
        try {
            $payeeId = $request->get('payee');
            $payerId = $request->get('payer');
            $value = $request->get('value');

            $response = $this->useCase->handle($value, $payerId, $payeeId);

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
