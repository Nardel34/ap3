<?php

namespace App\Form;

use App\Entity\Personnes;
use App\Entity\Reunion;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReunionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateReunion', DateTimeType::class)
            ->add('objet', TextType::class, [
                'attr' => [
                    'placeholder' => 'Objet de la réunion'
                ]
            ])
            ->add('professeurs', CollectionType::class, [
                'label' => "Ajouter des professeurs",
                'entry_type' => ProfType::class,
                'by_reference' => false,
                "allow_add" => true,
                "allow_delete" => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // $resolver->setDefaults([
        //     'data_class' => Reunion::class,
        // ]);
    }
}
