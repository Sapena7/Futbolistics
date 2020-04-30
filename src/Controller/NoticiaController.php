<?php

namespace App\Controller;

use App\Entity\Noticia;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/noticias")
 */
class NoticiaController extends AbstractController
{
    /**
     * @Route("/", name="noticias_index", methods={"GET"})
     */
    public function index(): Response
    {
        $noticias = $this->getDoctrine()
            ->getRepository(Noticia::class)
            ->findAll();

        return $this->render('pagina/news.html.twig', [
            'noticias' => $noticias,
        ]);
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
        return $this->render('pagina/news-single.html.twig', $properties);
    }
}
