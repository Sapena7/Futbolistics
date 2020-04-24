<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Estadio
 *
 * @ORM\Table(name="Estadio")
 * @ORM\Entity
 */
class Estadio
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
     * @var int
     *
     * @ORM\Column(name="ciudad", type="integer", nullable=false)
     */
    private $ciudad;

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

    public function getCiudad(): ?int
    {
        return $this->ciudad;
    }

    public function setCiudad(int $ciudad): self
    {
        $this->ciudad = $ciudad;

        return $this;
    }


}