<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250721012458 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dealership CHANGE createdOn created_on DATETIME NOT NULL');
        $this->addSql('ALTER TABLE note CHANGE createdOn created_on DATETIME NOT NULL');
        $this->addSql('ALTER TABLE table_type CHANGE createdOn created_on DATETIME NOT NULL');
        $this->addSql('ALTER TABLE tag CHANGE createdOn created_on DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tag CHANGE created_on createdOn DATETIME NOT NULL');
        $this->addSql('ALTER TABLE dealership CHANGE created_on createdOn DATETIME NOT NULL');
        $this->addSql('ALTER TABLE table_type CHANGE created_on createdOn DATETIME NOT NULL');
        $this->addSql('ALTER TABLE note CHANGE created_on createdOn DATETIME NOT NULL');
    }
}
