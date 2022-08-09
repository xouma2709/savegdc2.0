<?php

namespace App\Form;

use App\Entity\Secteurs;
use App\Entity\Etablissements;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddSecteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('etablissements', EntityType::class, [
                'class' => Etablissements::class,
                'choice_label' => 'EtabLibelle',
                'multiple' => false,
                'required' => true
            ])
            ->add('SecteurLibelle', TextType::class, ['required' => true])

            ->add('Ajouter', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Secteurs::class,
        ]);
    }
}
