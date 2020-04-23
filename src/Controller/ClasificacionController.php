<?php

namespace App\Controller;

use App\Entity\Clasificacion;
use App\Entity\Equipo;
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
        $clasificacion = $this->getDoctrine()
            ->getRepository(Clasificacion::class)
            ->findAll();

        $equipos = $this->getDoctrine()
            ->getRepository(Equipo::class)
            ->findAll();

        $properties = ["clasificacion" => $clasificacion, "equipos" => $equipos];

        return $this->render('pagina/ranking.html.twig', $properties);
    }
}
