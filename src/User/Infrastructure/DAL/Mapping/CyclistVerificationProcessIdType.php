<?php

declare(strict_types=1);

namespace App\User\Infrastructure\DAL\Mapping;

use App\Shared\Infrastructure\DAL\Mapping\DoctrineUlidType;
use App\User\Core\CyclistVerification\CyclistVerificationProcessId;

class CyclistVerificationProcessIdType extends DoctrineUlidType
{
    protected function getValueObjectClassName(): string
    {
        return CyclistVerificationProcessId::class;
    }

    public function getName(): string
    {
        return 'user__cyclist_verification_process_id';
    }
}
