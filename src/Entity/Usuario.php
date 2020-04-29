<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Usuario
 *
 * @ORM\Table(name="Usuario", indexes={@ORM\Index(name="rol", columns={"rol"}), @ORM\Index(name="equipo_favorito", columns={"equipo_favorito"})})
 * @ORM\Entity
 */
class Usuario implements UserInterface
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
     * @ORM\Column(name="email", type="string", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=100, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="foto_perfil", type="string", length=100, nullable=false)
     */
    private $fotoPerfil;

    /**
     * @var \Equipo
     *
     * @ORM\ManyToOne(targetEntity="Equipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipo_favorito", referencedColumnName="id")
     * })
     */
    private $equipoFavorito;

    /**
     * @var \Rol
     *
     * @ORM\ManyToOne(targetEntity="Rol")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rol", referencedColumnName="Id")
     * })
     */
    private $rol;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function getEquipoFavorito(): ?Equipo
    {
        return $this->equipoFavorito;
    }

    public function setEquipoFavorito(?Equipo $equipoFavorito): self
    {
        $this->equipoFavorito = $equipoFavorito;

        return $this;
    }

    public function getRol(): ?Rol
    {
        return $this->rol;
    }

    public function setRol(?Rol $rol): self
    {
        $this->rol = $rol;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getSalt():?string
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {

    }

    /**
     * @inheritDoc
     */
    public function getRoles():?array{

        //return $this->rol;
        return ['ROLE_ADMIN'];
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->nombre;
    }


    public function __toString() {
        return $this->getNombre();
    }
}
