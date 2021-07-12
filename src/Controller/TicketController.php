<?php

namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class TicketController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(EntityManagerInterface $emi)
    {

        $Totalticket = $emi->getRepository('App:Ticket')->NbreticketNoReso();
        
        return $this->render("TabHome.html.twig", array('Totalticket'=>$Totalticket));

    }
    
    #[Route('/tickets', name: 'List_ticket')]
    public function listTicketAction(EntityManagerInterface $emi){
        
        $tickets = $emi->getRepository('App:Ticket')->findAll();
        
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
    
    public function addTicketAction(){
        
    }
    
    public function editTicketAction(){
        
    }
    
    public function deleteTicketAction(){
        
    }
}
