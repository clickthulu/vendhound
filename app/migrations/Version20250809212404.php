<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250809212404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dealer_area (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dealership ADD area_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dealership ADD CONSTRAINT FK_7D7A975DBD0F409C FOREIGN KEY (area_id) REFERENCES dealer_area (id)');
        $this->addSql('CREATE INDEX IDX_7D7A975DBD0F409C ON dealership (area_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dealership DROP FOREIGN KEY FK_7D7A975DBD0F409C');
        $this->addSql('DROP INDEX IDX_7D7A975DBD0F409C ON dealership');
        $this->addSql('ALTER TABLE dealership DROP area_id');
    }
}
