<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Concerns\ResolvesPublicAssetPath;
use App\Repository\DocumentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentRepository::class)]
#[ORM\Table(name: 'documenti')]
class Document
{
    use ResolvesPublicAssetPath;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', enumType: DocumentType::class)]
    private DocumentType $tipo;

    #[ORM\Column(name: 'titolo', length: 190)]
    private string $title;

    #[ORM\Column(name: 'nome_file', length: 190)]
    private string $fileName;

    #[ORM\Column(length: 255)]
    private string $path;

    #[ORM\Column(name: 'data_caricamento', type: 'date')]
    private \DateTimeInterface $uploadedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): DocumentType
    {
        return $this->tipo;
    }

    public function setTipo(DocumentType $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getType(): string
    {
        return $this->tipo->value;
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

    public function getFileName(): string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getPublicPath(): string
    {
        return $this->resolvePublicAssetPath($this->path, 'assets/documents');
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getUploadedAt(): \DateTimeInterface
    {
        return $this->uploadedAt;
    }

    public function setUploadedAt(\DateTimeInterface $uploadedAt): self
    {
        $this->uploadedAt = $uploadedAt;

        return $this;
    }

    public function getFormattedUploadedAt(): string
    {
        return $this->uploadedAt->format('d/m/Y');
    }
}
