<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\BoardMember;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class BoardMemberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BoardMember::class);
    }

    /**
     * @return list<BoardMember>
     */
    public function findAllOrdered(): array
    {
        return $this->orderedQueryBuilder()
            ->getQuery()
            ->getResult();
    }

    /**
     * @return list<BoardMember>
     */
    public function findPreview(int $limit): array
    {
        return $this->orderedQueryBuilder()
            ->setMaxResults(max(1, $limit))
            ->getQuery()
            ->getResult();
    }

    private function orderedQueryBuilder(): \Doctrine\ORM\QueryBuilder
    {
        return $this->createQueryBuilder('boardMember')
            ->orderBy('boardMember.displayOrder', 'ASC')
            ->addOrderBy('boardMember.lastName', 'ASC')
            ->addOrderBy('boardMember.firstName', 'ASC');
    }
}
