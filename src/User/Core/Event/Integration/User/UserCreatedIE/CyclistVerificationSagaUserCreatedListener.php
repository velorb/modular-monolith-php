<?php

declare(strict_types=1);

namespace App\User\Core\Event\Integration\User\UserCreatedIE;

use App\Shared\Application\Bus\Event\IEventHandler;
use App\Shared\Application\Event\Integration\User\UserCreatedIE;
use App\Shared\Domain\Id\IUlidGenerator;
use App\User\Core\CyclistVerification\CyclistVerificationProcessId;
use App\User\Core\CyclistVerification\CyclistVerificationSaga;

class CyclistVerificationSagaUserCreatedListener implements IEventHandler
{
    public function __construct(
        private readonly CyclistVerificationSaga $cyclistVerificationSaga,
        private readonly IUlidGenerator $idGenerator,
    ) {
    }

    public function __invoke(UserCreatedIE $event): void
    {
        $this->cyclistVerificationSaga->start(
            CyclistVerificationProcessId::fromUlid($this->idGenerator->new()),
            $event->userId,
        );
    }
}
