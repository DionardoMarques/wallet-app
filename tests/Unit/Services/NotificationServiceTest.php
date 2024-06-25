<?php

namespace Tests\Unit\Services;

use App\Services\NotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class NotificationServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected NotificationService $notificationService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->notificationService = new NotificationService();
    }

    public function test_notify_payment_success(): void
    {
        Http::fake([
            'https://util.devi.tools/api/v1/notify' => Http::response('', 200),
        ]);

        $result = $this->notificationService->notifyPayment();

        $this->assertTrue($result);
    }

    public function test_notify_payment_failure(): void
    {
        Http::fake([
            'https://util.devi.tools/api/v1/notify' => Http::response('', 500),
        ]);

        $result = $this->notificationService->notifyPayment();

        $this->assertFalse($result);
    }
}
