<?php

namespace App\Controller;

use App\Form\EditUserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminController extends AbstractController
{
    /**
     * @Route("/utilisateurs", name="list_utilisateurs")
     */
    public function usersList(UserRepository $users)
    {
        return $this->render('agent/users.html.twig', [
            'users' => $users->findAll(),
        ]);
    }

    /**
     * @Route("/utilisateurs/modifier/{id}", name="modifier_utilisateur")
     */
    public function editUser($id, EntityManagerInterface $em, Request $request)
    {
        $user = $em->getRepository('App:User')->find($id);
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('list_utilisateurs');
        }

        return $this->render('agent/edituser.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }
    
    /**
     *
     *@Route("/utilisateurs/delete/{id}", name="delete_utilisateur")
     *
     */
    public function deleteUser($id, EntityManagerInterface $em)
    {

        $user = $em->getRepository('App:User')->find($id);

        if (!$user) {
            throw new NotFoundHttpException("L'utilisateur $user n'existe pas");
        } else {
            $em->remove($user);
            $em->flush();
            return $this->render("Home.html.twig");
        }
    }
}
