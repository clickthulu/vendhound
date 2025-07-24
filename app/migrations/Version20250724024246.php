<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250724024246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, voter_id_id INT NOT NULL, voted_for_id INT DEFAULT NULL, INDEX IDX_5A10856457F158CD (voter_id_id), INDEX IDX_5A108564861D2E7D (voted_for_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote_event (id INT AUTO_INCREMENT NOT NULL, added_by_id INT NOT NULL, votes_per_curator INT NOT NULL, start_time DATETIME DEFAULT NULL, end_time DATETIME DEFAULT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_6AC7686C55B127A4 (added_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A10856457F158CD FOREIGN KEY (voter_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564861D2E7D FOREIGN KEY (voted_for_id) REFERENCES dealership (id)');
        $this->addSql('ALTER TABLE vote_event ADD CONSTRAINT FK_6AC7686C55B127A4 FOREIGN KEY (added_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE dealership ADD is_accepted TINYINT(1) NOT NULL, ADD is_paid TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE image ADD usage_type LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE user ADD assoc_dealership_id INT DEFAULT NULL, ADD is_registered TINYINT(1) NOT NULL, ADD is_paid TINYINT(1) NOT NULL, ADD phone_number VARCHAR(255) DEFAULT NULL, ADD mailing_address VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64964500F49 FOREIGN KEY (assoc_dealership_id) REFERENCES dealership (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64964500F49 ON user (assoc_dealership_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A10856457F158CD');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564861D2E7D');
        $this->addSql('ALTER TABLE vote_event DROP FOREIGN KEY FK_6AC7686C55B127A4');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP TABLE vote_event');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64964500F49');
        $this->addSql('DROP INDEX IDX_8D93D64964500F49 ON user');
        $this->addSql('ALTER TABLE user DROP assoc_dealership_id, DROP is_registered, DROP is_paid, DROP phone_number, DROP mailing_address');
        $this->addSql('ALTER TABLE dealership DROP is_accepted, DROP is_paid');
        $this->addSql('ALTER TABLE image DROP usage_type');
    }
}
