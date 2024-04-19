<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SendEmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', TextType::class, [
            'constraints' => [
                new Assert\NotBlank([
                    'message' => 'Veuillez saisir votre email.',
                ]),
                // Autres contraintes éventuelles
            ],
        ])
        ->add('Send', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-lg btn-block btn-dark border-light'
            ]
        ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
