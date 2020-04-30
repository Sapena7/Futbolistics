<?php

namespace App\Controller;

use App\Entity\Jornada;
use App\Entity\Liga;
use App\Entity\Partido;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/partidos")
 */
class PartidoController extends AbstractController
{
    /**
     * @Route("/", name="partidos", methods={"GET"})
     */
    public function index(Request $request)
    {
        if ($request->query->get('jornada') == null){
            $jornada = 1;
        }else{
            $jornada = $request->query->get('jornada');
        }

        $jornadas = $this->getDoctrine()
            ->getRepository(Jornada::class)
            ->findAll();
        $ligas = $this->getDoctrine()
            ->getRepository(Liga::class)
            ->findAll();
        $partidos = $this->getDoctrine()
            ->getRepository(Partido::class);
        $partidos = $partidos->findByJornada($jornada);
        $properties = ['partidos' => $partidos, 'jornadas' => $jornadas, 'ligas' => $ligas, 'jornada' => $jornada];

        return $this->render('pagina/matches.html.twig', $properties);
    }
}
