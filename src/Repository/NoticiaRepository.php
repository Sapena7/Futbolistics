<?php

namespace App\Repository;

use App\Entity\Noticia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Pagination\Paginator;

/**
 * @method Noticia|null find($id, $lockMode = null, $lockVersion = null)
 * @method Noticia|null findOneBy(array $criteria, array $orderBy = null)
 * @method Noticia[]    findAll()
 * @method Noticia[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NoticiaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Noticia::class);
    }

    public function findNewsById($id){
        $query = $this->createQueryBuilder('u')
            ->andwhere("u.id = :id")
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getSingleResult();
    }
}
