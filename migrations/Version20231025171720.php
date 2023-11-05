<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231025171720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vacancies_parse_query DROP CONSTRAINT fk_b83b38eeda088960');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE settings_id_seq CASCADE');
        $this->addSql('ALTER TABLE settings DROP CONSTRAINT fk_e545a0c5da088960');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE settings');
        $this->addSql('DROP INDEX idx_b83b38eeda088960');
        $this->addSql('ALTER TABLE vacancies_parse_query DROP link_user_id');
        $this->addSql('ALTER TABLE vacancies_parse_query DROP additional_words');
        $this->addSql('ALTER TABLE vacancies_parse_query RENAME COLUMN industry TO industries');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE settings_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_8d93d649f85e0677 ON "user" (username)');
        $this->addSql('CREATE TABLE settings (id INT NOT NULL, link_user_id INT NOT NULL, api_key VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_e545a0c5da088960 ON settings (link_user_id)');
        $this->addSql('ALTER TABLE settings ADD CONSTRAINT fk_e545a0c5da088960 FOREIGN KEY (link_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vacancies_parse_query ADD link_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE vacancies_parse_query ADD additional_words VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE vacancies_parse_query RENAME COLUMN industries TO industry');
        $this->addSql('ALTER TABLE vacancies_parse_query ADD CONSTRAINT fk_b83b38eeda088960 FOREIGN KEY (link_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b83b38eeda088960 ON vacancies_parse_query (link_user_id)');
    }
}
