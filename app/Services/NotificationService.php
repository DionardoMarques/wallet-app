<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NotificationService
{
    public function notifyPayment(): bool
    {
        $response = Http::post('https://util.devi.tools/api/v1/notify');

        return $response->successful();
    }
}
