<?php

namespace App\Classe;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
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
}