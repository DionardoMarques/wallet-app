<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AuthorizationService
{
    public function authorizeTransaction(): bool
    {
        $response = Http::get('https://util.devi.tools/api/v2/authorize');

        return $response->successful();
    }
}
