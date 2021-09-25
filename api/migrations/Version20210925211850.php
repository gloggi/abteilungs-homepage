<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210925211850 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE item_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE form_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE textfield_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE item');
        $this->addSql('ALTER TABLE form ADD page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE form ADD CONSTRAINT FK_5288FD4FC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5288FD4FC4663E4 ON form (page_id)');
        $this->addSql('ALTER TABLE textfield ADD page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE textfield ADD CONSTRAINT FK_1AE4B76C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1AE4B76C4663E4 ON textfield (page_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE form_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE textfield_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE item (id INT NOT NULL, page_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_1f1b251ec4663e4 ON item (page_id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT fk_1f1b251ec4663e4 FOREIGN KEY (page_id) REFERENCES page (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE textfield DROP CONSTRAINT FK_1AE4B76C4663E4');
        $this->addSql('DROP INDEX IDX_1AE4B76C4663E4');
        $this->addSql('ALTER TABLE textfield DROP page_id');
        $this->addSql('ALTER TABLE form DROP CONSTRAINT FK_5288FD4FC4663E4');
        $this->addSql('DROP INDEX IDX_5288FD4FC4663E4');
        $this->addSql('ALTER TABLE form DROP page_id');
    }
}
