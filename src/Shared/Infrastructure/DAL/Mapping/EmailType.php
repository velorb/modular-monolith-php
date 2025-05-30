<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\DAL\Mapping;

use App\Shared\Domain\Email;

/**
 * @extends StringType<Email>
 */
class EmailType extends StringType
{
    protected function getValueObjectClassName(): string
    {
        return Email::class;
    }

    public function getName(): string
    {
        return 's__email';
    }
}
