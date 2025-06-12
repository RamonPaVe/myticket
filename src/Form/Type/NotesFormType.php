<?php

namespace App\Form\Type;

use App\Entity\Notes;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class NotesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('note', TextType::class)
            ->add('modification_date', DateTime::class)
            ->add('creation_date', DateTime::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Notes::class,
        ]);
    }

    public function getBlockPrefix(){
        return '';
    }

    public function getName(){
        return '';
    }
}