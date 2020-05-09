<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jornada
 *
 * @ORM\Table(name="Jornada", indexes={@ORM\Index(name="partidoEstrella", columns={"partidoEstrella"})})
 * @ORM\Entity
 */
class Jornada
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
     * @ORM\Column(name="jornada", type="string", length=100, nullable=false)
     */
    private $jornada;

    /**
     * @var \Partido
     *
     * @ORM\ManyToOne(targetEntity="Partido")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="partidoEstrella", referencedColumnName="id")
     * })
     */
    private $partidoestrella;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJornada(): ?string
    {
        return $this->jornada;
    }

    public function setJornada(string $jornada): self
    {
        $this->jornada = $jornada;

        return $this;
    }

    public function getPartidoestrella(): ?Partido
    {
        return $this->partidoestrella;
    }

    public function setPartidoestrella(?Partido $partidoestrella): self
    {
        $this->partidoestrella = $partidoestrella;

        return $this;
    }


}
