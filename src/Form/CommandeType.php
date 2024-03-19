<?php

namespace App\Form;

use App\Entity\Commande;
use Doctrine\DBAL\Types\DateTimeType;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandeType extends AbstractType
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
        
        ->add('adressSup', TextType::class, [
            'label' => 'Complément d\'adresse',
            'required' => false,
        ])
        ->add('city', TextType::class, [
            'label' => 'Ville',
            'required' => false,
        ])
        ->add('cp', IntegerType::class, [
            'label' => 'Code postal',
            'required' => false,
        ])
        ->add('country', TextType::class, [
            'label' => 'Pays',
            'required' => false,
        ])
        ->add('phone', IntegerType::class, [
            'label' => 'Téléphone',
            'required' => false,
        ])
        ->add('email', TextType::class, [
            'label' => 'Email',
            'required' => false,
        ])
        ->add('createdAt', DateTimeType::class, [
            'label' => 'Date de création',
            'widget' => 'single_text',
        ])
        ->add('updatedAt', DateTimeType::class, [
            'label' => 'Date de mise à jour',
            'widget' => 'single_text',
        ])
        ->add('deletedAt', DateTimeType::class, [
            'label' => 'Date de suppression',
            'widget' => 'single_text',
            'required' => false,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
