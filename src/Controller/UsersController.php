<?php

namespace App\Controller;

use App\Form\EditProfilType;
use App\Form\EditUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsersController extends AbstractController
{
    #[Route('/users', name: 'users')]
    public function index(EntityManagerInterface $emi, Request $request)
    {
        $id = $this->getUser()->getId();
        $username = $this->getUser()->getUsername();
        $TotalTicket = $emi->getRepository('App:Ticket')->findTotalTicketUser($username);
        $TotalTicketEnCours = $emi->getRepository('App:Ticket')->findTotalTicketEnCoursUser($username);
        $TotalTicketResolu = $emi->getRepository('App:Ticket')->findTotalTicketResoluUser($username);
        $user = $emi->getRepository('App:User')->find($id);
        $form = $this->createForm(EditProfilType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('users');
        }

        return $this->render('users/index.html.twig', array('TtllTicket' => $TotalTicket, 'TtlTicketEC' => $TotalTicketEnCours, 'TtlTicketR' => $TotalTicketResolu, 'userForm' => $form->createView()));
    }
}
