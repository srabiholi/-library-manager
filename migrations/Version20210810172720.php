<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210810172720 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD library_id INT NOT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1FE2541D7 FOREIGN KEY (library_id) REFERENCES library (id)');
        $this->addSql('CREATE INDEX IDX_64C19C1FE2541D7 ON category (library_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1FE2541D7');
        $this->addSql('DROP INDEX IDX_64C19C1FE2541D7 ON category');
        $this->addSql('ALTER TABLE category DROP library_id');
    }
}
