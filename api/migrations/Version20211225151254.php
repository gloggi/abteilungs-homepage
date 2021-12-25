<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211225151254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "group_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE page_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE page_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE section_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE form_item (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "group" (id INT NOT NULL, section_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6DC044C5D823E37A ON "group" (section_id)');
        $this->addSql('CREATE TABLE page (id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, route VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE page_item (id INT NOT NULL, page_id INT DEFAULT NULL, entityType VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_98DF39C4C4663E4 ON page_item (page_id)');
        $this->addSql('CREATE TABLE section (id INT NOT NULL, name VARCHAR(255) NOT NULL, from_age INT DEFAULT NULL, to_age INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE text_item (id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, text TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON "user" (username)');
        $this->addSql('ALTER TABLE form_item ADD CONSTRAINT FK_8B3A2109BF396750 FOREIGN KEY (id) REFERENCES page_item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "group" ADD CONSTRAINT FK_6DC044C5D823E37A FOREIGN KEY (section_id) REFERENCES section (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE page_item ADD CONSTRAINT FK_98DF39C4C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE text_item ADD CONSTRAINT FK_18655B2BBF396750 FOREIGN KEY (id) REFERENCES page_item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE page_item DROP CONSTRAINT FK_98DF39C4C4663E4');
        $this->addSql('ALTER TABLE form_item DROP CONSTRAINT FK_8B3A2109BF396750');
        $this->addSql('ALTER TABLE text_item DROP CONSTRAINT FK_18655B2BBF396750');
        $this->addSql('ALTER TABLE "group" DROP CONSTRAINT FK_6DC044C5D823E37A');
        $this->addSql('DROP SEQUENCE "group_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE page_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE page_item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE section_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE form_item');
        $this->addSql('DROP TABLE "group"');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE page_item');
        $this->addSql('DROP TABLE section');
        $this->addSql('DROP TABLE text_item');
        $this->addSql('DROP TABLE "user"');
    }
}
