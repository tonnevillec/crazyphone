<?php

namespace App\Controller;

use App\Entity\Brands;
use App\Entity\Categories;
use App\Entity\ContactInformations;
use App\Entity\Openings;
use App\Entity\Products;
use App\Entity\Services;
use App\Entity\SocialNetworks;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    public function __construct(private readonly EntityManagerInterface $em)
    {}

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $openings = $this->em->getRepository(Openings::class)->findAll();
        $services = $this->em->getRepository(Services::class)->findBy([], ['position' => 'ASC']);
        $networks = $this->em->getRepository(SocialNetworks::class)->findAll();
        $contacts = $this->em->getRepository(ContactInformations::class)->findAll();

        return $this->render('app/index.html.twig', [
            'openings' => $openings,
            'services' => $services,
            'networks' => $networks,
            'contacts' => $contacts,
        ]);
    }

    #[Route('/shop', name: 'app_shop')]
    public function shop(): Response
    {
        $products = $this->em->getRepository(Products::class)->findAll();
        $brands = $this->em->getRepository(Brands::class)->findBy([], ['name' => 'ASC']);
        $categories = $this->em->getRepository(Categories::class)->findBy([], ['title' => 'ASC']);

        return $this->render('app/shop.html.twig', [
            'products' => $products,
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        $openings = $this->em->getRepository(Openings::class)->findAll();
        $networks = $this->em->getRepository(SocialNetworks::class)->findAll();

        return $this->render('app/contact.html.twig', [
            'networks' => $networks,
            'openings' => $openings,
        ]);
    }
}
