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
}
