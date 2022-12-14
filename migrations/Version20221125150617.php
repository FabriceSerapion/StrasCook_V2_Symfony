<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221125150617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, menu_id INT NOT NULL, cook_id INT NOT NULL, customer_id INT NOT NULL, date DATETIME NOT NULL, adress VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, time INT NOT NULL, INDEX IDX_E00CEDDECCD7E912 (menu_id), INDEX IDX_E00CEDDEB0D5B835 (cook_id), INDEX IDX_E00CEDDE9395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cook (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(50) NOT NULL, lastname VARCHAR(50) NOT NULL, description LONGTEXT DEFAULT NULL, shift_start INT NOT NULL, shift_end INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, price DOUBLE PRECISION NOT NULL, rating DOUBLE PRECISION DEFAULT NULL, descr_appetizer LONGTEXT DEFAULT NULL, descr_starter LONGTEXT DEFAULT NULL, descr_meal LONGTEXT DEFAULT NULL, descr_dessert LONGTEXT DEFAULT NULL, descr_cheese LONGTEXT DEFAULT NULL, descr_cuteness LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_tag (menu_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_9B2879B1CCD7E912 (menu_id), INDEX IDX_9B2879B1BAD26311 (tag_id), PRIMARY KEY(menu_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, is_admin TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_rating (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, menu_id INT NOT NULL, rating INT NOT NULL, INDEX IDX_BDDB3D1F9395C3F3 (customer_id), INDEX IDX_BDDB3D1FCCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDECCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEB0D5B835 FOREIGN KEY (cook_id) REFERENCES cook (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE9395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE menu_tag ADD CONSTRAINT FK_9B2879B1CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_tag ADD CONSTRAINT FK_9B2879B1BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_rating ADD CONSTRAINT FK_BDDB3D1F9395C3F3 FOREIGN KEY (customer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_rating ADD CONSTRAINT FK_BDDB3D1FCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDECCD7E912');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEB0D5B835');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE9395C3F3');
        $this->addSql('ALTER TABLE menu_tag DROP FOREIGN KEY FK_9B2879B1CCD7E912');
        $this->addSql('ALTER TABLE menu_tag DROP FOREIGN KEY FK_9B2879B1BAD26311');
        $this->addSql('ALTER TABLE user_rating DROP FOREIGN KEY FK_BDDB3D1F9395C3F3');
        $this->addSql('ALTER TABLE user_rating DROP FOREIGN KEY FK_BDDB3D1FCCD7E912');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE cook');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_rating');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
