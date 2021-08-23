<?php

namespace Infrastructure\Repositories;

use Domain\Repositories\AuthorizationTransferRepository;
use Illuminate\Support\Facades\Log;

class AuthorizationTransferAPI implements AuthorizationTransferRepository
{

    public function getAuthorization(): bool
    {
        $request = curl_init('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);

        $response = json_decode(curl_exec($request));
        curl_close($request);

        Log::info('Get authorization transfer',);

        if (isset($response->message)) {
            return strtolower($response->message) == 'autorizado';
        }

        return false;
    }
}
