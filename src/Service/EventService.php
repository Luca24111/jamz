<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Event;
use App\Repository\EventRepository;

final class EventService
{
    public function __construct(private readonly EventRepository $repository)
    {
    }

    public function getPastEvents(?int $year = null, string $order = 'desc'): array
    {
        return $this->repository->findPast($year, $order);
    }

    public function getFutureEvents(string $order = 'asc'): array
    {
        return $this->repository->findFuture($order);
    }

    public function getPastYears(): array
    {
        return $this->repository->findPastYears();
    }

    public function getFeaturedFutureEvents(int $limit = 3): array
    {
        return array_slice($this->repository->findFuture('asc'), 0, $limit);
    }

    public function getRecentPastEvents(int $limit = 2): array
    {
        return array_slice($this->repository->findPast(null, 'desc'), 0, $limit);
    }

    public function getUltimiEventiFuturiPerHome(int $limit = 5): array
    {
        return $this->repository->findRecentFutureForHome($limit);
    }

    public function getUltimiEventiPassatiPerHome(int $limit = 5): array
    {
        return $this->repository->findRecentPastForHome($limit);
    }

    public function getEventById(int $id): ?Event
    {
        return $this->repository->findDetailedById($id);
    }

    /**
     * @return array<string, int>
     */
    public function getCounts(): array
    {
        return [
            'all' => $this->repository->count([]),
            'future' => $this->repository->countFuture(),
            'past' => $this->repository->countPast(),
        ];
    }
}
