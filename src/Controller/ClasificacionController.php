<?php

namespace App\Controller;

use App\Entity\Clasificacion;
use App\Entity\Partido;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/clasificacion")
 */
class ClasificacionController extends AbstractController
{
    /**
     * @Route("/", name="rankingLeague", methods={"GET"})
     */
    public function index(): Response
    {
        $clasificacionRepos = $this->getDoctrine()
            ->getRepository(Clasificacion::class);

        $partidoRepos = $this->getDoctrine()
            ->getRepository(Partido::class);

        $clasificacion = $clasificacionRepos->findAllOrderedByPuntos();

        $properties = ["clasificacion" => $clasificacion];

        return $this->render('pagina/ranking.html.twig', $properties);
    }
}
