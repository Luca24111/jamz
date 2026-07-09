<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Associate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class AssociateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Associate::class);
    }

    /**
     * @return list<Associate>
     */
    public function findPublicAll(): array
    {
        return $this->createQueryBuilder('assoc')
            ->andWhere('assoc.visibleInRegistry = :visible')
            ->setParameter('visible', true)
            ->orderBy('assoc.lastName', 'ASC')
            ->addOrderBy('assoc.firstName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function countPublic(): int
    {
        return (int) $this->createQueryBuilder('assoc')
            ->select('COUNT(assoc.id)')
            ->andWhere('assoc.visibleInRegistry = :visible')
            ->setParameter('visible', true)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
