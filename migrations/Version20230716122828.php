<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230716122828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dogs CHANGE breed_id breed_id INT DEFAULT NULL, CHANGE gender_id gender_id INT DEFAULT NULL, CHANGE size_id size_id INT DEFAULT NULL, CHANGE author_id author_id INT DEFAULT NULL, CHANGE photo_filename photo_filename VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dogs CHANGE breed_id breed_id INT NOT NULL, CHANGE gender_id gender_id INT NOT NULL, CHANGE size_id size_id INT NOT NULL, CHANGE author_id author_id INT NOT NULL, CHANGE photo_filename photo_filename VARCHAR(255) NOT NULL');
    }
}
