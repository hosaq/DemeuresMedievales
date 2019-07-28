<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190716065206 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE interets (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, lien VARCHAR(255) DEFAULT NULL, type1 VARCHAR(128) DEFAULT NULL, type2 VARCHAR(128) DEFAULT NULL, presentation LONGTEXT DEFAULT NULL, description LONGTEXT DEFAULT NULL, ville VARCHAR(128) DEFAULT NULL, region VARCHAR(128) DEFAULT NULL, lat DOUBLE PRECISION DEFAULT NULL, lng DOUBLE PRECISION DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, pays VARCHAR(128) DEFAULT NULL, code_postal INT DEFAULT NULL, date DATETIME DEFAULT NULL, photo1 VARCHAR(128) DEFAULT NULL, photo2 VARCHAR(128) DEFAULT NULL, photo3 VARCHAR(128) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE immo_interets (immo_id INT NOT NULL, interets_id INT NOT NULL, INDEX IDX_FE9137DDACCF8247 (immo_id), INDEX IDX_FE9137DD75621B20 (interets_id), PRIMARY KEY(immo_id, interets_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE immo_interets ADD CONSTRAINT FK_FE9137DDACCF8247 FOREIGN KEY (immo_id) REFERENCES immo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE immo_interets ADD CONSTRAINT FK_FE9137DD75621B20 FOREIGN KEY (interets_id) REFERENCES interets (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE immo_interets DROP FOREIGN KEY FK_FE9137DD75621B20');
        $this->addSql('DROP TABLE interets');
        $this->addSql('DROP TABLE immo_interets');
    }
}
