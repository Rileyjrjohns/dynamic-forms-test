<?php

namespace App\Form;

use App\Entity\Drink;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfonycasts\DynamicForms\DynamicFormBuilder;
use Symfonycasts\DynamicForms\DependentField;

class DrinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder = new DynamicFormBuilder($builder);

        $builder
            ->add('teaOrCoffee', ChoiceType::class, [
                'placeholder' => '-- Choisir --',
                'label' => 'Thé ou Café ?',
                'choices' => [
                    'Thé' => 'tea',
                    'Café' => 'coffee',
                ],
                'autocomplete' => true
            ])
            ->addDependent('teaType', 'teaOrCoffee', function (DependentField $field, ?string $teaOrCoffee) {
                if($teaOrCoffee !== 'tea') {
                    return;
                }
                $field
                    ->add(ChoiceType::class, [
                        'label' => false,
                        'placeholder' => '-- Choisir le thé --',
                        'choices' => [
                            'Thé noir' => 'black',
                            'Thé vert' => 'green',
                        ],
                        'autocomplete' => true,
                    ]);
            })
            ->addDependent('coffeeType', 'teaOrCoffee', function (DependentField $field, ?string $teaOrCoffee) {
                if($teaOrCoffee !== 'coffee') {
                    return;
                }
                $field->add(ChoiceType::class, [
                    'label' => false,
                    'placeholder' => '-- Choisir le café --',
                    'choices' => [
                        'Café noir' => 'black',
                        'Café avec lait' => 'with_milk',
                    ],
                    'autocomplete' => true,
                ]);
            })
           ->add('sugar', ChoiceType::class, [
               'label' => 'Sucre',
               'choices' => [
                   'Avec sucre' => true,
                   'Sans sucre' => false,
               ],
               'autocomplete' => true,
            ]);
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Drink::class,
        ]);
    }
}
