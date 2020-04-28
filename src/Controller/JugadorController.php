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
     * @Route("/{id}", name="jugador_byId", methods={"GET"})
     */
    public function findPlayerById($id)
    {
        $equipos = $this->getDoctrine()
            ->getRepository(Jugador::class);
        $equipo = $equipos->findPlayerById($id);
        $properties = ['equipo' => $equipo];
        return $this->render('pagina/players.html.twig', $properties);
    }
}
