<?php

namespace App\Controller;

use App\Entity\Equipo;
use App\Entity\Noticia;
use App\Form\NoticiaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DateTime;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/noticia")
 */
class NoticiaController extends AbstractController
{
    /**
     * @Route("/", defaults={"page": "1"}, methods="GET", name="noticia_index")
     * @Route("/page/{page<[1-9]\d*>}", methods="GET", name="noticia_paginated")
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
     * @Route("/{id}", name="noticias_byId", methods={"GET"})
     */
    public function findNoticiaById($id)
    {
        $noticias = $this->getDoctrine()
            ->getRepository(Noticia::class);
        $noticia = $noticias->findNewsById($id);
        $properties = ['noticia' => $noticia];
        return $this->render('noticia/noticia.twig', $properties);
    }

    /**
     * @Route("/new", name="noticia_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $noticium = new Noticia();
        $form = $this->createForm(NoticiaType::class, $noticium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($noticium);
            $entityManager->flush();

            return $this->redirectToRoute('noticia_index');
        }

        return $this->render('noticia/new.html.twig', [
            'noticium' => $noticium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="noticia_show", methods={"GET"})
     */
    public function show(Noticia $noticium): Response
    {
        return $this->render('noticia/show.html.twig', [
            'noticium' => $noticium,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="noticia_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Noticia $noticium): Response
    {
        $form = $this->createForm(NoticiaType::class, $noticium);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('noticia_index');
        }

        return $this->render('noticia/edit.html.twig', [
            'noticium' => $noticium,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="noticia_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Noticia $noticium): Response
    {
        if ($this->isCsrfTokenValid('delete'.$noticium->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($noticium);
            $entityManager->flush();
        }

        return $this->redirectToRoute('noticia_index');
    }
}
