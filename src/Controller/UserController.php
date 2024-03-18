<?php

namespace App\Controller;

use App\Form\UserDeletionType;
use App\Form\UserInformationsFormType;
use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/myAccount', name: 'app_user_account')]
    public function index(Security $security, ActivityRepository $activityRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $activities = $activityRepository->findForUser($this->getUser());
        dump($activities);

        return $this->render('user/index.html.twig', ['activities' => $activities]);
    }

    #[Route('/myAccount/update', name: 'app_user_update')]
    public function update(Security $security, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $security->getUser();
        $form = $this->createForm(UserInformationsFormType::class, $user);
        $form2 = $this->createForm(UserInformationsFormType::class, $user);
        $form->handleRequest($request);
        $form2->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager->flush();

            return $this->redirectToRoute('app_user_account');
        }
        if ($form2->isSubmitted() && $form2->isValid()) {
            $user = $form2->getData();
            $entityManager->flush();

            return $this->redirectToRoute('app_user_account');
        }

        return $this->render('user/update.html.twig', ['user' => $user, 'form' => $form, 'form2' => $form2]);
    }

    #[Route('/myAccount/delete', name: 'app_user_delete')]
    public function delete(Security $security, Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $form = $this->createForm(UserDeletionType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->get('delete')->isClicked()) {
                $entityManager->remove($security->getUser());
                $entityManager->flush();
                $request->getSession()->invalidate();
                $this->container->get('security.token_storage')->setToken(null);

                return $this->redirectToRoute('app_home');
            } else {
                return $this->redirectToRoute('app_user_account');
            }
        }

        return $this->render('user/delete.html.twig', ['form' => $form]);
    }
}
