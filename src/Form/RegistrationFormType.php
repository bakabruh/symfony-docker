<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'example@domain.com'
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'placeholder' => '••••••••'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ne pas laisser le champs vide.',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit être d\'au moins {{ limit }} caractères.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Michel'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Dupond'
                ]
            ])
            ->add('isCook', CheckboxType::class, [
                'label' => 'Je vais cuisiner (peut être changé).',
                'required' => false
            ])
            ->add('class', TextType::class, [
                'label' => 'Classe',
                'required' => true,
                'attr' => [
                    'placeholder' => 'A4 MTD'
                ]
            ])
            ->add('habits', TextareaType::class, [
                'label' => 'Quel(s) genre(s) de plats préfères-tu cuisiner ?',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Chili con carne, lasagnes, etc.'
                ]
            ])
            ->add('contactEmail', EmailType::class, [
                'label' => 'Email pour être contacter par les autres utilisateurs (laissez vide si égal à l\'email d\'inscription).',
                'required' => false,
                'attr' => [
                    'placeholder' => 'example@domain.com'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
