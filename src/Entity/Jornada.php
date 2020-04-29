<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Jornada
 *
 * @ORM\Table(name="Jornada")
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


}
