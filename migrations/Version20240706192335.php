<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240706192335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hero ADD current_point_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hero ADD CONSTRAINT FK_51CE6E865D50B488 FOREIGN KEY (current_point_id) REFERENCES point (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_51CE6E865D50B488 ON hero (current_point_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hero DROP FOREIGN KEY FK_51CE6E865D50B488');
        $this->addSql('DROP INDEX UNIQ_51CE6E865D50B488 ON hero');
        $this->addSql('ALTER TABLE hero DROP current_point_id');
    }
}
