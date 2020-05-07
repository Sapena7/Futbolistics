<?php

namespace App\Controller;

use App\Entity\Jornada;
use App\Entity\Jugador;
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
        $jornadasRepo = $this->getDoctrine()
            ->getRepository(Jornada::class);
        $ligas = $this->getDoctrine()
            ->getRepository(Liga::class)
            ->findAll();
        $partidos = $this->getDoctrine()
            ->getRepository(Partido::class);
        $partidos = $partidos->findByJornada($jornada);

        $jornadaa = $jornadasRepo->findByJornadaId(1);
        $properties = ['partidos' => $partidos, 'jornadas' => $jornadas, 'ligas' => $ligas, 'jornada' => $jornada, 'jornadaa' => $jornadaa];

        return $this->render('pagina/matches.html.twig', $properties);
    }

    /**
     * @Route("/{id}", name="partidos_byId", methods={"GET"})
     */
    public function findPartidoById($id)
    {
        $partidos = $this->getDoctrine()
            ->getRepository(Partido::class);
        $jugadoresDoctrine = $this->getDoctrine()
            ->getRepository(Jugador::class);

        $partido = $partidos->findPartidoById($id);

        $equipoLocal = $partido->getEquipoLocal();
        $equipoVisitante = $partido->getEquipoVisitante();

        $jugadoresEquipoLocal = $jugadoresDoctrine->findByEquipo($equipoLocal);
        $jugadoresEquipoVisitante = $jugadoresDoctrine->findByEquipo($equipoVisitante);


        $properties = ['partido' => $partido, 'jugadoresLocal' => $jugadoresEquipoLocal, 'jugadoresVisitante' => $jugadoresEquipoVisitante];
        return $this->render('pagina/match-live.html.twig', $properties);
    }
}
