<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use App\Repository\MenuRepository;
use App\Repository\UserRatingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(
        BookingRepository $bookingRepository,
        MenuRepository $menuRepository,
        RequestStack $requestStack,
        UserRatingRepository $userRatingRepository,
    ): Response
    {
        // GETTING SESSION 
        $session = $requestStack->getSession();

        // GETTING USER ID
        $idUser = ($session->get('idUser'));
        
        // GET ALL FUTURE BOOKINGS
        $bookings = $bookingRepository->findAllBookings(idUser : $idUser);
        

        // GET ALL DISTINCT BOOKED MENUS
        $bookedMenus = $bookingRepository->findAllMenuBooked($idUser);
        $menus = [];
        foreach ($bookedMenus as $idx => $bookedMenu) {
            $noted = $userRatingRepository->findNoteFromMenuAndUser(idMenu: $bookedMenu['id'], idCustomer: $idUser);
            // GET THE OBJECT MENU BASED ON THE RESULT ABOVE
            $menu = $menuRepository->findOneBy($bookedMenu);
            if (!empty($noted)) {
                // SET THE USER RATING ON THE MENU
                $menu->setUserRating($noted[0]['rating']);
            } else {
                $menu->setUserRating(null);
            }
            array_push($menus, $menu);
        };
        
        // PUSHING DATAS IN TWIG
        $data = ['bookings' => $bookings];
        $data['ratings'] = $bookedMenus;
        $data['menus'] = $menus;

        return $this->render('user/user_space.html.twig', $data);
    }


}
