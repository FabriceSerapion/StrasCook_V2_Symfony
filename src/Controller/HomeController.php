<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MenuRepository $menuRepository, TagRepository $tagRepository): Response

    {
        $menus = $menuRepository->findBy(array(), null, 3, 0);
        foreach ($menus as $idx => $menu) {
            $tagsFromMenu = $tagRepository->findTagsFromMenu($menu->getId());
            $menus[$idx]->addTag($tagsFromMenu);
        }
        return $this->render('home/index.html.twig', [
            'menus' => $menus,
        ]);
    }
}
