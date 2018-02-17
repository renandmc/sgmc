<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180217195229 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE turmas (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, curso VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipamentos ADD tipo_equipamento VARCHAR(100) NOT NULL, CHANGE descricao descricao VARCHAR(200) NOT NULL, CHANGE marca marca VARCHAR(100) NOT NULL, CHANGE modelo modelo VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE ordens ADD equipamento_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ordens ADD CONSTRAINT FK_358A0B3C20F76DE FOREIGN KEY (equipamento_id) REFERENCES equipamentos (id)');
        $this->addSql('CREATE INDEX IDX_358A0B3C20F76DE ON ordens (equipamento_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE turmas');
        $this->addSql('ALTER TABLE equipamentos DROP tipo_equipamento, CHANGE marca marca VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE modelo modelo VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE descricao descricao VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE ordens DROP FOREIGN KEY FK_358A0B3C20F76DE');
        $this->addSql('DROP INDEX IDX_358A0B3C20F76DE ON ordens');
        $this->addSql('ALTER TABLE ordens DROP equipamento_id');
    }
}
