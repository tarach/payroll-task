<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210324224946 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE department (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, bonus_constant INTEGER DEFAULT NULL, bonus_percentage SMALLINT DEFAULT NULL)');
        $this->addSql('CREATE TABLE employee (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, department_id INTEGER NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, salary INTEGER NOT NULL, bonus_type SMALLINT NOT NULL, salary_with_bonus INTEGER DEFAULT NULL, hired_at DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_5D9F75A1AE80F5DF ON employee (department_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE department');
        $this->addSql('DROP TABLE employee');
    }
}
