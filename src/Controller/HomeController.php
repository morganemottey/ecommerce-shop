<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Classe\Mail;
use App\Entity\Header;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

class HomeController extends AbstractController
{   private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        //$mail = new Mail();
        //$mail->send('morgane.mottey@gmail.com', 'Momo', 'Mon premier mail', "Bonjour Momo comment vas-tu");
        $products = $this->entityManager->getRepository(Product::class)->findByIsBest(1);
        $header = $this->entityManager->getRepository(Header::class)->findAll();

        return $this->render('home/index.html.twig', [
            'products'=> $products,
            'header' => $header
        ]);
    }
}
