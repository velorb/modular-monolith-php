<?php

declare(strict_types=1);

namespace App\Tests\Integration\Wallet\Application\Command\Internal\Wallet\Create;

use App\Tests\Support\IntegrationTestCase;
use App\Tests\Support\ObjectMother\Shared\Domain\User\UserIdOM;
use App\Tests\Support\ObjectMother\Wallet\Domain\Wallet\WalletIdOM;
use App\Wallet\Application\Command\Internal\Wallet\Create\CreateWalletCommand;
use App\Wallet\Application\Command\Internal\Wallet\Create\CreateWalletHandler;
use App\Wallet\Domain\Wallet\IWalletRepository;
use PHPUnit\Framework\Attributes\Test;

class CreateWalletHandlerTest extends IntegrationTestCase
{
    private CreateWalletHandler $createWalletHandler;
    private IWalletRepository $walletRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->createWalletHandler = $this->getServiceByClassName(CreateWalletHandler::class);
        $this->walletRepository = $this->getServiceByClassName(IWalletRepository::class);
    }

    #[Test]
    public function it_creates_wallet(): void
    {
        $userId = UserIdOM::random();
        $this->createWalletHandler->__invoke(
            new CreateWalletCommand(
                WalletIdOM::random(),
                $userId
            )
        );
        $this->clearEntityManager();

        $wallet = $this->walletRepository->findByUserId($userId);

        $this->assertNotNull($wallet);
    }
}
