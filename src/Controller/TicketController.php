<?php

namespace App\Controller;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Entity\Ticket;
use App\Form\TicketType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class TicketController extends AbstractController
{
    #[Route('/home', name: 'home')]
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
    
    /**
     * @Route("/ticket/{id}/", name="view_ticket")
     * requirements={"id":"\d+"}
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
     *
     *@Route("/edit/{id}", name="edit_ticket")
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
    
    public function deleteTicketAction(){
        
    }
}
