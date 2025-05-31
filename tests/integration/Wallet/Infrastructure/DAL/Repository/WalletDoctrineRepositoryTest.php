<?php

declare(strict_types=1);

namespace App\Tests\Integration\Wallet\Infrastructure\DAL\Repository;

use App\Shared\Domain\Money;
use App\Tests\Support\IntegrationTestCase;
use App\Tests\Support\ObjectMother\Shared\Domain\User\UserIdOM;
use App\Tests\Support\ObjectMother\Wallet\Domain\Wallet\WalletOM;
use App\Wallet\Domain\Wallet\Transaction\TransactionAuthor;
use App\Wallet\Domain\Wallet\Transaction\TransactionDto;
use App\Wallet\Domain\Wallet\Transaction\TransactionType;
use App\Wallet\Infrastructure\DAL\Repository\WalletDoctrineRepository;
use PHPUnit\Framework\Attributes\Test;

class WalletDoctrineRepositoryTest extends IntegrationTestCase
{
    private WalletDoctrineRepository $walletRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->walletRepository = $this->getServiceByClassName(WalletDoctrineRepository::class);
    }

    #[Test]
    public function wallet_without_transactions_can_be_saved_and_retrieved(): void
    {
        $wallet = WalletOM::create();
        $this->walletRepository->save($wallet);
        $this->clearEntityManager();
        $walletFromDb = $this->walletRepository->findById($wallet->getId());
        $this->assertNotEmpty($walletFromDb);
        $this->assertEquals($wallet->getId(), $walletFromDb->getId());
        $this->assertEquals($wallet->getBalance(), $walletFromDb->getBalance());
        $this->assertTrue($wallet->getUserId()->equals($walletFromDb->getUserId()));
        $this->assertEquals(
            $wallet->getCreatedAt()->format('Y-m-d H:i:s'),
            $walletFromDb->getCreatedAt()->format('Y-m-d H:i:s')
        );
        $this->assertEquals(
            $wallet->getUpdatedAt()->format('Y-m-d H:i:s'),
            $walletFromDb->getUpdatedAt()->format('Y-m-d H:i:s')
        );
    }

    #[Test]
    public function wallet_with_transactions_can_be_saved_and_retrieved(): void
    {
        $wallet = WalletOM::create();
        $clock = $this->getClock();
        $userId = UserIdOM::random();
        $wallet->deposit(Money::fromCents(100_00), TransactionAuthor::createSystemAuthor(), $clock);
        $wallet->withdraw(Money::fromCents(50_00), TransactionAuthor::createUserAuthor($userId), $clock);
        $this->walletRepository->save($wallet);
        $this->clearEntityManager();
        $walletFromDb = $this->walletRepository->findById($wallet->getId());
        $this->assertNotNull($walletFromDb);
        $this->assertEquals($wallet->getBalance(), $walletFromDb->getBalance());
        $this->assertCount(2, $wallet->getTransactions());
        $transactions = $walletFromDb->getTransactions();
        $deposit = array_find($transactions, fn (TransactionDto $tx) => $tx->type === TransactionType::DEPOSIT);
        $this->assertNotNull($deposit);
        $this->assertEquals(Money::fromCents(100_00), $deposit->amount);
        $this->assertEquals(TransactionAuthor::createSystemAuthor(), $deposit->createdBy);
        /** @var TransactionDto $withdrawal */
        $withdrawal = array_find($transactions, fn (TransactionDto $tx) => $tx->type === TransactionType::WITHDRAWAL);
        $this->assertEquals(Money::fromCents(50_00), $withdrawal->amount);
        $this->assertEquals(TransactionAuthor::createUserAuthor($userId), $withdrawal->createdBy);
    }
}
