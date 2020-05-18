<?php

namespace App\Repository;

use App\Entity\Jornada;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Jornada|null find($id, $lockMode = null, $lockVersion = null)
 * @method Jornada|null findOneBy(array $criteria, array $orderBy = null)
 * @method Jornada[]    findAll()
 * @method Jornada[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JornadaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Jornada::class);
    }

    public function findById($id) : Jornada{
        $query = $this->createQueryBuilder('j')
            ->andwhere("j.id = :id")
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getSingleResult();
    }

    public function countJornadas(){
        $query = $this->createQueryBuilder('j')
            ->select("COUNT(j.id)")
            ->getQuery();

        return $query->getSingleResult();
    }
}
