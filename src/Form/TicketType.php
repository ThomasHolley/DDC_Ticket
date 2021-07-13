<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Dealer;
use App\Entity\Etat;
use App\Entity\Ticket;
use Doctrine\DBAL\Types\StringType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Titre', TextType::class)
            ->add('Message', TextType::class)
            ->add('Date', DateTimeType::class, ['data' => new \DateTime()] )
            ->add('Demandeur', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'mail',
            ])
            ->add('Agent', EntityType::class, [
                'class' => Dealer::class,
                'choice_label' => 'Nom',
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
