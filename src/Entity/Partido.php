<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partido
 *
 * @ORM\Table(name="Partido", indexes={@ORM\Index(name="equipo_visitante", columns={"equipo_visitante"}), @ORM\Index(name="equipo_local", columns={"equipo_local"})})
 * @ORM\Entity
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


}
