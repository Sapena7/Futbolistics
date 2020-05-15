<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Equipo
 *
 * @ORM\Table(name="Equipo", indexes={@ORM\Index(name="liga", columns={"liga"}), @ORM\Index(name="estadio", columns={"estadio"})})
 * @ORM\Entity(repositoryClass="App\Repository\EquipoRepository")
 * @Vich\Uploadable()
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
     * @var string
     *
     * @ORM\Column(name="entrenador", type="string", length=100, nullable=false)
     */
    private $entrenador;

    /**
     * @var int
     *
     * @ORM\Column(name="trofeos", type="integer", nullable=false)
     */
    private $trofeos;

    /**
     * @var string
     *
     * @ORM\Column(name="region", type="string", length=100, nullable=false)
     */
    private $region;

    /**
     * @var int
     *
     * @ORM\Column(name="fundacion", type="integer", nullable=false)
     */
    private $fundacion;

    /**
     * @var string
     *
     * @ORM\Column(name="foto_perfil", type="string", length=500, nullable=false)
     */
    private $fotoPerfil;

    /**
     * @Vich\UploadableField(mapping="equipo_images", fileNameProperty="fotoPerfil")
     */
    private $fotoPerfilFile;


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

    public function getEntrenador(): ?string
    {
        return $this->entrenador;
    }

    public function setEntrenador(string $entrenador): self
    {
        $this->entrenador = $entrenador;

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

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getFundacion(): ?int
    {
        return $this->fundacion;
    }

    public function setFundacion(int $fundacion): self
    {
        $this->fundacion = $fundacion;

        return $this;
    }

    public function getFotoPerfil(): ?string
    {
        return $this->fotoPerfil;
    }

    public function setFotoPerfil(?string $fotoPerfil): self
    {
        $this->fotoPerfil = $fotoPerfil;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFotoPerfilFile()
    {
        return $this->fotoPerfilFile;
    }

    /**
     * @param mixed $fotoPerfilFile
     */
    public function setFotoPerfilFile($fotoPerfilFile): void
    {
        $this->fotoPerfilFile = $fotoPerfilFile;
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

    public function __toString() {
        return $this->getNombre();
    }

}
