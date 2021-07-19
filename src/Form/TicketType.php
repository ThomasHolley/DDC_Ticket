<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\User;
use App\Entity\Client;
use App\Entity\Dealer;
use App\Entity\Ticket;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\StringType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class TicketType extends AbstractType
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Titre', TextType::class)
            ->add('Message', TextareaType::class)
            ->add('Agent', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'choices' => $this->userRepository->findAdmin(),
            ])
            ->add('EtatTicket', EntityType::class, [
                'class' => Etat::class,
                'choice_label' => 'statut',
                
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           
        ]);
    }
}
