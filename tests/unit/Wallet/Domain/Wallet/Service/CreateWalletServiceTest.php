<?php

declare(strict_types=1);

namespace App\Tests\Unit\Wallet\Domain\Wallet\Service;

use App\Shared\Domain\Exception\DomainException;
use App\Tests\Support\Mock\Shared\Domain\ClockMock;
use App\Tests\Support\ObjectMother\Shared\Domain\User\UserIdOM;
use App\Tests\Support\ObjectMother\Wallet\Domain\Wallet\WalletIdOM;
use App\Tests\Support\ObjectMother\Wallet\Domain\Wallet\WalletOM;
use App\Tests\Support\UnitTestCase;
use App\Wallet\Domain\Wallet\IWalletRepository;
use App\Wallet\Domain\Wallet\Service\CreateWalletService;
use App\Wallet\Domain\Wallet\Wallet;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

class CreateWalletServiceTest extends UnitTestCase
{
    private IWalletRepository&MockObject $walletRepository;
    private CreateWalletService $service;
    private ClockMock $clock;

    protected function setUp(): void
    {
        $this->walletRepository = $this->createMock(IWalletRepository::class);
        $this->clock = $this->getClock('2025-06-01 12:00:00');
        $this->service = new CreateWalletService($this->walletRepository, $this->clock);
    }

    #[Test]
    public function it_creates_wallet_successfully(): void
    {
        $userId = UserIdOM::random();
        $walletId = WalletIdOM::random();

        $this->walletRepository
            ->expects($this->once())
            ->method('findByUserId')
            ->with($userId)
            ->willReturn(null);

        $wallet = $this->service->create($walletId, $userId);

        $this->assertInstanceOf(Wallet::class, $wallet);
        $this->assertEquals($walletId, $wallet->getId());
        $this->assertEquals($userId, $wallet->getUserId());
    }

    #[Test]
    public function user_can_have_only_one_portfel(): void
    {
        $userId = UserIdOM::random();
        $walletId = WalletIdOM::random();
        $existingWallet = WalletOM::create($userId);

        $this->walletRepository
            ->expects($this->once())
            ->method('findByUserId')
            ->with($userId)
            ->willReturn($existingWallet);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Wallet already exists for this user.');

        $this->service->create($walletId, $userId);
    }
}
