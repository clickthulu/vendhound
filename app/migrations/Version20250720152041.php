<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250720152041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE settings (id INT AUTO_INCREMENT NOT NULL, setting VARCHAR(255) NOT NULL, value VARCHAR(255) DEFAULT NULL, modifiedon DATETIME NOT NULL, defaultvalue VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, help LONGTEXT DEFAULT NULL, display_name VARCHAR(255) DEFAULT NULL, sourceoptions LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_E545A0C59F74B898 (setting), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql("INSERT INTO settings (setting, value, defaultvalue, modifiedon, type, help, display_name, sourceoptions) values ('allow_user_signup', '0', '0', NOW(), 'bool', 'Allow users to register without approval.', 'Open user registration', null)");
        $this->addSql("INSERT INTO settings (setting, value, defaultvalue, modifiedon, type, help, display_name, sourceoptions) values ('server_name', null, null, NOW(), 'string', 'Name of this Server', 'Server Name', null)");
        $this->addSql("INSERT INTO settings (setting, value, defaultvalue, modifiedon, type, help, display_name, sourceoptions) values ('server_url', null, null, NOW(), 'string', 'Server\'s URL', 'Server URL', null)");
        $this->addSql("INSERT INTO settings (setting, value, defaultvalue, modifiedon, type, help, display_name, sourceoptions) values ('debug_mode', '0', '0', NOW(), 'bool', 'Turn on debug features for testing', 'Debug Mode:', null)");
        $this->addSql("INSERT INTO settings (setting, value, defaultvalue, modifiedon, type, help, display_name, sourceoptions) values ('bug_tracking', null, null, NOW(), 'string', 'Location of a bug tracker/feature request site', 'Bug Tracking', null)");
        $this->addSql("INSERT INTO settings (setting, value, defaultvalue, modifiedon, type, help, display_name, sourceoptions) values ('unit_of_measurement', 'cm', 'cm', NOW(), 'string', 'Default unit of measurement', 'Unit of Measurement', 'App\Enumerations\UnitOfMeasurement')");



    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE settings');
    }
}
