<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Form\MenuType;
use App\Repository\MenuRepository;
use App\Repository\TagRepository;
use App\Repository\UserRatingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;

#[Route('/menu')]
class MenuController extends AbstractController
{
    #[Route('/', name: 'app_menu_index', methods: ['GET'])]
    public function index(RequestStack $requestStack, MenuRepository $menuRepository, TagRepository $tagRepository, UserRatingRepository $userRatingRepository): Response
    {
        $menus = $menuRepository->findAll();
        foreach ($menus as $idx => $menu) {
            $tags = $tagRepository->findTagsFromMenu($menu->getId());
            $ratings = $userRatingRepository->findAllRatingsByMenu($menu->getId());
            foreach ($tags as $tag) {
                $menus[$idx]->addTag($tag);
            }
            $menus[$idx]->setTotalRatings($ratings[0]["totalRatings"]);
        }

        $data = ['menus' => $menus];
        $data['tag'] = '';

        // GETTING SESSION 
        $session = $requestStack->getSession();

        if ($session->has('time')) {         
            $data['session'] = $session->get('time');
        } else {
            $data['session'] = '';
        }

        return $this->render('menu/index.html.twig', $data);
    }

    /**
     * Show informations --> menus with their tags linked, search by tag
     */
    #[Route('/showtag', name: 'app_menu_show', methods: ['POST'])]
    public function showMenus(MenuRepository $menuRepository, TagRepository $tagRepository, UserRatingRepository $userRatingRepository): Response
    {
        //Validation --> tag must be string
        $tagValidated = trim(htmlspecialchars($_POST['tag']));
        $menus = $menuRepository->findAllFromTag($tagValidated);

        foreach ($menus as $idx => $menu) {
            $tags = $tagRepository->findTagsFromMenu($menu->getId());
            $ratings = $userRatingRepository->findAllRatingsByMenu($menu->getId());
            foreach ($tags as $tag) {
                $menus[$idx]->addTag($tag);
            }
            $menus[$idx]->setTotalRatings($ratings[0]["totalRatings"]);
        }

        $data = ['menus' => $menus];
        $data['tag'] = $_POST['tag'];

        return $this->render('menu/index.html.twig', $data);
    }

    #[Route('/new', name: 'app_menu_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MenuRepository $menuRepository, TagRepository $tagRepository): Response
    {
        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $menuTAGS = $_POST["menu"];
            // var_dump($menu);die();
            $newTags = explode(' ', $menuTAGS['tagsArea']);

            foreach ($newTags as $newTag) {
                $tagExist = $tagRepository->findOneByName($newTag);
                $menu->addTag($tagExist);
            }

            $menuRepository->save($menu, true);

            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('menu/new.html.twig', [
            'menu' => $menu,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}', name: 'app_menu_show', methods: ['GET'])]
    // public function show(Menu $menu): Response
    // {
    //     return $this->render('menu/show.html.twig', [
    //         'menu' => $menu,
    //     ]);
    // }

    #[Route('/{id}/edit', name: 'app_menu_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Menu $menu, MenuRepository $menuRepository, TagRepository $tagRepository): Response
    {
        $tagsArea = '';
        foreach ($menu->getTags() as $tag) {
            $tagsArea = $tagsArea . ' ' . $tag->getName();
        }
        $menu->setTagsArea($tagsArea);

        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($menu->getTagsArea()) {
                $newTags = explode(' ', $menu->getTagsArea());
        
                if ($tagsArea != $menu->getTagsArea()) {
                    
                    $oldTags = explode(' ', $tagsArea);
                    //Adding tags if new tags are found
                    foreach ($newTags as $newTag) {
                        
                        if (!in_array($newTag, $oldTags)) {
                            
                            $tagExist = $tagRepository->findOneByName($newTag);
                            if ($tagExist) {                           
                                $menu->addTag($tagExist);
                            }
                        }
                    }
                    //Deleting tags if there are not found
                    foreach ($oldTags as $oldTag) {
                        if (!in_array($oldTag, $newTags)) {
                            $tagExist = $tagRepository->findOneByName($oldTag);
                            if ($tagExist) {
                                $menu->removeTag($tagExist);
                            }
                        }
                    }
                }   
            }

            $menuRepository->save($menu, true);

            return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('menu/edit.html.twig', [
            'menu' => $menu,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_menu_delete', methods: ['POST'])]
    public function delete(Request $request, Menu $menu, MenuRepository $menuRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $menu->getId(), $request->request->get('_token'))) {
            $menuRepository->remove($menu, true);
        }

        return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}
