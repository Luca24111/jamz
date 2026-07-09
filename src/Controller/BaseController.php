<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\PageContentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

abstract class BaseController extends AbstractController
{
    public function __construct(private readonly PageContentService $pageContentService)
    {
    }

    /**
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    protected function page(array $data, string $title, string $pageCss, string $pageJs): array
    {
        return array_merge($data, [
            'page_title' => sprintf('%s | Jamz', $title),
            'page_css' => $pageCss,
            'page_js' => $pageJs,
            'navigation' => $this->pageContentService->navigation(),
        ]);
    }

    protected function pageContentService(): PageContentService
    {
        return $this->pageContentService;
    }
}
