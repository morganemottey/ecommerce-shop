<?php

namespace App\Controller;

use App\Entity\Adress;
use App\Classe\Cart;
use App\Form\AdressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AccountAdressController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
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
    public function add(Cart $cart, Request $request)
    {
        $adress = new Adress();

        $form = $this->createForm(AdressType::class, $adress);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adress->setUser($this->getUser());
            $this->entityManager->persist($adress);
            $this->entityManager->flush();
            if($cart->get()) {
                return $this->redirectToRoute('order');
            } else {
                return $this->redirectToRoute('account_adress');
            }
        }

        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/compte/modifier-une-adresse/{id}", name="edit_account_adress")
     */
    public function edit(Request $request , $id)
    {
        $adress = $this->entityManager->getRepository(Adress::class)->findOneById($id);

        if(!$adress || $adress->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_adress');
        }
        $form = $this->createForm(AdressType::class, $adress);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->redirectToRoute('account_adress');
        }

        return $this->render('account/address_form.html.twig', [
            'form' => $form->createView()
        ]);
    }
     /**
     * @Route("/compte/supprimer-une-adresse/{id}", name="delete_account_adress")
     */
    public function delete($id)
    {
        $adress = $this->entityManager->getRepository(Adress::class)->findOneById($id);

        if($adress && $adress->getUser() == $this->getUser()) {
            $this->entityManager->remove($adress);
            $this->entityManager->flush();
        }
        return $this->redirectToRoute('account_adress');
    }
}
