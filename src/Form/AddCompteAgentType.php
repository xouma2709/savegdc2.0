<?php

namespace App\Form;

use App\Entity\Comptes;
use App\Entity\Softs;
use App\Entity\Agents;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCompteAgentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


        $builder
            ->add('login', TextType::class, ['required' => true])
            ->add('actif', CheckboxType::class, ['required' => false])
            ->add('admin', CheckboxType::class, ['required' => false])
            ->add('Softs', EntityType::class, [
                'class' => Softs::class,
                'choice_label' => 'SoftLibelle',
                'multiple' => true,
                'required' => true,
                'expanded' => true
            ])

            ->add('Ajouter', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comptes::class,
            'var' => null,
        ]);
    }
}
