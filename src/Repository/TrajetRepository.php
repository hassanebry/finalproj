<?php

namespace App\Repository;

use App\Entity\Trajet;
use App\Entity\TrajetSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Trajet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trajet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trajet[]    findAll()
 * @method Trajet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrajetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Trajet::class);
        $this->paginator = $paginator;
    }

    /**
     * @return Trajet[] Returns an array of Trajet objects
     */
    
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * recupere les trajets en lien avec une recherche
     * @return PaginationInterface
     */
    public function findSearch(TrajetSearch $search): PaginationInterface
    {
        $query = $this
                ->createQueryBuilder('t')
                ->select('t');
            
                if (!empty($search->getDepart())){
                    $query = $query
                            ->andWhere('t.ville_depart LIKE :depart')
                            ->setParameter('depart', "%{$search->getDepart()}%")
                            ;
                }

                if (!empty($search->getArrive())){
                    $query = $query
                            ->andWhere('t.ville_arrive LIKE :arrive')
                            ->setParameter('arrive', "%{$search->getArrive()}%")
                            ;
                }

                if (!empty($search->datedep)){
                    $query = $query
                            ->andWhere('t.date_depart = :datedep')
                            ->setParameter('datedep', $search->datedep)
                            ;
                }

                if (!empty($search->getPlace())){
                    $query = $query
                            ->andWhere('t.nbre_place >= :place')
                            ->setParameter('place', $search->getPlace())
                            ;
                }

        $query = $query->getQuery();
        return $this->paginator->paginate(
            $query, 
            $search->page,
            6
        );
    }

    /**
    * @return Trajet[]
    */
    public function getTrajetsNonExpires()
    {
    $qb = $this->createQueryBuilder('t')
                ->where('t.nbre_place > :nbreplace')
                ->setParameter('nbreplace', 0)
                ->orderBy('t.date_depart', 'DESC');
        return $qb->getQuery()->getResult();
    }
    

    /*
    public function findOneBySomeField($value): ?Trajet
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
