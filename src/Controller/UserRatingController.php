<?php

namespace App\Controller;

use App\Entity\UserRating;
use App\Form\UserRatingType;
use App\Repository\UserRatingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/rating')]
class UserRatingController extends AbstractController
{
    #[Route('/', name: 'app_user_rating_index', methods: ['GET'])]
    public function index(UserRatingRepository $userRatingRepository): Response
    {
        return $this->render('user_rating/index.html.twig', [
            'user_ratings' => $userRatingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_rating_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRatingRepository $userRatingRepository): Response
    {
        $userRating = new UserRating();
        $form = $this->createForm(UserRatingType::class, $userRating);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRatingRepository->save($userRating, true);

            return $this->redirectToRoute('app_user_rating_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_rating/new.html.twig', [
            'user_rating' => $userRating,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_rating_show', methods: ['GET'])]
    public function show(UserRating $userRating): Response
    {
        return $this->render('user_rating/show.html.twig', [
            'user_rating' => $userRating,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_rating_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UserRating $userRating, UserRatingRepository $userRatingRepository): Response
    {
        $form = $this->createForm(UserRatingType::class, $userRating);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRatingRepository->save($userRating, true);

            return $this->redirectToRoute('app_user_rating_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_rating/edit.html.twig', [
            'user_rating' => $userRating,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_rating_delete', methods: ['POST'])]
    public function delete(Request $request, UserRating $userRating, UserRatingRepository $userRatingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userRating->getId(), $request->request->get('_token'))) {
            $userRatingRepository->remove($userRating, true);
        }

        return $this->redirectToRoute('app_user_rating_index', [], Response::HTTP_SEE_OTHER);
    }
}
