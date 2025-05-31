<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20250531072248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Init database schema for user and wallet modules';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            CREATE TABLE user_user (id CHAR(26) NOT NULL, sso_id CHAR(36) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE UNIQUE INDEX UNIQ_F7129A807843BFA4 ON user_user (sso_id)
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE UNIQUE INDEX UNIQ_F7129A80F85E0677 ON user_user (username)
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE TABLE user_user_role (user_id CHAR(26) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(user_id, role))
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE INDEX IDX_2D084B47A76ED395 ON user_user_role (user_id)
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE TABLE wallet_transaction (id SERIAL NOT NULL, wallet_id CHAR(26) NOT NULL, amount INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, type VARCHAR(255) NOT NULL, created_by_type VARCHAR(255) NOT NULL, created_by_author_id CHAR(36) DEFAULT NULL, PRIMARY KEY(id))
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE INDEX IDX_7DAF972712520F3 ON wallet_transaction (wallet_id)
        SQL
        );
        $this->addSql(
            <<<'SQL'
            COMMENT ON COLUMN wallet_transaction.created_at IS '(DC2Type:datetime_immutable)'
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE TABLE wallet_wallet (id CHAR(26) NOT NULL, user_sso_id CHAR(36) NOT NULL, balance INT NOT NULL, createdAt TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updatedAt TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))
        SQL
        );
        $this->addSql(
            <<<'SQL'
            CREATE UNIQUE INDEX UNIQ_CCC80D5B1D11A499 ON wallet_wallet (user_sso_id)
        SQL
        );
        $this->addSql(
            <<<'SQL'
            COMMENT ON COLUMN wallet_wallet.createdAt IS '(DC2Type:datetime_immutable)'
        SQL
        );
        $this->addSql(
            <<<'SQL'
            COMMENT ON COLUMN wallet_wallet.updatedAt IS '(DC2Type:datetime_immutable)'
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE user_user_role ADD CONSTRAINT FK_2D084B47A76ED395 FOREIGN KEY (user_id) REFERENCES user_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE wallet_transaction ADD CONSTRAINT FK_7DAF972712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet_wallet (id) NOT DEFERRABLE INITIALLY IMMEDIATE
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
            ALTER TABLE user_user_role DROP CONSTRAINT FK_2D084B47A76ED395
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE wallet_transaction DROP CONSTRAINT FK_7DAF972712520F3
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP TABLE user_user
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP TABLE user_user_role
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP TABLE wallet_transaction
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP TABLE wallet_wallet
        SQL
        );
    }
}
