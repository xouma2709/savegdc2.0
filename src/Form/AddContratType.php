<?php

namespace App\Form;
use App\Entity\Agents;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\Contrats;
use App\Entity\TypesContrat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddContratType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('DateDebut', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('DateFin', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('preuve')
            ->add('TypeContrat', EntityType::class, [
                'class' => TypesContrat::class,
                'choice_label' => 'TypeContratLibelle',
                'multiple' => false,
                'required' => true
            ])
            ->add('Ajouter', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrats::class,
        ]);
    }
}
