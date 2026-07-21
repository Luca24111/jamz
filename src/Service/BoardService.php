<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\BoardMemberRepository;

final class BoardService
{
    public function __construct(private readonly BoardMemberRepository $repository)
    {
    }

    public function getBoardMembers(): array
    {
        return $this->repository->findAllOrdered();
    }

    public function getPreview(int $limit = 3): array
    {
        return $this->repository->findPreview($limit);
    }

    public function countMembers(): int
    {
        return $this->repository->count([]);
    }
}
