<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20250601143032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'User. Add address fields to user_user table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            ALTER TABLE user_user ADD address_postal_code VARCHAR(20) DEFAULT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE user_user ADD address_city VARCHAR(100) DEFAULT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE user_user ADD address_street VARCHAR(255) DEFAULT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE user_user ADD address_building_number VARCHAR(20) DEFAULT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE user_user ADD address_apartment_number VARCHAR(20) DEFAULT NULL
        SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            ALTER TABLE user_user DROP address_postal_code
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE user_user DROP address_city
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE user_user DROP address_street
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE user_user DROP address_building_number
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE user_user DROP address_apartment_number
        SQL
        );
    }
}
