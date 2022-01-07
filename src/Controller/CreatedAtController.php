<?php

namespace App\Controller;

use App\Entity\CRequest;
use App\Form\CRequest1Type;
use App\Repository\CRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/created/at")
 */
class CreatedAtController extends AbstractController
{
    /**
     * @Route("/", name="created_at_index", methods={"GET"})
     */
    public function index(CRequestRepository $cRequestRepository): Response
    {
        return $this->render('created_at/index.html.twig', [
            'c_requests' => $cRequestRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="created_at_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cRequest = new CRequest();
        $form = $this->createForm(CRequest1Type::class, $cRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cRequest);
            $entityManager->flush();

            return $this->redirectToRoute('created_at_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('created_at/new.html.twig', [
            'c_request' => $cRequest,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="created_at_show", methods={"GET"})
     */
    public function show(CRequest $cRequest): Response
    {
        return $this->render('created_at/show.html.twig', [
            'c_request' => $cRequest,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="created_at_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, CRequest $cRequest, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CRequest1Type::class, $cRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('created_at_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('created_at/edit.html.twig', [
            'c_request' => $cRequest,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="created_at_delete", methods={"POST"})
     */
    public function delete(Request $request, CRequest $cRequest, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cRequest->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cRequest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('created_at_index', [], Response::HTTP_SEE_OTHER);
    }
}
