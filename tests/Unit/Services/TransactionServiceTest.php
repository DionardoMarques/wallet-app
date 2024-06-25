<?php

namespace Tests\Unit\Services;

use App\DTO\CreateTransactionDTO;
use App\Repositories\TransactionRepositoryInterface;
use App\Services\NotificationService;
use App\Services\TransactionService;
use App\Services\TransactionValidationService;
use App\Services\UserService;
use App\Services\WalletService;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use stdClass;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var TransactionRepositoryInterface|\Mockery\MockInterface
     */
    protected $transactionRepository;

    /**
     * @var TransactionValidationService|\Mockery\MockInterface
     */
    protected $transactionValidationService;

    /**
     * @var WalletService|\Mockery\MockInterface
     */
    protected $walletService;

    /**
     * @var NotificationService|\Mockery\MockInterface
     */
    protected $notificationService;

    /**
     * @var UserService|\Mockery\MockInterface
     */
    protected $userService;

    /**
     * @var TransactionService
     */
    protected $transactionService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->transactionRepository = Mockery::mock(TransactionRepositoryInterface::class);
        $this->transactionValidationService = Mockery::mock(TransactionValidationService::class);
        $this->walletService = Mockery::mock(WalletService::class);
        $this->notificationService = Mockery::mock(NotificationService::class);
        $this->userService = Mockery::mock(UserService::class);

        $this->transactionService = new TransactionService(
            $this->transactionRepository,
            $this->transactionValidationService,
            $this->walletService,
            $this->notificationService,
            $this->userService
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_new_transaction_success(): void
    {
        $dto = new CreateTransactionDTO(
            100.0,
            1,
            2,
            'pending'
        );

        $this->transactionValidationService->shouldReceive('validateTransaction')
            ->with($dto)
            ->once()
            ->andReturn(true);

        $this->walletService->shouldReceive('updateBalancePayer')
            ->with($dto->payer_id, $dto->value)
            ->once();

        $this->walletService->shouldReceive('updateBalancePayee')
            ->with($dto->payee_id, $dto->value)
            ->once();

        $this->notificationService->shouldReceive('notifyPayment')
            ->once()
            ->andReturn(true);

        $this->transactionRepository->shouldReceive('new')
            ->with(Mockery::on(function ($arg) use ($dto) {
                return $arg instanceof CreateTransactionDTO
                    && $arg->value === $dto->value
                    && $arg->payer_id === $dto->payer_id
                    && $arg->payee_id === $dto->payee_id
                    && $arg->status === $dto->status;
            }))
            ->once()
            ->andReturn(new stdClass());

        $result = $this->transactionService->new($dto);

        $this->assertInstanceOf(stdClass::class, $result);
    }

    public function test_new_transaction_validation_fail(): void
    {
        $dto = new CreateTransactionDTO(
            100.0,
            1,
            2,
            'pending'
        );

        $this->transactionValidationService->shouldReceive('validateTransaction')
            ->with($dto)
            ->once()
            ->andThrow(new Exception('Validation failed'));

        $this->expectException(Exception::class);

        $this->transactionService->new($dto);
    }
}
