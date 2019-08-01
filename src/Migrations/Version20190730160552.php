<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190730160552 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE genresinterets (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE interets ADD genresinterets_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE interets ADD CONSTRAINT FK_BD1B190323213092 FOREIGN KEY (genresinterets_id) REFERENCES genresinterets (id)');
        $this->addSql('CREATE INDEX IDX_BD1B190323213092 ON interets (genresinterets_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE interets DROP FOREIGN KEY FK_BD1B190323213092');
        $this->addSql('DROP TABLE genresinterets');
        $this->addSql('DROP INDEX IDX_BD1B190323213092 ON interets');
        $this->addSql('ALTER TABLE interets DROP genresinterets_id');
    }
}
