<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220622171047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE orders (id INT AUTO_INCREMENT NOT NULL, status_id INT DEFAULT NULL, estimated_arrival DATETIME NOT NULL, delivery_address1 VARCHAR(255) NOT NULL, delivery_address2 VARCHAR(255) NOT NULL, delivery_city VARCHAR(255) NOT NULL, delivery_postcode VARCHAR(255) NOT NULL, delivery_country VARCHAR(255) NOT NULL, billing_address1 VARCHAR(255) NOT NULL, billing_address2 VARCHAR(255) NOT NULL, billing_city VARCHAR(255) NOT NULL, billing_postcode VARCHAR(255) NOT NULL, billing_country VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_E52FFDEE6BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_delayed (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, check_time DATETIME NOT NULL, estimated_arrival DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_9AFBE37C8D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE6BF700BD FOREIGN KEY (status_id) REFERENCES order_status (id)');
        $this->addSql('ALTER TABLE order_delayed ADD CONSTRAINT FK_9AFBE37C8D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_delayed DROP FOREIGN KEY FK_9AFBE37C8D9F6D38');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE6BF700BD');
        $this->addSql('DROP TABLE order_status');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE order_delayed');
    }
}
