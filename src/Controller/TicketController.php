<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Ticket;
use App\Form\MessageType;
use App\Form\TicketType;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    #[Route('/ticket', name: 'app_ticket_index')]
    public function index(TicketRepository $ticketRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ticket = $form->getData();
            $ticket->setUserConcerned($this->getUser());
            $entityManager->persist($ticket);
            $entityManager->flush();

            return $this->redirectToRoute('app_ticket_show', ['id' => $ticket->getId()]);
        }
        $isAdmin = $this->isGranted('ROLE_ADMIN');
        $nbTickets = $isAdmin ? $ticketRepository->countTicketsByAdmin($this->getUser()) : $ticketRepository->countTicketsByUser($this->getUser());
        $tickets = $isAdmin ? $ticketRepository->findTicketsByAdminId($this->getUser()) : $ticketRepository->findTicketsByUserId($this->getUser());

        return $this->render('ticket/index.html.twig', [
            'nbTickets' => $nbTickets,
            'tickets' => $tickets,
            'form' => $form,
        ]);
    }

    #[Route('/ticket/{id<\d+>}', name: 'app_ticket_show')]
    public function show(Ticket $ticket, TicketRepository $ticketRepository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $attributionForm = $this->createFormBuilder()
            ->add('accept', SubmitType::class)
            ->getForm();
        $attributionForm->handleRequest($request);
        if ($attributionForm->isSubmitted()) {
            $ticket->setAdminConcerned($this->getUser());
            $entityManager->flush();
        }
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getErrors(true, false));

            $message = $form->getData();
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('app_ticket_show', ['id' => $ticket->getId()]);
        }

        return $this->render('ticket/show.html.twig', ['attributionForm' => $attributionForm, 'form' => $form, 'ticket' => $ticket, 'messages' => $ticket->getMessages()]);
    }
}
