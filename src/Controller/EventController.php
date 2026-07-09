<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Service\EventService;
use App\Service\PageContentService;
use Symfony\Component\HttpFoundation\Request;
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
    public function past(Request $request): Response
    {
        $year = $request->query->getInt('year') ?: null;
        $order = in_array($request->query->get('order'), ['asc', 'desc'], true) ? (string) $request->query->get('order') : 'desc';

        return $this->render('pages/events/past.html.twig', $this->page([
            'events' => $this->eventService->getPastEvents($year, $order),
            'available_years' => $this->eventService->getPastYears(),
            'selected_year' => $year,
            'selected_order' => $order,
        ], 'Eventi passati', 'eventi-passati.css', 'eventi-passati.js'));
    }

    #[Route('/eventi-futuri', name: 'app_events_future', methods: ['GET'])]
    public function future(Request $request): Response
    {
        $order = in_array($request->query->get('order'), ['asc', 'desc'], true) ? (string) $request->query->get('order') : 'asc';

        return $this->render('pages/events/future.html.twig', $this->page([
            'events' => $this->eventService->getFutureEvents($order),
            'selected_order' => $order,
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
                ? array_slice($this->eventService->getPastEvents(null, 'desc'), 0, 3)
                : array_slice($this->eventService->getFutureEvents('asc'), 0, 3),
        ], $event->getTitle(), 'evento-dettaglio.css', 'evento-dettaglio.js'));
    }
}
