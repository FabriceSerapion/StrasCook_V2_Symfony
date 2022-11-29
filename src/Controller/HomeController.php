<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MenuRepository $menuRepository): Response
    {
        $menus = $menuRepository->findBy(array(), null, 3, 0);
        return $this->render('home/index.html.twig', [
            'menus' => $menus,
        ]);
    }
}
