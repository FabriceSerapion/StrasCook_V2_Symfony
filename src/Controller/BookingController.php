<?php

namespace App\Controller;

use DateTime;
use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use App\Repository\CookRepository;
use App\Repository\MenuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\RequestStack;

#[Route('/booking')]
class BookingController extends AbstractController
{

    public int $pricePrestation = 10;

    #[Route('/', name: 'app_booking_index', methods: ['GET'])]
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('booking/index.html.twig', [
            'bookings' => $bookingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_booking_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BookingRepository $bookingRepository): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookingRepository->save($booking, true);

            return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    #[Route('/newPT1', name: 'app_booking_newPT1', methods: ['POST'])]
    public function newPT1(RequestStack $requestStack): Response
    {
        // MODIFYING INFORMATIONS
        $datenew = DateTime::createFromFormat("Y-m-d", $_POST['date']);
        $intTime = intval($_POST['time']);

        // CREATE SESSION 
        $session = $requestStack->getSession();

        // FILL SESSION WITH 3 INFORMATIONS : ADRESS + DATE + HOUR
        if (!$session->has('adress')) {
            $session->set('adress', $_POST['adress']);
        }
        if (!$session->has('date')) {
            $session->set('date', $datenew);
        }
        if (!$session->has('time')) {
            $session->set('time', $intTime);
        }

        return $this->redirectToRoute('app_menu_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/newPT2', name: 'app_booking_newPT2', methods: ['POST'])]
    public function newPT2(RequestStack $requestStack, MenuRepository $menuRepository): Response
    {
        // GETTING SESSION 
        $session = $requestStack->getSession();

        // FILL BOOKING WITH SESSION INFORMATIONS
        $booking = new Booking();
        $booking->setAdress($session->get('adress'));
        $booking->setDate($session->get('date'));
        $booking->setTime($session->get('time'));
        
        // FILL BOOKING WITH MENU CHOOSED
        $menu = $menuRepository->findOneById($_POST['id']);
        $booking->setMenu($menu);

        // FILL SESSION WITH 1 INFORMATIONS : IDMENU
        if (!$session->has('idMenu')) {
            $session->set('idMenu', $_POST['id']);
        }

        //PUSH DATAS IN TWIG
        $data = ['booking' => $booking];
        $data['pricePrestation'] = $this->pricePrestation;

        return $this->renderForm('booking/summary.html.twig', $data);
    }

    #[Route('/newPT3', name: 'app_booking_newPT3', methods: ['POST'])]
    public function newPT3(RequestStack $requestStack, Request $request, MenuRepository $menuRepository, CookRepository $cookRepository, BookingRepository $bookingRepository): Response
    {
        // GETTING SESSION 
        $session = $requestStack->getSession();

        // CREATE AND FILL BOOKING WITH SESSION INFORMATIONS
        $booking = new Booking();
        $booking->setAdress($session->get('adress'));
        $booking->setDate($session->get('date'));
        $booking->setTime($session->get('time'));

        // FILL BOOKING WITH 1 INFORMATION : QUANTITY
        $booking->setQuantity($_POST['quantity']);

        // FILL BOOKING WITH MENU CHOOSED
        $menu = $menuRepository->findOneById($session->get('idMenu'));
        $booking->setMenu($menu);

        // FILL BOOKING WITH COOK CHOOSED
        $cook = $cookRepository->findOneByHour($session->get('time'));
        $booking->setCook($cook);

        // FILL BOOKING WITH PRICE
        $booking->setPrice($this->pricePrestation + ($menu->getPrice() * $booking->getQuantity()));

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookingRepository->save($booking, true);

            return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
        }

        //PUSH DATAS IN TWIG
        $data = ['booking' => $booking];
        $data['pricePrestation'] = $this->pricePrestation;

        return $this->renderForm('booking/summary.html.twig', $data);
    }

    // #[Route('/{id}', name: 'app_booking_show', methods: ['GET'])]
    // public function show(Booking $booking): Response
    // {
    //     return $this->render('booking/show.html.twig', [
    //         'booking' => $booking,
    //     ]);
    // }

    // #[Route('/{id}/edit', name: 'app_booking_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Booking $booking, BookingRepository $bookingRepository): Response
    // {
    //     $form = $this->createForm(BookingType::class, $booking);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $bookingRepository->save($booking, true);

    //         return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->renderForm('booking/edit.html.twig', [
    //         'booking' => $booking,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}', name: 'app_booking_delete', methods: ['POST'])]
    public function delete(Request $request, MailerInterface $mailer, Booking $booking, BookingRepository $bookingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $bookingRepository->remove($booking, true);

            $email = (new Email())
                ->from('your_email@example.com')
                ->to('your_email@example.com')
                ->subject('Suppression d\'une réservation !')
                ->html('<p>Vous venez de supprimer une réservation !</p>');

            $mailer->send($email);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
