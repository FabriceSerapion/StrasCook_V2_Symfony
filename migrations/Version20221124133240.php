<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221124133240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE menu_user DROP FOREIGN KEY FK_45DC2607A76ED395');
        $this->addSql('ALTER TABLE menu_user DROP FOREIGN KEY FK_45DC2607CCD7E912');
        $this->addSql('DROP TABLE menu_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE menu_user (menu_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_45DC2607A76ED395 (user_id), INDEX IDX_45DC2607CCD7E912 (menu_id), PRIMARY KEY(menu_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE menu_user ADD CONSTRAINT FK_45DC2607A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_user ADD CONSTRAINT FK_45DC2607CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
