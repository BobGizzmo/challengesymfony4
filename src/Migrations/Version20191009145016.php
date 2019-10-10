<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191009145016 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, username, password, email, roles FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL COLLATE BINARY, password VARCHAR(255) NOT NULL COLLATE BINARY, email VARCHAR(255) NOT NULL COLLATE BINARY, roles VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, username, password, email, roles) SELECT id, username, password, email, roles FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('DROP INDEX IDX_67D5399D8BAC62AF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__house AS SELECT id, city_id, nomination, image, price, description FROM house');
        $this->addSql('DROP TABLE house');
        $this->addSql('CREATE TABLE house (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city_id INTEGER NOT NULL, nomination VARCHAR(255) NOT NULL COLLATE BINARY, image VARCHAR(255) NOT NULL COLLATE BINARY, price VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, CONSTRAINT FK_67D5399D8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO house (id, city_id, nomination, image, price, description) SELECT id, city_id, nomination, image, price, description FROM __temp__house');
        $this->addSql('DROP TABLE __temp__house');
        $this->addSql('CREATE INDEX IDX_67D5399D8BAC62AF ON house (city_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_67D5399D8BAC62AF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__house AS SELECT id, city_id, nomination, image, price, description FROM house');
        $this->addSql('DROP TABLE house');
        $this->addSql('CREATE TABLE house (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city_id INTEGER NOT NULL, nomination VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL, description CLOB NOT NULL)');
        $this->addSql('INSERT INTO house (id, city_id, nomination, image, price, description) SELECT id, city_id, nomination, image, price, description FROM __temp__house');
        $this->addSql('DROP TABLE __temp__house');
        $this->addSql('CREATE INDEX IDX_67D5399D8BAC62AF ON house (city_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, username, password, email, roles FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, roles CLOB NOT NULL COLLATE BINARY --(DC2Type:array)
        )');
        $this->addSql('INSERT INTO user (id, username, password, email, roles) SELECT id, username, password, email, roles FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }
}
