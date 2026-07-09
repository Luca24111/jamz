<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\HomeService;
use App\Service\PageContentService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends BaseController
{
    public function __construct(
        PageContentService $pageContentService,
        private readonly HomeService $homeService
    ) {
        parent::__construct($pageContentService);
    }

    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/home/index.html.twig', $this->page(
            array_merge($this->homeService->getPageData(), [
                'base_css_files' => ['css/base/coverflow-carousel.css'],
                'base_js_files' => ['js/base/coverflow-carousel.js'],
            ]),
            'Home',
            'home.css',
            'home.js'
        ));
    }
}
