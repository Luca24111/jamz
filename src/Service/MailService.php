<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\MusicianApplication;

final class MailService
{
    public function __construct(
        private readonly string $projectDir,
        private readonly string $mailTo,
        private readonly string $mailFrom,
        private readonly string $transport
    ) {
    }

    public function notifyMusicianApplication(MusicianApplication $application): void
    {
        $subject = sprintf('Nuova richiesta "Suona con noi" da %s', $application->getFullName());
        $message = implode(PHP_EOL, [
            'Nuova candidatura ricevuta dal sito Jamz.',
            '',
            'Nome: ' . $application->getFullName(),
            'Email: ' . $application->getEmail(),
            'Telefono: ' . $application->getPhone(),
            'Genere musicale: ' . $application->getMusicGenre(),
            'Disponibilita: ' . $application->getAvailability(),
            'Link materiali: ' . ($application->getMaterialLink() ?? 'Non indicato'),
            '',
            'Descrizione progetto:',
            $application->getProjectDescription(),
        ]);

        if ($this->transport === 'mail' && function_exists('mail')) {
            @mail(
                $this->mailTo,
                $subject,
                $message,
                sprintf("From: %s\r\nContent-Type: text/plain; charset=UTF-8", $this->mailFrom)
            );

            return;
        }

        $logLine = sprintf("[%s] %s\n%s\n\n", date('Y-m-d H:i:s'), $subject, $message);
        @file_put_contents($this->projectDir . '/var/log/mail.log', $logLine, FILE_APPEND);
    }
}
