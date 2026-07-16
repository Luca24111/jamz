<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Concerns\ResolvesPublicAssetPath;
use App\Repository\EventRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ORM\Table(name: 'eventi')]
class Event
{
    use ResolvesPublicAssetPath;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'titolo', length: 180)]
    private string $title;

    #[ORM\Column(name: 'descrizione', type: 'text')]
    private string $description;

    #[ORM\Column(name: 'report_evento', type: 'text', nullable: true)]
    private ?string $eventReport = null;

    #[ORM\Column(name: 'created_at', type: 'datetime_immutable', nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(name: 'data_evento', type: 'datetime')]
    private \DateTimeInterface $eventDate;

    #[ORM\Column(name: 'luogo', length: 180)]
    private string $location;

    #[ORM\Column(name: 'immagine_copertina', length: 255)]
    private string $coverImage;

    #[ORM\Column(name: 'link_partecipazione', length: 255, nullable: true)]
    private ?string $participationLink = null;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: EventImage::class, orphanRemoval: true)]
    #[ORM\OrderBy(['displayOrder' => 'ASC', 'id' => 'ASC'])]
    private Collection $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEventReport(): ?string
    {
        return $this->eventReport;
    }

    public function setEventReport(?string $eventReport): self
    {
        $this->eventReport = $eventReport;

        return $this;
    }

    /**
     * @return list<string>
     */
    public function getReportParagraphs(): array
    {
        if ($this->eventReport === null || trim($this->eventReport) === '') {
            return [];
        }

        $paragraphs = preg_split('/\n{2,}/', trim($this->eventReport)) ?: [];

        return array_values(array_filter(array_map('trim', $paragraphs), static fn (string $paragraph): bool => $paragraph !== ''));
    }

    public function getEventDate(): DateTimeInterface
    {
        return $this->eventDate;
    }

    public function setEventDate(DateTimeInterface $eventDate): self
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    public function getFormattedDate(): string
    {
        return $this->eventDate->format('d/m/Y H:i');
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getYear(): int
    {
        return (int) $this->eventDate->format('Y');
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getCoverImage(): string
    {
        return $this->coverImage;
    }

    public function getCoverImagePath(): string
    {
        return $this->resolvePublicAssetPath($this->coverImage, 'assets/images/events/covers');
    }

    public function setCoverImage(string $coverImage): self
    {
        $this->coverImage = $coverImage;

        return $this;
    }

    public function getParticipationLink(): ?string
    {
        return $this->participationLink;
    }

    public function setParticipationLink(?string $participationLink): self
    {
        $this->participationLink = $participationLink;

        return $this;
    }

    public function isPast(): bool
    {
        return $this->eventDate < new \DateTimeImmutable('now');
    }

    /**
     * @return Collection<int, EventImage>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(EventImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setEvent($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->title ?? sprintf('Evento #%d', $this->id ?? 0);
    }
}
