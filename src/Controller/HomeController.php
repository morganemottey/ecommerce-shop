<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Classe\Mail;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $mail = new Mail();

        $mail->send('morgane.mottey@gmail.com', 'Momo', 'Mon premier mail', "Bonjour Momo comment vas-tu");

        return $this->render('home/index.html.twig',);
    }
}
