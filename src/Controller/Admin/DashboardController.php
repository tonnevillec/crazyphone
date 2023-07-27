<?php

namespace App\Controller\Admin;

use App\Entity\About;
use App\Entity\Brands;
use App\Entity\Categories;
use App\Entity\ContactInformations;
use App\Entity\Galerie;
use App\Entity\Openings;
use App\Entity\Products;
use App\Entity\Promotions;
use App\Entity\Services;
use App\Entity\SocialNetworks;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(OpeningsCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Crazyphone')
            ->setLocales(['fr'])
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::subMenu('Magasin')->setSubItems([
            MenuItem::linkToCrud('Horaires', 'fas fa-list', Openings::class),
            MenuItem::linkToCrud('Services', 'fas fa-list', Services::class),
            MenuItem::linkToCrud('Contacts', 'fas fa-list', ContactInformations::class),
            MenuItem::linkToCrud('Réseaux', 'fas fa-list', SocialNetworks::class),
            MenuItem::linkToCrud('A propos', 'fas fa-list', About::class),
            MenuItem::linkToCrud('Galerie', 'fas fa-list', Galerie::class),
        ]);

        yield MenuItem::section('');

        yield MenuItem::subMenu('Articles')->setSubItems([
            MenuItem::linkToCrud('Categories de produits', 'fas fa-list', Categories::class),
            MenuItem::linkToCrud('Marques', 'fas fa-list', Brands::class),
            MenuItem::linkToCrud('Produits', 'fas fa-list', Products::class),
            MenuItem::linkToCrud('Promotions', 'fas fa-list', Promotions::class),
        ]);

//        yield MenuItem::section('');

//        yield MenuItem::subMenu('Administration')->setSubItems([
//            MenuItem::linkToCrud('Users', 'fas fa-list', Users::class),
//        yield MenuItem::linkToUrl('Analytics', 'fas fa-chart-line', $this->param->get('matomo'));
//        ]);

        yield MenuItem::section();
        yield MenuItem::linkToUrl('Retour au site', 'far fa-arrow-alt-circle-left', $this->generateUrl('app_home'));
    }
}
