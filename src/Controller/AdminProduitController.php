<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Service\FileUploader;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/produit')]
class AdminProduitController extends AbstractController
{
    #[Route('/', name: 'app_admin_produit_index', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('admin/admin_produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_produit_new', methods: ['GET', 'POST'])]
    public function new(fileUploader  $fileUploader, Request $request, ProduitRepository $produitRepository): Response
    {
        $produit = new Produit();//on instancie la classe produit: devient un object
        $form = $this->createForm(ProduitType::class, $produit);//on crée un formulaire a partir de la class ProduitType  
        $form->handleRequest($request);//on demmande au formailaire de recuperer les données
   //si le form est valaidé 
        if ($form->isSubmitted() && $form->isValid()) {

          
                // le fichier qu'on recupere depuis le form
                $file = $form->get('imageProduit')->getData();
                // Si il existe bien alors
                if ($file) {
                    // on l'envoie sur le serveur grace au service
                    $FileName = $fileUploader->upload($file); // upload du fichier
                    $produit->setImageProduit($FileName); // nom du fichier
                }

           //utilise le repository pour ajouter les infor dans entité article
            //rediriger vers la fonction index 
            $produitRepository->add($produit);
            return $this->redirectToRoute('app_admin_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_admin_produit_show', methods: ['GET'])]
    public function show(Produit $produit): Response
    {
        return $this->render('admin/admin_produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $produitRepository->add($produit);
            return $this->redirectToRoute('app_admin_produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/admin_produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_produit_delete', methods: ['POST'])]
    public function delete(Request $request, Produit $produit, ProduitRepository $produitRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $produitRepository->remove($produit);
        }

        return $this->redirectToRoute('app_admin_produit_index', [], Response::HTTP_SEE_OTHER);
    }
   
}