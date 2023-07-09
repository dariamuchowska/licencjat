<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230703130908 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE breeds (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX uq_breeds_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dogs (id INT AUTO_INCREMENT NOT NULL, breed_id INT NOT NULL, gender_id INT NOT NULL, size_id INT NOT NULL, name VARCHAR(100) NOT NULL, age INT NOT NULL, description VARCHAR(500) NOT NULL, photo_filename VARCHAR(255) DEFAULT NULL, INDEX IDX_353BEEB3A8B4A30F (breed_id), INDEX IDX_353BEEB3708A0E0 (gender_id), INDEX IDX_353BEEB3498DA827 (size_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genders (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX uq_genders_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sizes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX uq_sizes_name (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dogs ADD CONSTRAINT FK_353BEEB3A8B4A30F FOREIGN KEY (breed_id) REFERENCES breeds (id)');
        $this->addSql('ALTER TABLE dogs ADD CONSTRAINT FK_353BEEB3708A0E0 FOREIGN KEY (gender_id) REFERENCES genders (id)');
        $this->addSql('ALTER TABLE dogs ADD CONSTRAINT FK_353BEEB3498DA827 FOREIGN KEY (size_id) REFERENCES sizes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dogs DROP FOREIGN KEY FK_353BEEB3A8B4A30F');
        $this->addSql('ALTER TABLE dogs DROP FOREIGN KEY FK_353BEEB3708A0E0');
        $this->addSql('ALTER TABLE dogs DROP FOREIGN KEY FK_353BEEB3498DA827');
        $this->addSql('DROP TABLE breeds');
        $this->addSql('DROP TABLE dogs');
        $this->addSql('DROP TABLE genders');
        $this->addSql('DROP TABLE sizes');
    }
}
