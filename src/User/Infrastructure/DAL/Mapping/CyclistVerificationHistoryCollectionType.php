<?php

declare(strict_types=1);

namespace App\User\Infrastructure\DAL\Mapping;

use App\User\Core\CyclistVerification\CyclistVerificationHistory;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class CyclistVerificationHistoryCollectionType extends Type
{
    public const NAME = 'user__cyclist_verification_history_collection';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getJsonTypeDeclarationSQL($column);
    }

    /**
     * @param CyclistVerificationHistory[] $value
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        $data = [];
        /** @var CyclistVerificationHistory $item */
        foreach ($value as $item) {
            $data[] = $item->toArray();
        }

        $result = json_encode($data);
        if ($result === false) {
            throw new \InvalidArgumentException(
                'Failed to encode CyclistVerificationHistory to JSON: ' . json_last_error_msg()
            );
        }

        return $result;
    }

    /**
     * @return CyclistVerificationHistory[]
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): array
    {
        if (!is_string($value)) {
            return [];
        }

        $data = json_decode($value, true);
        if (!is_array($data)) {
            return [];
        }

        $result = [];
        foreach ($data as $item) {
            $result[] = CyclistVerificationHistory::fromArray($item); // @phpstan-ignore-line
        }

        return $result;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
