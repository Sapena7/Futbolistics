<?php

namespace App\Repository;

use App\Entity\Usuario;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Pagination\Paginator;

/**
 * @method Usuario|null find($id, $lockMode = null, $lockVersion = null)
 * @method Usuario|null findOneBy(array $criteria, array $orderBy = null)
 * @method Usuario[]    findAll()
 * @method Usuario[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsuarioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usuario::class);
    }

    public function findUserById($id) : Usuario{
        $query = $this->createQueryBuilder('u')
            ->andwhere("u.id = :id")
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getSingleResult();
    }

    public function findEmailsByTeam($id_equipo): array {
        $query = $this->createQueryBuilder('u')
            ->select("u.email")
            ->andwhere("u.equipoFavorito = :id")
            ->setParameter('id', $id_equipo)
            ->getQuery();

        return $query->getResult();
    }
}
