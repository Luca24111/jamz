<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\MusicianApplicationService;
use App\Service\PageContentService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MusicianApplicationController extends BaseController
{
    public function __construct(
        PageContentService $pageContentService,
        private readonly MusicianApplicationService $applicationService
    ) {
        parent::__construct($pageContentService);
    }

    #[Route('/suona-con-noi', name: 'app_musician_create', methods: ['GET'])]
    public function create(Request $request): Response
    {
        return $this->render('pages/musician/index.html.twig', $this->page([
            'errors' => [],
            'old' => $this->emptyForm(),
            'success_message' => $request->query->getBoolean('submitted')
                ? 'Richiesta inviata correttamente. Ti contatteremo dopo la valutazione del materiale.'
                : null,
        ], 'Suona con noi', 'suona-con-noi.css', 'suona-con-noi.js'));
    }

    #[Route('/suona-con-noi', name: 'app_musician_store', methods: ['POST'])]
    public function store(Request $request): Response
    {
        $result = $this->applicationService->validate($request->request->all());

        if (!$this->isCsrfTokenValid('musician_application', (string) $request->request->get('_token'))) {
            $result['errors']['form'] = 'La sessione del modulo è scaduta. Ricarica la pagina e riprova.';
        }

        if ($result['errors'] !== []) {
            return $this->render('pages/musician/index.html.twig', $this->page([
                'errors' => $result['errors'],
                'old' => $result['old'],
                'success_message' => null,
            ], 'Suona con noi', 'suona-con-noi.css', 'suona-con-noi.js'), new Response('', Response::HTTP_UNPROCESSABLE_ENTITY));
        }

        $this->applicationService->submit($result['old']);

        return $this->redirectToRoute('app_musician_create', ['submitted' => 1]);
    }

    /**
     * @return array<string, string>
     */
    private function emptyForm(): array
    {
        return [
            'nome' => '',
            'cognome' => '',
            'email' => '',
            'telefono' => '',
            'genere_musicale' => '',
            'descrizione_progetto' => '',
            'link_materiale' => '',
            'disponibilita' => '',
        ];
    }
}
