<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use App\Repository\TagRepository;
use App\Repository\UserRatingRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(RequestStack $requestStack, MenuRepository $menuRepository, TagRepository $tagRepository, UserRatingRepository $userRatingRepository): Response
    {
        $menus = $menuRepository->findBy(array(), null, 3, 0);
        foreach ($menus as $idx => $menu) {
            $tags = $tagRepository->findTagsFromMenu($menu->getId());
            $ratings = $userRatingRepository->findAllRatingsByMenu($menu->getId());
            foreach ($tags as $tag) {
                $menus[$idx]->addTag($tag);
            }
            $menus[$idx]->setTotalRatings($ratings[0]["totalRatings"]);
        }

        // CREATE SESSION 
        $session = $requestStack->getSession();

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
