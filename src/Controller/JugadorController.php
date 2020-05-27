<?php

namespace App\Controller;

use App\Entity\Jugador;
use App\Entity\Equipo;
use App\Form\JugadorType;
use App\Repository\JugadorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use Mpdf\Mpdf;

/**
 * @Route("/jugador")
 */
class JugadorController extends AbstractController
{
    /**
     * @Route("/", name="jugador_index", methods={"GET"})
     */
    public function index(): Response
    {
        $jugadores = $this->getDoctrine()
            ->getRepository(Jugador::class)
            ->findAll();

        return $this->render('jugador/index.html.twig', [
            'jugadores' => $jugadores,
        ]);
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
        return $this->render('jugador/index.html.twig', $properties);
    }

    /**
     * @Route("/equipo/{equipo}/jugador/{id}", name="jugador_byIdAndTeam", methods={"GET"})
     */
    public function findPlayerByTeamId($equipo, $id)
    {
        $jug = $this->getDoctrine()
            ->getRepository(Jugador::class);
        $jugador = $jug->findById($id);
        $equipos = $this->getDoctrine()
            ->getRepository(Equipo::class);
        $equipo = $equipos->findTeamById($equipo);
        $properties = ['jugador' => $jugador, 'equipo' => $equipo];
        return $this->render('jugador/player.html.twig', $properties);
    }

    /**
     * @Route("/new", name="jugador_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $jugador = new Jugador();
        $form = $this->createForm(JugadorType::class, $jugador);
        $form->handleRequest($request);
        $equipos = $this->getDoctrine()
            ->getRepository(Equipo::class);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($jugador);
            $entityManager->flush();
            $equipo = $jugador->getEquipo();

            return $this->redirectToRoute('equipos_byId', array('id' => $equipo->getId()));
        }

        return $this->render('jugador/new.html.twig', [
            'jugador' => $jugador,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="jugador_show", methods={"GET"})
     */
    public function show(Jugador $jugador): Response
    {
        return $this->render('jugador/show.html.twig', [
            'jugador' => $jugador,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="jugador_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Jugador $jugador): Response
    {
        $equipoRespos = $this->getDoctrine()
            ->getRepository(Equipo::class);
        $jug = $this->getDoctrine()
            ->getRepository(Jugador::class);
        $jugador2 = $jug->findById($jugador->getId());
        $equipo = $jugador2->getEquipo();
        $form = $this->createForm(JugadorType::class, $jugador);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('equipos_byId', array('id' => $equipo->getId()));
        }

        return $this->render('jugador/edit.html.twig', [
            'jugador' => $jugador,
            'equipo' => $equipo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="jugador_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Jugador $jugador): Response
    {
        $jug = $this->getDoctrine()
            ->getRepository(Jugador::class);
        $jugador2 = $jug->findById($jugador->getId());
        $equipo = $jugador2->getEquipo();
        if ($this->isCsrfTokenValid('delete'.$jugador->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($jugador);
            $entityManager->flush();
        }

        return $this->redirectToRoute('equipos_byId', array('id' => $equipo->getId()));
    }

    /**
     * @Route("/{id}/jugadores/pdf", name="players_pdf", methods={"GET"})
     */
    public function generatePDF($id):Response{
        $jugadoresRepos = $this->getDoctrine()
            ->getRepository(Jugador::class);
        $equiposRepos = $this->getDoctrine()
            ->getRepository(Equipo::class);

        $jugadores = $jugadoresRepos->findByEquipo($id);
        $equipo = $equiposRepos->findTeamById($id);

        $properties = ['jugadores' => $jugadores, 'equipo' => $equipo];


        $mpdf = new mPDF();

        // Write some HTML code:

        $html = $this->renderView('jugador/playerPdf.html.twig', $properties);
        $mpdf->WriteHTML($html);

        // Output a PDF file directly to the browser
        $mpdf->Output();
    }
}
