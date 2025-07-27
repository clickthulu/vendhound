<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250724024721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vote ADD event_id_id INT NOT NULL, ADD last_updated DATETIME DEFAULT NULL, ADD created_on DATETIME NOT NULL, ADD update_count INT NOT NULL');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085643E5F2F7B FOREIGN KEY (event_id_id) REFERENCES vote_event (id)');
        $this->addSql('CREATE INDEX IDX_5A1085643E5F2F7B ON vote (event_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085643E5F2F7B');
        $this->addSql('DROP INDEX IDX_5A1085643E5F2F7B ON vote');
        $this->addSql('ALTER TABLE vote DROP event_id_id, DROP last_updated, DROP created_on, DROP update_count');
    }
}
