<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\Ticket;
use App\Form\TicketType;
use App\Form\EditUserType;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TicketController extends AbstractController
{

    /**
     * @Route("", name="home")
     * 
     */
    public function index(EntityManagerInterface $emi)
    {

        $TotalticketNoReso = $emi->getRepository('App:Ticket')->NbreticketNoReso();
        $TotalticketOuvert = $emi->getRepository('App:Ticket')->NbreticketOuvert();
        
        return $this->render("TabHome.html.twig", array('TotalticketNR'=>$TotalticketNoReso, 'TotalTicketO'=>$TotalticketOuvert));

    }
    

    


    
    #[Route('/tickets', name: 'List_ticket')]
    public function listTicketAction(EntityManagerInterface $emi){
        
        $tickets = $emi->getRepository('App:Ticket')->findTicketNoFerme();
        
        return $this->render("listTicket.html.twig",array('tickets'=>$tickets));
         
    }
    
    #[Route('/ticketsFerme', name: 'List_ticket_Ferme')]
    public function listTicketFermeAction(EntityManagerInterface $emi){
        
        $tickets = $emi->getRepository('App:Ticket')->findTicketFerme();
        
        return $this->render("listTicketFerme.html.twig",array('tickets'=>$tickets));
         
    }
    
    
    
    /**
     * @Route("/ticket/{id}/", name="view_ticket")
     * requirements={"id":"\d+"}
     * @IsGranted("ROLE_ADMIN")
     */
    public function viewTicketAction($id, EntityManagerInterface $em){
        $ticket = $em->getRepository('App:Ticket')->find($id);
        
        if(!$ticket){
            throw new NotFoundHttpException("Le $ticket n'existe pas");
        }
        return $this->render("ViewTicket.html.twig",array('ticket'=>$ticket));
    }
    
    /**
     * @Route("/add/", name="add_ticket")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addTicketAction(Request $request){
        
        $ticket = new Ticket();
        $form = $this->createForm(TicketType::class, $ticket);
        $form->add('send', SubmitType::class, ['label' => 'créé un nouveau ticket']);
        $form->handleRequest($request);
        
        if($form->isSubmitted()){
            $ticket->setDate(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();
            return $this->redirectToRoute('List_ticket');
        }
        
        return $this->render("add.html.twig", array('form' => $form->createView()));
        
    }
    
    
    /**
     * 
     *@Route("/edit/{id}", name="edit_ticket")
    * @IsGranted("ROLE_ADMIN")
     */
    public function editTicketAction($id, EntityManagerInterface $em, Request $request){
        $ticket = $em->getRepository('App:Ticket')->find($id);
        $form = $this->createForm(TicketType::class, $ticket);
        $form->add('send', SubmitType::class, ['label' => 'créé un nouveau ticket']);
        $form->handleRequest($request);
        
        if($form->isSubmitted()){
            $ticket->setDate(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($ticket);
            $em->flush();
            return $this->redirectToRoute('List_ticket');
        }
        
        return $this->render("edit.html.twig", array('form' => $form->createView()));
        
    }
    
        /**
    * @Route("/utilisateurs", name="utilisateurs")
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
            return $this->redirectToRoute('utilisateurs');
        }
        
        return $this->render('agent/edituser.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }
    
    /**
     * 
     *
     *@Route("/delete/{id}", name="delete_ticket")
    * @IsGranted("ROLE_ADMIN")
     */
    public function deleteAction($id, EntityManagerInterface $em){
        
        $ticket = $em->getRepository('App:Ticket')->find($id);
        
        if(!$ticket){
            throw new NotFoundHttpException("Le ticket $ticket n'existe pas");
        }
        else {
            $em->remove($ticket);
            $em->flush();
            return $this->render("TabHome.html.twig");
        }
        
    }
}
