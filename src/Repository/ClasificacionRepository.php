<?php

namespace App\Repository;

use App\Entity\Clasificacion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Pagination\Paginator;

/**
 * @method Clasificacion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Clasificacion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Clasificacion[]    findAll()
 * @method Clasificacion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClasificacionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Clasificacion::class);
    }

    public function findAllOrderedByPuntos() {
        $query = $this->createQueryBuilder('c')
            ->orderBy('c.puntos', 'DESC')
            ->getQuery();

        return $query->getResult();
    }
}
