<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230905054631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE settings_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE settings (id INT NOT NULL, link_user_id INT NOT NULL, api_key VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E545A0C5DA088960 ON settings (link_user_id)');
        $this->addSql('ALTER TABLE settings ADD CONSTRAINT FK_E545A0C5DA088960 FOREIGN KEY (link_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE settings_id_seq CASCADE');
        $this->addSql('ALTER TABLE settings DROP CONSTRAINT FK_E545A0C5DA088960');
        $this->addSql('DROP TABLE settings');
    }
}
