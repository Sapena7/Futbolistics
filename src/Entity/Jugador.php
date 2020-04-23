<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jugador
 *
 * @ORM\Table(name="Jugador", indexes={@ORM\Index(name="liga", columns={"liga"}), @ORM\Index(name="equipo", columns={"equipo"}), @ORM\Index(name="posicion", columns={"posicion"})})
 * @ORM\Entity
 */
class Jugador
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
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100, nullable=false)
     */
    private $nombre;

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

    /**
     * @var \Posicion
     *
     * @ORM\ManyToOne(targetEntity="Posicion")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="posicion", referencedColumnName="id")
     * })
     */
    private $posicion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

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

    public function getPosicion(): ?Posicion
    {
        return $this->posicion;
    }

    public function setPosicion(?Posicion $posicion): self
    {
        $this->posicion = $posicion;

        return $this;
    }


}
