<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\MusicianApplicationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MusicianApplicationRepository::class)]
#[ORM\Table(name: 'richieste_musicisti', indexes: [
    new ORM\Index(name: 'idx_richieste_musicisti_stato', columns: ['stato']),
])]
class MusicianApplication
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'nome', length: 100)]
    private string $firstName;

    #[ORM\Column(name: 'cognome', length: 100)]
    private string $lastName;

    #[ORM\Column(length: 190)]
    private string $email;

    #[ORM\Column(length: 50)]
    private string $telefono;

    #[ORM\Column(name: 'descrizione_progetto', type: 'text')]
    private string $projectDescription;

    #[ORM\Column(name: 'genere_musicale', length: 120)]
    private string $musicGenre;

    #[ORM\Column(name: 'link_materiale', length: 255, nullable: true)]
    private ?string $materialLink = null;

    #[ORM\Column(name: 'disponibilita', length: 190)]
    private string $availability;

    #[ORM\Column(name: 'data_richiesta', type: 'datetime_immutable')]
    private \DateTimeImmutable $requestedAt;

    #[ORM\Column(type: 'string', enumType: MusicianApplicationStatus::class)]
    private MusicianApplicationStatus $stato = MusicianApplicationStatus::InAttesa;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFullName(): string
    {
        return trim($this->firstName . ' ' . $this->lastName);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->telefono;
    }

    public function getProjectDescription(): string
    {
        return $this->projectDescription;
    }

    public function setProjectDescription(string $projectDescription): self
    {
        $this->projectDescription = $projectDescription;

        return $this;
    }

    public function getMusicGenre(): string
    {
        return $this->musicGenre;
    }

    public function setMusicGenre(string $musicGenre): self
    {
        $this->musicGenre = $musicGenre;

        return $this;
    }

    public function getMaterialLink(): ?string
    {
        return $this->materialLink;
    }

    public function setMaterialLink(?string $materialLink): self
    {
        $this->materialLink = $materialLink;

        return $this;
    }

    public function getAvailability(): string
    {
        return $this->availability;
    }

    public function setAvailability(string $availability): self
    {
        $this->availability = $availability;

        return $this;
    }

    public function getRequestedAt(): \DateTimeImmutable
    {
        return $this->requestedAt;
    }

    public function setRequestedAt(\DateTimeImmutable $requestedAt): self
    {
        $this->requestedAt = $requestedAt;

        return $this;
    }

    public function getStatus(): string
    {
        return $this->stato->value;
    }

    public function getStato(): MusicianApplicationStatus
    {
        return $this->stato;
    }

    public function setStato(MusicianApplicationStatus $stato): self
    {
        $this->stato = $stato;

        return $this;
    }
}
