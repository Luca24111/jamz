<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\DocumentService;
use App\Service\PageContentService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DocumentController extends BaseController
{
    public function __construct(
        PageContentService $pageContentService,
        private readonly DocumentService $documentService
    ) {
        parent::__construct($pageContentService);
    }

    #[Route('/statuto', name: 'app_documents', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/documents/index.html.twig', $this->page([
            'documents' => $this->documentService->getDocuments(),
        ], 'Statuto e atto costitutivo', 'statuto.css', 'statuto.js'));
    }
}
