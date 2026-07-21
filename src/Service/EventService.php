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

    public function getPastEvents(?int $year = null, ?int $month = null, string $order = 'desc'): array
    {
        return $this->repository->findPast($year, $month, $order);
    }

    public function getFutureEvents(?int $year = null, ?int $month = null, string $order = 'asc'): array
    {
        return $this->repository->findFuture($year, $month, $order);
    }

    public function getPastYears(): array
    {
        return $this->repository->findPastYears();
    }

    public function getFutureYears(): array
    {
        return $this->repository->findFutureYears();
    }

    public function getPastMonths(?int $year = null): array
    {
        return $this->repository->findPastMonths($year);
    }

    public function getFutureMonths(?int $year = null): array
    {
        return $this->repository->findFutureMonths($year);
    }

    /**
     * @return array<int, string>
     */
    public function getMonthLabels(): array
    {
        return [
            1 => 'Gennaio',
            2 => 'Febbraio',
            3 => 'Marzo',
            4 => 'Aprile',
            5 => 'Maggio',
            6 => 'Giugno',
            7 => 'Luglio',
            8 => 'Agosto',
            9 => 'Settembre',
            10 => 'Ottobre',
            11 => 'Novembre',
            12 => 'Dicembre',
        ];
    }

    public function getFeaturedFutureEvents(int $limit = 3): array
    {
        return array_slice($this->repository->findFuture(null, null, 'asc'), 0, $limit);
    }

    public function getRecentPastEvents(int $limit = 2): array
    {
        return array_slice($this->repository->findPast(null, null, 'desc'), 0, $limit);
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

    public function getRelatedEvents(Event $event, int $limit = 3): array
    {
        return $this->repository->findRelated($event, $limit);
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
