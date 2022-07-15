<?php

namespace App\Service;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{

    protected $session;
    protected $produitRepository;

    public function __construct(SessionInterface $session, ProduitRepository $produitRepository)
    {
        $this->session = $session;
        $this->produitRepository = $produitRepository;
    }

            public function add(int $id)
            {
                $cart =  $this->session->get('cart', []);
                if (!empty ($cart[$id])) { //si j'ai deja un produit dans mon panier
                    $cart[$id] ++;    // je vais ajouté un autre p
                } else {
                    $cart[$id] = 1;   //si nom panier =1
                }
   // ce qui a etait dans mon panier je le remplace par mon nouveau panier
                $this->session->set('cart', $cart);
            }

    public function clear()
    {
        // supprimer la variable cart contenant un tableau enregistré en session
        $this->session->remove('cart');
    }

    public function getFull()
    {

        // Recuperation du panier
        // Si il existe on aura le tableau rempli sinon un tableau vide
        $cart = $this->session->get('cart', []);
        foreach ($cart as $id => $quantite) {
            $panier_rempli[] = [
                'product' => $this->produitRepository->find($id),
                'quantite' => $quantite
            ];
        }

        return $panier_rempli;
    }

    public function getTotal()
    {

        $panier_rempli = $this->getFull();
        $total = 0;
        if ($panier_rempli != "") {

            foreach ($panier_rempli as $couple) {
              
                $total += ($couple['product']->getPrixProduit() * $couple['quantite']);
            }
        }
        return $total;
    }

    public function remove(int $id)
    {

        // on recupere le panier en session
        $cart = $this->session->get('cart', []);



        // on verifie que l'ID est bien présent 
        // dans le tableau de session
        if (!empty($cart[$id])) {
            // on supprime du tableau la clé correspondante
            if ($cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        }

        // on écrit dans la sessions
        $this->session->set('cart', $cart);
    }
}