<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Noticia
 *
 * @ORM\Table(name="Noticia", indexes={@ORM\Index(name="noticia_ibfk_2", columns={"colaborador"}), @ORM\Index(name="equipo", columns={"equipo"})})
 * @ORM\Entity(repositoryClass="App\Repository\NoticiaRepository")
 */
class Noticia
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
     * @ORM\Column(name="titular", type="text", length=65535, nullable=false)
     */
    private $titular;

    /**
     * @var string
     *
     * @ORM\Column(name="cuerpo", type="text", length=65535, nullable=false)
     */
    private $cuerpo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="date", nullable=false)
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=100, nullable=false)
     */
    private $imagen;

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
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="colaborador", referencedColumnName="id")
     * })
     */
    private $colaborador;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitular(): ?string
    {
        return $this->titular;
    }

    public function setTitular(string $titular): self
    {
        $this->titular = $titular;

        return $this;
    }

    public function getCuerpo(): ?string
    {
        return $this->cuerpo;
    }

    public function setCuerpo(string $cuerpo): self
    {
        $this->cuerpo = $cuerpo;

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

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): self
    {
        $this->imagen = $imagen;

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

    public function getColaborador(): ?Usuario
    {
        return $this->colaborador;
    }

    public function setColaborador(?Usuario $colaborador): self
    {
        $this->colaborador = $colaborador;

        return $this;
    }


}
