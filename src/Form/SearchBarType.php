<?php

namespace App\Form;

use App\Entity\Agents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class SearchBarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class, ['required' => false])
            ->add('Prenom', TextType::class, ['required' => false])
            ->add('Matricule', TextType::class, ['required' => false])
            ->add('partielle', SubmitType::class, ['label' => 'Recherche partielle'])
            ->add('exacte', SubmitType::class, ['label' => 'Recherche exacte'])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agents::class,
        ]);
    }
}
