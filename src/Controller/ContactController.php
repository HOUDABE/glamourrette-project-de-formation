<?php

namespace App\Controller;

use App\Service\Mail;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{

    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(Request $request,Mail $mail): Response
    {
        // on créé un formulaire de type contact Form/ContactType
        $formulaire = $this->createForm(ContactType::class);
        $formulaire->handleRequest($request);


        // on vérifie si les donnée sont envoyé
        if ($formulaire->isSubmitted()) {
            // on recuperer les donnée envoyé
            $data = $formulaire->getData();

            
                // Utilisation du service de mail
                $mail->send($data); 
            // on redirige vers la page envoye.html.twig
            return $this->renderForm('contact/envoye.html.twig', [
                'data' => $data
            ]);
        } else {
            return $this->renderForm('contact/index.html.twig', [
                'form' => $formulaire,
            ]);
        }
    }
}