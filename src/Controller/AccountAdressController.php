<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Form\AdressType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAdressController extends AbstractController
{
    /**
     * @Route("/compte/adress", name="account_adress")
     */
    public function index(): Response
    {
        return $this->render('account/address.html.twig', );
    }
    /**
     * @Route("/compte/ajouter-une-adresse", name="add_account_adress")
     */
    public function add()
    {
        $adress = new Adress();

        $form = $this->createForm(AdressType::class, $adress);
        return $this->render('account/address_add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
