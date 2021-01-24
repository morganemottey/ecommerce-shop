<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Order;

class OrderCancelController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/commande/erreur/{stripeSessionId}", name="order_cancel")
     */
    public function index($stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);
        
        if(!$order || $order->getUser() != $this->getUser()) { // nous testons si l'order n'existe pas ou que l'utilisateur ne correspond au bon utilisateur, la commande ne pourra abotir
            return $this->redirectToRoute('home');
        }
    
        // Envoyer un email à notre client pour lui envoyer un echec de paiment
        // Afficher les queleues infos de la commande de l'utilisateur
        
        return $this->render('order_cancel/index.html.twig', [
            'order' => $order
        ]);
    }
}
