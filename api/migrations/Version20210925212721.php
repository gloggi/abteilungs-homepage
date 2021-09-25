<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210925212721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE form_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE textfield_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE item (id INT NOT NULL, page_id INT DEFAULT NULL, entityType VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1F1B251EC4663E4 ON item (page_id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EC4663E4 FOREIGN KEY (page_id) REFERENCES page (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE form DROP CONSTRAINT fk_5288fd4fc4663e4');
        $this->addSql('DROP INDEX idx_5288fd4fc4663e4');
        $this->addSql('ALTER TABLE form DROP page_id');
        $this->addSql('ALTER TABLE form ADD CONSTRAINT FK_5288FD4FBF396750 FOREIGN KEY (id) REFERENCES item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE textfield DROP CONSTRAINT fk_1ae4b76c4663e4');
        $this->addSql('DROP INDEX idx_1ae4b76c4663e4');
        $this->addSql('ALTER TABLE textfield DROP page_id');
        $this->addSql('ALTER TABLE textfield ADD CONSTRAINT FK_1AE4B76BF396750 FOREIGN KEY (id) REFERENCES item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE form DROP CONSTRAINT FK_5288FD4FBF396750');
        $this->addSql('ALTER TABLE textfield DROP CONSTRAINT FK_1AE4B76BF396750');
        $this->addSql('DROP SEQUENCE item_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE form_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE textfield_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP TABLE item');
        $this->addSql('ALTER TABLE textfield ADD page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE textfield ADD CONSTRAINT fk_1ae4b76c4663e4 FOREIGN KEY (page_id) REFERENCES page (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_1ae4b76c4663e4 ON textfield (page_id)');
        $this->addSql('ALTER TABLE form ADD page_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE form ADD CONSTRAINT fk_5288fd4fc4663e4 FOREIGN KEY (page_id) REFERENCES page (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_5288fd4fc4663e4 ON form (page_id)');
    }
}
