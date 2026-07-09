<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\AssociateService;
use App\Service\PageContentService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AssociateController extends BaseController
{
    public function __construct(
        PageContentService $pageContentService,
        private readonly AssociateService $associateService
    ) {
        parent::__construct($pageContentService);
    }

    #[Route('/albo-associati', name: 'app_associates', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/associates/index.html.twig', $this->page([
            'associates' => $this->associateService->getPublicAssociates(),
        ], 'Albo associati', 'albo-associati.css', 'albo-associati.js'));
    }
}
