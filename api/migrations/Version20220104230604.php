<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220104230604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image_item (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE image_item_media_object (image_item_id INT NOT NULL, media_object_id INT NOT NULL, PRIMARY KEY(image_item_id, media_object_id))');
        $this->addSql('CREATE INDEX IDX_49DBE73B877F0582 ON image_item_media_object (image_item_id)');
        $this->addSql('CREATE INDEX IDX_49DBE73B64DE5A5 ON image_item_media_object (media_object_id)');
        $this->addSql('ALTER TABLE image_item ADD CONSTRAINT FK_ED21CF80BF396750 FOREIGN KEY (id) REFERENCES page_item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE image_item_media_object ADD CONSTRAINT FK_49DBE73B877F0582 FOREIGN KEY (image_item_id) REFERENCES image_item (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE image_item_media_object ADD CONSTRAINT FK_49DBE73B64DE5A5 FOREIGN KEY (media_object_id) REFERENCES media_object (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE image_item_media_object DROP CONSTRAINT FK_49DBE73B877F0582');
        $this->addSql('DROP TABLE image_item');
        $this->addSql('DROP TABLE image_item_media_object');
    }
}
