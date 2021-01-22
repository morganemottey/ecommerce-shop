<?php

namespace App\Controller;

use App\Form\OrderType;
use App\Classe\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
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

        $form ->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            dd($form->getData());

        }

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);
    }
}
