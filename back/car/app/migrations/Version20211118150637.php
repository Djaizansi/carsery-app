<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211118150637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand ADD car_id INT NOT NULL');
        $this->addSql('ALTER TABLE brand ADD CONSTRAINT FK_1C52F958C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('CREATE INDEX IDX_1C52F958C3C6F69F ON brand (car_id)');
        $this->addSql('ALTER TABLE category ADD car_id INT NOT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('CREATE INDEX IDX_64C19C1C3C6F69F ON category (car_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand DROP FOREIGN KEY FK_1C52F958C3C6F69F');
        $this->addSql('DROP INDEX IDX_1C52F958C3C6F69F ON brand');
        $this->addSql('ALTER TABLE brand DROP car_id');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1C3C6F69F');
        $this->addSql('DROP INDEX IDX_64C19C1C3C6F69F ON category');
        $this->addSql('ALTER TABLE category DROP car_id');
    }
}
