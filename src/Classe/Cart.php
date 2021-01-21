<?php

namespace App\Classe;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface; 

class Cart
{
    private $session;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
    }

    public function add($id) 
    {
        $cart = $this->session->get('cart', []);

        if(!empty($cart[$id])) { //permet d'incrémenter notre quantitée présente dans notre panier
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $this->session->set('cart', $cart);
    }

    public function get() 
    {
        return $this->session->get('cart');
    }

    public function remove() 
    {
        return $this->session->remove('cart'); //permet de supprimer ou diminuer la quantité dans notre panier
    }
    public function delete($id) 
    {
        $cart = $this->session->get('cart', []);

        unset($cart[$id]);
        
        return $this->session->set('cart', $cart);
    }
    public function decrease($id) 
    {
        $cart = $this->session->get('cart', []);
        
        if($cart[$id] > 1 ) {
            $cart[$id] --;
        } else {
            unset($cart[$id]);
        }
        
        return $this->session->set('cart', $cart);
    }
    public function getFull() 
    {
        $cartComplete = [];

        if($this->get()) {
            foreach($this->get() as $id => $quantity) {
                $product_object = $this->entityManager->getRepository(Product::class)->findOneById($id);

                if(!$product_object) {
                    $this->delete($id); //permet de supprimer automatiquement le mauvais id dans notre table si celui ci est faux
                    continue; // permet de sortir de la boucle et de ne pas affecter le mauvais id et éviter une erreur
                }
                $cartComplete[] = [
                    'product' => $product_object,
                    'quantity' => $quantity
                ];
            }
        }
        return $cartComplete;
    }
}