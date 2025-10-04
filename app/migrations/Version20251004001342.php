<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251004001342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add missing columns to dealership and table tables, create table_add_on table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE table_add_on (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, additional_cost DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dealership ADD table_request_type_second_id INT DEFAULT NULL, ADD table_request_type_three_id INT DEFAULT NULL, ADD table_add_on_id INT DEFAULT NULL, ADD email VARCHAR(255) NOT NULL, ADD legalname VARCHAR(255) NOT NULL, ADD phone VARCHAR(255) NOT NULL, ADD website VARCHAR(255) DEFAULT NULL, ADD rating VARCHAR(255) DEFAULT NULL, ADD special_requests LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE dealership ADD CONSTRAINT fk_dealership_table_type_second FOREIGN KEY (table_request_type_second_id) REFERENCES table_type (id)');
        $this->addSql('ALTER TABLE dealership ADD CONSTRAINT fk_dealership_table_type_three FOREIGN KEY (table_request_type_three_id) REFERENCES table_type (id)');
        $this->addSql('ALTER TABLE dealership ADD CONSTRAINT fk_dealership_table_addon FOREIGN KEY (table_add_on_id) REFERENCES table_add_on (id)');
        $this->addSql('CREATE INDEX idx_dealership_table_type_second ON dealership (table_request_type_second_id)');
        $this->addSql('CREATE INDEX idx_dealership_table_type_three ON dealership (table_request_type_three_id)');
        $this->addSql('CREATE INDEX idx_dealership_table_addon ON dealership (table_add_on_id)');
        $this->addSql('ALTER TABLE `table` ADD dealership_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `table` ADD CONSTRAINT fk_table_dealership FOREIGN KEY (dealership_id) REFERENCES dealership (id)');
        $this->addSql('CREATE INDEX idx_table_dealership ON `table` (dealership_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dealership DROP FOREIGN KEY FK_7D7A975DA449EEA8');
        $this->addSql('DROP TABLE table_add_on');
        $this->addSql('ALTER TABLE dealership DROP FOREIGN KEY FK_7D7A975DCEB02DD5');
        $this->addSql('ALTER TABLE dealership DROP FOREIGN KEY FK_7D7A975D3F19FBCB');
        $this->addSql('DROP INDEX IDX_7D7A975DCEB02DD5 ON dealership');
        $this->addSql('DROP INDEX IDX_7D7A975D3F19FBCB ON dealership');
        $this->addSql('DROP INDEX IDX_7D7A975DA449EEA8 ON dealership');
        $this->addSql('ALTER TABLE dealership DROP table_request_type_second_id, DROP table_request_type_three_id, DROP table_add_on_id, DROP email, DROP legalname, DROP phone, DROP website, DROP rating, DROP special_requests');
        $this->addSql('ALTER TABLE `table` DROP FOREIGN KEY FK_F6298F468CF5FC51');
        $this->addSql('DROP INDEX IDX_F6298F468CF5FC51 ON `table`');
        $this->addSql('ALTER TABLE `table` DROP dealership_id');
    }
}
