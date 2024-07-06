<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240706192149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE point (id INT AUTO_INCREMENT NOT NULL, maze_id INT NOT NULL, type VARCHAR(255) NOT NULL, x INT NOT NULL, y INT NOT NULL, INDEX IDX_B7A5F324923FCDD9 (maze_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE point ADD CONSTRAINT FK_B7A5F324923FCDD9 FOREIGN KEY (maze_id) REFERENCES maze (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE point DROP FOREIGN KEY FK_B7A5F324923FCDD9');
        $this->addSql('DROP TABLE point');
    }
}
