<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class NewmdpFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', HiddenType::class, [
            'data' => $options['email'],
        ])
            ->add('newPassword', PasswordType::class, [
                
                'attr' => ['class' => 'form-control-lg']
            ])
            ->add('confirmPassword', PasswordType::class, [
                
                'attr' => ['class' => 'form-control-lg']
            ])
            ->add('Confirmer', SubmitType::class, [
                
                'attr' => [
                    'class' => 'btn btn-lg btn-lg w-100 mt-4 mb-0',
                    'style' => 'background-color: #FEA116'
                ]
            ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'email' => null, // Défaut à null
        ]);
    }
}
