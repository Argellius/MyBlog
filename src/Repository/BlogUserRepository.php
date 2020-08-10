<?php

namespace App\Repository;

use App\Entity\BlogUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BlogUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogUser[]    findAll()
 * @method BlogUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogUser::class);
    }

}
