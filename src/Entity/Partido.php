<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partido
 *
 * @ORM\Table(name="Partido", indexes={@ORM\Index(name="equipo_visitante", columns={"equipo_visitante"}), @ORM\Index(name="jornada", columns={"jornada"}), @ORM\Index(name="liga", columns={"liga"}), @ORM\Index(name="equipo_local", columns={"equipo_local"}), @ORM\Index(name="estadio", columns={"estadio"})})
 * @ORM\Entity(repositoryClass="App\Repository\PartidoRepository")
 */
class Partido
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
     * @ORM\Column(name="goles_local", type="integer", nullable=false)
     */
    private $golesLocal;

    /**
     * @var int
     *
     * @ORM\Column(name="goles_visitante", type="integer", nullable=false)
     */
    private $golesVisitante;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=false)
     */
    private $fecha;

    /**
     * @var \Equipo
     *
     * @ORM\ManyToOne(targetEntity="Equipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipo_local", referencedColumnName="id")
     * })
     */
    private $equipoLocal;

    /**
     * @var \Equipo
     *
     * @ORM\ManyToOne(targetEntity="Equipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipo_visitante", referencedColumnName="id")
     * })
     */
    private $equipoVisitante;

    /**
     * @var \Estadio
     *
     * @ORM\ManyToOne(targetEntity="Estadio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="estadio", referencedColumnName="id")
     * })
     */
    private $estadio;

    /**
     * @var \Jornada
     *
     * @ORM\ManyToOne(targetEntity="Jornada")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="jornada", referencedColumnName="id")
     * })
     */
    private $jornada;

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

    public function getGolesLocal(): ?int
    {
        return $this->golesLocal;
    }

    public function setGolesLocal(int $golesLocal): self
    {
        $this->golesLocal = $golesLocal;

        return $this;
    }

    public function getGolesVisitante(): ?int
    {
        return $this->golesVisitante;
    }

    public function setGolesVisitante(int $golesVisitante): self
    {
        $this->golesVisitante = $golesVisitante;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getEquipoLocal(): ?Equipo
    {
        return $this->equipoLocal;
    }

    public function setEquipoLocal(?Equipo $equipoLocal): self
    {
        $this->equipoLocal = $equipoLocal;

        return $this;
    }

    public function getEquipoVisitante(): ?Equipo
    {
        return $this->equipoVisitante;
    }

    public function setEquipoVisitante(?Equipo $equipoVisitante): self
    {
        $this->equipoVisitante = $equipoVisitante;

        return $this;
    }

    public function getEstadio(): ?Estadio
    {
        return $this->estadio;
    }

    public function setEstadio(?Estadio $estadio): self
    {
        $this->estadio = $estadio;

        return $this;
    }

    public function getJornada(): ?Jornada
    {
        return $this->jornada;
    }

    public function setJornada(?Jornada $jornada): self
    {
        $this->jornada = $jornada;

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
