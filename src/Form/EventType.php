<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Lieu;
use App\Entity\Personnes;
use App\Entity\Type;
use App\Repository\PersonnesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function __construct(protected PersonnesRepository $pr)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('personnes', EntityType::class, [
                'label' => "Remplacement",
                'placeholder' => '-- Choisir un professeur --',
                'attr' => [
                    'class' => "form-select"
                ],
                'choices' => $this->pr->findByRole('PROF'),
                'class' => Personnes::class,
                'required' => false
            ])
            ->add('type', EntityType::class, [
                'label' => "Type d'évènement",
                'placeholder' => '-- Choisir un type --',
                'attr' => [
                    'class' => "form-select"
                ],
                'class' => Type::class,
                'choice_label' =>  'nomType',
                'required' => false
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
                'choice_label' => 'adresseLieu',
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
