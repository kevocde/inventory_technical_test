<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240816055254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inventory DROP CONSTRAINT fk_b12d4a36de18e50b');
        $this->addSql('DROP INDEX idx_b12d4a36de18e50b');
        $this->addSql('ALTER TABLE inventory RENAME COLUMN product_id_id TO product_id');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A364584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B12D4A364584665A ON inventory (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE inventory DROP CONSTRAINT FK_B12D4A364584665A');
        $this->addSql('DROP INDEX IDX_B12D4A364584665A');
        $this->addSql('ALTER TABLE inventory RENAME COLUMN product_id TO product_id_id');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT fk_b12d4a36de18e50b FOREIGN KEY (product_id_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b12d4a36de18e50b ON inventory (product_id_id)');
    }
}
