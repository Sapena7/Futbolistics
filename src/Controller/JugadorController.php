<?php

namespace App\Controller;

use App\Entity\Equipo;
use App\Entity\Jugador;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/jugadores")
 */
class JugadorController extends AbstractController
{
    /**
     * @Route("/", name="jugadores_index", methods={"GET"})
     */
    public function index(): Response
    {
        $jugadores = $this->getDoctrine()
            ->getRepository(Jugador::class)
            ->findAll();

        return $this->render('pagina/players.html.twig', [
            'jugadores' => $jugadores,
        ]);
    }

    /**
     * @Route("/{equipo}/{id}", name="jugador_byIdAndTeam", methods={"GET"})
     */
    public function findPlayerById($equipo, $id)
    {
        $jugadores = $this->getDoctrine()
            ->getRepository(Jugador::class);
        $jugador = $jugadores->findByEquipoAndId($equipo, $id);
        $properties = ['equipo' => $equipo, 'jugador' => $jugador];
        return $this->render('pagina/player.html.twig', $properties);
    }

    /**
     * @Route("/equipo/{id}", name="equipos_byId", methods={"GET"})
     */
    public function findPlayersByTeamId($id)
    {
        $jug = $this->getDoctrine()
            ->getRepository(Jugador::class);
        $jugadores = $jug->findByEquipo($id);
        $equipos = $this->getDoctrine()
            ->getRepository(Equipo::class);
        $equipo = $equipos->findTeamById($id);
        $properties = ['jugadores' => $jugadores, 'equipo' => $equipo];
        return $this->render('pagina/players.html.twig', $properties);
    }
}
