<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240320132406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delivery_locations DROP FOREIGN KEY FK_5383062882EA2E54');
        $this->addSql('DROP INDEX IDX_5383062882EA2E54 ON delivery_locations');
        $this->addSql('ALTER TABLE delivery_locations DROP commande_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delivery_locations ADD commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE delivery_locations ADD CONSTRAINT FK_5383062882EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5383062882EA2E54 ON delivery_locations (commande_id)');
    }
}
