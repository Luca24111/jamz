<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Document;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Document::class);
    }

    /**
     * @return list<Document>
     */
    public function findAllOrdered(): array
    {
        $documents = $this->createQueryBuilder('doc')
            ->orderBy('doc.uploadedAt', 'DESC')
            ->getQuery()
            ->getResult();

        usort($documents, static function (Document $left, Document $right): int {
            $priority = [
                'statuto' => 1,
                'atto_costitutivo' => 2,
                'altro' => 3,
            ];

            $leftPriority = $priority[$left->getType()] ?? 99;
            $rightPriority = $priority[$right->getType()] ?? 99;

            if ($leftPriority === $rightPriority) {
                return $right->getUploadedAt()->getTimestamp() <=> $left->getUploadedAt()->getTimestamp();
            }

            return $leftPriority <=> $rightPriority;
        });

        return $documents;
    }
}
