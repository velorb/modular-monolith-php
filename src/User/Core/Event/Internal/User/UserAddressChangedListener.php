<?php

declare(strict_types=1);

namespace App\User\Core\Event\Internal\User;

use App\User\Core\CyclistVerification\CyclistVerificationSaga;
use App\User\Core\User\Event\UserAddressChanged;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

/**
 * TODO: Refactor
 *  Currently, saga changes are processed within the same transaction as the user address update.
 *  However, we want to avoid sharing address changes directly as integration events.
 *  Instead, this listener should dispatch an internal asynchronous command to update the saga.
 *  For now, this operation runs synchronously in the user address change transaction :(.
 */
#[AsEventListener]
class UserAddressChangedListener
{
    public function __construct(
        private readonly CyclistVerificationSaga $cyclistVerificationSaga
    ) {
    }

    public function __invoke(UserAddressChanged $event): void
    {
        $this->cyclistVerificationSaga->handleAddressChanged($event);
    }
}
