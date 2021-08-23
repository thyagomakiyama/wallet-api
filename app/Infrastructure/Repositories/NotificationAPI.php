<?php

namespace Infrastructure\Repositories;

use Domain\Repositories\NotificationRepository;
use Illuminate\Support\Facades\Log;

class NotificationAPI implements NotificationRepository
{

    public function send(string $message, string $payeeId): void
    {
        $request = curl_init('http://o4d9z.mocklab.io/notify');
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_POST, true);

        $response = json_decode(curl_exec($request));
        curl_close($request);

        $dataLog = [
            'request_body' => [
                'message' => $message,
                'payee_id' => $payeeId
            ],
            'response' => $response
        ];

        Log::info(sprintf('Send notification transfer to payee %s', $payeeId), $dataLog);
    }
}
