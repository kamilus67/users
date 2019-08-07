<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190804164742 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE eav_attributes (id INT AUTO_INCREMENT NOT NULL, attribute_code VARCHAR(255) NOT NULL, entity_type_id INT NOT NULL, label VARCHAR(255) NOT NULL, type VARCHAR(50) NOT NULL, eav_type VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eav_attributes_option (id INT AUTO_INCREMENT NOT NULL, attribute_id VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_entity (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, email VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_entity_int (id INT AUTO_INCREMENT NOT NULL, attribute_id INT NOT NULL, entity_id INT NOT NULL, value INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_entity_varchar (id INT AUTO_INCREMENT NOT NULL, attribute_id INT NOT NULL, entity_id INT NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');

        $this->addSql("INSERT INTO eav_attributes (id, attribute_code, entity_type_id, label, type, eav_type) VALUES (1, 'stanowisko', 0, 'Stanowisko', 'select', 'int')");

        $this->addSql("INSERT INTO eav_attributes_option (attribute_id, value) VALUES (1, 'Tester')");
        $this->addSql("INSERT INTO eav_attributes_option (attribute_id, value) VALUES (2, 'Developer')");
        $this->addSql("INSERT INTO eav_attributes_option (attribute_id, value) VALUES (3, 'Project manager')");

        $this->addSql("INSERT INTO eav_attributes (attribute_code, entity_type_id, label, type, eav_type) VALUES ('systemy_testujace', 1, 'Systemy testujące', 'text', 'varchar')");
        $this->addSql("INSERT INTO eav_attributes (attribute_code, entity_type_id, label, type, eav_type) VALUES ('systemy_raportowe', 1, 'Systemy raportowe', 'text', 'varchar')");
        $this->addSql("INSERT INTO eav_attributes (attribute_code, entity_type_id, label, type, eav_type) VALUES ('zna_selenium', 1, 'Zna selenium', 'checkbox', 'int')");

        $this->addSql("INSERT INTO eav_attributes (attribute_code, entity_type_id, label, type, eav_type) VALUES ('srodowiska_ide', 2, 'Środowiska IDE', 'text', 'varchar')");
        $this->addSql("INSERT INTO eav_attributes (attribute_code, entity_type_id, label, type, eav_type) VALUES ('jezyki_programowania', 2, 'Języki programowania', 'text', 'varchar')");
        $this->addSql("INSERT INTO eav_attributes (attribute_code, entity_type_id, label, type, eav_type) VALUES ('zna_mysql', 2, 'Zna MySQL', 'checkbox', 'int')");

        $this->addSql("INSERT INTO eav_attributes (attribute_code, entity_type_id, label, type, eav_type) VALUES ('metodologie_prowadzenia_projektow', 3, 'Metodologie prowadzenia projektów', 'text', 'varchar')");
        $this->addSql("INSERT INTO eav_attributes (attribute_code, entity_type_id, label, type, eav_type) VALUES ('zna_scrum', 3, 'Zna Scrum', 'checkbox', 'int')");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE eav_attributes');
        $this->addSql('DROP TABLE eav_attributes_option');
        $this->addSql('DROP TABLE user_entity');
        $this->addSql('DROP TABLE user_entity_int');
        $this->addSql('DROP TABLE user_entity_varchar');
    }
}
