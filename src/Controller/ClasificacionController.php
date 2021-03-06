<?php

namespace App\Controller;

use App\Entity\Clasificacion;
use App\Entity\Partido;
use App\Form\ClasificacionType;
use App\Repository\ClasificacionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Mpdf\Mpdf;

/**
 * @Route("/clasificacion")
 */
class ClasificacionController extends AbstractController
{
    /**
     * @Route("/", name="clasificacion_index", methods={"GET"})
     */
    public function index(): Response
    {
        $clasificacionRepos = $this->getDoctrine()
            ->getRepository(Clasificacion::class);

        $partidoRepos = $this->getDoctrine()
            ->getRepository(Partido::class);

        $clasificacion = $clasificacionRepos->findAllOrderedByPuntos();

        $properties = ["clasificacion" => $clasificacion];

        return $this->render('clasificacion/index.html.twig', $properties);
    }

    /**
     * @Route("/new", name="clasificacion_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $clasificacion = new Clasificacion();
        $form = $this->createForm(ClasificacionType::class, $clasificacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($clasificacion);
            $entityManager->flush();

            $this->addFlash(
                'info',
                'Creado correctamente'
            );

            return $this->redirectToRoute('clasificacion_index');
        }

        return $this->render('clasificacion/new.html.twig', [
            'clasificacion' => $clasificacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="clasificacion_show", methods={"GET"})
     */
    public function show(Clasificacion $clasificacion): Response
    {
        return $this->render('clasificacion/show.html.twig', [
            'clasificacion' => $clasificacion,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="clasificacion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Clasificacion $clasificacion): Response
    {
        $form = $this->createForm(ClasificacionType::class, $clasificacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'info',
                'Editado correctamente'
            );

            return $this->redirectToRoute('clasificacion_index');
        }

        return $this->render('clasificacion/edit.html.twig', [
            'clasificacion' => $clasificacion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="clasificacion_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Clasificacion $clasificacion): Response
    {
        if ($this->isCsrfTokenValid('delete'.$clasificacion->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($clasificacion);
            $entityManager->flush();

            $this->addFlash(
                'info',
                'Borrado correctamente'
            );
        }

        return $this->redirectToRoute('clasificacion_index');
    }

    /**
     * @Route("/clasificacion/pdf", name="clasificacion_pdf", methods={"GET"})
     */
    public function generatePDF():Response{
        $clasificacion = $this->getDoctrine()
            ->getRepository(Clasificacion::class)
            ->findAll();

        $properties = ['clasificacion' => $clasificacion];


        $mpdf = new mPDF();

        // Write some HTML code:

        $html = $this->renderView('clasificacion/clasificacionPdf.html.twig', $properties);
        $mpdf->WriteHTML($html);

        // Output a PDF file directly to the browser
        $mpdf->Output('Clasificacion primera regional grupo 6'. '.pdf', 'I');
    }
}
