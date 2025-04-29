<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250429150617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'MenuCatalog. Menu item.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            CREATE TABLE mc_menu_item (id CHAR(26) NOT NULL, name VARCHAR(255) NOT NULL, price_net INT NOT NULL, price_gross INT NOT NULL, price_vat_rate INT NOT NULL, PRIMARY KEY(id))
        SQL
        );
        $this->addSql(
            <<<'SQL'
            COMMENT ON COLUMN mc_menu_item.id IS '(DC2Type:s-mc-menu_item_id)'
        SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            DROP TABLE mc_menu_item
        SQL
        );
    }
}
