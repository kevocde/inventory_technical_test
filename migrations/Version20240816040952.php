<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240816040952 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE inventory_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE product_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE inventory (id INT NOT NULL, product_id_id INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B12D4A36DE18E50B ON inventory (product_id_id)');
        $this->addSql('CREATE TABLE product (id INT NOT NULL, product_id INT NOT NULL, name VARCHAR(100) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, weighted BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36DE18E50B FOREIGN KEY (product_id_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE inventory_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE product_id_seq CASCADE');
        $this->addSql('ALTER TABLE inventory DROP CONSTRAINT FK_B12D4A36DE18E50B');
        $this->addSql('DROP TABLE inventory');
        $this->addSql('DROP TABLE product');
    }
}
