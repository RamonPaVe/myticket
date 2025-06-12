<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230508191834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3EDE70614 FOREIGN KEY (affected_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3A545015 FOREIGN KEY (id_category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA360A04351 FOREIGN KEY (id_subcategory_id) REFERENCES subcategory (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3F4E668C7 FOREIGN KEY (id_ticket_type_id) REFERENCES ticket_type (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA38359DF4E FOREIGN KEY (assigned_group_id) REFERENCES `group` (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3E5784294 FOREIGN KEY (creator_user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3A527067E FOREIGN KEY (assigned_user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3D9074F50 FOREIGN KEY (id_center_id) REFERENCES center (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA35169D40E FOREIGN KEY (id_priority_id) REFERENCES priority (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3F6AA732 FOREIGN KEY (id_level_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA31241655D FOREIGN KEY (id_provider_id) REFERENCES provider (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3EDE70614 ON ticket (affected_user_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3A545015 ON ticket (id_category_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA360A04351 ON ticket (id_subcategory_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3F4E668C7 ON ticket (id_ticket_type_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA38359DF4E ON ticket (assigned_group_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3E5784294 ON ticket (creator_user_id_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3A527067E ON ticket (assigned_user_id_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3D9074F50 ON ticket (id_center_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA35169D40E ON ticket (id_priority_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA3F6AA732 ON ticket (id_level_id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA31241655D ON ticket (id_provider_id)');
        $this->addSql('ALTER TABLE user ADD id_center_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D9074F50 FOREIGN KEY (id_center_id) REFERENCES center (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649D9074F50 ON user (id_center_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3EDE70614');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3A545015');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA360A04351');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3F4E668C7');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA38359DF4E');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3E5784294');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3A527067E');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3D9074F50');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA35169D40E');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3F6AA732');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA31241655D');
        $this->addSql('DROP INDEX IDX_97A0ADA3EDE70614 ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA3A545015 ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA360A04351 ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA3F4E668C7 ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA38359DF4E ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA3E5784294 ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA3A527067E ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA3D9074F50 ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA35169D40E ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA3F6AA732 ON ticket');
        $this->addSql('DROP INDEX IDX_97A0ADA31241655D ON ticket');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D9074F50');
        $this->addSql('DROP INDEX IDX_8D93D649D9074F50 ON user');
        $this->addSql('ALTER TABLE user DROP id_center_id');
    }
}
