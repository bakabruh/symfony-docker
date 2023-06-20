<?php

namespace App\Form;

use App\Entity\Meal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class MealType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom du plat',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ex: Lasagnes'
                ]
            ])
            ->add('ingredients', TextareaType::class, [
                'label' => 'Ingrédients',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ex: Pâtes, sauce tomate, viande hachée, fromage...'
                ]
            ])
            ->add('allergen', TextareaType::class, [
                'label' => 'Allergènes',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: Gluten, lait, oeuf...'
                ]
            ])
            ->add('container', TextareaType::class, [
                'label' => 'Contenant',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: Tuperware, plat et assiettes...'
                ]
            ])
            ->add('cutlery', CheckboxType::class, [
                'label' => 'Couverts',
                'required' => false,
            ])
            ->add('time', DateTimeType::class, [
                'label' => 'Date et heure de disponibilité',
                'required' => true,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'placeholder' => [
                    'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                    'hour' => 'Heure', 'minute' => 'Minute', 'second' => 'Seconde',
                ]
            ])
            ->add('place', TextType::class, [
                'label' => 'Lieu de disponibilité',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ex: Salle 402, réfectoire...'
                ]
            ])
            ->add('shares', IntegerType::class, [
                'label' => 'Nombre de parts',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Ex: 4'
                ]
            ])
            ->add('image', TextType::class, [
                'label' => 'Image',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Ex: https://www.example.com/image.jpg'
                ]
            ])
            ->add('disclaimer', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'rows' => 5,
                ],
                'help' => 'Vous pouvez indiquer ici n\'importe quelle information supplémentaire que vous souhaitez signaler.',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Meal::class,
        ]);
    }
}
