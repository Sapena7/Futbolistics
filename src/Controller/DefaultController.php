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
        $noticias = $this->getDoctrine()
            ->getRepository(Noticia::class);

        $ultimosPartidos = $partidos->orderByFecha();

        $properties = ['ultimosPartidos' => $ultimosPartidos];

        return $this->render('default/index.html.twig', $properties);
    }
}
