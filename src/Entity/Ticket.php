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
     * @ORM\Column(type="string", length=255)
     */
    private $Demandeur;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Agents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Agent;

    /**
     * @ORM\ManyToOne(targetEntity=Etat::class, inversedBy="Etat_Ticket")
     * @ORM\JoinColumn(nullable=false)
     */
    private $EtatTicket;

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

    public function getDemandeur(): ?string
    {
        return $this->Demandeur;
    }

    public function setDemandeur(string $Demandeur): self
    {
        $this->Demandeur = $Demandeur;

        return $this;
    }

    public function getAgent(): ?User
    {
        return $this->Agent;
    }

    public function setAgent(?User $Agent): self
    {
        $this->Agent = $Agent;

        return $this;
    }

    public function getEtatTicket(): ?Etat
    {
        return $this->EtatTicket;
    }

    public function setEtatTicket(?Etat $EtatTicket): self
    {
        $this->EtatTicket = $EtatTicket;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getEtatTicket();
    }
}
