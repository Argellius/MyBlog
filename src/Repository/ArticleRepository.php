<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return Article[] Returns an array of Article objects
     */
    public function findByContent($value)
    {
        return $this->createQueryBuilder('a')        
        ->Where('a.Content LIKE :val')
        ->orWhere(('a.Title LIKE :val'))
        ->orWhere(('a.Description LIKE :val'))
        ->setParameter('val', '%'.$value.'%')
        ->orderBy('a.id', 'ASC')
        ->getQuery()
        ->getResult();
        
        //var_dump($query->getDQL());die;

        
    }
}
