<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170125061449 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE genus DROP FOREIGN KEY FK_38C5106E69438F1E');
        $this->addSql('DROP INDEX IDX_38C5106E69438F1E ON genus');
        $this->addSql('ALTER TABLE genus CHANGE sub_familiy_id sub_family_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE genus ADD CONSTRAINT FK_38C5106ED15310D4 FOREIGN KEY (sub_family_id) REFERENCES sub_family (id)');
        $this->addSql('CREATE INDEX IDX_38C5106ED15310D4 ON genus (sub_family_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE genus DROP FOREIGN KEY FK_38C5106ED15310D4');
        $this->addSql('DROP INDEX IDX_38C5106ED15310D4 ON genus');
        $this->addSql('ALTER TABLE genus CHANGE sub_family_id sub_familiy_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE genus ADD CONSTRAINT FK_38C5106E69438F1E FOREIGN KEY (sub_familiy_id) REFERENCES sub_family (id)');
        $this->addSql('CREATE INDEX IDX_38C5106E69438F1E ON genus (sub_familiy_id)');
    }
}
