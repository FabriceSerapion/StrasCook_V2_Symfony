<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\User;
use App\Entity\UserRating;
use App\Form\UserRatingType;
use App\Repository\MenuRepository;
use App\Repository\UserRatingRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
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
    public function new(
        MenuRepository $menuRepository,
        Request $request,
        RequestStack $requestStack,
        UserRepository $userRepository,
        UserRatingRepository $userRatingRepository): Response
    {
        // GETTING SESSION 
        $session = $requestStack->getSession();

        // GETTING THIS USER FROM ID
        $user = $userRepository->findById($session->get('idUser'));

        $userRating = new UserRating();
        $form = $this->createForm(UserRatingType::class, $userRating);
        $form->handleRequest($request);

        $userRating->setCustomer($user[0]);

        $menu = $menuRepository->findById($_GET['menu_id']);

        $userRating->setMenu($menu[0]);

        if ($form->isSubmitted() && $form->isValid()) {
            $userRatingRepository->save($userRating, true);

            $this->modifyNoteGlobal($userRating->getRating(), 0, $userRatingRepository, $menuRepository, $menu[0]);

            return $this->redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_rating/new.html.twig', [
            'user_rating' => $userRating,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}', name: 'app_user_rating_show', methods: ['GET'])]
    // public function show(UserRating $userRating): Response
    // {
    //     return $this->render('user_rating/show.html.twig', [
    //         'user_rating' => $userRating,
    //     ]);
    // }

    #[Route('/{id}/edit', name: 'app_user_rating_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request,
    MenuRepository $menuRepository,
    UserRating $userRating,
    UserRatingRepository $userRatingRepository): Response
    {
        $form = $this->createForm(UserRatingType::class, $userRating);
        $form->handleRequest($request);

        $ratingSaved = $userRating->getRating();

        $menu = $menuRepository->findById($userRating->getMenu()->getId());

        if ($form->isSubmitted() && $form->isValid()) {
            $userRatingRepository->save($userRating, true);

            $this->modifyNoteGlobal($userRating->getRating(), $ratingSaved, $userRatingRepository, $menuRepository, $menu[0]);

            return $this->redirectToRoute('app_user', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user_rating/edit.html.twig', [
            'user_rating' => $userRating,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_rating_delete', methods: ['POST'])]
    public function delete(Request $request,
    UserRating $userRating,
    UserRatingRepository $userRatingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$userRating->getId(), $request->request->get('_token'))) {
            $userRatingRepository->remove($userRating, true);
        }

        return $this->redirectToRoute('app_user_rating_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * Modifying note when user modify his note for a menu
     */
    public function modifyNoteGlobal(string $userRating, int $oldRating, UserRatingRepository $userRatingRepository, MenuRepository $menuRepository, Menu $menu): void
    {
        $noteMenu = $userRatingRepository->findAllRatingsByMenu($menu->getId());

        $number = $noteMenu[0]['totalRatings'];

        if ($oldRating == 0) {
            $finalRating = $noteMenu[0]['ratings'] / $number;
        } else {
            $finalRating = ($noteMenu[0]['ratings'] - $oldRating + floatval($userRating)) / $number;
        }

        $menu->setRating($finalRating);

        $menuRepository->save($menu, true);
    }
}
