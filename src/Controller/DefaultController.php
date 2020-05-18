<?php

namespace App\Controller;

use App\Entity\Noticia;
use App\Entity\Partido;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {

        $partidos = $this->getDoctrine()
            ->getRepository(Partido::class);
        $noticiasRepos = $this->getDoctrine()
            ->getRepository(Noticia::class);

        $ultimasNoticias = $noticiasRepos->orderByFecha();

        $ultimosPartidos = $partidos->orderByFecha();

        $properties = ['ultimosPartidos' => $ultimosPartidos, 'ultimasNoticias' => $ultimasNoticias];

        return $this->render('default/index.html.twig', $properties);
    }
}
