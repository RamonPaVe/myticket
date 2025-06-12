<?php

namespace App\Form\Type;

use App\Entity\Ticket;
use DateTime;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TicketFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('summary', TextType::class)
            ->add('description', TextType::class)
            ->add('creation_date', DateTime::class)
            ->add('modification_date', DateTime::class)
            ->add('resolution_date', DateTime::class)
            ->add('close_date', DateTime::class)
            ->add('external_ticket', TextType::class)
            ->add('resolution', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }

    public function getBlockPrefix(){
        return '';
    }

    public function getName(){
        return '';
    }
}