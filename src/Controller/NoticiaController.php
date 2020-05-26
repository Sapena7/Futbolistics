<?php

namespace App\Controller;

use App\Entity\Equipo;
use App\Entity\Noticia;
use App\Entity\Usuario;
use App\Form\NoticiaType;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DateTime;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;

/**
 * @Route("/noticias")
 */
class NoticiaController extends AbstractController
{
    /**
     * @Route("/", defaults={"page": "1"}, methods="GET", name="noticia_index")
     * @Route("/pagina/{page<[1-9]\d*>}", methods="GET", name="noticia_paginated")
     *
     * NOTE: For standard formats, Symfony will also automatically choose the best
     * Content-Type header for the response.
     * See https://symfony.com/doc/current/routing.html#special-parameters
     */
    public function index(Request $request, int $page)
    {
        $news = $this->getDoctrine()
            ->getRepository(Noticia::class);

        $equipos = $this->getDoctrine()
            ->getRepository(Equipo::class)
            ->findAll();

        if ($request->query->get('text') == null){
            $text = null;
        }else{
            $text = $request->query->get('text');
        }

        if ($request->query->get('equipo') == null){
            $equipo = null;
        }else{
            $equipo = $request->query->get('equipo');
        }

        if ($request->query->get('fechaMin') == null && $request->query->get('fechaMax') == null){
            $fechaMin = null;
            $fechaMax = null;
        }else{
            $fechaMin = $request->query->get('fechaMin');
            $fechaMax = $request->query->get('fechaMax');
            $formato = 'Y-m-d h:i';
            $fechaMin = DateTime::createFromFormat($formato, $fechaMin .  " 00:00");
            $fechaMax = DateTime::createFromFormat($formato, $fechaMax . " 00:00");
        }

        $noticias = $news->findAllOrderByDate($page, $equipo, $fechaMin, $fechaMax, $text);

        $properties = ['noticias' => $noticias, 'equipos' => $equipos];
        return $this->render('noticia/index.html.twig', $properties);
    }

    /**
     * @Route("/noticia/{id}", name="noticias_byId", methods={"GET"})
     */
    public function findNoticiaById($id)
    {
        $noticias = $this->getDoctrine()
            ->getRepository(Noticia::class);
        $noticia = $noticias->findNewsById($id);
        $noticiasRecomendadas = $noticias->orderByFecha();
        $idColaborador = $noticia->getColaborador();
        $nNoticiasColaborador = $noticias->countNoticiasByIdColaborador($idColaborador);

        $properties = ['noticia' => $noticia, 'noticiasRecomendadas' => $noticiasRecomendadas, 'nNoticiasColaborador' => $nNoticiasColaborador];
        return $this->render('noticia/noticia.twig', $properties);
    }

    /**
     * @Route("/new", name="noticia_new", methods={"GET","POST"})
     */
    public function new(Request $request, MailerInterface $mailer): Response
    {
        $usuarios = $this->getDoctrine()
            ->getRepository(Usuario::class);
        $noticium = new Noticia();
        $form = $this->createForm(NoticiaType::class, $noticium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($noticium);
            $entityManager->flush();

            $id_equipo = $noticium->getEquipo()->getId();

            $lista = $usuarios->findEmailsByTeam($id_equipo);

            $contenido = substr($noticium->getCuerpo(), 0, 15).'...';

            $array_num = count($lista);
            $toAddresses = [];
            for ($i = 0; $i < $array_num; ++$i){
                array_push($toAddresses,$lista[$i]["email"]);
            }

            $email = (new NotificationEmail())
                ->from('jsapenafutbolistics@gmail.com')
                ->to(...$toAddresses)
                ->subject($noticium->getTitular())
                ->action('Leer', 'http://127.0.0.1:8000/noticias/noticia/' . $noticium->getId());
                //->importance(NotificationEmail::IMPORTANCE_MEDIUM);

            $mailer->send($email);

            $this->addFlash(
                'info',
                'Creado correctamente'
            );

            return $this->redirectToRoute('noticia_index');
        }

        return $this->render('noticia/new.html.twig', [
            'noticium' => $noticium,
            'form' => $form->createView(),
        ]);
    }
/*
    /**
     * @Route("/num/{id}", name="noticia_show", methods={"GET"})

    public function show(Noticia $noticium): Response
    {
        return $this->render('noticia/show.html.twig', [
            'noticium' => $noticium,
        ]);
    }
*/
    /**
     * @Route("/{id}/edit", name="noticia_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Noticia $noticium): Response
    {
        $form = $this->createForm(NoticiaType::class, $noticium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'info',
                'Editado correctamente'
            );

            return $this->redirectToRoute('noticia_index');
        }

        return $this->render('noticia/edit.html.twig', [
            'noticium' => $noticium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="noticia_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Noticia $noticium): Response
    {
        if ($this->isCsrfTokenValid('delete'.$noticium->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($noticium);
            $entityManager->flush();

            $this->addFlash(
                'info',
                'Borrado correctamente'
            );
        }

        return $this->redirectToRoute('noticia_index');
    }
}
