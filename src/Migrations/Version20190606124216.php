<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190606124216 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE immo ADD proprio_id INT NOT NULL');
        $this->addSql('ALTER TABLE immo ADD CONSTRAINT FK_2A3B56C56B82600 FOREIGN KEY (proprio_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2A3B56C56B82600 ON immo (proprio_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE immo DROP FOREIGN KEY FK_2A3B56C56B82600');
        $this->addSql('DROP INDEX IDX_2A3B56C56B82600 ON immo');
        $this->addSql('ALTER TABLE immo DROP proprio_id');
    }
}
