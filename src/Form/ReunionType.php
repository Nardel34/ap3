<?php

namespace App\Form;

use App\Entity\Reunion;
use App\Entity\Personnes;
use App\Repository\PersonnesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Security\Core\User\UserInterface;

class ReunionType extends AbstractType
{
    public function __construct(protected PersonnesRepository $pr)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateReunion', DateTimeType::class)
            ->add('objet', TextType::class, [
                'attr' => [
                    'placeholder' => 'Objet de la réunion'
                ],
                'required' => false
            ])
            ->add('professeurs', EntityType::class, [
                'label' => "Ajouter des professeurs",
                'class' => Personnes::class,
                'multiple' => true,
                'placeholder' => "-- Choisir un professeur --",
                'choices' => $this->pr->findByRole('PROF', $options['user']),
                'attr' => [
                    'class' => 'form-select'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'data_class' => Reunion::class,
            ])
            ->setRequired(['user']);
    }
}
