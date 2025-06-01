<?php

declare(strict_types=1);

namespace App\Tests\Support\ObjectMother\User\Core\CyclistVerification;

use App\Shared\Domain\IClock;
use App\Shared\Domain\User\UserId;
use App\Tests\Support\Mock\Shared\Domain\ClockMock;
use App\Tests\Support\ObjectMother\Shared\Domain\User\UserIdOM;
use App\User\Core\CyclistVerification\CyclistVerificationProcess;

class CyclistVerificationProcessOM
{
    public static function create(
        ?UserId $userId = null,
        ?IClock $clock = null,
    ): CyclistVerificationProcess {
        return CyclistVerificationProcess::start(
            CyclistVerificationProcessIdOM::random(),
            $userId ?? UserIdOM::random(),
            $clock ?? new ClockMock(),
        );
    }
}
