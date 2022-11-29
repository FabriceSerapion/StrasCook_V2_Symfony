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
    // public function index(): Response
    // {
    //     return $this->render('home/index.html.twig', [
    //         'controller_name' => 'HomeController',
    //     ]);
    // }
    // * ? Rewrite of the function for home index to include Menu. Is this the good method ?
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
