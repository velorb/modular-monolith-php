<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain;

use App\Shared\Domain\Email;
use App\Shared\Domain\Exception\DomainException;
use App\Tests\Support\UnitTestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class EmailTest extends UnitTestCase
{
    /**
     * @return array<string, mixed[]>
     */
    public static function dataProvider_can_create_valid_email(): array
    {
        return [
            'standard email' => ['test@example.com'],
            'email with plus tag' => ['user.name+tag@domain.co'],
            'uppercase email' => ['UPPER@EXAMPLE.COM'],
            'email with subdomain' => ['user@subdomain.example.com'],
            'email with numbers' => ['user123@example.com'],
            'email with hyphen' => ['user-name@example.com'],
        ];
    }

    /**
     * @return array<string, mixed[]>
     */
    public static function dataProvider_can_not_create_invalid_email(): array
    {
        return [
            'no @ symbol' => ['invalid-email'],
            'missing username' => ['@missinguser.com'],
            'missing domain' => ['user@.com'],
            'incomplete domain' => ['user@domain'],
            'empty string' => [''],
            'only whitespace' => [' '],
            'email with space 1' => [' test@example.com'],
            'email with space 2' => ['test@example.com '],
            'email with space 3' => ['test@ example.com'],
            'missing tld' => ['user@domain.'],
            'multiple @ symbols' => ['user@domain@example.com'],
        ];
    }

    /**
     * @return array<string, mixed[]>
     */
    public static function dataProvider_it_checks_that_emails_are_equals(): array
    {
        return [
            'same email different case' => [
                'Test@Example.com',
                'test@example.com',
                'equals' => true
            ],
            'uppercase and lowercase domains' => [
                'user@DOMAIN.COM',
                'user@domain.com',
                'equals' => true
            ],
            'different emails' => [
                'user1@example.com',
                'user2@example.com',
                'equals' => false
            ],
            'same local part different domains' => [
                'user@domain1.com',
                'user@domain2.com',
                'equals' => false
            ],
        ];
    }

    #[Test]
    #[DataProvider('dataProvider_can_not_create_invalid_email')]
    public function can_not_create_invalid_email(string $input): void
    {
        $this->expectException(DomainException::class);
        new Email($input);
    }

    #[Test]
    #[DataProvider('dataProvider_can_create_valid_email')]
    public function can_create_valid_email(string $input): void
    {
        $this->expectNotToPerformAssertions();
        new Email($input);
    }

    #[Test]
    #[DataProvider('dataProvider_it_checks_that_emails_are_equals')]
    public function it_checks_that_emails_are_equals(string $a, string $b, bool $equals): void
    {
        $email1 = new Email($a);
        $email2 = new Email($b);
        $this->assertSame($equals, $email1->equals($email2));
    }
}
