<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240708201808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE point ADD type_id INT NOT NULL');
        $this->addSql('ALTER TABLE point ADD CONSTRAINT FK_B7A5F324C54C8C93 FOREIGN KEY (type_id) REFERENCES point_type (id)');
        $this->addSql('CREATE INDEX IDX_B7A5F324C54C8C93 ON point (type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE point DROP FOREIGN KEY FK_B7A5F324C54C8C93');
        $this->addSql('DROP INDEX IDX_B7A5F324C54C8C93 ON point');
        $this->addSql('ALTER TABLE point DROP type_id');
    }
}
