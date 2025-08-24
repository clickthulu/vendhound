<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250824164645 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vote_event_dealer_area (vote_event_id INT NOT NULL, dealer_area_id INT NOT NULL, INDEX IDX_6933347F8FA841A2 (vote_event_id), INDEX IDX_6933347FFBD16ECF (dealer_area_id), PRIMARY KEY(vote_event_id, dealer_area_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote_event_table_type (vote_event_id INT NOT NULL, table_type_id INT NOT NULL, INDEX IDX_A03075138FA841A2 (vote_event_id), INDEX IDX_A0307513C77FCD9C (table_type_id), PRIMARY KEY(vote_event_id, table_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote_event_tag (vote_event_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_500AB5958FA841A2 (vote_event_id), INDEX IDX_500AB595BAD26311 (tag_id), PRIMARY KEY(vote_event_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vote_event_dealer_area ADD CONSTRAINT FK_6933347F8FA841A2 FOREIGN KEY (vote_event_id) REFERENCES vote_event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote_event_dealer_area ADD CONSTRAINT FK_6933347FFBD16ECF FOREIGN KEY (dealer_area_id) REFERENCES dealer_area (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote_event_table_type ADD CONSTRAINT FK_A03075138FA841A2 FOREIGN KEY (vote_event_id) REFERENCES vote_event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote_event_table_type ADD CONSTRAINT FK_A0307513C77FCD9C FOREIGN KEY (table_type_id) REFERENCES table_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote_event_tag ADD CONSTRAINT FK_500AB5958FA841A2 FOREIGN KEY (vote_event_id) REFERENCES vote_event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote_event_tag ADD CONSTRAINT FK_500AB595BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote_event ADD max_curator_votes_per_applicant INT DEFAULT NULL, ADD sql_query VARCHAR(10000) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vote_event_dealer_area DROP FOREIGN KEY FK_6933347F8FA841A2');
        $this->addSql('ALTER TABLE vote_event_dealer_area DROP FOREIGN KEY FK_6933347FFBD16ECF');
        $this->addSql('ALTER TABLE vote_event_table_type DROP FOREIGN KEY FK_A03075138FA841A2');
        $this->addSql('ALTER TABLE vote_event_table_type DROP FOREIGN KEY FK_A0307513C77FCD9C');
        $this->addSql('ALTER TABLE vote_event_tag DROP FOREIGN KEY FK_500AB5958FA841A2');
        $this->addSql('ALTER TABLE vote_event_tag DROP FOREIGN KEY FK_500AB595BAD26311');
        $this->addSql('DROP TABLE vote_event_dealer_area');
        $this->addSql('DROP TABLE vote_event_table_type');
        $this->addSql('DROP TABLE vote_event_tag');
        $this->addSql('ALTER TABLE vote_event DROP max_curator_votes_per_applicant, DROP sql_query');
    }
}
