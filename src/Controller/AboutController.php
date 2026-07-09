<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\PageContentService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AboutController extends BaseController
{
    public function __construct(PageContentService $pageContentService)
    {
        parent::__construct($pageContentService);
    }

    #[Route('/chi-siamo', name: 'app_about', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/about/index.html.twig', $this->page(
            $this->pageContentService()->aboutPage(),
            'Chi siamo',
            'chi-siamo.css',
            'chi-siamo.js'
        ));
    }
}
