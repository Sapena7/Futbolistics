<?php

namespace App\Controller;

use App\Entity\Clasificacion;
use App\Entity\Equipo;
use App\Entity\Jornada;
use App\Entity\Jugador;
use App\Entity\Partido;
use App\Entity\Usuario;
use App\Form\EquipoType;
use App\Repository\EquipoRepository;
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
     * @Route("/", name="equipo_index", methods={"GET"})
     */
    public function index(): Response
    {
        $equipos = $this->getDoctrine()
            ->getRepository(Equipo::class)
            ->findAll();

        return $this->render('equipo/index.html.twig', [
            'equipos' => $equipos,
        ]);
    }

    /**
     * @Route("/new", name="equipo_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $equipo = new Equipo();
        $form = $this->createForm(EquipoType::class, $equipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipo);
            $entityManager->flush();

            return $this->redirectToRoute('equipo_index');
        }

        return $this->render('equipo/new.html.twig', [
            'equipo' => $equipo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/equipo/{id}", name="equipo_show", methods={"GET"})
     */
    public function findEquipoById($id)
    {
        $equipos = $this->getDoctrine()
            ->getRepository(Equipo::class);
        $clasificacion = $this->getDoctrine()
            ->getRepository(Clasificacion::class);
        $jornadas = $this->getDoctrine()
            ->getRepository(Jornada::class);
        $partidos = $this->getDoctrine()
            ->getRepository(Partido::class);
        $jugadores = $this->getDoctrine()
            ->getRepository(Jugador::class);


        $goleadores = $jugadores->orderByGoalsTeamId($id);
        $equipo = $equipos->findTeamById($id);
        $ganados = $clasificacion->findPartidosGanadosByEquipo($id);
        $perdidos = $clasificacion->findPartidosPerdidosByEquipo($id);
        $clasificacionLiga = $clasificacion->find(1);
        $jugadoresEquipo = $jugadores->findByEquipo($id);

        $numeroJornadas = $jornadas->countJornadas();
        $ultimoPartido = $partidos->orderByFechaByTeam($id);
        $properties = ['equipo' => $equipo, 'ganados' => $ganados, 'perdidos' => $perdidos, 'numeroJornadas' => $numeroJornadas, 'ultimoPartido' => $ultimoPartido,
            'goleadores' => $goleadores, 'clasificacion' => $clasificacionLiga, 'jugadores' => $jugadoresEquipo];
        return $this->render('equipo/team.html.twig', $properties);
    }

    /**
     * @Route("/{id}/edit", name="equipo_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Equipo $equipo): Response
    {
        $form = $this->createForm(EquipoType::class, $equipo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('equipo_index');
        }

        return $this->render('equipo/edit.html.twig', [
            'equipo' => $equipo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="equipo_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Equipo $equipo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$equipo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($equipo);
            $entityManager->flush();
        }

        return $this->redirectToRoute('equipo_index');
    }
}
