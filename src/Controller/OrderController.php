<?php

namespace App\Controller;

use App\Form\OrderType;
use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/commande", name="order")
     */
    public function index(Request $request, Cart $cart): Response
    {
        if (!$this->getUser()->getAdresses()->getValues())  //getValues permet de récupérer toutes mes data
        {
            return $this->redirectToRoute('add_account_adress');
        } 
        $form = $this->createForm(OrderType::class , null, [
            'user' => $this->getUser()
        ]);

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);
    }
    /**
     * @Route("/commande/recapitulatif", name="order_recap", methods={"POST"})
     */
    public function add(Request $request, Cart $cart): Response
    {
        $form = $this->createForm(OrderType::class , null, [
            'user' => $this->getUser()
        ]);

        $form ->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 

            $date = new DateTime();
            $carrieres = $form->get('carrieres')->getData();
            $delivery = $form->get('adresses')->getData();
            $delivery_content = $delivery->getFirstname(). ' '. $delivery->getLastname();
            $delivery_content .= '<br/>'.$delivery->getPhone();

            if($delivery->getCompany()) {
                $delivery_content .= '<br/>'.$delivery->getCompany();
            }

            $delivery_content .= '<br/>'.$delivery->getAdress();
            $delivery_content .= '<br/>'.$delivery->getCodepostal();
            $delivery_content .= '<br/>'.$delivery->getCity();
        
            // Enregistrer ma commande Order()
            $order = new Order();
            $order->setUser($this->getUser());
            $order->setCreateAt($date);
            $order->setCarrierName($carrieres->getName());
            $order->setCarrierPrice($carrieres->getPrix());
            $order->setDelivery($delivery_content);
            $order->setIsPaid(0);
            
            $this->entityManager->persist($order);
            
            
            // Enregistrer mes produits OrderDetails()
            foreach ($cart->getFull() as $product) {
                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product['product']->getPrix());
                $orderDetails->setTotal($product['product']->getPrix() * $product['quantity']);
                $this->entityManager->persist($orderDetails);
                }
            
            // $this->entityManager->flush();
            
            return $this->render('order/add.html.twig', [
                'cart' => $cart->getFull(),
                'carrieres' => $carrieres,
                'delivery' => $delivery_content,
            ]);

        } else {

            return $this->redirectToRoute('cart');
        }

    }
}
