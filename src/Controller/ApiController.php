<?php
namespace App\Controller;

use App\Entity\Brands;
use App\Entity\Categories;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ApiController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $em)
    {}

    #[Route('/products', name: 'api.products', methods: ['GET'])]
    public function products(): JsonResponse
    {
        $products = $this->em->getRepository(Products::class)->findAll();

        return $this->json($products, 200, [], ['groups' => ['products.read']]);
    }

    #[Route('/categories', name: 'api.categories', methods: ['GET'])]
    public function categories(): JsonResponse
    {
        $categories = $this->em->getRepository(Categories::class)->findAll();

        return $this->json($categories, 200, [], ['groups' => ['categories.read']]);
    }

    #[Route('/brands', name: 'api.brands', methods: ['GET'])]
    public function brands(): JsonResponse
    {
        $brands = $this->em->getRepository(Brands::class)->findAll();

        return $this->json($brands, 200, [], ['groups' => ['brands.read']]);
    }
}