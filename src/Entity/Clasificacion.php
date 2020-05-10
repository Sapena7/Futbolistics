<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Clasificacion
 *
 * @ORM\Table(name="Clasificacion", indexes={@ORM\Index(name="liga", columns={"liga"}), @ORM\Index(name="equipo", columns={"equipo"})})
 * @ORM\Entity(repositoryClass="App\Repository\ClasificacionRepository")
 */
class Clasificacion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="puntos", type="integer", nullable=false)
     */
    private $puntos;

    /**
     * @var int
     *
     * @ORM\Column(name="jugados", type="integer", nullable=false)
     */
    private $jugados;

    /**
     * @var int
     *
     * @ORM\Column(name="ganados", type="integer", nullable=false)
     */
    private $ganados;

    /**
     * @var int
     *
     * @ORM\Column(name="empatados", type="integer", nullable=false)
     */
    private $empatados;

    /**
     * @var int
     *
     * @ORM\Column(name="perdidos", type="integer", nullable=false)
     */
    private $perdidos;

    /**
     * @var int
     *
     * @ORM\Column(name="goles_favor", type="integer", nullable=false)
     */
    private $golesFavor;

    /**
     * @var int
     *
     * @ORM\Column(name="goles_contra", type="integer", nullable=false)
     */
    private $golesContra;

    /**
     * @var int
     *
     * @ORM\Column(name="goles_diferencia", type="integer", nullable=false)
     */
    private $golesDiferencia;

    /**
     * @var \Equipo
     *
     * @ORM\ManyToOne(targetEntity="Equipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipo", referencedColumnName="id")
     * })
     */
    private $equipo;

    /**
     * @var \Liga
     *
     * @ORM\ManyToOne(targetEntity="Liga")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="liga", referencedColumnName="id")
     * })
     */
    private $liga;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPuntos(): ?int
    {
        return $this->puntos;
    }

    public function setPuntos(int $puntos): self
    {
        $this->puntos = $puntos;

        return $this;
    }

    public function getJugados(): ?int
    {
        return $this->jugados;
    }

    public function setJugados(int $jugados): self
    {
        $this->jugados = $jugados;

        return $this;
    }

    public function getGanados(): ?int
    {
        return $this->ganados;
    }

    public function setGanados(int $ganados): self
    {
        $this->ganados = $ganados;

        return $this;
    }

    public function getEmpatados(): ?int
    {
        return $this->empatados;
    }

    public function setEmpatados(int $empatados): self
    {
        $this->empatados = $empatados;

        return $this;
    }

    public function getPerdidos(): ?int
    {
        return $this->perdidos;
    }

    public function setPerdidos(int $perdidos): self
    {
        $this->perdidos = $perdidos;

        return $this;
    }

    public function getGolesFavor(): ?int
    {
        return $this->golesFavor;
    }

    public function setGolesFavor(int $golesFavor): self
    {
        $this->golesFavor = $golesFavor;

        return $this;
    }

    public function getGolesContra(): ?int
    {
        return $this->golesContra;
    }

    public function setGolesContra(int $golesContra): self
    {
        $this->golesContra = $golesContra;

        return $this;
    }

    public function getGolesDiferencia(): ?int
    {
        return $this->golesDiferencia;
    }

    public function setGolesDiferencia(int $golesDiferencia): self
    {
        $this->golesDiferencia = $golesDiferencia;

        return $this;
    }

    public function getEquipo(): ?Equipo
    {
        return $this->equipo;
    }

    public function setEquipo(?Equipo $equipo): self
    {
        $this->equipo = $equipo;

        return $this;
    }

    public function getLiga(): ?Liga
    {
        return $this->liga;
    }

    public function setLiga(?Liga $liga): self
    {
        $this->liga = $liga;

        return $this;
    }

}
