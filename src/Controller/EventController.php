<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Service\EventService;
use App\Service\PageContentService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EventController extends BaseController
{
    public function __construct(
        PageContentService $pageContentService,
        private readonly EventService $eventService
    ) {
        parent::__construct($pageContentService);
    }

    #[Route('/eventi-passati', name: 'app_events_past', methods: ['GET'])]
    public function past(): Response
    {
        return $this->render('pages/events/past.html.twig', $this->page([
            'events' => $this->eventService->getPastEvents(null, null, 'desc'),
            'base_css_files' => ['css/base/event-explorer.css'],
            'base_js_files' => ['js/base/event-explorer.js'],
        ], 'Eventi passati', 'eventi-passati.css', 'eventi-passati.js'));
    }

    #[Route('/eventi-futuri', name: 'app_events_future', methods: ['GET'])]
    public function future(): Response
    {
        return $this->render('pages/events/future.html.twig', $this->page([
            'events' => $this->eventService->getFutureEvents(null, null, 'asc'),
            'base_css_files' => ['css/base/event-explorer.css'],
            'base_js_files' => ['js/base/event-explorer.js'],
        ], 'Eventi futuri', 'eventi-futuri.css', 'eventi-futuri.js'));
    }

    #[Route('/eventi/{id}', name: 'app_events_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        $event = $this->eventService->getEventById($id);

        if ($event === null) {
            throw new NotFoundHttpException('Evento non trovato.');
        }

        return $this->render('pages/events/show.html.twig', $this->page([
            'event' => $event,
            'related_events' => $event->isPast()
                ? array_slice($this->eventService->getPastEvents(null, null, 'desc'), 0, 3)
                : array_slice($this->eventService->getFutureEvents(null, null, 'asc'), 0, 3),
        ], $event->getTitle(), 'evento-dettaglio.css', 'evento-dettaglio.js'));
    }
}
