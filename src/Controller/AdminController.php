<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use App\Repository\TagRepository;
use App\Repository\CookRepository;
use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin_index')]
    public function index(MenuRepository $menuRepository, TagRepository $tagRepository, CookRepository $cookRepository, BookingRepository $bookingRepository): Response
    {
        //GET ALL MENUS
        $menus = $menuRepository->findBy(array(), array('name' => 'ASC'));

        //GET ALL TAGS
        $tags = $tagRepository->findBy(array(), array('name' => 'ASC'));

        //LINK TAGS WITH MENUS
        foreach ($menus as $idx => $menu) {
            $tagsLinked = $tagRepository->findTagsFromMenu($menu->getId());
            foreach ($tagsLinked as $tag) {
                $menus[$idx]->addTag($tag);
            }
        }

        //GET ALL COOKS
        $cooks = $cookRepository->findBy(array(), array('firstname' => 'ASC'));

        //GET ALL FUTURE BOOKS
        $date = date('Y-m-d');
        $bookings = $bookingRepository->findBy(array(), array('date' => 'ASC'), 5, 0);

        //PUSH DATAS IN TWIG
        $data = ['menus' => $menus];
        $data['tags'] = $tags;
        $data['cooks'] = $cooks;
        $data['bookings'] = $bookings;

        return $this->render('user/admin.html.twig', $data);
    }
}
