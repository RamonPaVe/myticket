<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230605161306 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notes_user DROP FOREIGN KEY FK_C5C8C0C8A76ED395');
        $this->addSql('ALTER TABLE notes_user DROP FOREIGN KEY FK_C5C8C0C8FC56F556');
        $this->addSql('DROP TABLE notes_user');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68C79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_11BA68C79F37AE5 ON notes (id_user_id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA35503D054 FOREIGN KEY (id_state_id) REFERENCES state (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA35503D054 ON ticket (id_state_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notes_user (notes_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C5C8C0C8FC56F556 (notes_id), INDEX IDX_C5C8C0C8A76ED395 (user_id), PRIMARY KEY(notes_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE notes_user ADD CONSTRAINT FK_C5C8C0C8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notes_user ADD CONSTRAINT FK_C5C8C0C8FC56F556 FOREIGN KEY (notes_id) REFERENCES notes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notes DROP FOREIGN KEY FK_11BA68C79F37AE5');
        $this->addSql('DROP INDEX IDX_11BA68C79F37AE5 ON notes');
        $this->addSql('ALTER TABLE notes DROP id_user_id, CHANGE id_ticket_id id_ticket_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA35503D054');
        $this->addSql('DROP INDEX IDX_97A0ADA35503D054 ON ticket');
    }
}
