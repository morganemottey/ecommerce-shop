<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', RepeatedType::class , [
                'type' => PasswordType::class, 
                'invalid_message' => 'Le mot de passe est invalide',
                'label' => 'votre mot de passe',
                'required' => true,
                'first_options' => [ 'label' => 'Mot de passe'],
                'second_options' => [ 'label' => 'Confirmation mot de passe']
            ])
            ->add('submit', SubmitType::class , [
                'label' => "S'inscrire",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
