<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230906144056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE vacancies_by_region_query_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE vacancies_parse_query_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE vacancies_parse_query (id INT NOT NULL, link_user_id INT NOT NULL, search_text VARCHAR(255) NOT NULL, region_id VARCHAR(255) NOT NULL, request_time INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B83B38EEDA088960 ON vacancies_parse_query (link_user_id)');
        $this->addSql('ALTER TABLE vacancies_parse_query ADD CONSTRAINT FK_B83B38EEDA088960 FOREIGN KEY (link_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vacancies_by_region_query DROP CONSTRAINT fk_3c436fc5da088960');
        $this->addSql('DROP TABLE vacancies_by_region_query');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE vacancies_parse_query_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE vacancies_by_region_query_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE vacancies_by_region_query (id INT NOT NULL, link_user_id INT NOT NULL, search_text VARCHAR(255) NOT NULL, region_id VARCHAR(255) NOT NULL, request_time INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_3c436fc5da088960 ON vacancies_by_region_query (link_user_id)');
        $this->addSql('ALTER TABLE vacancies_by_region_query ADD CONSTRAINT fk_3c436fc5da088960 FOREIGN KEY (link_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vacancies_parse_query DROP CONSTRAINT FK_B83B38EEDA088960');
        $this->addSql('DROP TABLE vacancies_parse_query');
    }
}
