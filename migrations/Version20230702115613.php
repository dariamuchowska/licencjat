<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230702115613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dogs ADD photo_filename VARCHAR(255) DEFAULT NULL, DROP picture, DROP sex, DROP size, CHANGE name name VARCHAR(100) NOT NULL, CHANGE age age INT NOT NULL, CHANGE description description VARCHAR(500) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dogs ADD picture LONGBLOB DEFAULT NULL, ADD sex VARCHAR(100) DEFAULT NULL, ADD size VARCHAR(100) DEFAULT NULL, DROP photo_filename, CHANGE name name VARCHAR(100) DEFAULT NULL, CHANGE age age INT DEFAULT NULL, CHANGE description description LONGTEXT NOT NULL');
    }
}
