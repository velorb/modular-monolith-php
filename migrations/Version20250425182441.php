<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250425182441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE user_user (id CHAR(26) NOT NULL, sso_id CHAR(36) NOT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN user_user.id IS '(DC2Type:s-user-user_id)'
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN user_user.sso_id IS '(DC2Type:user-user_sso_id)'
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user_user_role (user_id CHAR(26) NOT NULL, role VARCHAR(255) NOT NULL, PRIMARY KEY(user_id, role))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2D084B47A76ED395 ON user_user_role (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            COMMENT ON COLUMN user_user_role.user_id IS '(DC2Type:s-user-user_id)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_user_role ADD CONSTRAINT FK_2D084B47A76ED395 FOREIGN KEY (user_id) REFERENCES user_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_user_role DROP CONSTRAINT FK_2D084B47A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_user_role
        SQL);
    }
}
