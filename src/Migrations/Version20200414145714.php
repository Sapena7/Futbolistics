<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200414145714 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Usuario CHANGE equipo_favorito equipo_favorito INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Noticia CHANGE equipo equipo INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Clasificacion CHANGE liga liga INT DEFAULT NULL, CHANGE equipo equipo INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Equipo CHANGE liga liga INT DEFAULT NULL, CHANGE estadio estadio INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Partido CHANGE equipo_local equipo_local INT DEFAULT NULL, CHANGE equipo_visitante equipo_visitante INT DEFAULT NULL');
        $this->addSql('ALTER TABLE Jugador CHANGE posicion posicion INT DEFAULT NULL, CHANGE equipo equipo INT DEFAULT NULL, CHANGE liga liga INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Clasificacion CHANGE equipo equipo INT NOT NULL, CHANGE liga liga INT NOT NULL');
        $this->addSql('ALTER TABLE Equipo CHANGE estadio estadio INT NOT NULL, CHANGE liga liga INT NOT NULL');
        $this->addSql('ALTER TABLE Jugador CHANGE equipo equipo INT NOT NULL, CHANGE liga liga INT NOT NULL, CHANGE posicion posicion INT NOT NULL');
        $this->addSql('ALTER TABLE Noticia CHANGE equipo equipo INT NOT NULL');
        $this->addSql('ALTER TABLE Partido CHANGE equipo_local equipo_local INT NOT NULL, CHANGE equipo_visitante equipo_visitante INT NOT NULL');
        $this->addSql('ALTER TABLE Usuario CHANGE equipo_favorito equipo_favorito INT NOT NULL');
    }
}
