<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class , [
                'label' => 'Votre prénom',
                'attr' => [
                    'placeholder' => 'Entrez votre nom'
                ]
            ])
            ->add('firstname', TextType::class , [
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'Entrez votre nom'
                ]
            ])
            ->add('lastname' , TextType::class , [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Votre nom'
                ]
            ])
            ->add('company', TextType::class , [
                'label' => 'Votre société',
                'attr' => [
                    'placeholder' => '(facultatif) Entrez le nom de votre société'
                ]
            ])
            ->add('adress', TextType::class , [
                'label' => 'Votre adresse',
                'attr' => [
                    'placeholder' => '8 rue des lilas..'
                ]
            ])
            ->add('codepostal', TextType::class , [
                'label' => 'Votre code postal',
                'attr' => [
                    'placeholder' => 'Entrez votre code postal'
                ]
            ])
            ->add('city', TextType::class , [
                'label' => 'Votre ville',
                'attr' => [
                    'placeholder' => 'Entrez votre ville'
                ]
            ])
            ->add('phone', TelType::class , [
                'label' => 'Votre téléphone',
                'attr' => [
                    'placeholder' => 'Entrez votre numéro'
                ]
            ])
            ->add('submit' , SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-dark'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
