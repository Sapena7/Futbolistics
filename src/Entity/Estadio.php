<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Estadio
 *
 * @ORM\Table(name="Estadio")
 * @ORM\Entity
 * @Vich\Uploadable()
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
     * @var string
     *
     * @ORM\Column(name="ciudad", type="string", length=100, nullable=false)
     */
    private $ciudad;

    /**
     * @var string
     *
     * @ORM\Column(name="foto_estadio", type="string", length=100, nullable=false)
     */
    private $fotoEstadio;

    /**
     * @Vich\UploadableField(mapping="estadio_images", fileNameProperty="fotoEstadio")
     */
    private $fotoEstadioFile;

    /**
     * @return mixed
     */
    public function getFotoEstadioFile()
    {
        return $this->fotoEstadioFile;
    }

    /**
     * @param mixed $fotoEstadioFile
     */
    public function setFotoEstadioFile($fotoEstadioFile): void
    {
        $this->fotoEstadioFile = $fotoEstadioFile;
    }

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

    public function getCiudad(): ?string
    {
        return $this->ciudad;
    }

    public function setCiudad(string $ciudad): self
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    public function getFotoEstadio(): ?string
    {
        return $this->fotoEstadio;
    }

    public function setFotoEstadio(?string $fotoEstadio): self
    {
        $this->fotoEstadio = $fotoEstadio;

        return $this;
    }

    public function __toString() {
        return $this->getNombre();
    }

}
