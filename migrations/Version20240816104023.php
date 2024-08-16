<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240816104023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE cart_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE shopping_cart_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE cart_item (id INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE cart_item_product (cart_item_id INT NOT NULL, product_id INT NOT NULL, PRIMARY KEY(cart_item_id, product_id))');
        $this->addSql('CREATE INDEX IDX_AE98B090E9B59A59 ON cart_item_product (cart_item_id)');
        $this->addSql('CREATE INDEX IDX_AE98B0904584665A ON cart_item_product (product_id)');
        $this->addSql('CREATE TABLE shopping_cart (id INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE cart_item_product ADD CONSTRAINT FK_AE98B090E9B59A59 FOREIGN KEY (cart_item_id) REFERENCES cart_item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cart_item_product ADD CONSTRAINT FK_AE98B0904584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('DROP INDEX idx_b12d4a364584665a');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B12D4A364584665A ON inventory (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE cart_item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE shopping_cart_id_seq CASCADE');
        $this->addSql('ALTER TABLE cart_item_product DROP CONSTRAINT FK_AE98B090E9B59A59');
        $this->addSql('ALTER TABLE cart_item_product DROP CONSTRAINT FK_AE98B0904584665A');
        $this->addSql('DROP TABLE cart_item');
        $this->addSql('DROP TABLE cart_item_product');
        $this->addSql('DROP TABLE shopping_cart');
        $this->addSql('DROP INDEX UNIQ_B12D4A364584665A');
        $this->addSql('CREATE INDEX idx_b12d4a364584665a ON inventory (product_id)');
    }
}
