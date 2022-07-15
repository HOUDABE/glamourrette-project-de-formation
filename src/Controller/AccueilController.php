<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(ProduitRepository $produitRepository ): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'produits' => $produitRepository->findBy( ['categorieR' => '1' ]),
            'arrivage' => $produitRepository->findBy( [ 'categorieR' => '4']),
        ]);
    }

 
}
