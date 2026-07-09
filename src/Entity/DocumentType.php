<?php

declare(strict_types=1);

namespace App\Entity;

enum DocumentType: string
{
    case Statuto = 'statuto';
    case AttoCostitutivo = 'atto_costitutivo';
    case Altro = 'altro';
}
