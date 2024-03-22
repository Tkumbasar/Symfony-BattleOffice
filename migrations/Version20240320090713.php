<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240320090713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD delivery_locations_id INT DEFAULT NULL, ADD payment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D72F4A727 FOREIGN KEY (delivery_locations_id) REFERENCES delivery_locations (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D4C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D72F4A727 ON commande (delivery_locations_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6EEAA67D4C3A3BB ON commande (payment_id)');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D82EA2E54');
        $this->addSql('DROP INDEX IDX_6D28840D82EA2E54 ON payment');
        $this->addSql('ALTER TABLE payment DROP commande_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment ADD commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6D28840D82EA2E54 ON payment (commande_id)');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D72F4A727');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D4C3A3BB');
        $this->addSql('DROP INDEX IDX_6EEAA67D72F4A727 ON commande');
        $this->addSql('DROP INDEX UNIQ_6EEAA67D4C3A3BB ON commande');
        $this->addSql('ALTER TABLE commande DROP delivery_locations_id, DROP payment_id');
    }
}
