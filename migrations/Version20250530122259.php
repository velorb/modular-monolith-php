<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250530122259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'User. Add email, first name, last name fields and unique indexes for sso_id and username';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<'SQL'
            ALTER TABLE user_user ADD email VARCHAR(255) NOT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE user_user ADD first_name VARCHAR(255) NOT NULL
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE user_user ADD last_name VARCHAR(255) NOT NULL
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
            DROP INDEX UNIQ_F7129A807843BFA4
        SQL
        );
        $this->addSql(
            <<<'SQL'
            DROP INDEX UNIQ_F7129A80F85E0677
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE user_user DROP email
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE user_user DROP first_name
        SQL
        );
        $this->addSql(
            <<<'SQL'
            ALTER TABLE user_user DROP last_name
        SQL
        );
    }
}
