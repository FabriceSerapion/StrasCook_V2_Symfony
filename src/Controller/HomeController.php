<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use App\Repository\TagRepository;
use App\Repository\UserRatingRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(RequestStack $requestStack,UserRepository $userRepository, MenuRepository $menuRepository, TagRepository $tagRepository, UserRatingRepository $userRatingRepository, AuthenticationUtils $authenticationUtils): Response
    {
        // GETTING SESSION
        $session = $requestStack->getSession();
        
        // GET USER FROM LOGIN
        $user = $userRepository->findByUsername($authenticationUtils->getLastUsername());

         // FILL SESSION WITH USER INFORMATIONS
         if ($user) {
            $session->set('idUser', $user[0]->getId());
            $session->set('username', $user[0]->getUsername());
        }

        $menus = $menuRepository->findBy(array(), null, 3, 0);
        foreach ($menus as $idx => $menu) {
            $tags = $tagRepository->findTagsFromMenu($menu->getId());
            $ratings = $userRatingRepository->findAllRatingsByMenu($menu->getId());
            foreach ($tags as $tag) {
                $menus[$idx]->addTag($tag);
            }
            $menus[$idx]->setTotalRatings($ratings[0]["totalRatings"]);
        }

        if (!$session->has('adress')) {
            $adress = '';
        } else {
            $adress = $session->get('adress');
        }
        if (!$session->has('date')) {
            $date = '';
        } else {
            $date = $session->get('date');
        }
        if (!$session->has('time')) {
            $time = '';
        } else {
            $time = $session->get('time');
        }

        //PUSH DATAS IN TWIG
        $data = ['menus' => $menus];
        $data['adress'] = $adress;
        $data['date'] = $date;
        $data['time'] = $time;

        return $this->render('home/index.html.twig', $data);
    }
}
