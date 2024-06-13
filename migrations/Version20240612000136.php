<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240612000136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
CREATE TABLE users (
    id INTEGER PRIMARY KEY NOT NULL, 
    first_name VARCHAR(255) NOT NULL, 
    last_name VARCHAR(255) NOT NULL,
    -- Which type to use?
    -- credit_balance INTEGER UNSIGNED NOT NULL
    -- credit_balance INTEGER NOT NULL
    -- credit_balance FLOAT NOT NULL
);
SQL
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE users');
    }
}
