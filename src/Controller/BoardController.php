<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\BoardService;
use App\Service\PageContentService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BoardController extends BaseController
{
    public function __construct(
        PageContentService $pageContentService,
        private readonly BoardService $boardService
    ) {
        parent::__construct($pageContentService);
    }

    #[Route('/consiglio-direttivo', name: 'app_board', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/board/index.html.twig', $this->page(
            ['members' => $this->boardService->getBoardMembers()],
            'Consiglio direttivo',
            'consiglio-direttivo.css',
            'consiglio-direttivo.js'
        ));
    }
}
