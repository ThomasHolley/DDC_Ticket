<?php

namespace App\Repository;

use App\Entity\Ticket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ticket|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ticket|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ticket[]    findAll()
 * @method Ticket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ticket::class);
    }

    public function NbreticketNoReso()
    {
        return $this->createQueryBuilder('t')
            ->where('t.EtatTicket = 1')
            ->select('count(t.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function NbreticketOuvert()
    {
        return $this->createQueryBuilder('t')
            ->where('t.EtatTicket = 2')
            ->select('count(t.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
    public function NbreticketFerme()
    {
        return $this->createQueryBuilder('t')
            ->where('t.EtatTicket = 3')
            ->select('count(t.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findTicketNoFerme()
    {
        return $this->createQueryBuilder('t')
            ->where('t.EtatTicket != 3')
            ->getQuery()
            ->getResult();
    }
    
    public function findTicketNoFermeOrderByDate()
    {
        return $this->createQueryBuilder('t')
            ->where('t.EtatTicket != 3')
            ->orderBy('t.date', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findTicketFerme()
    {
        return $this->createQueryBuilder('t')
            ->where('t.EtatTicket = 3')
            ->getQuery()
            ->getResult();
    }


    public function findTicketUser($username)
    {
        return $this->createQueryBuilder('t')
            ->where('t.Demandeur = :actual')->setParameter('actual', $username)
            ->getQuery()
            ->getResult();
    }
    
    public function findTotalTicketUser($username)
    {
        return $this->createQueryBuilder('t')
        ->where('t.Demandeur = :actual')->setParameter('actual', $username)
        ->select('count(t.id)')
        ->getQuery()
        ->getSingleScalarResult();
    }
    
    public function findTotalTicketEnCoursUser($username)
    {
        return $this->createQueryBuilder('t')
        ->where('t.EtatTicket != 3 AND t.Demandeur = :actual')->setParameter('actual', $username)
        ->select('count(t.id)')
        ->getQuery()
        ->getSingleScalarResult();
    }
    
    public function findTotalTicketResoluUser($username)
    {
        return $this->createQueryBuilder('t')
        ->where('t.EtatTicket = 3 AND t.Demandeur = :actual')->setParameter('actual', $username)
        ->select('count(t.id)')
        ->getQuery()
        ->getSingleScalarResult();
    }
    

}
    
    

    // /**
    //  * @return Ticket[] Returns an array of Ticket objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ticket
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
