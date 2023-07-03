<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230703112206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dogs DROP FOREIGN KEY FK_353BEEB3498DA827');
        $this->addSql('ALTER TABLE dogs ADD CONSTRAINT FK_353BEEB3498DA827 FOREIGN KEY (size_id) REFERENCES sizes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dogs DROP FOREIGN KEY FK_353BEEB3498DA827');
        $this->addSql('ALTER TABLE dogs ADD CONSTRAINT FK_353BEEB3498DA827 FOREIGN KEY (size_id) REFERENCES genders (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
