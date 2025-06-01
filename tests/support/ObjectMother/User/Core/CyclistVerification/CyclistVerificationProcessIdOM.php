<?php

declare(strict_types=1);

namespace App\Tests\Support\ObjectMother\User\Core\CyclistVerification;

use App\Tests\Support\Faker\UlidFaker;
use App\User\Core\CyclistVerification\CyclistVerificationProcessId;

class CyclistVerificationProcessIdOM
{
    public static function random(): CyclistVerificationProcessId
    {
        return new CyclistVerificationProcessId(UlidFaker::generate());
    }
}
