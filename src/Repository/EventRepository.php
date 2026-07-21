<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
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
    public function findPast(?int $year = null, ?int $month = null, string $order = 'desc'): array
    {
        $qb = $this->createQueryBuilder('evt')
            ->leftJoin('evt.images', 'img')->addSelect('img')
            ->andWhere('evt.eventDate < :now')
            ->setParameter('now', new \DateTimeImmutable('now'));

        $this->applyCalendarFilters($qb, true, $year, $month);

        $qb->orderBy('evt.eventDate', $order === 'asc' ? 'ASC' : 'DESC');

        return $qb->getQuery()->getResult();
    }

    /**
     * @return list<Event>
     */
    public function findFuture(?int $year = null, ?int $month = null, string $order = 'asc'): array
    {
        $qb = $this->createQueryBuilder('evt')
            ->leftJoin('evt.images', 'img')->addSelect('img')
            ->andWhere('evt.eventDate >= :now')
            ->setParameter('now', new \DateTimeImmutable('now'))
            ->orderBy('evt.eventDate', $order === 'desc' ? 'DESC' : 'ASC');

        $this->applyCalendarFilters($qb, false, $year, $month);

        return $qb->getQuery()->getResult();
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

    /**
     * @return list<int>
     */
    public function findFutureYears(): array
    {
        $rows = $this->getEntityManager()->getConnection()->fetchFirstColumn(
            'SELECT DISTINCT YEAR(data_evento) AS year
             FROM eventi
             WHERE data_evento >= NOW()
             ORDER BY year ASC'
        );

        return array_map(static fn (mixed $year): int => (int) $year, $rows);
    }

    /**
     * @return list<int>
     */
    public function findPastMonths(?int $year = null): array
    {
        return $this->findMonthsByScope(true, $year);
    }

    /**
     * @return list<int>
     */
    public function findFutureMonths(?int $year = null): array
    {
        return $this->findMonthsByScope(false, $year);
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

    /**
     * @return list<Event>
     */
    public function findRelated(Event $event, int $limit = 3): array
    {
        return $this->createQueryBuilder('evt')
            ->andWhere('evt.id != :currentId')
            ->andWhere($event->isPast() ? 'evt.eventDate < :now' : 'evt.eventDate >= :now')
            ->setParameter('currentId', $event->getId())
            ->setParameter('now', new \DateTimeImmutable('now'))
            ->orderBy('evt.eventDate', $event->isPast() ? 'DESC' : 'ASC')
            ->setMaxResults(max(1, $limit))
            ->getQuery()
            ->getResult();
    }

    private function applyCalendarFilters(QueryBuilder $qb, bool $past, ?int $year, ?int $month): void
    {
        if ($year !== null && $month !== null) {
            $startOfMonth = new \DateTimeImmutable(sprintf('%04d-%02d-01 00:00:00', $year, $month));
            $endOfMonth = $startOfMonth->modify('+1 month');

            $qb->andWhere('evt.eventDate >= :startOfMonth')
                ->andWhere('evt.eventDate < :endOfMonth')
                ->setParameter('startOfMonth', $startOfMonth)
                ->setParameter('endOfMonth', $endOfMonth);

            return;
        }

        if ($year !== null) {
            $startOfYear = new \DateTimeImmutable(sprintf('%04d-01-01 00:00:00', $year));
            $startOfNextYear = $startOfYear->modify('+1 year');

            $qb->andWhere('evt.eventDate >= :startOfYear')
                ->andWhere('evt.eventDate < :startOfNextYear')
                ->setParameter('startOfYear', $startOfYear)
                ->setParameter('startOfNextYear', $startOfNextYear);
        }

        if ($month !== null && $year === null) {
            $eventIds = $this->findEventIdsByMonthAndScope($month, $past);

            if ($eventIds === []) {
                $qb->andWhere('1 = 0');

                return;
            }

            $qb->andWhere('evt.id IN (:eventIds)')
                ->setParameter('eventIds', $eventIds);
        }
    }

    /**
     * @return list<int>
     */
    private function findMonthsByScope(bool $past, ?int $year = null): array
    {
        $sql = 'SELECT DISTINCT MONTH(data_evento) AS month
            FROM eventi
            WHERE data_evento ' . ($past ? '<' : '>=') . ' NOW()';
        $params = [];
        $types = [];

        if ($year !== null) {
            $sql .= ' AND YEAR(data_evento) = :year';
            $params['year'] = $year;
        }

        $sql .= ' ORDER BY month ASC';

        $rows = $this->getEntityManager()->getConnection()->fetchFirstColumn($sql, $params, $types);

        return array_map(static fn (mixed $month): int => (int) $month, $rows);
    }

    /**
     * @return list<int>
     */
    private function findEventIdsByMonthAndScope(int $month, bool $past): array
    {
        $rows = $this->getEntityManager()->getConnection()->fetchFirstColumn(
            'SELECT id
             FROM eventi
             WHERE MONTH(data_evento) = :month
               AND data_evento ' . ($past ? '<' : '>=') . ' NOW()',
            ['month' => $month]
        );

        return array_map(static fn (mixed $id): int => (int) $id, $rows);
    }
}
