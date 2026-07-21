<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Concerns\ResolvesPublicAssetPath;
use App\Repository\EventImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventImageRepository::class)]
#[ORM\Table(name: 'evento_immagini', indexes: [
    new ORM\Index(name: 'idx_evento_immagini_ordine', columns: ['evento_id', 'ordine_visualizzazione']),
])]
class EventImage
{
    use ResolvesPublicAssetPath;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[ORM\JoinColumn(name: 'evento_id', nullable: false, onDelete: 'CASCADE')]
    private ?Event $event = null;

    #[ORM\Column(name: 'url_immagine', length: 255)]
    private string $url;

    #[ORM\Column(name: 'alt_text', length: 255, nullable: true)]
    private ?string $altText = null;

    #[ORM\Column(name: 'ordine_visualizzazione', options: ['default' => 0])]
    private int $displayOrder = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getPublicPath(): string
    {
        return $this->resolvePublicAssetPath($this->url, 'assets/images/events/gallery');
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getAltText(): string
    {
        return $this->altText ?: 'Galleria evento';
    }

    public function setAltText(?string $altText): self
    {
        $this->altText = $altText;

        return $this;
    }

    public function getDisplayOrder(): int
    {
        return $this->displayOrder;
    }

    public function setDisplayOrder(int $displayOrder): self
    {
        $this->displayOrder = $displayOrder;

        return $this;
    }

    public function isVideo(): bool
    {
        $path = parse_url($this->url, \PHP_URL_PATH);
        $extension = strtolower(pathinfo($path ?? $this->url, \PATHINFO_EXTENSION));

        return in_array($extension, ['mp4', 'webm', 'mov', 'm4v', 'ogg'], true);
    }
}
