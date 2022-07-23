<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Service\Cart;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{

  
    /**
     * @Route("/cart/view", name="app_cart_view")
     */
    public function view(SessionInterface $session, Cart $cart,ProduitRepository $produitRepository): Response
    {
        if (!empty($session->get('cart'))) {

            $panier_rempli = $cart->getFull();
            $total = $cart->getTotal();
        } else {
            $panier_rempli = 0;
            $total = 0;
        }

        return $this->render('cart/view.html.twig', [
            'controller_name' => 'CartController',
            'rows' =>  $panier_rempli,
            'total' => $total
        ]);
    }

    // vider le panier 
    /**
     * @Route("/cart/clear", name="app_cart_clear")
     */
    public function clear(Cart $cart): Response
    {
        // supprimer la variable cart contenant un tableau enregistré en session
        $cart->clear();

        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
        ]);
    }


    /**
     * @Route("/cart/add/{id}", name="app_cart")
     */
    public function index($id, Cart $cart): Response
    {

        $cart->add($id);
        $panier_rempli = $cart->getFull();
        $total = $cart->getTotal();

        return $this->redirectToRoute('app_maquillage');

        
    }

    /**
     * @Route("/cart/remove/{id}", name="app_remove")
     */
    public function remove($id, Cart $cart): Response
    {
        // on utilise le service pour supprimer de notre panier
        $cart->remove($id);

        // on redirige
        return $this->redirectToRoute('app_cart_view');
    }
}
