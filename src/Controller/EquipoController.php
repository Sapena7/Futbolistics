<?php

namespace App\Controller;

use App\Entity\Equipo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/equipos")
 */
class EquipoController extends AbstractController
{
    /**
     * @Route("/", name="equipos_index", methods={"GET"})
     */
    public function index(): Response
    {
        $equipos = $this->getDoctrine()
            ->getRepository(Equipo::class)
            ->findAll();

        return $this->render('pagina/teams.html.twig', [
            'equipos' => $equipos,
        ]);
    }

    /**
     * @Route("/{id}", name="equipos_byId", methods={"GET"})
     */
    public function findEquipoById($id)
    {
        $equipos = $this->getDoctrine()
            ->getRepository(Equipo::class);
        $equipo = $equipos->findTeamById($id);
        $properties = ['equipo' => $equipo];
        return $this->render('pagina/club-stats.html.twig', $properties);
    }
}
