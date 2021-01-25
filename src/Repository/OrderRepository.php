<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }
    //findSuccesOrders()
    // permet d'affciher les commandes dans le'espace membre de l'utilisateur
    
    public function findSuccessOrders($user) 
    {
        return $this->createQueryBuilder('o') // o = order
            ->andWhere('o.isPaid = 1')
            ->andWhere('o.user = :user') // :user (flag user)attention nous cherchons à récupérer les commandes de notre user en cours ! et non toutes les commandes
            ->setParameter('user', $user) // à quoi correspond le flag :user ? , il correspond à la variable $user
            ->orderBy('o.id' , 'DESC') // affichage de la commande enfonction de l'id par ordre descendant
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Order[] Returns an array of Order objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Order
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
