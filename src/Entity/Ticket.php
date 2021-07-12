<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 */
class Ticket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Date;


    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Demandeur;

    /**
     * @ORM\ManyToOne(targetEntity=Dealer::class, inversedBy="DealerTicket")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Agent;

    /**
     * @ORM\ManyToOne(targetEntity=Etat::class, inversedBy="Etat_Ticket")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Etat_Ticket;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): self
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->Message;
    }

    public function setMessage(string $Message): self
    {
        $this->Message = $Message;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getDemandeur(): ?Client
    {
        return $this->Demandeur;
    }

    public function setDemandeur(?Client $Demandeur): self
    {
        $this->Demandeur = $Demandeur;

        return $this;
    }

    public function getAgent(): ?Dealer
    {
        return $this->Agent;
    }

    public function setAgent(?Dealer $Agent): self
    {
        $this->Agent = $Agent;

        return $this;
    }

    public function getEtat_Ticket(): ?Etat
    {
        return $this->Etat_Ticket;
    }

    public function setEtat_Ticket(?Etat $Etat_Ticket): self
    {
        $this->Etat_Ticket = $Etat_Ticket;

        return $this;
    }
}