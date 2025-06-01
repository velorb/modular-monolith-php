<?php

declare(strict_types=1);

namespace App\User\Core\CyclistVerification;

readonly class CyclistVerificationHistory
{
    public function __construct(
        public CyclistVerificationStep $step,
        public \DateTimeImmutable $occurredAt,
    ) {
    }

    /**
     * @param array{step: string, occurred_at: string} $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            CyclistVerificationStep::from($data['step']),
            new \DateTimeImmutable($data['occurred_at']),
        );
    }

    /**
     * @return array{step: string, occurred_at: string}
     */
    public function toArray(): array
    {
        return [
            'step' => $this->step->value,
            'occurred_at' => $this->occurredAt->format(\DateTimeInterface::ATOM),
        ];
    }
}
