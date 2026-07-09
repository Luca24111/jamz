<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\PageContentService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ObjectivesController extends BaseController
{
    public function __construct(PageContentService $pageContentService)
    {
        parent::__construct($pageContentService);
    }

    #[Route('/obiettivi-filosofia', name: 'app_objectives', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/objectives/index.html.twig', $this->page(
            $this->pageContentService()->objectivesPage(),
            'Obiettivi e filosofia',
            'obiettivi-filosofia.css',
            'obiettivi-filosofia.js'
        ));
    }
}
