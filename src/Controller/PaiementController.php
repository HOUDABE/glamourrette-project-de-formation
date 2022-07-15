<?php

namespace App\Controller;

use App\Service\Cart;
use App\Entity\Commande;
use App\Service\Paiement;
use App\Entity\CommandeOneLine;
use App\Repository\ProduitRepository;
use App\Repository\CommandeRepository;
use App\Repository\CommandeOneLineRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaiementController extends AbstractController
{
    #[Route('/paiement/reussi', name: 'app_paiement_reussi')]
    public function sucess(Security $security, CommandeRepository $commandeRepository,CommandeOneLineRepository $commandeOneLineRepositor, Cart $cart,SessionInterface $session, ProduitRepository $produitRepository): Response
    {
         // recuperation du panier [ id => Quantite : 3 => 5]
         $cart_s=$session->get('cart' , []);
          // Je vais lire mon panier 
        // a chaque identifiant je vais le stocke dans une nouvelle ligne
        // de ma table CommandeOneLine

        // recuperation de l'objet user en session
         $user=$security->getUser();
         $lineCommande = new CommandeOneLine();
         $commande=new Commande();                          
         $commande->setClient($user);
        $commande->setDateCommande(new \DateTime );
         $commandeRepository->add($commande);
        

         foreach ($cart_s as $id=>$quantite){
                // mescommandes correspond à ligne commande
            $lineCommande = new CommandeOneLine();

            // stock dans $p le produit correpond à $id issue du panier grace au Repository
            $p=$produitRepository->find($id);
              // modifier l'entité et on utiliser setProduits pour inserer le produit dans l'entité commande
             
              $lineCommande->setProduit($p);
              // modifier l'entité et on utiliser setQuantite pour inserer la quantité dans l'entité commande
              $lineCommande->setQuantite($quantite);
              $lineCommande->setPrixTotal($p->getPrixProduit()*$quantite);
              $lineCommande->setCommande($commande);
              $lineCommande->setQuantite($quantite);
              // Ajout en BD de la la nouvelle ligne issue du panier
              // grâce à entity manager
            //   $CommandeOneLineRepository->add($lineCommande);
          }
         
        $cart->clear();
        return $this->render('paiement/success.html.twig');
     
    }
    #[Route('/paiement', name: 'app_paiement')]
    public function index(Paiement $paiement,Cart $cart): Response
    {
        $paymentIntent=$paiement->create();
        $total= $cart->getTotal();

        return $this->render('paiement/index.html.twig', [
            'controller_name' => 'PaiementController',
             'clientSecret'=>$paymentIntent->client_secret,
            'total'=>$total
        ]);
    }
}
