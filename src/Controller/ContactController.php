<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    /**
     * @Route("/contacto", name="contact")
     */

    public function index(Request $request, \Swift_Mailer $mailer){
    $form = $this->createForm(ContactType::class);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        $contactFormData = $form->getData();

        $message = (new \Swift_Message('Tienes un correo!'))
            ->setFrom($contactFormData['email'])
            ->setTo('jsapenafutbolistics@gmail.com')
            ->setBody($contactFormData['mensaje'], 'text/plain');

           $mailer->send($message);

           $this->addFlash(
               'info',
               'Enviado correctamente'
           );

           return $this->redirectToRoute('contact');
        }

    return $this->render('contact/contacts.html.twig', [
        'form' => $form->createView(),
    ]);
}
}