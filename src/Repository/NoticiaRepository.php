<?php

namespace App\Repository;

use App\Entity\Noticia;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Pagination\Paginator;
use DateTime;

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
        $query = $this->createQueryBuilder('n')
            ->andwhere("n.id = :id")
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getSingleResult();
    }

    /**
     * @return Noticia[]
     */
    public function findAllOrderByDate(int $page = 1, int $equipo = null, DateTime $fechaMin = null, DateTime $fechaMax = null, string $text= null): Paginator{

        $qb = $this->createQueryBuilder('n')
            ->orderBy('n.fecha', 'DESC');

        if ($text != null){
            $qb = $this->createQueryBuilder('n')
                ->andwhere("n.titular lIKE :text")
                ->setParameter('text', "%" . $text . "%");
        }

        if ($equipo != null){
            $qb = $this->createQueryBuilder('n')
                ->andwhere("n.equipo = :equipo")
                ->setParameter('equipo', $equipo);
        }

        if ($fechaMin != null && $fechaMax != null){
            $qb = $this->createQueryBuilder('n')
                ->andwhere("n.fecha BETWEEN :startDate AND :endDate")
                ->setParameter('startDate', $fechaMin)
                ->setParameter('endDate', $fechaMax);
        }

        return (new Paginator($qb))->paginate($page);
    }
}
