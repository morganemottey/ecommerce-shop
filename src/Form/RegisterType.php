<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class , [
                'label' => 'Nom', 
                'attr' => [
                    'placeholder' => 'Votre nom'
                ]
            ])
            ->add('firstname', TextType::class , [
                'label' => 'Prénom', 
                'attr' => [
                    'placeholder' => 'Votre prénom'
                ]
            ])
            ->add('email',  EmailType::class , [
                'label' => 'Email', 
                'attr' => [
                    'placeholder' => 'Votre email'
                ]
            ])
            ->add('password', PasswordType::class , [
                'label' => 'Mot de passe', 
                'attr' => [
                    'placeholder' => 'Votre mot de passe'
                ]
            ])
            ->add('confirm_password', PasswordType::class , [
                'label' => 'Confirmation de votre mot de passe',
                'mapped' => false, 
                'attr' => [
                    'placeholder' => 'Confirmer votre mot de passe'
                ]
            ])
            ->add('submit', SubmitType::class , [
                'label' => "S'inscrire", 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
