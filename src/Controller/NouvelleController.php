<?php

namespace App\Controller;

use App\Entity\CRequest;
use App\Form\CRequest2Type;
use App\Repository\CRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/nouvelle")
 */
class NouvelleController extends AbstractController
{
    /**
     * @Route("/", name="nouvelle_index", methods={"GET"})
     */
    public function index(CRequestRepository $cRequestRepository): Response
    {
        return $this->render('nouvelle/index.html.twig', [
            'c_requests' => $cRequestRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="nouvelle_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cRequest = new CRequest();
        $form = $this->createForm(CRequest2Type::class, $cRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cRequest);
            $entityManager->flush();

            return $this->redirectToRoute('nouvelle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nouvelle/new.html.twig', [
            'c_request' => $cRequest,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="nouvelle_show", methods={"GET"})
     */
    public function show(CRequest $cRequest): Response
    {
        return $this->render('nouvelle/show.html.twig', [
            'c_request' => $cRequest,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="nouvelle_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CRequest $cRequest, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CRequest2Type::class, $cRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('nouvelle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('nouvelle/edit.html.twig', [
            'c_request' => $cRequest,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="nouvelle_delete", methods={"POST"})
     */
    public function delete(Request $request, CRequest $cRequest, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cRequest->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cRequest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('nouvelle_index', [], Response::HTTP_SEE_OTHER);
    }
}
