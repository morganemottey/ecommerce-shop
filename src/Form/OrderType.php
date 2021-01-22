<?php

namespace App\Form;

use App\Entity\Adress;
use App\Entity\Carrier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $options['user'];

        $builder
            ->add('adresses', EntityType::class , [
                'label' => 'Choisissez votre adresse de livraison',
                'required' => true,
                'choices' => $user->getAdresses(),
                'class' => Adress::class,
                'multiple' => false,
                'expanded' => true
            ])
            ->add('carrieres', EntityType::class , [
                'label' => 'Choisissez votre transporteur',
                'required' => true,
                'class' => Carrier::class,
                'multiple' => false,
                'expanded' => true
            ])
            ->add('submit', SubmitType::class , [
                'label' => "Valider ma commande",
                'attr' => [
                    'class' => 'btn btn-block btn-dark'
                ] 
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'user' => array()
        ]); 
    }
}
