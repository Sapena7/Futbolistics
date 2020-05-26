<?php

namespace App\Controller;

use App\Entity\Equipo;
use App\Entity\Partido;
use App\Entity\Jornada;
use App\Entity\Liga;
use App\Entity\Jugador;
use App\Form\PartidoType;
use App\Repository\PartidoRepository;
use Mpdf\Mpdf;
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
     * @Route("/", name="partidos_index", methods={"GET"})
     */
    public function index(Request $request): Response
    {

        if ($request->query->get('jornada') == null){
            $jornadaId = 1;
        }else{
            $jornadaId = $request->query->get('jornada');
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
        $partidos = $partidos->findByJornada($jornadaId);

        $jornada = $jornadasRepo->findById($jornadaId);

        $properties = ['partidos' => $partidos, 'jornadas' => $jornadas, 'ligas' => $ligas, 'jornada' => $jornada];

        return $this->render('partido/index.html.twig', $properties);
    }

    /**
     * @Route("/new", name="partido_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $partido = new Partido();
        $form = $this->createForm(PartidoType::class, $partido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partido);
            $entityManager->flush();

            $this->addFlash(
                'info',
                'Creado correctamente'
            );

            return $this->redirectToRoute('partidos_index');
        }

        return $this->render('partido/new.html.twig', [
            'partido' => $partido,
            'form' => $form->createView(),
        ]);
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
        return $this->render('partido/match-live.html.twig', $properties);
    }

    /**
     * @Route("/{id}/edit", name="partido_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Partido $partido): Response
    {
        $form = $this->createForm(PartidoType::class, $partido);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('partidos_index');
        }

        $this->addFlash(
            'info',
            'Editado correctamente'
        );

        return $this->render('partido/edit.html.twig', [
            'partido' => $partido,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="partido_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Partido $partido): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partido->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($partido);
            $entityManager->flush();

            $this->addFlash(
                'info',
                'Borrado correctamente'
            );
        }

        return $this->redirectToRoute('partidos_index');
    }

    /**
     * @Route("/{id}/jornada/pdf", name="jornada_pdf", methods={"GET"})
     */
    public function generatePDF($id):Response{
        $jornadasRepo = $this->getDoctrine()
            ->getRepository(Jornada::class);
        $jugadoresRepos = $this->getDoctrine()
            ->getRepository(Jugador::class);
        $equiposRepos = $this->getDoctrine()
            ->getRepository(Equipo::class);
        $partidos = $this->getDoctrine()
            ->getRepository(Partido::class);

        $jornada = $jornadasRepo->findById($id);
        $partidos = $partidos->findByJornada($id);

        $properties = ['jornada' => $jornada, 'partidos' => $partidos];


        $mpdf = new mPDF();

        // Write some HTML code:

        $html = $this->renderView('partido/partidosJornadaPdf.html.twig', $properties);
        $mpdf->WriteHTML($html);

        // Output a PDF file directly to the browser
        $mpdf->Output($jornada->getJornada() . '.pdf', 'I');
    }
}
