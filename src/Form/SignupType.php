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
                'attr' => ['placeholder' => "Entrez votre adresse email"],
                'required' => false
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Entrez un mot de passe',
                'attr' => ['placeholder' => "Entrez votre mot de passe"],
                'required' => false
            ])
            ->add('nom', TextType::class, [
                'label' => 'Entrez votre nom',
                'attr' => ['placeholder' => "Entrez votre nom"],
                'required' => false
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Entrez votre prénom',
                'attr' => ['placeholder' => "Entrez votre prénom"],
                'required' => false
            ])
            ->add('age', TextType::class, [
                'label' => 'Entrez votre âge',
                'attr' => ['placeholder' => "Entrez votre âge"],
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personnes::class,
        ]);
    }
}
