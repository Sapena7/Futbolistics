<?php

namespace App\Repository;

use App\Entity\Jugador;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Pagination\Paginator;

/**
 * @method Jugador|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jugador|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jugador[]    findAll()
 * @method Jugador[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JugadorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jugador::class);
    }

    public function findByEquipo($id){
        $query = $this->createQueryBuilder('j')
            ->andwhere("j.equipo = :id")
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getSingleResult();
    }

    /**
     * @return Jugador[]
     */
    public function findByEquipoAndId($equipo, $id){
        $query = $this->createQueryBuilder('j')
            ->andwhere("j.equipo = :equipo AND j.id = :id")
            ->setParameter('equipo', $equipo)
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getSingleResult();
    }
}
