<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jornada
 *
 * @ORM\Table(name="Jornada")
 * @ORM\Entity(repositoryClass="App\Repository\JornadaRepository")
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
     * @var int
     *
     * @ORM\Column(name="partidoEstrella", type="integer", nullable=false)
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

    public function getPartidoestrella(): ?int
    {
        return $this->partidoestrella;
    }

    public function setPartidoestrella(int $partidoestrella): self
    {
        $this->partidoestrella = $partidoestrella;

        return $this;
    }


}
