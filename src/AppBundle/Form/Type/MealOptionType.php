<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\MealOption;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Tbbc\MoneyBundle\Form\Type\SimpleMoneyType;

class MealOptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name')
                ->add('displayName')
                ->add('position', NumberType::class)
                ->add('price', SimpleMoneyType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MealOption::class,
            'attr' => [
                'class' => 'form-vertical'
            ]
        ]);
    }
}
