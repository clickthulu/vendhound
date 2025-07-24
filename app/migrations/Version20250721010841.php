<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250721010841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(500) NOT NULL, path VARCHAR(1000) NOT NULL, dimension_x INT NOT NULL, dimension_y INT NOT NULL, size INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category CHANGE createdon created_on DATETIME NOT NULL');
        $this->addSql('ALTER TABLE dealership CHANGE taxid tax_id VARCHAR(255) DEFAULT NULL, CHANGE productsandservices products_and_services LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE `table` CHANGE createdon created_on DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE createdon created_on DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE image');
        $this->addSql('ALTER TABLE user CHANGE created_on createdon DATETIME NOT NULL');
        $this->addSql('ALTER TABLE category CHANGE created_on createdon DATETIME NOT NULL');
        $this->addSql('ALTER TABLE dealership CHANGE tax_id taxid VARCHAR(255) DEFAULT NULL, CHANGE products_and_services productsandservices LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE `table` CHANGE created_on createdon DATETIME NOT NULL');
    }
}
