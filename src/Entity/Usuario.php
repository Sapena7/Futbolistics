<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Usuario
 *
 * @ORM\Table(name="Usuario", uniqueConstraints={@ORM\UniqueConstraint(name="nombre", columns={"nombre"})}, indexes={@ORM\Index(name="equipo_favorito", columns={"equipo_favorito"}), @ORM\Index(name="rol", columns={"rol"})})
 * @ORM\Entity(repositoryClass="App\Repository\UsuarioRepository")
 * @Vich\Uploadable()
 */
class Usuario implements UserInterface, \Serializable
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
     * @ORM\Column(name="nombreCompleto", type="string", length=100, nullable=false)
     */
    private $nombrecompleto;

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
     * @var json
     *
     * @ORM\Column(name="rol", type="json")
     */
    private $rol = [];

    /**
     * @var string|null
     *
     * @ORM\Column(name="foto_perfil", type="string", length=100, nullable=true)
     */
    private $fotoPerfil;

    /**
     * @Vich\UploadableField(mapping="usuario_images", fileNameProperty="fotoPerfil")
     */
    private $fotoPerfilFile;

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

    /**
     * @var \Equipo
     *
     * @ORM\ManyToOne(targetEntity="Equipo")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipo_favorito", referencedColumnName="id")
     * })
     */
    private $equipoFavorito;

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

    public function getNombrecompleto(): ?string
    {
        return $this->nombrecompleto;
    }

    public function setNombrecompleto(string $nombrecompleto): self
    {
        $this->nombrecompleto = $nombrecompleto;

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

    public function getRol(): ?string
    {
        if ($this->rol == null){
            return 'ROLE_USER';
        }else{
            return $this->rol[0];
        }

    }

    public function setRol(array $rol): self
    {
        $this->rol = $rol;

        return $this;
    }

    public function getFotoPerfil(): ?string
    {
        if ($this->fotoPerfil == null){
            $this->fotoPerfil = 'perfilPorDefecto.png';
        }
            return $this->fotoPerfil;


    }

    public function setFotoPerfil(?string $fotoPerfil): self
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

        $roles = $this->rol;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
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

    /**
     * {@inheritdoc}
     */
    public function serialize(): string
    {
        // add $this->salt too if you don't use Bcrypt or Argon2i
        return serialize([$this->id, $this->nombre, $this->password, $this->rol[0]]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized): void
    {
        // add $this->salt too if you don't use Bcrypt or Argon2i
        [$this->id, $this->nombre, $this->password, $this->rol[0]] = unserialize($serialized, ['allowed_classes' => false]);
    }

}
