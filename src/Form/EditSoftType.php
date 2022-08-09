<?php

namespace App\Form;

use App\Entity\Softs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditSoftType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('SoftLibelle', TextType::class, ['required' => true])
        ->add('SynchroAD', CheckboxType::class, ['required' => false])
        ->add('Precisions', TextareaType::class, ['required' => false])
        ->add('actif', CheckboxType::class, ['required' => false])
        ->add('Modifier', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Softs::class,
        ]);
    }
}
