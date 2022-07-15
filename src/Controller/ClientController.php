<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\Client1Type;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/profile')]
class ClientController extends AbstractController
{
  

    

    #[Route('/show', name: 'app_client_show', methods: ['GET'])]
    public function show(Security $security): Response
    {
        $client=$security->getUser();
       
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }

    #[Route('/edit', name: 'app_client_edit', methods: ['GET', 'POST'])]
    public function edit(Security $security, Request $request, ClientRepository $clientRepository): Response
    {
        $client=$security->getUser();
        $form = $this->createForm(Client1Type::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $clientRepository->add($client);
            return $this->redirectToRoute('app_client_show', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('client/edit.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

   
}
