<?php

namespace App\Repository;

use App\Entity\ContactInformations;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContactInformations>
 *
 * @method ContactInformations|null find($id, $lockMode = null, $lockVersion = null)
 * @method ContactInformations|null findOneBy(array $criteria, array $orderBy = null)
 * @method ContactInformations[]    findAll()
 * @method ContactInformations[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactInformationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactInformations::class);
    }

//    /**
//     * @return ContactInformations[] Returns an array of ContactInformations objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ContactInformations
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
