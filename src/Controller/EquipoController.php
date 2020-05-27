<?php

namespace App\Controller;

use App\Entity\Clasificacion;
use App\Entity\Equipo;
use App\Entity\Jornada;
use App\Entity\Jugador;
use App\Entity\Liga;
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

        $liga = $this->getDoctrine()
            ->getRepository(Liga::class);

        $ligaEquipo = $liga->find(1);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($equipo);
            $entityManager->flush();

            $clasificacion = new Clasificacion();
            $clasificacion->setLiga($ligaEquipo);
            $clasificacion->setEquipo($equipo);
            $clasificacion->setJugados(0);
            $clasificacion->setPuntos(0);
            $clasificacion->setGanados(0);
            $clasificacion->setEmpatados(0);
            $clasificacion->setPerdidos(0);
            $clasificacion->setGolesFavor(0);
            $clasificacion->setGolesContra(0);
            $clasificacion->setGolesDiferencia(0);
            $entityManager->persist($clasificacion);
            $entityManager->flush();

            $this->addFlash(
                'info',
                'Creado correctamente'
            );

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

            $this->addFlash(
                'info',
                'Editado correctamente'
            );

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
        $clasificacionRepos = $this->getDoctrine()
            ->getRepository(Clasificacion::class);

        $clasificacion = $clasificacionRepos->findByTeamId($equipo->getId());

        if ($this->isCsrfTokenValid('delete'.$equipo->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->remove($clasificacion);
            $entityManager->flush();

            $entityManager->remove($equipo);
            $entityManager->flush();


            $this->addFlash(
                'info',
                'Borrado correctamente'
            );
        }

        return $this->redirectToRoute('equipo_index');
    }
}
