<?php

namespace App\Form;

use App\Entity\Trajet;
use App\Entity\Utilisateur;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrajetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ville_depart', TextType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('date_depart', DateType::class)
            ->add('heure_depart', TimeType::class)
            ->add('ville_arrive', TextType::class)
            ->add('date_arrive', DateType::class)
            ->add('heure_arrive', TimeType::class)
            ->add('nbre_place', NumberType::class)
            ->add('nbre_place_dispo', NumberType::class)
            ->add('prix', NumberType::class)
            ->add('distance', NumberType::class)
        
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trajet::class,
        ]);
    }
}
