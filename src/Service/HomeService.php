<?php

declare(strict_types=1);

namespace App\Service;

final class HomeService
{
    public function __construct(
        private readonly EventService $eventService,
        private readonly BoardService $boardService,
        private readonly AssociateService $associateService,
        private readonly PageContentService $contentService
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function getPageData(): array
    {
        $content = $this->contentService->homeContent();
        $eventCounts = $this->eventService->getCounts();
        $futureEventsForHome = $this->eventService->getUltimiEventiFuturiPerHome();
        $pastEventsForHome = $this->eventService->getUltimiEventiPassatiPerHome();

        return [
            'hero' => $content['hero'],
            'cards' => $content['cards'],
            'future_event_carousel_items' => $this->mapEventsToCarouselItems($futureEventsForHome),
            'past_event_carousel_items' => $this->mapEventsToCarouselItems($pastEventsForHome),
            'board_preview' => $this->boardService->getPreview(),
            'stats' => [
                ['value' => $eventCounts['future'], 'label' => 'Eventi in programma'],
                ['value' => $eventCounts['past'], 'label' => 'Eventi realizzati'],
                ['value' => $this->boardService->countMembers(), 'label' => 'Membri del direttivo'],
                ['value' => $this->associateService->countPublicAssociates(), 'label' => 'Associati in albo'],
            ],
        ];
    }

    /**
     * Traduce gli eventi nel formato generico usato dal carosello coverflow.
     *
     * @param array<int, \App\Entity\Event> $events
     * @return array<int, array<string, string>>
     */
    private function mapEventsToCarouselItems(array $events): array
    {
        return array_map(static function (\App\Entity\Event $event): array {
            return [
                'image' => $event->getCoverImagePath(),
                'title' => $event->getTitle(),
                'subtitle' => $event->getFormattedDate() . ' · ' . $event->getLocation(),
                'excerpt' => $event->getDescription(),
                'url' => '/eventi/' . $event->getId(),
                'badge' => $event->isPast() ? 'Report' : 'In programma',
                'cta' => 'Scopri di più',
            ];
        }, $events);
    }
}
