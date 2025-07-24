<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250723025643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD uploaded_by_id INT NOT NULL, ADD assoc_dealership_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FA2B28FE8 FOREIGN KEY (uploaded_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F64500F49 FOREIGN KEY (assoc_dealership_id) REFERENCES dealership (id)');
        $this->addSql('CREATE INDEX IDX_C53D045FA2B28FE8 ON image (uploaded_by_id)');
        $this->addSql('CREATE INDEX IDX_C53D045F64500F49 ON image (assoc_dealership_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FA2B28FE8');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F64500F49');
        $this->addSql('DROP INDEX IDX_C53D045FA2B28FE8 ON image');
        $this->addSql('DROP INDEX IDX_C53D045F64500F49 ON image');
        $this->addSql('ALTER TABLE image DROP uploaded_by_id, DROP assoc_dealership_id');
    }
}
