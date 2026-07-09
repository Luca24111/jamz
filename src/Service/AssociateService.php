<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\AssociateRepository;

final class AssociateService
{
    public function __construct(private readonly AssociateRepository $repository)
    {
    }

    public function getPublicAssociates(): array
    {
        return $this->repository->findPublicAll();
    }

    public function countPublicAssociates(): int
    {
        return $this->repository->countPublic();
    }
}
