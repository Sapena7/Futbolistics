<?php

namespace App\Controller;

use App\Entity\Noticia;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Twig\Mime\NotificationEmail;

class MailerController extends AbstractController
{
    public function sendEmail(MailerInterface $mailer, $idNoticia){

        $noticias = $this->getDoctrine()
            ->getRepository(Noticia::class);

        $noticia = $noticias->findNewsById($idNoticia);

        $email = (new NotificationEmail())
            ->from('jsapenafutbolistics@gmail.com')
            ->to('jaumesapena77@gmail.com')
            ->subject($noticia->getTitular())
            ->action('Leer', '127.0.0.1/noticia/' . $idNoticia);
            //->importance(NotificationEmail::IMPORTANCE_HIGH);

        $mailer->send($email);

        return null;
    }
}