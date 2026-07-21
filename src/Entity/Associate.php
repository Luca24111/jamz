<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AssociateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssociateRepository::class)]
#[ORM\Table(name: 'associati', indexes: [
    new ORM\Index(name: 'idx_associati_albo_ordine', columns: ['visibile_albo', 'cognome', 'nome']),
])]
class Associate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'nome', length: 100)]
    private string $firstName;

    #[ORM\Column(name: 'cognome', length: 100)]
    private string $lastName;

    #[ORM\Column(name: 'numero_tessera', length: 50, unique: true)]
    private string $membershipNumber;

    #[ORM\Column(name: 'data_iscrizione', type: 'date')]
    private \DateTimeInterface $joinDate;

    #[ORM\Column(name: 'citta', length: 120)]
    private string $city;

    #[ORM\Column(name: 'strumento', length: 120)]
    private string $instrument;

    #[ORM\Column(name: 'bio_breve', type: 'text')]
    private string $shortBio;

    #[ORM\Column(length: 190, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(name: 'visibile_albo', type: 'boolean', options: ['default' => true])]
    private bool $visibleInRegistry = true;

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

    public function getMembershipNumber(): string
    {
        return $this->membershipNumber;
    }

    public function setMembershipNumber(string $membershipNumber): self
    {
        $this->membershipNumber = $membershipNumber;

        return $this;
    }

    public function getJoinDate(): \DateTimeInterface
    {
        return $this->joinDate;
    }

    public function setJoinDate(\DateTimeInterface $joinDate): self
    {
        $this->joinDate = $joinDate;

        return $this;
    }

    public function getFormattedJoinDate(): string
    {
        return $this->joinDate->format('d/m/Y');
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getInstrument(): string
    {
        return $this->instrument;
    }

    public function setInstrument(string $instrument): self
    {
        $this->instrument = $instrument;

        return $this;
    }

    public function getShortBio(): string
    {
        return $this->shortBio;
    }

    public function setShortBio(string $shortBio): self
    {
        $this->shortBio = $shortBio;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function isVisibleInRegistry(): bool
    {
        return $this->visibleInRegistry;
    }

    public function setVisibleInRegistry(bool $visibleInRegistry): self
    {
        $this->visibleInRegistry = $visibleInRegistry;

        return $this;
    }
}
