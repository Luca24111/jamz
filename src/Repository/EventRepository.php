<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    /**
     * @return list<Event>
     */
    public function findPast(?int $year = null, string $order = 'desc'): array
    {
        $qb = $this->createQueryBuilder('evt')
            ->leftJoin('evt.images', 'img')->addSelect('img')
            ->andWhere('evt.eventDate < :now')
            ->setParameter('now', new \DateTimeImmutable('now'));

        if ($year !== null) {
            $startOfYear = new \DateTimeImmutable(sprintf('%d-01-01 00:00:00', $year));
            $startOfNextYear = $startOfYear->modify('+1 year');

            $qb->andWhere('evt.eventDate >= :startOfYear')
                ->andWhere('evt.eventDate < :startOfNextYear')
                ->setParameter('startOfYear', $startOfYear)
                ->setParameter('startOfNextYear', $startOfNextYear);
        }

        $qb->orderBy('evt.eventDate', $order === 'asc' ? 'ASC' : 'DESC');

        return $qb->getQuery()->getResult();
    }

    /**
     * @return list<Event>
     */
    public function findFuture(string $order = 'asc'): array
    {
        return $this->createQueryBuilder('evt')
            ->leftJoin('evt.images', 'img')->addSelect('img')
            ->andWhere('evt.eventDate >= :now')
            ->setParameter('now', new \DateTimeImmutable('now'))
            ->orderBy('evt.eventDate', $order === 'desc' ? 'DESC' : 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Restituisce i futuri più recenti per data di inserimento, per la home.
     *
     * @return list<Event>
     */
    public function findRecentFutureForHome(int $limit = 5): array
    {
        return $this->createQueryBuilder('evt')
            ->andWhere('evt.eventDate >= :now')
            ->setParameter('now', new \DateTimeImmutable('now'))
            ->orderBy('evt.createdAt', 'DESC')
            ->addOrderBy('evt.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Restituisce i passati più recenti per data di inserimento, per la home.
     *
     * @return list<Event>
     */
    public function findRecentPastForHome(int $limit = 5): array
    {
        return $this->createQueryBuilder('evt')
            ->andWhere('evt.eventDate < :now')
            ->setParameter('now', new \DateTimeImmutable('now'))
            ->orderBy('evt.createdAt', 'DESC')
            ->addOrderBy('evt.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return list<int>
     */
    public function findPastYears(): array
    {
        $rows = $this->getEntityManager()->getConnection()->fetchFirstColumn(
            'SELECT DISTINCT YEAR(data_evento) AS year
             FROM eventi
             WHERE data_evento < NOW()
             ORDER BY year DESC'
        );

        return array_map(static fn (mixed $year): int => (int) $year, $rows);
    }

    public function countFuture(): int
    {
        return (int) $this->createQueryBuilder('evt')
            ->select('COUNT(evt.id)')
            ->andWhere('evt.eventDate >= :now')
            ->setParameter('now', new \DateTimeImmutable('now'))
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function countPast(): int
    {
        return (int) $this->createQueryBuilder('evt')
            ->select('COUNT(evt.id)')
            ->andWhere('evt.eventDate < :now')
            ->setParameter('now', new \DateTimeImmutable('now'))
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findDetailedById(int $id): ?Event
    {
        return $this->createQueryBuilder('evt')
            ->leftJoin('evt.images', 'img')->addSelect('img')
            ->andWhere('evt.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
