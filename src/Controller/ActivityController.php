<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Entity\Booking;
use App\Form\ActivityType;
use App\Form\BookingType;
use App\Repository\ActivityRepository;
use App\Repository\AnimalRepository;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActivityController extends AbstractController
{
    #[Route('/activity', name: 'app_activity')]
    public function index(ActivityRepository $activityRepository, AnimalRepository $animalRepository, Request $request): Response
    {
        $val = $request->query->get('search');
        $activities = $activityRepository->search($val);
        $animals = $animalRepository->findAll();

        $images = [];
        foreach ($activities as $key => $activity) {
            $images[$key] = base64_encode($activity['image_act']);
        }

        return $this->render('activity/index.html.twig', ['activities' => $activities, 'animals' => $animals, 'animalFiltre' => $val, 'images' => $images]);
    }

    #[Route('/activity/create', name: 'app_activity_create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $activity = new Activity();
        $form = $this->createForm(ActivityType::class, $activity);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $activity = $form->getData();
            $entityManager->persist($activity);
            $entityManager->flush();

            return $this->redirectToRoute('app_activity_show', ['id' => $activity->getId()]);
        }

        return $this->render('activity/create.html.twig', ['form' => $form]);
    }

    #[Route('/activity/{id}', name: 'app_activity_show')]
    public function show(Activity $activity, ActivityRepository $activityRepository, BookingRepository $bookingRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $users = $bookingRepository->getInscrit($activity);
        $idUsers = $bookingRepository->getIdInscrit($activity);
        $animals = $activityRepository->findByActivityId($activity);
        dump($animals);

        $booking = new Booking();
        $formBooking = $this->createForm(BookingType::class, $booking);
        $formUnbooking = $this->createFormBuilder($bookingRepository->findOneBy(['activity' => $activity->getId(), 'user' => $this->getUser()]))
            ->add('unbooking', SubmitType::class)
            ->getForm();

        $formUnbooking->handleRequest($request);
        if ($formUnbooking->isSubmitted() && $formUnbooking->isValid()) {
            $booking = $formUnbooking->getData();
            $entityManager->remove($booking);
            $entityManager->flush();
            $activityRepository->incrementsPlaces($activity);

            return $this->render('activity/refuse.html.twig', ['activity' => $activity, 'users' => $users]);
        }
        $formBooking->handleRequest($request);
        if ($formBooking->isSubmitted() && $formBooking->isValid()) {
            $booking->setUser($this->getUser());
            $booking->setActivity($activity);
            $entityManager->persist($booking);
            $entityManager->flush();
            $activityRepository->decrementsPlaces($activity);

            return $this->render('activity/confirm.html.twig', ['activity' => $activity, 'users' => $users]);
        }

        return $this->render('activity/show.html.twig', ['activity' => $activity, 'animals' => $animals, 'users' => $users, 'formBooking' => $formBooking, 'formUnbooking' => $formUnbooking, 'idUsers' => $idUsers]);
    }

    #[Route('/activity/{id}/update')]
    public function update(Activity $activity, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ActivityType::class, $activity);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $activity = $form->getData();
            $entityManager->flush();

            return $this->redirectToRoute('app_activity_show', ['id' => $activity->getId()]);
        }

        return $this->render('activity/update.html.twig', ['activity' => $activity, 'form' => $form]);
    }

    #[Route('/activity/{id}/delete')]
    public function delete(Activity $activity, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createFormBuilder($activity)
            ->add('delete', SubmitType::class)
            ->add('cancel', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('delete')->isClicked()) {
                $activity = $form->getData();
                $entityManager->remove($activity);
                $entityManager->flush();

                return $this->redirectToRoute('app_activity');
            } elseif ($form->get('cancel')->isClicked()) {
                return $this->redirectToRoute('app_activity_show', ['id' => $activity->getId()]);
            }
        }

        return $this->render('activity/delete.html.twig', ['activity' => $activity, 'formDelete' => $form]);
    }
}
