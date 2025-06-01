<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250601131132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'User. CyclistVerificationProcess table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            CREATE TABLE user_cyclist_verification_process (user_id VARCHAR(36) NOT NULL, profile_data_verified BOOLEAN NOT NULL, wallet_minimum_balance_reached BOOLEAN NOT NULL, completed BOOLEAN NOT NULL, history JSON NOT NULL, id VARCHAR(36) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_F1405F3DA76ED395 ON user_cyclist_verification_process (user_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql(<<<'SQL'
            DROP TABLE user_cyclist_verification_process
        SQL);
    }
}
