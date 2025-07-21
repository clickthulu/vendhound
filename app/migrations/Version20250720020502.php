<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250720020502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, createdOn DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dealership (id INT AUTO_INCREMENT NOT NULL, table_request_type_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, taxID VARCHAR(255) DEFAULT NULL, productsAndServices LONGTEXT DEFAULT NULL, createdOn DATETIME NOT NULL, INDEX IDX_7D7A975D2C1AB4C6 (table_request_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dealership_category (dealership_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_7170D6128CF5FC51 (dealership_id), INDEX IDX_7170D61212469DE2 (category_id), PRIMARY KEY(dealership_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, dealership_id INT DEFAULT NULL, author_id INT NOT NULL, title VARCHAR(255) NOT NULL, note LONGTEXT NOT NULL, createdOn DATETIME NOT NULL, INDEX IDX_CFBDFA148CF5FC51 (dealership_id), INDEX IDX_CFBDFA14F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE table_tag (table_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_A6C3DE7ECFF285C (table_id), INDEX IDX_A6C3DE7BAD26311 (tag_id), PRIMARY KEY(table_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE table_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, width DOUBLE PRECISION NOT NULL, depth DOUBLE PRECISION NOT NULL, createdOn DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, createdOn DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dealership ADD CONSTRAINT FK_7D7A975D2C1AB4C6 FOREIGN KEY (table_request_type_id) REFERENCES table_type (id)');
        $this->addSql('ALTER TABLE dealership_category ADD CONSTRAINT FK_7170D6128CF5FC51 FOREIGN KEY (dealership_id) REFERENCES dealership (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dealership_category ADD CONSTRAINT FK_7170D61212469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA148CF5FC51 FOREIGN KEY (dealership_id) REFERENCES dealership (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE table_tag ADD CONSTRAINT FK_A6C3DE7ECFF285C FOREIGN KEY (table_id) REFERENCES `table` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE table_tag ADD CONSTRAINT FK_A6C3DE7BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `table` ADD createdOn DATETIME NOT NULL, DROP is_endcap, DROP is_mature');
        $this->addSql('ALTER TABLE user ADD createdOn DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dealership DROP FOREIGN KEY FK_7D7A975D2C1AB4C6');
        $this->addSql('ALTER TABLE dealership_category DROP FOREIGN KEY FK_7170D6128CF5FC51');
        $this->addSql('ALTER TABLE dealership_category DROP FOREIGN KEY FK_7170D61212469DE2');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA148CF5FC51');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14F675F31B');
        $this->addSql('ALTER TABLE table_tag DROP FOREIGN KEY FK_A6C3DE7ECFF285C');
        $this->addSql('ALTER TABLE table_tag DROP FOREIGN KEY FK_A6C3DE7BAD26311');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE dealership');
        $this->addSql('DROP TABLE dealership_category');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE table_tag');
        $this->addSql('DROP TABLE table_type');
        $this->addSql('DROP TABLE tag');
        $this->addSql('ALTER TABLE `table` ADD is_endcap TINYINT(1) NOT NULL, ADD is_mature TINYINT(1) NOT NULL, DROP createdOn');
        $this->addSql('ALTER TABLE user DROP createdOn');
    }
}
