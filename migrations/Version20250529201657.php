<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250529201657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remove restaurant module.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            DROP TABLE restaurant_menu_item
        SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            CREATE SCHEMA public
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE TABLE restaurant_menu_item (id CHAR(26) NOT NULL, name VARCHAR(255) NOT NULL, price_net INT NOT NULL, price_gross INT NOT NULL, price_vat_rate INT NOT NULL, PRIMARY KEY(id))
        SQL
        );
    }
}
