<?php

namespace App\Form;

use App\Entity\Personnes;
use App\Repository\PersonnesRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfType extends AbstractType
{
    public function __construct(protected PersonnesRepository $pr)
    {
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('personnes', EntityType::class, [
                'label' => false,
                'class' => Personnes::class,
                'placeholder' => "-- Choisir un professeur --",
                'attr' => [
                    'class' => "form-select"
                ],
                'choices' => $this->pr->findByRole('PROF'),
                'choice_label' =>  function (Personnes $personnes) {
                    return strtoupper($personnes->getNom()) . " " . $personnes->getPrenom();
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        // $resolver->setDefaults([
        //     'data_class' => Personnes::class,
        // ]);
    }
}
