<?php

namespace App\Controller;

use App\Form\EditUserType;
use App\Form\EditProfilType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UsersController extends AbstractController
{
    #[Route('/users', name: 'users')]
    public function index(EntityManagerInterface $emi, Request $request,SluggerInterface $slugger)
    {
        $id = $this->getUser()->getId();
        $username = $this->getUser()->getUsername();
        $TotalTicket = $emi->getRepository('App:Ticket')->findTotalTicketUser($username);
        $TotalTicketEnCours = $emi->getRepository('App:Ticket')->findTotalTicketEnCoursUser($username);
        $TotalTicketResolu = $emi->getRepository('App:Ticket')->findTotalTicketResoluUser($username);
        $user = $emi->getRepository('App:User')->find($id);
        $userphoto = $this->getUser()->getPhoto();
        

        
        $form = $this->createForm(EditProfilType::class, $user);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $fichierphoto = $form->get('photo')->getData();
            
            if ($fichierphoto) {
                $originalFilename = pathinfo($fichierphoto->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$fichierphoto->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $fichierphoto->move(
                        $this->getParameter('Photo_folder'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $user->setPhoto($newFilename);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('users');
        }

        return $this->render('users/index.html.twig', array($userphoto,'TtllTicket' => $TotalTicket, 'TtlTicketEC' => $TotalTicketEnCours, 'TtlTicketR' => $TotalTicketResolu, 'userForm' => $form->createView()));
    }
}
