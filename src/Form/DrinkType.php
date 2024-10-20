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
                'choices' => [
                    'Thé' => 'tea',
                    'Café' => 'coffee',
                ],
                'expanded' => false,
                'multiple' => false,
                'autocomplete' => true,
                
            ])
            ->addDependent('teaType', 'teaOrCoffee', function (DependentField $field, ?string $teaOrCoffee) {
                if($teaOrCoffee !== 'tea') {
                    return;
                }
                    $field
                    ->add('teaType', ChoiceType::class, [
                        'choices' => [
                            'Thé noir' => 'black',
                            'Thé vert' => 'green',
                        ],
                        'expanded' => false,
                        'multiple' => false,
                        'autocomplete' => true,
                    ]);
                
            })
            ->addDependent('coffeeType', 'teaOrCoffee', function (DependentField $field, ?string $teaOrCoffee) {
                if($teaOrCoffee !== 'coffee') {
                    return;
                }
                    $field->add('coffeeType', ChoiceType::class, [
                        'choices' => [
                            'Café noir' => 'black',
                            'Café avec lait' => 'with_milk',
                        ],
                        'expanded' => false,
                        'multiple' => false,
                        'autocomplete' => true,
                    ]);
                
            })
           ->add('sugar', ChoiceType::class, [
               'choices' => [
                   'Avec sucre' => true,
                   'Sans sucre' => false,
               ],
               'expanded' => false,
               'multiple' => false,
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
