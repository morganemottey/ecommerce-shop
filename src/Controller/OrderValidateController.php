<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Order;
use App\Classe\Cart;
use App\Classe\Mail;

class OrderValidateController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/commande/merci/{stripeSessionId}", name="order_validate")
     */
    public function index(Cart $cart, $stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);
        
        if(!$order || $order->getUser() != $this->getUser()) { // nous testons si l'order n'existe pas ou que l'utilisateur ne correspond au bon utilisateur, la commande ne pourra abotir
            return $this->redirectToRoute('home');
        }
        // Modifier le statut isPaid de notre commande en le passant à 1
        if(!$order->getState()) {
            // Vider la session 'cart'
            $cart->remove();
            $order->setState(1);
            $this->entityManager->flush();
        }
        // Envoyer un email à notre client pour lui confirmer la commande
        $mail = new Mail();
        $content ='Bonjour '.$order->getUser()->getFirstName();
        $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstName(), "Merci pour votre commande", $content);
        // Afficher les queleues infos de la commande de l'utilisateur
        return $this->render('order_success/index.html.twig', [
            'order' => $order
        ]);
    }
}
