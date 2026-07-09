<?php

declare(strict_types=1);

namespace App\Entity;

enum MusicianApplicationStatus: string
{
    case InAttesa = 'in_attesa';
    case Accettata = 'accettata';
    case Rifiutata = 'rifiutata';
}
