<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\BookingRepository;
use App\Repository\MenuRepository;
use App\Repository\UserRatingRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(
        BookingRepository $bookingRepository,
        RequestStack $requestStack,
        UserRatingRepository $userRatingRepository,
        User $user
    ): Response
    {
        // GETTING SESSION 
        $session = $requestStack->getSession();

        // GETTING USER ID
        $session->get($idUser);


        // GET ALL FUTURE BOOKINGS
        // TODO check how to access idUser inside the parameter
        $bookings = $bookingRepository->findAllBookings(idUser : $user->getId());

        // GET ALL DISTINCT BOOKED MENUS
        $bookedMenus = $bookingRepository->findAllMenuBooked($user->getId());
        foreach ($bookedMenus as $idx => $bookedMenu) {
            $noted = $userRatingRepository->findNoteFromMenuAndUser($bookedMenu->getId(), $user->getId());
            if (!empty($noted)) {
                $bookedMenus[$idx]->setRating($noted->getRating());
            } else {
                $bookedMenus[$idx]->setRating('');
            }
        };
        
        // PUSHING DATAS IN TWIG
        $data = ['bookings' => $bookings];
        $data['ratings'] = $bookedMenus;

        return $this->render('user/user_space.html.twig', $data);
    }


}
