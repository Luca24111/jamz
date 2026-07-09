<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\MusicianApplication;
use App\Entity\MusicianApplicationStatus;
use Doctrine\ORM\EntityManagerInterface;

final class MusicianApplicationService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly MailService $mailService
    ) {
    }

    /**
     * @param array<string, mixed> $payload
     * @return array{errors: array<string, string>, old: array<string, string>}
     */
    public function validate(array $payload): array
    {
        $sanitized = [
            'nome' => $this->cleanText($payload['nome'] ?? ''),
            'cognome' => $this->cleanText($payload['cognome'] ?? ''),
            'email' => filter_var(trim((string) ($payload['email'] ?? '')), FILTER_SANITIZE_EMAIL) ?: '',
            'telefono' => preg_replace('/[^0-9+()\\s.-]/', '', (string) ($payload['telefono'] ?? '')) ?? '',
            'genere_musicale' => $this->cleanText($payload['genere_musicale'] ?? ''),
            'descrizione_progetto' => $this->cleanTextarea($payload['descrizione_progetto'] ?? ''),
            'link_materiale' => trim((string) ($payload['link_materiale'] ?? '')),
            'disponibilita' => $this->cleanText($payload['disponibilita'] ?? ''),
        ];

        $errors = [];

        if (mb_strlen($sanitized['nome']) < 2) {
            $errors['nome'] = 'Inserisci un nome valido.';
        }

        if (mb_strlen($sanitized['cognome']) < 2) {
            $errors['cognome'] = 'Inserisci un cognome valido.';
        }

        if (!filter_var($sanitized['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Inserisci un indirizzo email valido.';
        }

        if (mb_strlen($sanitized['telefono']) < 7) {
            $errors['telefono'] = 'Inserisci un recapito telefonico valido.';
        }

        if (mb_strlen($sanitized['genere_musicale']) < 3) {
            $errors['genere_musicale'] = 'Specifica il genere musicale o la direzione artistica.';
        }

        if (mb_strlen($sanitized['descrizione_progetto']) < 40) {
            $errors['descrizione_progetto'] = 'Descrivi il progetto con almeno 40 caratteri.';
        }

        if ($sanitized['link_materiale'] !== '' && !filter_var($sanitized['link_materiale'], FILTER_VALIDATE_URL)) {
            $errors['link_materiale'] = 'Il link ai materiali deve essere un URL valido.';
        }

        return ['errors' => $errors, 'old' => $sanitized];
    }

    /**
     * @param array<string, string> $payload
     */
    public function submit(array $payload): void
    {
        $application = (new MusicianApplication())
            ->setFirstName($payload['nome'])
            ->setLastName($payload['cognome'])
            ->setEmail($payload['email'])
            ->setTelefono($payload['telefono'])
            ->setMusicGenre($payload['genere_musicale'])
            ->setProjectDescription($payload['descrizione_progetto'])
            ->setMaterialLink($payload['link_materiale'] !== '' ? $payload['link_materiale'] : null)
            ->setAvailability($payload['disponibilita'] !== '' ? $payload['disponibilita'] : 'Da concordare')
            ->setRequestedAt(new \DateTimeImmutable('now'))
            ->setStato(MusicianApplicationStatus::InAttesa);

        $this->entityManager->persist($application);
        $this->entityManager->flush();

        $this->mailService->notifyMusicianApplication($application);
    }

    private function cleanText(mixed $value): string
    {
        return trim(strip_tags((string) $value));
    }

    private function cleanTextarea(mixed $value): string
    {
        $text = strip_tags((string) $value);
        $text = preg_replace('/\r\n?/', "\n", $text) ?? $text;

        return trim($text);
    }
}
