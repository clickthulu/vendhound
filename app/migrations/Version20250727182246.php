<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250727182246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_on DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dealership (id INT AUTO_INCREMENT NOT NULL, table_request_type_id INT DEFAULT NULL, mail_address_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, tax_id VARCHAR(255) DEFAULT NULL, products_and_services LONGTEXT DEFAULT NULL, created_on DATETIME NOT NULL, is_accepted TINYINT(1) NOT NULL, is_paid TINYINT(1) NOT NULL, INDEX IDX_7D7A975D2C1AB4C6 (table_request_type_id), UNIQUE INDEX UNIQ_7D7A975D21744589 (mail_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dealership_category (dealership_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_7170D6128CF5FC51 (dealership_id), INDEX IDX_7170D61212469DE2 (category_id), PRIMARY KEY(dealership_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, uploaded_by_id INT NOT NULL, assoc_dealership_id INT DEFAULT NULL, name VARCHAR(500) NOT NULL, path VARCHAR(1000) NOT NULL, dimension_x INT NOT NULL, dimension_y INT NOT NULL, size INT NOT NULL, usage_type LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', created_on DATETIME NOT NULL, INDEX IDX_C53D045FA2B28FE8 (uploaded_by_id), INDEX IDX_C53D045F64500F49 (assoc_dealership_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE mailing_address (id INT AUTO_INCREMENT NOT NULL, street1 VARCHAR(255) NOT NULL, street2 VARCHAR(255) DEFAULT NULL, street3 VARCHAR(255) DEFAULT NULL, city VARCHAR(255) NOT NULL, province VARCHAR(255) DEFAULT NULL, postal_code VARCHAR(255) DEFAULT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, dealership_id INT DEFAULT NULL, author_id INT NOT NULL, title VARCHAR(255) NOT NULL, note LONGTEXT NOT NULL, created_on DATETIME NOT NULL, INDEX IDX_CFBDFA148CF5FC51 (dealership_id), INDEX IDX_CFBDFA14F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE settings (id INT AUTO_INCREMENT NOT NULL, setting VARCHAR(255) NOT NULL, value VARCHAR(255) DEFAULT NULL, modifiedon DATETIME NOT NULL, defaultvalue VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, help LONGTEXT DEFAULT NULL, display_name VARCHAR(255) DEFAULT NULL, sourceoptions LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_E545A0C59F74B898 (setting), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `table` (id INT AUTO_INCREMENT NOT NULL, location_name VARCHAR(255) NOT NULL, width DOUBLE PRECISION NOT NULL, depth DOUBLE PRECISION NOT NULL, position_x DOUBLE PRECISION NOT NULL, position_y DOUBLE PRECISION NOT NULL, created_on DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE table_tag (table_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_A6C3DE7ECFF285C (table_id), INDEX IDX_A6C3DE7BAD26311 (tag_id), PRIMARY KEY(table_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE table_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, width DOUBLE PRECISION NOT NULL, depth DOUBLE PRECISION NOT NULL, created_on DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_on DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, dealership_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, created_on DATETIME NOT NULL, is_registered TINYINT(1) NOT NULL, is_paid TINYINT(1) NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, INDEX IDX_8D93D6498CF5FC51 (dealership_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, voter_id_id INT NOT NULL, voted_for_id INT DEFAULT NULL, event_id_id INT NOT NULL, last_updated DATETIME DEFAULT NULL, created_on DATETIME NOT NULL, update_count INT NOT NULL, INDEX IDX_5A10856457F158CD (voter_id_id), INDEX IDX_5A108564861D2E7D (voted_for_id), INDEX IDX_5A1085643E5F2F7B (event_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote_event (id INT AUTO_INCREMENT NOT NULL, added_by_id INT NOT NULL, votes_per_curator INT NOT NULL, start_time DATETIME DEFAULT NULL, end_time DATETIME DEFAULT NULL, is_active TINYINT(1) NOT NULL, created_on DATETIME NOT NULL, INDEX IDX_6AC7686C55B127A4 (added_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dealership ADD CONSTRAINT FK_7D7A975D2C1AB4C6 FOREIGN KEY (table_request_type_id) REFERENCES table_type (id)');
        $this->addSql('ALTER TABLE dealership ADD CONSTRAINT FK_7D7A975D21744589 FOREIGN KEY (mail_address_id) REFERENCES mailing_address (id)');
        $this->addSql('ALTER TABLE dealership_category ADD CONSTRAINT FK_7170D6128CF5FC51 FOREIGN KEY (dealership_id) REFERENCES dealership (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dealership_category ADD CONSTRAINT FK_7170D61212469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FA2B28FE8 FOREIGN KEY (uploaded_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F64500F49 FOREIGN KEY (assoc_dealership_id) REFERENCES dealership (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA148CF5FC51 FOREIGN KEY (dealership_id) REFERENCES dealership (id)');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE table_tag ADD CONSTRAINT FK_A6C3DE7ECFF285C FOREIGN KEY (table_id) REFERENCES `table` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE table_tag ADD CONSTRAINT FK_A6C3DE7BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498CF5FC51 FOREIGN KEY (dealership_id) REFERENCES dealership (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A10856457F158CD FOREIGN KEY (voter_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564861D2E7D FOREIGN KEY (voted_for_id) REFERENCES dealership (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A1085643E5F2F7B FOREIGN KEY (event_id_id) REFERENCES vote_event (id)');
        $this->addSql('ALTER TABLE vote_event ADD CONSTRAINT FK_6AC7686C55B127A4 FOREIGN KEY (added_by_id) REFERENCES user (id)');

        $this->addSql("INSERT INTO settings (setting, value, defaultvalue, modifiedon, type, help, display_name, sourceoptions) values ('allow_user_signup', '0', '0', NOW(), 'bool', 'Allow users to register without approval.', 'Open user registration', null)");
        $this->addSql("INSERT INTO settings (setting, value, defaultvalue, modifiedon, type, help, display_name, sourceoptions) values ('server_name', null, null, NOW(), 'string', 'Name of this Server', 'Server Name', null)");
        $this->addSql("INSERT INTO settings (setting, value, defaultvalue, modifiedon, type, help, display_name, sourceoptions) values ('server_url', null, null, NOW(), 'string', 'Server\'s URL', 'Server URL', null)");
        $this->addSql("INSERT INTO settings (setting, value, defaultvalue, modifiedon, type, help, display_name, sourceoptions) values ('debug_mode', '0', '0', NOW(), 'bool', 'Turn on debug features for testing', 'Debug Mode:', null)");
        $this->addSql("INSERT INTO settings (setting, value, defaultvalue, modifiedon, type, help, display_name, sourceoptions) values ('bug_tracking', null, null, NOW(), 'string', 'Location of a bug tracker/feature request site', 'Bug Tracking', null)");
        $this->addSql("INSERT INTO settings (setting, value, defaultvalue, modifiedon, type, help, display_name, sourceoptions) values ('unit_of_measurement', 'cm', 'cm', NOW(), 'string', 'Default unit of measurement', 'Unit of Measurement', 'App\\\\Enumerations\\\\UnitOfMeasurement')");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dealership DROP FOREIGN KEY FK_7D7A975D2C1AB4C6');
        $this->addSql('ALTER TABLE dealership DROP FOREIGN KEY FK_7D7A975D21744589');
        $this->addSql('ALTER TABLE dealership_category DROP FOREIGN KEY FK_7170D6128CF5FC51');
        $this->addSql('ALTER TABLE dealership_category DROP FOREIGN KEY FK_7170D61212469DE2');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FA2B28FE8');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F64500F49');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA148CF5FC51');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14F675F31B');
        $this->addSql('ALTER TABLE table_tag DROP FOREIGN KEY FK_A6C3DE7ECFF285C');
        $this->addSql('ALTER TABLE table_tag DROP FOREIGN KEY FK_A6C3DE7BAD26311');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6498CF5FC51');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A10856457F158CD');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564861D2E7D');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A1085643E5F2F7B');
        $this->addSql('ALTER TABLE vote_event DROP FOREIGN KEY FK_6AC7686C55B127A4');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE dealership');
        $this->addSql('DROP TABLE dealership_category');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE mailing_address');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE settings');
        $this->addSql('DROP TABLE `table`');
        $this->addSql('DROP TABLE table_tag');
        $this->addSql('DROP TABLE table_type');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vote');
        $this->addSql('DROP TABLE vote_event');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
