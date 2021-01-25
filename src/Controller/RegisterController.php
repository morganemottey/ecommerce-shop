<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Classe\Mail;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{   private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/inscription", name="register")
     */

    public function index(Request $request, UserPasswordEncoderInterface $encoder )
    {
        $notification = null;
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user );

        $form ->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $user = $form->getData();

            $search_email = $this->entityManager->getRepository(User::class)->findOneByMail($this->getUser());
            
            if($search_email) {
                $password = $encoder->encodePassword($user,$user->getPassword());
                $user->setPassword($password);
    
                $this->entityManager->persist($user);
                $this->entityManager->flush();

                $mail = new Mail();
                $content ='Lorem ueueudhiudhkz iaugdbakunkx udgalnxkak';
                $mail->send($user->getEmail(), $user->getFirstName(), "Bienvenue sur notre eshop", $content);
    
                $notification = "Votre inscription s'est correctement déroulée. VOus pouvez dès à présent vous connecter à votre compte";               
            } else {
                $notification = "L'email que vous avez renseigné existe déjà";
            }
           

        }
        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
