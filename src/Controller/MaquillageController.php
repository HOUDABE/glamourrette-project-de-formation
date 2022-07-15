<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MaquillageController extends AbstractController
{
    #[Route('/maquillage', name: 'app_maquillage')]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('maquillage/index.html.twig', [
            'controller_name' => 'MaquillageController',
            'produits' => $produitRepository->findBy( ['categorieR' => array(5,6,7,8) ]),
        ]);
    }

    #[Route('/maquillage/teint', name: 'app_teint')]
    public function teint(ProduitRepository $produitRepository): Response
    {
        return $this->render('maquillage/teint.html.twig', [
            'controller_name' => 'MaquillageController',
            'produits' => $produitRepository->findBy( ['categorieR' => '5' ]),
        ]);
    }

    #[Route('/maquillage/levres', name: 'app_levres')]
    public function levres(ProduitRepository $produitRepository): Response
    {
        return $this->render('maquillage/levres.html.twig', [
            'controller_name' => 'MaquillageController',
            'produits' => $produitRepository->findBy( ['categorieR' => '6' ]),
        ]);
    }

    #[Route('/maquillage/ongles', name: 'app_ongles')]
    public function ongles(ProduitRepository $produitRepository): Response
    {
        return $this->render('maquillage/ongles.html.twig', [
            'controller_name' => 'MaquillageController',
            'produits' => $produitRepository->findBy( ['categorieR' => '7' ]),
        ]);
    }

    #[Route('/maquillage/yeux', name: 'app_yeux')]
    public function yeux(ProduitRepository $produitRepository): Response
    {
        return $this->render('maquillage/yeux.html.twig', [
            'controller_name' => 'MaquillageController',
            'produits' => $produitRepository->findBy( ['categorieR' => '8' ]),
        ]);
    }

}