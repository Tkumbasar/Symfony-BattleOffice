<?php

namespace App\Form;


use App\Entity\DeliveryLocations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeliveryLocationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('lastName', TextType::class, [
            'label' => 'Nom de famille',
            'required' => false,
        ])

        ->add('firstName', TextType::class, [
            'label' => 'Prénom',
            'required' => false,
        ])

        ->add('adress', TextType::class, [
            'label' => 'Adresse',
            'required' => false,
        ])
        
        ->add('addressSupp', TextType::class, [
            'label' => 'Complément d\'adresse',
            'required' => false,
        ])
        ->add('city', TextType::class, [
            'label' => 'Ville',
            'required' => false,
        ])
        ->add('cp', TextType::class, [
            'label' => 'Code postal',
            'required' => false,
        ])
        ->add('country', ChoiceType::class, [
            'choices' => [
            'france' => 'france',
            'italie' => 'italie',
            'rachid' => 'rachid',
            ]
        ])
        ->add('phone', TextType::class, [
            'label' => 'Téléphone',
            'required' => false,
        ])
        // ->add('email', TextType::class, [
        //     'label' => 'Email',
        //     'required' => false,
        // ])
            // ->add('createdAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('updateAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('deleteAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('product', TextType::class, [
            //     'label' => 'Email',
            //     'required' => false,
            // ])
    
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DeliveryLocations::class,
        ]);
    }
}
