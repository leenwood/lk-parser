<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230919125331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vacancies_parse_query ADD search_fields TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE vacancies_parse_query ADD industry INT DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN vacancies_parse_query.search_fields IS \'(DC2Type:array)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vacancies_parse_query DROP search_fields');
        $this->addSql('ALTER TABLE vacancies_parse_query DROP industry');
    }
}
