<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240319093814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande ADD product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_6EEAA67D4584665A ON commande (product_id)');
        $this->addSql('ALTER TABLE payment ADD commande_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('CREATE INDEX IDX_6D28840D82EA2E54 ON payment (commande_id)');
        $this->addSql('ALTER TABLE payment_method ADD payment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE payment_method ADD CONSTRAINT FK_7B61A1F64C3A3BB FOREIGN KEY (payment_id) REFERENCES payment (id)');
        $this->addSql('CREATE INDEX IDX_7B61A1F64C3A3BB ON payment_method (payment_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D4584665A');
        $this->addSql('DROP INDEX IDX_6EEAA67D4584665A ON commande');
        $this->addSql('ALTER TABLE commande DROP product_id');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D82EA2E54');
        $this->addSql('DROP INDEX IDX_6D28840D82EA2E54 ON payment');
        $this->addSql('ALTER TABLE payment DROP commande_id');
        $this->addSql('ALTER TABLE payment_method DROP FOREIGN KEY FK_7B61A1F64C3A3BB');
        $this->addSql('DROP INDEX IDX_7B61A1F64C3A3BB ON payment_method');
        $this->addSql('ALTER TABLE payment_method DROP payment_id');
    }
}
