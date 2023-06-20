<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230224112812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE meal (id INT AUTO_INCREMENT NOT NULL, chef_id INT NOT NULL, title VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, ingredients LONGTEXT NOT NULL, allergen LONGTEXT NOT NULL, container LONGTEXT DEFAULT NULL, cutlery TINYINT(1) NOT NULL, time DATETIME NOT NULL, place VARCHAR(255) NOT NULL, shares INT NOT NULL, INDEX IDX_9EF68E9C150A48F1 (chef_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_cook TINYINT(1) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) DEFAULT NULL, contact_email VARCHAR(255) DEFAULT NULL, pronoun VARCHAR(255) DEFAULT NULL, avatar VARCHAR(255) NOT NULL, habits LONGTEXT DEFAULT NULL, class VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE meal ADD CONSTRAINT FK_9EF68E9C150A48F1 FOREIGN KEY (chef_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meal DROP FOREIGN KEY FK_9EF68E9C150A48F1');
        $this->addSql('DROP TABLE meal');
        $this->addSql('DROP TABLE `user`');
    }
}
