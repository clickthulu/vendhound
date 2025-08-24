<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250810013515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dealership ADD owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE dealership ADD CONSTRAINT FK_7D7A975D7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7D7A975D7E3C61F9 ON dealership (owner_id)');
        $this->addSql('ALTER TABLE mailing_address ADD user_id INT NOT NULL, ADD nickname VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE mailing_address ADD CONSTRAINT FK_1C9E8AEEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1C9E8AEEA76ED395 ON mailing_address (user_id)');
        $this->addSql('ALTER TABLE table_type CHANGE num_user_slots num_user_slots INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dealership DROP FOREIGN KEY FK_7D7A975D7E3C61F9');
        $this->addSql('DROP INDEX UNIQ_7D7A975D7E3C61F9 ON dealership');
        $this->addSql('ALTER TABLE dealership DROP owner_id');
        $this->addSql('ALTER TABLE mailing_address DROP FOREIGN KEY FK_1C9E8AEEA76ED395');
        $this->addSql('DROP INDEX IDX_1C9E8AEEA76ED395 ON mailing_address');
        $this->addSql('ALTER TABLE mailing_address DROP user_id, DROP nickname');
        $this->addSql('ALTER TABLE table_type CHANGE num_user_slots num_user_slots INT DEFAULT 1 NOT NULL');
    }
}
