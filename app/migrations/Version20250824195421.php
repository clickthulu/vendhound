<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250824195421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE table_add_on (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, additional_cost DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dealership ADD table_request_type_second_id INT DEFAULT NULL, ADD table_request_type_three_id INT DEFAULT NULL, ADD table_add_on_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dealership ADD CONSTRAINT FK_7D7A975DCEB02DD5 FOREIGN KEY (table_request_type_second_id) REFERENCES table_type (id)');
        $this->addSql('ALTER TABLE dealership ADD CONSTRAINT FK_7D7A975D3F19FBCB FOREIGN KEY (table_request_type_three_id) REFERENCES table_type (id)');
        $this->addSql('ALTER TABLE dealership ADD CONSTRAINT FK_7D7A975DA449EEA8 FOREIGN KEY (table_add_on_id) REFERENCES table_add_on (id)');
        $this->addSql('CREATE INDEX IDX_7D7A975DCEB02DD5 ON dealership (table_request_type_second_id)');
        $this->addSql('CREATE INDEX IDX_7D7A975D3F19FBCB ON dealership (table_request_type_three_id)');
        $this->addSql('CREATE INDEX IDX_7D7A975DA449EEA8 ON dealership (table_add_on_id)');
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
        $this->addSql('ALTER TABLE dealership DROP table_request_type_second_id, DROP table_request_type_three_id, DROP table_add_on_id');
    }
}
