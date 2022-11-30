<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use App\Repository\TagRepository;
use App\Repository\UserRatingRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MenuRepository $menuRepository, TagRepository $tagRepository, UserRatingRepository $userRatingRepository): Response
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
        return $this->render('home/index.html.twig', [
            'menus' => $menus,
        ]);
    }
}
