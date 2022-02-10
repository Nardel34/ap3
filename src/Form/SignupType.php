<?php

namespace App\Form;

use App\Entity\Personnes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class SignupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Entrez une adresse Email',
                'attr' => ['placeholder' => "Entrez votre adresse email"]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Entrez un mot de passe',
                'attr' => ['placeholder' => "Entrez votre mot de passe"]
            ])
            // ->add('roles', ChoiceType::class, [
            //     'label' => 'Choisissez votre status',
            //     'choices' => [
            //         'Professeur' => "ROLE_PROF",
            //         'Elève' => "ROLE_ELEVE"
            //     ],
            //     'expanded' => true,
            //     'multiple' => false
            // ])
            ->add('nom', TextType::class, [
                'label' => 'Entrez votre nom',
                'attr' => ['placeholder' => "Entrez votre nom"]
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Entrez votre prénom',
                'attr' => ['placeholder' => "Entrez votre prénom"]
            ])
            ->add('age', TextType::class, [
                'label' => 'Entrez votre âge',
                'attr' => ['placeholder' => "Entrez votre âge"]
            ]);

        // $builder->get('roles')
        //     ->addModelTransformer(new CallbackTransformer(
        //         function ($rolesArray) {
        //             // transform the array to a string
        //             return count($rolesArray) ? $rolesArray[0] : null;
        //         },
        //         function ($rolesString) {
        //             // transform the string back to an array
        //             return [$rolesString];
        //         }
        //     ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personnes::class,
        ]);
    }
}
