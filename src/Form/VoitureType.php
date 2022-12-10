<?php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('serie')
            ->add('date_Mise_En')
            ->add('prix_jour')
            ->add('model',EntityType::class,
            ['class'=>'App\Entity\Modele' ,
                'choice_label' => 'libelle',
                'multiple' => false,
                'expanded'=>false])
            ->add('modele')
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
