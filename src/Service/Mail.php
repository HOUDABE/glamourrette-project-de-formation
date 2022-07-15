<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class Mail{

    // un attribut permettant de recuperer le mailerinterface
    private $monmail;

    public function __construct(MailerInterface $mail)
    {
        // on de recuperer le mailer interface dans l attribut mon mail
        $this->monmail=$mail;
    }


    public function send($data){
        
        $lemail=new TemplatedEmail();
        $lemail->from($data['email'])
                ->to('benradi.houda@gmail.com') 
                ->subject('email')
                ->text($data['message'])
               // path of the Twig template to render
                ->htmlTemplate('contact/envoye.html.twig')
                ->context([
                    'expiration_date' => new \DateTime('+7 days'),
                    'username' => 'houda',
                    'data' => $data // envoie des données du tableau de form depuis le parametre de la méthode send
                ]);

        $this->monmail->send($lemail); 
    }
}