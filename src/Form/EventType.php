<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Lieu;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', EntityType::class, [
                'label' => "Type d'évènement",
                'placeholder' => '-- Choisir une un type --',
                'attr' => [
                    'class' => "form-select"
                ],
                'class' => Type::class,
                'choice_label' =>  'nomType'
            ])
            ->add('dateEvent', DateType::class, [
                'label' => "Date de l'évènement"
            ])
            ->add('lieu', EntityType::class, [
                'label' => "Adresse de l'évènement",
                'placeholder' => '-- Choisir une adresse --',
                'attr' => [
                    'class' => "form-select"
                ],
                'class' => Lieu::class,
                'choice_label' =>  'adresseLieu'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
