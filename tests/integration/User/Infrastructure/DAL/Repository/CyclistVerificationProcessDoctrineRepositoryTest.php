<?php

declare(strict_types=1);

namespace App\Tests\Integration\User\Infrastructure\DAL\Repository;

use App\Shared\Domain\Money;
use App\Tests\Support\IntegrationTestCase;
use App\Tests\Support\ObjectMother\Shared\Domain\User\UserIdOM;
use App\Tests\Support\ObjectMother\User\Core\CyclistVerification\CyclistVerificationProcessIdOM;
use App\User\Core\CyclistVerification\CyclistVerificationHistory;
use App\User\Core\CyclistVerification\CyclistVerificationProcess;
use App\User\Infrastructure\DAL\Repository\CyclistVerificationProcessDoctrineRepository;
use PHPUnit\Framework\Attributes\Test;

class CyclistVerificationProcessDoctrineRepositoryTest extends IntegrationTestCase
{
    private CyclistVerificationProcessDoctrineRepository $processRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->processRepository = self::getServiceByClassName(CyclistVerificationProcessDoctrineRepository::class);
    }

    #[Test]
    public function it_can_be_saved_and_retrieved(): void
    {
        $clock = $this->getClock();
        $process = CyclistVerificationProcess::start(
            CyclistVerificationProcessIdOM::random(),
            UserIdOM::random(),
            $clock
        );
        $this->processRepository->save($process);
        $this->clearEntityManager();

        $retrievedProcess = $this->processRepository->findById($process->getId());
        $this->assertNotNull($retrievedProcess);
        $this->assertEquals($process->getId(), $retrievedProcess->getId());
        $this->assertEquals($process->getUserId(), $retrievedProcess->getUserId());
        $this->assertEquals(false, $retrievedProcess->isCompleted());

        /** @var CyclistVerificationHistory $history */
        $history = $process->getHistory()[0];
        /** @var CyclistVerificationHistory $retrievedHistory */
        $retrievedHistory = $retrievedProcess->getHistory()[0];
        $this->assertEquals(
            $history->occurredAt->format('Y-m-d H:i:s'),
            $retrievedHistory->occurredAt->format('Y-m-d H:i:s')
        );
        $this->assertEquals($history->step, $retrievedHistory->step);
    }

    #[Test]
    public function it_finds_active_process_by_user(): void
    {
        $clock = $this->getClock();
        $process1 = CyclistVerificationProcess::start(
            CyclistVerificationProcessIdOM::random(),
            UserIdOM::random(),
            $clock
        );
        $process1->markProfileDataFulfilled($clock);
        $process1->verifyWalletBalance(Money::fromCents(20_00), $clock);
        $this->processRepository->save($process1);

        $process2 = CyclistVerificationProcess::start(
            CyclistVerificationProcessIdOM::random(),
            UserIdOM::random(),
            $clock
        );
        $this->processRepository->save($process2);
        $this->clearEntityManager();

        $retrievedProcess = $this->processRepository->findActiveByUserId($process1->getUserId());
        $this->assertNull($retrievedProcess);

        $retrievedProcess = $this->processRepository->findActiveByUserId($process2->getUserId());
        $this->assertNotNull($retrievedProcess);
    }
}
