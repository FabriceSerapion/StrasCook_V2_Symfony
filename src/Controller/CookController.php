<?php

namespace App\Controller;

use App\Entity\Cook;
use App\Form\CookType;
use App\Repository\CookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cook')]
class CookController extends AbstractController
{
    #[Route('/', name: 'app_cook_index', methods: ['GET'])]
    public function index(CookRepository $cookRepository): Response
    {
        return $this->render('cook/index.html.twig', [
            'cooks' => $cookRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_cook_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CookRepository $cookRepository): Response
    {
        $cook = new Cook();
        $form = $this->createForm(CookType::class, $cook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cookRepository->save($cook, true);

            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cook/new.html.twig', [
            'cook' => $cook,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cook_show', methods: ['GET'])]
    public function show(Cook $cook): Response
    {
        return $this->render('cook/show.html.twig', [
            'cook' => $cook,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cook_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cook $cook, CookRepository $cookRepository): Response
    {
        $form = $this->createForm(CookType::class, $cook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cookRepository->save($cook, true);

            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cook/edit.html.twig', [
            'cook' => $cook,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cook_delete', methods: ['POST'])]
    public function delete(Request $request, Cook $cook, CookRepository $cookRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cook->getId(), $request->request->get('_token'))) {
            $cookRepository->remove($cook, true);
        }

        return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}
