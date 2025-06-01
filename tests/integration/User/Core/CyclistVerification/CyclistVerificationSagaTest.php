<?php

declare(strict_types=1);

namespace App\Tests\Integration\User\Core\CyclistVerification;

use App\Shared\Application\Event\Integration\User\CyclistVerifiedIE;
use App\Shared\Application\Event\Integration\Wallet\WalletBalanceChangedIE;
use App\Shared\Domain\Money;
use App\Shared\Domain\User\UserRole;
use App\Tests\Support\IntegrationTestCase;
use App\Tests\Support\ObjectMother\Shared\Domain\AddressOM;
use App\Tests\Support\ObjectMother\User\Core\CyclistVerification\CyclistVerificationProcessIdOM;
use App\Tests\Support\ObjectMother\User\Core\CyclistVerification\CyclistVerificationProcessOM;
use App\Tests\Support\ObjectMother\User\Core\User\UserOM;
use App\User\Core\CyclistVerification\CyclistVerificationSaga;
use App\User\Core\CyclistVerification\ICyclistVerificationProcessRepository;
use App\User\Core\User\Event\UserAddressChanged;
use PHPUnit\Framework\Attributes\Test;

class CyclistVerificationSagaTest extends IntegrationTestCase
{
    private CyclistVerificationSaga $cyclistVerificationSaga;
    private ICyclistVerificationProcessRepository $processRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cyclistVerificationSaga = $this->getServiceByClassName(CyclistVerificationSaga::class);
        $this->processRepository = $this->getServiceByClassName(ICyclistVerificationProcessRepository::class);
    }

    #[Test]
    public function it_creates_cyclist_verification_process_on_start_for_cyclist(): void
    {
        $user = UserOM::create(roles: [UserRole::CYCLIST]);
        $this->saveEntities($user);
        $this->setTime('2025-01-01T00:00:00');
        $processId = CyclistVerificationProcessIdOM::random();
        $this->cyclistVerificationSaga->start($processId, $user->getId());
        $this->clearEntityManager();

        $cyclistVerificationProcess = $this->processRepository->findById($processId);
        $this->assertNotNull($cyclistVerificationProcess);
        $this->assertEquals($user->getId(), $cyclistVerificationProcess->getUserId());
        $processHistory = $cyclistVerificationProcess->getHistory()[0];
        $this->assertEquals('2025-01-01 00:00:00', $processHistory->occurredAt->format('Y-m-d H:i:s'));
        $this->assertNotDispatchedCyclistVerifiedIntegrationEvent();
    }

    #[Test]
    public function it_skips_start_when_active_process_already_exists(): void
    {
        $user = UserOM::create(roles: [UserRole::CYCLIST]);
        $process = CyclistVerificationProcessOM::create(userId: $user->getId());
        $this->saveEntities($user, $process);
        $processId = CyclistVerificationProcessIdOM::random();
        $this->cyclistVerificationSaga->start($processId, $user->getId());
        $this->clearEntityManager();

        $cyclistVerificationProcess = $this->processRepository->findById($processId);
        $this->assertNull($cyclistVerificationProcess);
        $this->assertNotDispatchedCyclistVerifiedIntegrationEvent();
    }

    #[Test]
    public function it_skips_for_admin(): void
    {
        $user = UserOM::create(roles: [UserRole::ADMIN]);
        $this->saveEntities($user);
        $this->setTime('2025-01-01T00:00:00');
        $processId = CyclistVerificationProcessIdOM::random();
        $this->cyclistVerificationSaga->start($processId, $user->getId());
        $this->clearEntityManager();

        $cyclistVerificationProcess = $this->processRepository->findById($processId);
        $this->assertNull($cyclistVerificationProcess);
        $this->assertNotDispatchedCyclistVerifiedIntegrationEvent();
    }

    #[Test]
    public function it_handles_wallet_balance_changed(): void
    {
        $user = UserOM::create(roles: [UserRole::CYCLIST]);
        $process = CyclistVerificationProcessOM::create(userId: $user->getId());
        $this->saveEntities($user, $process);
        $this->clearEntityManager();
        $this->cyclistVerificationSaga->handleWalletBalanceChanged(
            new WalletBalanceChangedIE(
                $process->getUserId(),
                Money::fromCents(20_00)
            )
        );
        $this->clearEntityManager();

        $retrievedProcess = $this->processRepository->findById($process->getId());
        $this->assertNotNull($retrievedProcess);
        $this->assertTrue($retrievedProcess->isWalletMinimumBalanceReached());
        $this->assertNotDispatchedCyclistVerifiedIntegrationEvent();
    }

    #[Test]
    public function it_handles_user_profile_verified(): void
    {
        $user = UserOM::create(roles: [UserRole::CYCLIST]);
        $process = CyclistVerificationProcessOM::create(userId: $user->getId());
        $this->saveEntities($user, $process);
        $this->clearEntityManager();

        $this->cyclistVerificationSaga->handleAddressChanged(
            new UserAddressChanged(
                $process->getUserId(),
                $this->getClock()->now(),
                AddressOM::create()
            )
        );

        $retrievedProcess = $this->processRepository->findById($process->getId());
        $this->assertNotNull($retrievedProcess);
        $this->assertTrue($retrievedProcess->isProfileDataVerified());
        $this->assertNotDispatchedCyclistVerifiedIntegrationEvent();
    }

    #[Test]
    public function it_dispatches_user_verified_integration_event(): void
    {
        $user = UserOM::create(roles: [UserRole::CYCLIST]);
        $process = CyclistVerificationProcessOM::create(userId: $user->getId());
        $this->saveEntities($user, $process);
        $this->clearEntityManager();

        $this->cyclistVerificationSaga->handleWalletBalanceChanged(
            new WalletBalanceChangedIE(
                $process->getUserId(),
                Money::fromCents(20_00)
            )
        );
        $this->cyclistVerificationSaga->handleAddressChanged(
            new UserAddressChanged(
                $process->getUserId(),
                $this->getClock()->now(),
                AddressOM::create()
            )
        );

        $retrievedProcess = $this->processRepository->findById($process->getId());
        $this->assertNotNull($retrievedProcess);
        $this->assertTrue($retrievedProcess->isCompleted());
        $this->assertDispatchedCyclistVerifiedIntegrationEvent();
    }

    private function assertNotDispatchedCyclistVerifiedIntegrationEvent(): void
    {
        $this->assertFalse(
            $this->getEventBus()->hasDispatchedEvent(fn ($event) => $event instanceof CyclistVerifiedIE),
            'CyclistVerifiedIE should not be dispatched',
        );
    }

    private function assertDispatchedCyclistVerifiedIntegrationEvent(): void
    {
        $this->assertTrue(
            $this->getEventBus()->hasDispatchedEvent(fn ($event) => $event instanceof CyclistVerifiedIE),
            'CyclistVerifiedIE should be dispatched',
        );
    }
}
