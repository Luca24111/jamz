<?php

declare(strict_types=1);

namespace App\Entity\Concerns;

trait ResolvesPublicAssetPath
{
    private function resolvePublicAssetPath(?string $path, string $baseDirectory): string
    {
        $value = trim((string) $path);

        if ($value === '') {
            return '';
        }

        if (preg_match('#^(?:https?:)?//#', $value) === 1 || str_starts_with($value, '/')) {
            return $value;
        }

        if (str_starts_with($value, $baseDirectory . '/')) {
            return $value;
        }

        if (str_contains($value, '/')) {
            return ltrim($value, '/');
        }

        return $baseDirectory . '/' . $value;
    }
}
