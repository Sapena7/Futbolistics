<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipo
 *
 * @ORM\Table(name="Equipo", indexes={@ORM\Index(name="liga", columns={"liga"}), @ORM\Index(name="estadio", columns={"estadio"})})
 * @ORM\Entity
 */
class Equipo
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
     * @ORM\Column(name="trofeos", type="integer", nullable=false)
     */
    private $trofeos;

    /**
     * @var string
     *
     * @ORM\Column(name="foto_perfil", type="string", length=500, nullable=false)
     */
    private $fotoPerfil;

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

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getTrofeos(): ?int
    {
        return $this->trofeos;
    }

    public function setTrofeos(int $trofeos): self
    {
        $this->trofeos = $trofeos;

        return $this;
    }

    public function getFotoPerfil(): ?string
    {
        return $this->fotoPerfil;
    }

    public function setFotoPerfil(string $fotoPerfil): self
    {
        $this->fotoPerfil = $fotoPerfil;

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
