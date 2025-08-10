<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250810205155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dealership ADD email VARCHAR(255) NOT NULL, ADD legalname VARCHAR(255) NOT NULL, ADD phone VARCHAR(255) NOT NULL, ADD website VARCHAR(255) DEFAULT NULL, ADD rating VARCHAR(255) DEFAULT NULL, ADD special_requests LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE mailing_address ADD user_id_id INT DEFAULT NULL, ADD address_type LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE mailing_address ADD CONSTRAINT FK_1C9E8AEE9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1C9E8AEE9D86650F ON mailing_address (user_id_id)');
        $this->addSql('ALTER TABLE `table` ADD dealership_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `table` ADD CONSTRAINT FK_F6298F468CF5FC51 FOREIGN KEY (dealership_id) REFERENCES dealership (id)');
        $this->addSql('CREATE INDEX IDX_F6298F468CF5FC51 ON `table` (dealership_id)');
        $this->addSql('ALTER TABLE table_type CHANGE num_user_slots num_user_slots INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dealership DROP email, DROP legalname, DROP phone, DROP website, DROP rating, DROP special_requests');
        $this->addSql('ALTER TABLE mailing_address DROP FOREIGN KEY FK_1C9E8AEE9D86650F');
        $this->addSql('DROP INDEX IDX_1C9E8AEE9D86650F ON mailing_address');
        $this->addSql('ALTER TABLE mailing_address DROP user_id_id, DROP address_type');
        $this->addSql('ALTER TABLE table_type CHANGE num_user_slots num_user_slots INT DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE `table` DROP FOREIGN KEY FK_F6298F468CF5FC51');
        $this->addSql('DROP INDEX IDX_F6298F468CF5FC51 ON `table`');
        $this->addSql('ALTER TABLE `table` DROP dealership_id');
    }
}
