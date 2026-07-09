<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\AdminUser;
use App\Entity\Associate;
use App\Entity\BoardMember;
use App\Entity\Document;
use App\Entity\Event;
use App\Entity\EventImage;
use App\Entity\MusicianApplication;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractDashboardController
{
    public function __construct(private readonly AdminUrlGenerator $adminUrlGenerator)
    {
    }

    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(EventCrudController::class)
            ->setAction(Action::INDEX)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Jamz Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Contenuti');
        yield MenuItem::linkToCrud('Eventi', 'fa fa-calendar', Event::class);
        yield MenuItem::linkToCrud('Immagini evento', 'fa fa-image', EventImage::class);
        yield MenuItem::linkToCrud('Documenti', 'fa fa-file-pdf', Document::class);
        yield MenuItem::linkToCrud('Consiglio', 'fa fa-user-tie', BoardMember::class);
        yield MenuItem::linkToCrud('Associati', 'fa fa-users', Associate::class);
        yield MenuItem::linkToCrud('Candidature', 'fa fa-music', MusicianApplication::class);
        yield MenuItem::section('Accesso');
        yield MenuItem::linkToCrud('Utenti admin', 'fa fa-user-shield', AdminUser::class);
        yield MenuItem::linkToRoute('Torna al sito', 'fa fa-arrow-left', 'app_home');
        yield MenuItem::linkToRoute('Logout', 'fa fa-sign-out-alt', 'app_logout');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return UserMenu::new()
            ->setName($user->getUserIdentifier())
            ->displayUserName()
            ->displayUserAvatar(false)
            ->setMenuItems([]);
    }
}
