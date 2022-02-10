<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Lieu;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
                'class' => Type::class,
                'choice_label' =>  function (Type $type) {
                    return strtoupper($type->getNomType());
                }
            ])
            ->add('dateEvent', TextType::class, [
                'label' => "Date de l'évènement",
                'attr' => [
                    'placeholder' => "Entrez la date de l'évènement"
                ]
            ])
            ->add('lieu', TextType::class, [
                'label' => "Adresse de l'évènement",
                'placeholder' => '-- Choisir une adresse --',
                'class' => Lieu::class,
                'choice_label' =>  function (Lieu $lien) {
                    return strtoupper($lien->getAdresseLieu());
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
