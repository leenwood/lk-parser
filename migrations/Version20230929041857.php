<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230929041857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vacancies_parse_query ADD only_with_salary BOOLEAN DEFAULT NULL');
        $this->addSql('UPDATE vacancies_parse_query SET industry = NULL');
        $this->addSql('ALTER TABLE vacancies_parse_query ALTER industry TYPE TEXT');
        $this->addSql('COMMENT ON COLUMN vacancies_parse_query.industry IS \'(DC2Type:array)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vacancies_parse_query DROP only_with_salary');
        $this->addSql('UPDATE vacancies_parse_query SET industry = NULL');
        $this->addSql('ALTER TABLE vacancies_parse_query ALTER industry TYPE INT');
        $this->addSql('COMMENT ON COLUMN vacancies_parse_query.industry IS NULL');
    }
}
