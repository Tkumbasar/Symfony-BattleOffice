<?php

namespace App\Repository;

use App\Entity\DeliveryLocations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<DeliveryLocations>
 *
 * @method DeliveryLocations|null find($id, $lockMode = null, $lockVersion = null)
 * @method DeliveryLocations|null findOneBy(array $criteria, array $orderBy = null)
 * @method DeliveryLocations[]    findAll()
 * @method DeliveryLocations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeliveryLocationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DeliveryLocations::class);
    }

//    /**
//     * @return DeliveryLocations[] Returns an array of DeliveryLocations objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?DeliveryLocations
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
