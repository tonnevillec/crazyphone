<?php

namespace App\Controller;

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
        $promotions = $this->em->getRepository(Promotions::class)->findBy([], ['id' => 'desc'], 2);

        return $this->render('app/index.html.twig', [
            'openings' => $openings,
            'services' => $services,
            'networks' => $networks,
            'contacts' => $contacts,
            'promotions' => $promotions,
        ]);
    }

    #[Route('/shop', name: 'app_shop')]
    public function shop(): Response
    {
        return $this->render('app/shop.html.twig');
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        $about = $this->em->find(About::class, 1);
        $pictures = $this->em->getRepository(Galerie::class)->findBy([], ['ordre' => 'asc']);

        return $this->render('app/about.html.twig', [
            'about' => $about,
            'pictures' => $pictures
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
