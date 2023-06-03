<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230603145019 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket ADD id_state_id INT NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA35503D054 FOREIGN KEY (id_state_id) REFERENCES state (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA35503D054 ON ticket (id_state_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA35503D054');
        $this->addSql('DROP INDEX IDX_97A0ADA35503D054 ON ticket');
        $this->addSql('ALTER TABLE ticket DROP id_state_id');
    }
}
