<?php

declare(strict_types=1);

namespace App\Tests\Unit\Wallet\Domain\Wallet;

use App\Shared\Domain\Exception\DomainException;
use App\Shared\Domain\Money;
use App\Tests\Support\ObjectMother\Shared\Domain\User\UserIdOM;
use App\Tests\Support\ObjectMother\Wallet\Domain\Wallet\WalletIdOM;
use App\Tests\Support\UnitTestCase;
use App\Wallet\Domain\Wallet\Transaction\TransactionAuthor;
use App\Wallet\Domain\Wallet\Transaction\TransactionDto;
use App\Wallet\Domain\Wallet\Transaction\TransactionType;
use App\Wallet\Domain\Wallet\Wallet;
use PHPUnit\Framework\Attributes\Test;

class WalletTest extends UnitTestCase
{
    #[Test]
    public function created_wallet_has_initial_balance_of_zero(): void
    {
        $wallet = Wallet::create(
            WalletIdOM::random(),
            UserIdOM::random(),
            $this->getClock(),
        );

        // Assert
        $this->assertEquals(Money::zero(), $wallet->getBalance());
    }

    #[Test]
    public function it_updates_modification_dates(): void
    {
        $wallet = Wallet::create(
            WalletIdOM::random(),
            UserIdOM::random(),
            $this->getClock('2025-04-01T00:00:00'),
        );
        $this->assertEquals(new \DateTimeImmutable('2025-04-01T00:00:00'), $wallet->getCreatedAt());
        $this->assertEquals(new \DateTimeImmutable('2025-04-01T00:00:00'), $wallet->getUpdatedAt());

        $wallet->deposit(
            Money::fromCents(100),
            TransactionAuthor::createSystemAuthor(),
            $this->getClock('2025-04-02T00:00:00'),
        );
        $this->assertEquals(new \DateTimeImmutable('2025-04-01T00:00:00'), $wallet->getCreatedAt());
        $this->assertEquals(new \DateTimeImmutable('2025-04-02T00:00:00'), $wallet->getUpdatedAt());
    }

    #[Test]
    public function it_can_deposit_money(): void
    {
        $wallet = Wallet::create(
            WalletIdOM::random(),
            UserIdOM::random(),
            $this->getClock(),
        );

        $wallet->deposit(
            Money::fromCents(500),
            TransactionAuthor::createSystemAuthor(),
            $this->getClock(),
        );

        $this->assertEquals(Money::fromCents(500), $wallet->getBalance());
        $this->assertCount(1, $wallet->getTransactions());
    }

    #[Test]
    public function it_can_withdraw_money(): void
    {
        $wallet = Wallet::create(
            WalletIdOM::random(),
            UserIdOM::random(),
            $this->getClock(),
        );
        $wallet->deposit(
            Money::fromCents(1000),
            TransactionAuthor::createSystemAuthor(),
            $this->getClock(),
        );

        $wallet->withdraw(
            Money::fromCents(300),
            TransactionAuthor::createSystemAuthor(),
            $this->getClock(),
        );

        $this->assertEquals(Money::fromCents(700), $wallet->getBalance());
        $this->assertCount(2, $wallet->getTransactions());
    }

    #[Test]
    public function deposit_amount_must_be_greater_than_zero(): void
    {
        $wallet = Wallet::create(
            WalletIdOM::random(),
            UserIdOM::random(),
            $this->getClock(),
        );

        try {
            $wallet->deposit(
                Money::fromCents(-100),
                TransactionAuthor::createSystemAuthor(),
                $this->getClock(),
            );
            $this->fail('Cannot deposit negative amount');
        } catch (DomainException $e) {
            $this->assertEquals('Deposit amount must be greater than zero.', $e->getMessage());
        }

        try {
            $wallet->deposit(
                Money::zero(),
                TransactionAuthor::createSystemAuthor(),
                $this->getClock(),
            );
            $this->fail('Cannot deposit zero amount');
        } catch (DomainException $e) {
            $this->assertEquals('Deposit amount must be greater than zero.', $e->getMessage());
        }
    }

    #[Test]
    public function it_prevents_deposit_exceeding_max_balance(): void
    {
        $wallet = Wallet::create(
            WalletIdOM::random(),
            UserIdOM::random(),
            $this->getClock(),
        );

        $wallet->deposit(
            Money::fromCents(10_000_00),
            TransactionAuthor::createSystemAuthor(),
            $this->getClock(),
        );

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Deposit exceeds maximum wallet balance.');

        $wallet->deposit(
            Money::fromCents(1),
            TransactionAuthor::createUserAuthor(UserIdOM::random()),
            $this->getClock(),
        );
    }

    #[Test]
    public function system_can_deposit_even_if_max_balance_exceeded(): void
    {
        $wallet = Wallet::create(
            WalletIdOM::random(),
            UserIdOM::random(),
            $this->getClock(),
        );
        $wallet->deposit(
            Money::fromCents(10_000_00),
            TransactionAuthor::createSystemAuthor(),
            $this->getClock(),
        );

        $wallet->deposit(
            Money::fromCents(1),
            TransactionAuthor::createSystemAuthor(),
            $this->getClock(),
        );

        $this->assertEquals(Money::fromCents(10_000_01), $wallet->getBalance());
    }

    #[Test]
    public function it_stores_transaction_history(): void
    {
        $wallet = Wallet::create(
            WalletIdOM::random(),
            UserIdOM::random(),
            $this->getClock('2025-04-01T00:00:00'),
        );
        $wallet->deposit(
            Money::fromCents(500),
            TransactionAuthor::createSystemAuthor(),
            $this->getClock('2025-04-01T12:00:00'),
        );
        $userAuthor = TransactionAuthor::createUserAuthor(UserIdOM::random());
        $wallet->withdraw(
            Money::fromCents(200),
            $userAuthor,
            $this->getClock('2025-04-02T12:00:00'),
        );

        $transactions = $wallet->getTransactions();

        $this->assertCount(2, $transactions);
        /** @var TransactionDto $deposit */
        $deposit = array_find($transactions, fn (TransactionDto $tx) => $tx->type === TransactionType::DEPOSIT);
        $this->assertEquals(Money::fromCents(500), $deposit->amount);
        $this->assertEquals(TransactionType::DEPOSIT, $deposit->type);
        $this->assertEquals(new \DateTimeImmutable('2025-04-01T12:00:00'), $deposit->createdAt);
        $this->assertEquals(TransactionAuthor::createSystemAuthor(), $deposit->createdBy);
        /** @var TransactionDto $withdrawal */
        $withdrawal = array_find(
            $transactions,
            fn (TransactionDto $tx) => $tx->type === TransactionType::WITHDRAWAL
        );
        $this->assertEquals(Money::fromCents(200), $withdrawal->amount);
        $this->assertEquals(TransactionType::WITHDRAWAL, $withdrawal->type);
        $this->assertEquals(new \DateTimeImmutable('2025-04-02T12:00:00'), $withdrawal->createdAt);
        $this->assertEquals($withdrawal->createdBy, $userAuthor);
    }

    #[Test]
    public function it_tracks_transaction_author(): void
    {
        $wallet = Wallet::create(
            WalletIdOM::random(),
            UserIdOM::random(),
            $this->getClock(),
        );
        $userAuthor = TransactionAuthor::createUserAuthor(UserIdOM::random());

        $wallet->deposit(
            Money::fromCents(500),
            $userAuthor,
            $this->getClock(),
        );

        $transactions = $wallet->getTransactions();
        $this->assertEquals($userAuthor, $transactions[0]->createdBy);
    }
}
