<?php

declare(strict_types=1);

namespace App\User\Core\CyclistVerification;

use App\Shared\Domain\IEntityRepository;
use App\Shared\Domain\User\UserId;

/**
 * @extends IEntityRepository<CyclistVerificationProcess, CyclistVerificationProcessId>
 */
interface ICyclistVerificationProcessRepository extends IEntityRepository
{
    public function findActiveByUserId(UserId $userId): ?CyclistVerificationProcess;
}
