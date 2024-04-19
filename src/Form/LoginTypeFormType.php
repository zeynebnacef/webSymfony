<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', TextType::class, [
            'invalid_message' => 'Votre adresse email est invalide',
        ])
        ->add('password', PasswordType::class, [
            'invalid_message' => 'Votre mot de passe est incorrect',
        ])
        ->add('login', SubmitType::class, [
            'label' => 'Login',
            'attr' => [
                'class' => 'btn btn-lg btn-lg w-100 mt-4 mb-0',
                'style' => 'background-color: #FEA116'
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
