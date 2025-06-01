<?php

declare(strict_types=1);

namespace App\Wallet\Infrastructure\IntegrationEvent\User;

use App\Shared\Application\Bus\Event\IEventHandler;
use App\Shared\Application\Event\Integration\User\UserCreatedIE;
use App\Shared\Domain\Id\IUlidGenerator;
use App\Shared\Infrastructure\Bus\Command\CommandBus;
use App\Wallet\Application\Command\Internal\Wallet\Create\CreateWalletCommand;
use App\Wallet\Domain\Wallet\WalletId;

class UserCreatedHandler implements IEventHandler
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly IUlidGenerator $ulidGenerator,
    ) {
    }

    public function __invoke(UserCreatedIE $event): void
    {
        $this->commandBus->dispatch(
            new CreateWalletCommand(WalletId::fromUlid($this->ulidGenerator->new()), $event->userId)
        );
    }
}
