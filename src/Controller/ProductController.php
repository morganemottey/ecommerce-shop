<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/mes-produits", name="products")
     */
    public function index(): Response
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();
            return $this->render('product/index.html.twig', [
                'products' => $products
            ]);
    }
}
