<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\DocumentRepository;

final class DocumentService
{
    public function __construct(private readonly DocumentRepository $repository)
    {
    }

    public function getDocuments(): array
    {
        return $this->repository->findAllOrdered();
    }
}
