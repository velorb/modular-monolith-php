<?php

declare(strict_types=1);

namespace App\User\Infrastructure\DAL\Repository;

use App\Shared\Domain\User\UserId;
use App\Shared\Infrastructure\DAL\Repository\DoctrineEntityRepository;
use App\User\Core\CyclistVerification\CyclistVerificationProcess;
use App\User\Core\CyclistVerification\CyclistVerificationProcessId;
use App\User\Core\CyclistVerification\ICyclistVerificationProcessRepository;

/**
 * @extends DoctrineEntityRepository<CyclistVerificationProcess, CyclistVerificationProcessId>
 */
class CyclistVerificationProcessDoctrineRepository extends DoctrineEntityRepository implements
    ICyclistVerificationProcessRepository
{
    public static function getEntityClassName(): string
    {
        return CyclistVerificationProcess::class;
    }

    public function findActiveByUserId(UserId $userId): ?CyclistVerificationProcess
    {
        return $this->findOneBy(['userId' => $userId, 'completed' => false]);
    }
}
