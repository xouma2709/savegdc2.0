<?php

namespace App\Form;

use App\Entity\Agents;
use App\Entity\Secteurs;
use App\Entity\Fonctions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddAgentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class, ['required' => true])
            ->add('Prenom', TextType::class, ['required' => true])
            ->add('PrenomAutres', TextType::class, ['required' => false])
            ->add('Mail', TextType::class, ['required' => false])
            ->add('EnvoiMail', CheckboxType::class, ['required' => false])
            ->add('Tel', TextType::class, ['required' => false])
            ->add('EnvoiSMS', CheckboxType::class, ['required' => false])
            ->add('Matricule', TextType::class, ['required' => false])
            ->add('commentaire', TextareaType::class, ['required' => false])
            ->add('Secteur', EntityType::class, [
                'class' => Secteurs::class,
                'choice_label' => 'SecteurLibelle',
                'multiple' => false,
                'required' => true
            ])
            ->add('Fonction', EntityType::class, [
                'class' => Fonctions::class,
                'choice_label' => 'FonctionLibelle',
                'multiple' => false,
                'required' => true
            ])
            ->add('Ajouter', SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agents::class,
        ]);
    }
}
