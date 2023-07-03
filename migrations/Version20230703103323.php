<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230703103323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dogs ADD gender_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dogs ADD CONSTRAINT FK_353BEEB3708A0E0 FOREIGN KEY (gender_id) REFERENCES genders (id)');
        $this->addSql('CREATE INDEX IDX_353BEEB3708A0E0 ON dogs (gender_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dogs DROP FOREIGN KEY FK_353BEEB3708A0E0');
        $this->addSql('DROP INDEX IDX_353BEEB3708A0E0 ON dogs');
        $this->addSql('ALTER TABLE dogs DROP gender_id');
    }
}
