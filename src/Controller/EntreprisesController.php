<?php

namespace App\Controller;

use App\Entity\Compagny;
use App\Form\CompagnyType;
use App\Repository\CompagnyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/entreprises")
 */
class EntreprisesController extends AbstractController
{
    /**
     * @Route("/", name="entreprises_index", methods={"GET"})
     */
    public function index(CompagnyRepository $compagnyRepository): Response
    {
        return $this->render('entreprises/index.html.twig', [
            'compagnies' => $compagnyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="entreprises_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $compagny = new Compagny();
        $form = $this->createForm(CompagnyType::class, $compagny);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($compagny);
            $entityManager->flush();

            return $this->redirectToRoute('entreprises_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entreprises/new.html.twig', [
            'compagny' => $compagny,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="entreprises_show", methods={"GET"})
     */
    public function show(Compagny $compagny): Response
    {
        return $this->render('entreprises/show.html.twig', [
            'compagny' => $compagny,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="entreprises_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Compagny $compagny, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CompagnyType::class, $compagny);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('entreprises_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entreprises/edit.html.twig', [
            'compagny' => $compagny,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="entreprises_delete", methods={"POST"})
     */
    public function delete(Request $request, Compagny $compagny, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$compagny->getId(), $request->request->get('_token'))) {
            $entityManager->remove($compagny);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entreprises_index', [], Response::HTTP_SEE_OTHER);
    }
}
