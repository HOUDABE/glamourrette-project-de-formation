<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ParfumController extends AbstractController
{
    #[Route('/parfum', name: 'app_parfum')]
    public function index(ProduitRepository $produitRepository): Response
    {
        //$this->repos['notif']->findby(array('status' => array(1, 2, 3)));
 
        return $this->render('parfum/index.html.twig', [
            'controller_name' => 'ParfumController',
            'produits' => $produitRepository->findBy( ['categorieR' => array(1, 2, 4) , ]),
           
        ]);
    }

    #[Route('/parfum/parfum-femme', name: 'app_parfum_femme')]
    public function parfumFemme(ProduitRepository $produitRepository): Response
    {
        return $this->render('parfum/pFemme.html.twig', [
            'controller_name' => 'ParfumController',

            'produits' => $produitRepository->findBy( ['categorieR' => '1' ]),
        ]);
    }

    #[Route('/parfum/parfum-homme', name: 'app_parfum_homme')]
    public function parfumHomme(ProduitRepository $produitRepository): Response
    {
        return $this->render('parfum/pHomme.html.twig', [
            'controller_name' => 'ParfumController',
            'produits' => $produitRepository->findBy( ['categorieR' => '2' ]),
        ]);
    }

    #[Route('/parfum/parfum-enfant', name: 'app_parfum_enfant')]
    public function parfumEnfant(ProduitRepository $produitRepository): Response
    {
        return $this->render('parfum/enfant.html.twig', [
            'controller_name' => 'ParfumController',

            'produits' => $produitRepository->findBy( ['categorieR' => '3' ]),
        ]);
    }

    
    #[Route('/parfum/coffret-parfum', name: 'app_coffret_parfum')]
    public function coffretParfum(ProduitRepository $produitRepository): Response
    {
        return $this->render('parfum/coffret.html.twig', [
            'controller_name' => 'ParfumController',
            'produits' => $produitRepository->findBy( ['categorieR' => '4' ]),
        ]);
    }
}


