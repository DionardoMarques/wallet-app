<?php

namespace Tests\Unit\Services;

use App\Services\AuthorizationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AuthorizationServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected AuthorizationService $authorizationService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authorizationService = new AuthorizationService();
    }

    public function test_authorize_transaction_success(): void
    {
        Http::fake([
            'https://util.devi.tools/api/v2/authorize' => Http::response('', 200),
        ]);

        $result = $this->authorizationService->authorizeTransaction();

        $this->assertTrue($result);
    }

    public function test_authorize_transaction_failure(): void
    {
        Http::fake([
            'https://util.devi.tools/api/v2/authorize' => Http::response('', 500),
        ]);

        $result = $this->authorizationService->authorizeTransaction();

        $this->assertFalse($result);
    }
}
