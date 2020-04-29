<?php

namespace App\Repository;

use App\Entity\Jugador;
use App\Entity\Partido;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Pagination\Paginator;

/**
 * @method Partido|null find($id, $lockMode = null, $lockVersion = null)
 * @method Partido|null findOneBy(array $criteria, array $orderBy = null)
 * @method Partido[]    findAll()
 * @method Partido[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartidoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Partido::class);
    }

    public function findByJornada($jornada){
        $query = $this->createQueryBuilder('p')
            ->andwhere("p.jornada = :jornada")
            ->setParameter('jornada', $jornada)
            ->getQuery();

        return $query->getSingleResult();
    }
}
