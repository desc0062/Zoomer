<?php

namespace App\Controller\Admin;

use App\Entity\Activity;
use App\Entity\Animal;
use App\Entity\Booking;
use App\Entity\User;
use App\Entity\Ticket;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Sae3 01');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa-solid fa-user', User::class);
        yield MenuItem::linkToCrud('Activités', 'fas fa-list', Activity::class);
        yield MenuItem::linkToCrud('Animaux', 'fa-solid fa-hippo', Animal::class);
        yield MenuItem::linkToCrud('Réservations', 'fa-solid fa-calendar-days', Booking::class);
        yield MenuItem::linkToCrud('Tickets', 'fa-solid fa-ticket', Ticket::class);
    }
}
