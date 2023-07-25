<?php
namespace App\Controller;

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
}