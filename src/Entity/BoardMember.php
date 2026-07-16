<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Concerns\ResolvesPublicAssetPath;
use App\Repository\BoardMemberRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoardMemberRepository::class)]
#[ORM\Table(name: 'membri_consiglio')]
class BoardMember
{
    use ResolvesPublicAssetPath;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'nome', length: 100)]
    private string $firstName;

    #[ORM\Column(name: 'cognome', length: 100)]
    private string $lastName;

    #[ORM\Column(name: 'ruolo', length: 150)]
    private string $role;

    #[ORM\Column(type: 'text')]
    private string $bio;

    #[ORM\Column(length: 190)]
    private string $email;

    #[ORM\Column(name: 'foto', length: 255)]
    private string $photo;

    #[ORM\Column(name: 'ordine_visualizzazione', options: ['default' => 0])]
    private int $displayOrder = 0;

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

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getBio(): string
    {
        return $this->bio;
    }

    public function setBio(string $bio): self
    {
        $this->bio = $bio;

        return $this;
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

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function getPhotoPath(): string
    {
        return $this->resolvePublicAssetPath($this->photo, 'assets/images/board-members');
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

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
}
