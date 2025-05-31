<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Wallet\Transaction;

use App\Shared\Domain\User\UserSsoId;

readonly class TransactionAuthor
{
    private function __construct(
        private TransactionAuthorType $type,
        private ?UserSsoId $id,
    ) {
    }

    public static function createUserAuthor(UserSsoId $id): self
    {
        return new self(TransactionAuthorType::USER, $id);
    }

    public static function createSystemAuthor(): self
    {
        return new self(
            TransactionAuthorType::SYSTEM,
            null
        );
    }

    public function isSystemAuthor(): bool
    {
        return $this->type === TransactionAuthorType::SYSTEM;
    }

    public function getId(): ?UserSsoId
    {
        return $this->id;
    }

    public function getType(): TransactionAuthorType
    {
        return $this->type;
    }
}
